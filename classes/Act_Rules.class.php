<?php 
class Act_Rules
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'act_rules';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	  self::$extendent_folder_path = 'act_rules/';
	}

	public function add()
	{
		
		$_POST['status'] = 'active';

		$_POST['recTime'] = $this->recTime;

		$_POST['recBy'] = $_SESSION['adminId'];
		
		
		if($_FILES['file_one']['name']!='') {
			//DataValidator::isValidPDFfile('photo');
		
			$Uploader = new Uploader();
			$_POST['attachment'] = $Uploader -> file_upload_single(self::$extendent_folder_path);
		}
		

	
		$ret = DataProcess::saveData($_POST, self::$tableName, true);
	}
	
	
	
	
	public function edit()
	{
		$rule_id = $_POST['rule_id'];
		if($_FILES['file_one']['name']!='') {
			$Uploader = new Uploader();
			$_POST['attachment'] = $Uploader -> file_upload_single(self::$extendent_folder_path, $_POST['cur_file']);
		}
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
					".self::$tableName." WHERE status='active'  $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 
		 $sql = "SELECT *
				FROM
					 ".self::$tableName."
				WHERE 
					status!='deleted' $condition 
				ORDER BY 
					sort_no, ".self::$PrimeryKey." ASC 
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public function get_ui_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT
						*
				FROM
					 ipb_act_rules
				WHERE 
					ipb_act_rules.status='active' $condition 
				ORDER BY 
					sort_no, ".self::$PrimeryKey." ASC 
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	

	
	public function delete($dataId)
	{
		$sql = "UPDATE ".self::$tableName." SET status='deleted' WHERE ".self::$PrimeryKey."=".$dataId;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
	}



}
?>