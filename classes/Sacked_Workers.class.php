<?php 
class Sacked_Workers
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'sacked_workers';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	  self::$extendent_folder_path = 'sacked/';
	}

	public function add()
	{
		$_POST['status'] = 'active';

		$_POST['recTime'] = $this->recTime;

		$_POST['recBy'] = $_SESSION['adminId'];

		
		
		if($_FILES['file_one']['name']!='') {
			//DataValidator::isValidPhoto(self::$file_permission_list, 'file_one');
		
			$Uploader = new Uploader();
			$photoLarge = $_POST['photo'] = $Uploader -> photoNamer(1, 'file_one', 120, self::$extendent_folder_path);
		}

		
		
		
		$_POST['sacked_date'] = Common::converToMysqlDate($_POST['sacked_date']);
		
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
		$sql = "SELECT count(ipb_sacked_workers.sacked_worker_id) as total
				FROM 
					ipb_sacked_workers
				WHERE 
					ipb_sacked_workers.status='active' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_ui_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT
						 ipb_sacked_workers.sacked_worker_id,
						 ipb_sacked_workers.name,
						 ipb_sacked_workers.contact_no,
						 ipb_sacked_workers.nid,
						 ipb_sacked_workers.per_address,
						 ipb_sacked_workers.sacked_date, 
						 ipb_sacked_workers.reson,
						 ipb_sacked_workers.photo,
						 ipb_sacked_workers.sacked_from
				FROM
					 ipb_sacked_workers
				WHERE 
					ipb_sacked_workers.status='active' $condition 
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
	
	public function edit($dataId)
	{
		$_POST['photo'] = $_POST['cur_file'];		
		if($_FILES['file_one']['name']!='') {
			//DataValidator::isValidPhoto(self::$file_permission_list, 'photo');
			
			$Uploader = new Uploader();
			
			$Uploader -> photoDelete($_POST['cur_file'], self::$extendent_folder_path);
			$_POST['photo'] = $Uploader -> photoNamer(1, 'file_one', 120, self::$extendent_folder_path);
			
		}
		
		
		$_POST['sacked_date'] = Common::converToMysqlDate($_POST['sacked_date']);
		DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	
	public function delete($dataId)
	{
		$sql = "UPDATE ".self::$tableName." SET status='deleted' WHERE ".self::$PrimeryKey."=".$dataId;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
	}
	
}
?>