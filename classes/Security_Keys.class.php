<?php 
class Security_Keys
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'security_cods';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	 // self::$extendent_folder_path = 'modules/';
	}

	public function add()
	{
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function get($dataId)
	{
		$dataId = DataValidator::isNumeric('var', $dataId, SE.' (Module::get::dataId)');
		
		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$dataId";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	
	
	
	public function data_count($condition='')
	{
		 $sql = "SELECT count(*) AS total
				FROM 
					".self::$tableName;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 $sql = "SELECT 
						sec.security_id,
						sec.type,
						sec.unit_id,
						sec.security_code,
						ul.unit_name,
						sec.status
				FROM
					 ipb_security_cods AS sec
					 LEFT JOIN ipb_unit_list AS ul ON ul.unit_id = sec.unit_id
				WHERE 
					sec.status!='deleted' $condition 
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	

	
	public function security_key($condition)
	{
		$sql = "SELECT security_code FROM ipb_security_cods WHERE status!='deleted' $condition";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['security_code'];
	}
	
	
	public function delete($dataId)
	{
		$sql = "UPDATE ".self::$tableName." SET status='deleted' WHERE ".self::$PrimeryKey."=".$dataId;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
	}


	
}
?>