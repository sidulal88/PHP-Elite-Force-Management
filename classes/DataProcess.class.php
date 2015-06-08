<?php
class DataProcess
{
	
    public function escapeString($str = null)
    {
        return "'" . $str . "'";
    }
	
	public function saveData(&$pdata, $tableName, $debug=false){
	 	$primeryKey = self::getPrimKey($tableName);
	 	$_POST = str_replace("'", "&#39;", $_POST);
		$_POST = str_replace('"', "&#34;", $_POST);
		$_REQUEST = $_POST = $pdata;

	 	$data = self::getUserDataSet($tableName);
	 	$info['table'] = $tableName;
	 	$info['debug'] = $debug;

	 	if(array_key_exists($primeryKey,$pdata)) {
	 		$data["_modified"] = date("Y-m-d H:i:s");
	 		$info['data']  = $data;
	 		$info['where'] = $tableName.".".$primeryKey."=".self::escapeString($pdata[$primeryKey]);
	 		$info['debug'] = $debug;
	 		$ret = self::update($info);
	 	}
	 	else
	 	{
	 		$data["_modified"] = date("Y-m-d H:i:s");
	 		$data["rectime"] = date("Y-m-d H:i:s");
	 		$info['data']  	 = $data;
	 		$ret = self::insert($info);
	 		return $ret;
	 	}
	 }

   public function getUserDataSet($table = null)
    {

        $fieldMap = self::getTableFields($table);

        $resultData = array();

        // Loop through the field map and find out
        // which of the field(s) have data from $_REQUEST
        foreach ($fieldMap as $field => $info) {
            list($type,
                    $len,
                    $required,
                    $autoinc,
                    $pk,
                    $unique,
                    $enum) = explode(":", $info);

            // Ignore auto inc field since it is never received from user
            if ($autoinc)
                continue;

            $value = isset($_REQUEST[$field]) ? $_REQUEST[$field] : $_POST[$field];

            // If value is available we need to store it
            // in result set
            //if (! empty($value))
            if (isset($value)) {
                // We trim the string to remove leading
                // and trailing spaces
                if (preg_match("/string/i", $type) ||
                        preg_match("/blob/i", $type)
                ) {
                    $value = trim($value);
                }
                else if ((preg_match("/int/i", $type) ||
                        preg_match("/float/i", $type) ||
                        preg_match("/decimail/i", $type) ||
                        preg_match("/double/i", $type)
                        ) && !is_numeric($value)
                ) {
                    // User given value is a NOT number
                    // when we are expecting one!
                    // so we are going to ignore it
                    continue;
                }

                $resultData[$field] = $value;
            }
        }

        return $resultData;
    }


    public function getTableFields($table = null)
    {
		$sql = "SELECT * FROM $table";
        $result = Database::query($sql, 2, __FILE__, __LINE__);

        // If table does not exist, return null
        if ($result->field_count < 1 )
            return null;

        // Get field names for the table
        //$fields = $result->field_count;

        // Setup an array to store return info
        $hash = array();

        // For each field, find out what type, length, requirements,
        // PK, unqiue, enum, attributes etc.
		$finfo = mysqli_fetch_fields($result);
		$mysql_data_type_hash = array(
			1=>'tinyint',
			2=>'smallint',
			3=>'int',
			4=>'float',
			5=>'double',
			7=>'timestamp',
			8=>'bigint',
			9=>'mediumint',
			10=>'date',
			11=>'time',
			12=>'datetime',
			13=>'year',
			16=>'bit',
			252=>'blob',
			253=>'string',
			254=>'char',
			246=>'decimal'
		);
			foreach ($finfo as $val) {
				$type = $mysql_data_type_hash[$val->type];
				$name = $val->name;
				$len = $val->max_length;
				$flags = $val->flags;
				
				$required = (preg_match("/not_null/i", $flags)) ? 1 : 0;
				$autoinc = (preg_match("/auto_increment/i", $flags)) ? 1 : 0;
				$pk = (preg_match("/primary/i", $flags)) ? 1 : 0;
				$unique = (preg_match("/unique/i", $flags)) ? 1 : 0;
				$enum = (preg_match("/enum/i", $flags)) ? 1 : 0;
	
				$hash["$name"] = "$type:$len:$required:$autoinc:$pk:$unique:$enum";
				
			}
			mysqli_free_result($result);		
        // Return
        return $hash;
    }


	public function getPrimKey($table){
		$sql = "SHOW INDEX FROM $table WHERE Key_name = 'PRIMARY'";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$num_rows = $result->num_rows;
		if($num_rows > 0){
			// Note I'm not using a while loop because I never use more than one prim key column
			$fetch_result = $result->fetch_array(MYSQL_ASSOC);
			extract($fetch_result);
			return($Column_name);
			}else{
			return(false);
		}
	}

    public function insert($data = null)
    {
        $ret = array();
        $fieldMap = self::getTableFields($data['table']);
        $valueList = array();
        $fieldList = array();
        $userData = $data['data'];

        foreach ($fieldMap as $field => $settings) {
            list($type,
                    $len,
                    $required,
                    $autoinc,
                    $pk,
                    $uniq,
                    $enum) = explode(':', $settings);
            $userField = strtolower($field);
            if (isset($userData[$userField]))
                $value = trim($userData[$userField]);
            else
                continue;

            $fieldList[] = $field;

			//$value = preg_match("/date/i", $type)?Common::converToMysqlDate($value):$value;
			$value = preg_match("/string/i", $type)?filter_var($value, FILTER_SANITIZE_STRING):$value;
            // Quote if the field type requires it
            $valueList[] = (preg_match("/string/i", $type) ||
                    preg_match("/char/i", $type) ||
                    preg_match("/blob/i", $type) ||
                    preg_match("/date/i", $type) ||
                    preg_match("/time/i", $type)
                    ) ? self::escapeString($value) : $value;
        }

        $fieldStr = implode(',', $fieldList);
        $valueStr = implode(',', $valueList);
		
		mysqli_query('SET CHARACTER SET utf8');
		mysqli_query("SET SESSION collation_connection ='utf8_general_ci'"); 
		
		$stmt = 'INSERT INTO ' . $data['table'] . " ($fieldStr) VALUES($valueStr)";
        $result = Database::query($stmt, 2, __FILE__, __LINE__);
        $err = mysqli_error();

        if (isset($data['debug']) && $data['debug']) {
             echo $stmt;
            echo "Error: " . $err;
        }

        if (!empty($err)) {
            if (preg_match("/Duplicate/i", $err)) {
                $errors[] = $data['dup_error'];
                $ret['error'] = $errors;
                $ret['affected_rows'] = 0;
            }
        }
        else {
            $ret['affected_rows'] = Database::affectedRows();
        }
		$ret['newid'] = Database::lastID();
        return $ret;
    }


    public function update($info)
    {
         if(DEBUG>1) $info['debug'] = true;
        $table = (isset($info['table'])) ? $info['table'] : null;
        $where = (isset($info['where'])) ? $info['where'] : 1;
        $data = (isset($info['data'])) ? $info['data'] : null;

        // If table name or data not provided return false
        if (!$table || !$data)
            return false;

        $updateStr = array();

        // Get the table field meta data
        $fieldMap = self::getTableFields($info['table']);

        // Quote fields as needed
        foreach ($fieldMap as $field => $settings) {
            // Break down each field's meta info into attributes
            list($type,
                    $len,
                    $required,
                    $autoinc,
                    $pk,
                    $uniq,
                    $enum) = explode(':', $settings);

            $userField = strtolower($field);


            if (isset($data[$userField]))
                $value = trim($data[$userField]);
            else
                continue;

            // Special case: value = NULL is changed to value = ''
            if (preg_match("/^NULL$/i", $value))
                $value = '';

            // Quote strings/date/blob type data
            $value = (preg_match("/string/i", $type) ||
                    preg_match("/char/i", $type) ||
                    preg_match("/date/i", $type) ||
                    preg_match("/time/i", $type) ||
                    preg_match("/blob/i", $type)) ? self::escapeString($value) : $value;
            $updateStr[] = "$field = $value";
        }

        $keyVal = implode(', ', $updateStr);
		mysql_query('SET CHARACTER SET utf8');
		mysql_query("SET SESSION collation_connection ='utf8_general_ci'"); 
		
		$update = "UPDATE $table  SET $keyVal WHERE $where";
        $result = Database::query($update, 2, __FILE__, __LINE__);;
        $err = mysqli_error();
        $affectedRows = Database::affectedRows();

        // If debugging is turned on show helpful info
        if (isset($info['debug']) && $info['debug']) {
            echo $update;
            echo $err;
            echo "Affected rows $affectedRows";
        }
        return (empty($err)) ? true : false;
    }




}

?>