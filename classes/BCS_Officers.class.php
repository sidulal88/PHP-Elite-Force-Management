<?php 
class BCS_Officers
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'bcs_officers';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	  self::$extendent_folder_path = 'bcs_officers/';
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


		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function edit()
	{
		$bcs_officer_id = $_POST['bcs_officer_id'];

		$_POST['photo'] = $_POST['cur_file'];		
		if($_FILES['file_one']['name']!='') {
			//DataValidator::isValidPhoto(self::$file_permission_list, 'photo');
			
			$Uploader = new Uploader();
			
			$Uploader -> photoDelete($_POST['cur_file'], self::$extendent_folder_path);
			$_POST['photo'] = $Uploader -> photoNamer(1, 'file_one', 120, self::$extendent_folder_path);
			
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
		$sql = "SELECT count(ipb_bcs_officers.bcs_officer_id) AS total
				FROM 
					ipb_bcs_officers
					LEFT JOIN ipb_distrcit_list ON ipb_distrcit_list.district_id = ipb_bcs_officers.district_id
 				WHERE
					ipb_bcs_officers.status='active' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_ui_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT
						 ipb_bcs_officers.bcs_officer_id,
						 ipb_bcs_officers.name,
						 ipb_bcs_officers.contact_no,
						 ipb_bcs_officers.merit_no,
						 ipb_bcs_officers.police_id_no,
						 ipb_bcs_officers.batch_no, 
						 ipb_bcs_officers.current_rank,
						 ipb_bcs_officers.posting_place,
						 ipb_ranks.rank_name,
						 ipb_bcs_officers.photo,
						 ipb_distrcit_list.distrcit_name
				FROM
					 ipb_bcs_officers
					 LEFT JOIN ipb_distrcit_list ON ipb_distrcit_list.district_id = ipb_bcs_officers.district_id
					 LEFT JOIN ipb_ranks ON ipb_ranks.rank_id = ipb_bcs_officers.current_rank
				WHERE 
					ipb_bcs_officers.status='active' $condition 
				ORDER BY
					ipb_bcs_officers.batch_no DESC, ipb_bcs_officers.merit_no ASC
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	

	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT
						 ipb_bcs_officers.bcs_officer_id,
						 ipb_bcs_officers.name,
						 ipb_bcs_officers.contact_no,
						 ipb_bcs_officers.merit_no,
						 ipb_bcs_officers.police_id_no,
						 ipb_bcs_officers.batch_no, 
						 ipb_bcs_officers.current_rank,
						 ipb_bcs_officers.posting_place,
						 ipb_ranks.rank_name,
						 ipb_bcs_officers.photo,
						 ipb_distrcit_list.distrcit_name,
						 ipb_bcs_officers.status
				FROM
					 ipb_bcs_officers
					 LEFT JOIN ipb_distrcit_list ON ipb_distrcit_list.district_id = ipb_bcs_officers.district_id
					 LEFT JOIN ipb_ranks ON ipb_ranks.rank_id = ipb_bcs_officers.current_rank
				WHERE 
					ipb_bcs_officers.status!='deleted' $condition 
				ORDER BY
					ipb_bcs_officers.batch_no DESC, ipb_bcs_officers.merit_no ASC
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