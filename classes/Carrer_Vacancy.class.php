<?php 
class Carrer_Vacancy
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'vacancy_list';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	  self::$extendent_folder_path = 'vacancy/';
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
		$_POST['date'] = Common::converToMysqlDate($_POST['date']);
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	
	
	public function edit($dataId)
	{
		$_POST['photo'] = $_POST['cur_file'];		
		if($_FILES['file_one']['name']!='') {
		
			$Uploader = new Uploader();
			$Uploader -> photoDelete($_POST['cur_file'], self::$extendent_folder_path);
			$_POST['attachment'] = $Uploader -> file_upload_single(self::$extendent_folder_path, 'file_one');
			
		}
		$_POST['date'] = Common::converToMysqlDate($_POST['date']);
		
		DataProcess::saveData($_POST, self::$tableName, false);
	
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
		$sql = "SELECT count(*) AS total FROM ".self::$tableName." WHERE status='active' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_ui_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT
						*
				FROM
					 ipb_vacancy_list
				WHERE 
					ipb_vacancy_list.status='active' $condition 
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	

	
	public function data_count_all($condition='')
	{
		$sql = "SELECT count(*) AS total FROM ".self::$tableName." WHERE status!='deleted' $condition ";
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