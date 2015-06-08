<?php 
class Tenders
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'tenders';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	  self::$extendent_folder_path = 'tender/';
	}

	public function add()
	{
			
		$_POST['status'] = 'active';

		$_POST['recTime'] = $this->recTime;

		$_POST['recBy'] = $_SESSION['adminId'];
		$_POST['expired'] = 'no';
		
		
		$Uploader = new Uploader();
		if($_FILES['file_one']['name']!='') {
			$_POST['attachment'] = $Uploader -> file_upload_single(self::$extendent_folder_path, 'file_one');
		}
		
		if($_FILES['file_two']['name']!='') {
			$_POST['tender_schedule'] = $Uploader -> file_upload_single(self::$extendent_folder_path, 'file_two');
		}
		
		$_POST['date'] = Common::converToMysqlDate($_POST['date']);
		$_POST['schedule_date'] = Common::converToMysqlDateTime($_POST['schedule_date']);
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
		
		if($_FILES['file_two']['name']!='') {
		
			$Uploader = new Uploader();
			$Uploader -> photoDelete($_POST['cur_file2'], self::$extendent_folder_path);
			$_POST['tender_schedule'] = $Uploader -> file_upload_single(self::$extendent_folder_path, 'file_two');
			
		}
		$_POST['date'] = Common::converToMysqlDate($_POST['date']);
		$_POST['schedule_date'] = Common::converToMysqlDateTime($_POST['schedule_date']);
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
		$sql = "SELECT count(ipb_tenders.tender_id) AS total
				FROM 
					ipb_tenders
					LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_tenders.unit_id
				WHERE 
					ipb_tenders.status='active' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_ui_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT
						 ipb_tenders.tender_id,
						 ipb_tenders.title,
						 ipb_tenders.tender_no,
						 ipb_tenders.date,
						 ipb_tenders.schedule_date,
						 ipb_tenders.attachment,
						 ipb_tenders.tender_schedule,
						 ipb_tenders.expired,
						 ipb_unit_list.unit_name
				FROM
					 ipb_tenders
					 LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_tenders.unit_id
				WHERE 
					ipb_tenders.status='active' $condition 
				ORDER BY 
					ipb_tenders.date DESC
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public function data_count_all($condition='')
	{
		$sql = "SELECT count(*) AS total 
				FROM 
					ipb_tenders
					LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_tenders.unit_id
		 		WHERE 
					ipb_tenders.status!='deleted' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 
		 $sql = "SELECT 
		 				ipb_tenders.tender_id,
						 ipb_tenders.title,
						 ipb_tenders.tender_no,
						 ipb_tenders.date,
						 ipb_tenders.schedule_date,
						 ipb_tenders.unit_id,
						 ipb_tenders.attachment,
						 ipb_tenders.tender_schedule,
						 ipb_tenders.status,
						 ipb_unit_list.unit_name
				FROM 
					ipb_tenders
					LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_tenders.unit_id
		 		WHERE 
					ipb_tenders.status!='deleted' $condition 
				ORDER BY 
					ipb_tenders.date DESC
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