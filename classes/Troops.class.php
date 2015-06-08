<?php 
class Troops
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'troops';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	  self::$extendent_folder_path = 'troops/';
	}

	public function add()
	{
		$_POST['status'] = 'active';

		$_POST['recTime'] = $this->recTime;

		$_POST['recBy'] = $_SESSION['adminId'];
		
		
		if($_FILES['file_one']['name']!='') {
			//DataValidator::isValidPhoto(self::$file_permission_list, 'file_one');
			$Uploader = new Uploader();
			$photoLarge = $_POST['photo'] = $Uploader -> photoNamer(1, 'file_one', 180, self::$extendent_folder_path);
		}

		
		if(!empty($_POST['dob']))
		{
			$_POST['dob'] = Common::converToMysqlDate($_POST['dob']);
		}
		
		if(!empty($_POST['last_mc']))
		{
			$_POST['last_mc'] = Common::converToMysqlDate($_POST['last_mc']);
		}
		
		if(!empty($_POST['dor']))
		{
			$_POST['dor'] = Common::converToMysqlDate($_POST['dor']);
		}
		
		if(!empty($_POST['doj']))
		{
			$_POST['doj'] = Common::converToMysqlDate($_POST['doj']);
		}
		if(!empty($_POST['doi']))
		{
			$_POST['doi'] = Common::converToMysqlDate($_POST['doi']);
		}
		
		if(!empty($_POST['promotion_date']))
		{
			$_POST['promotion_date'] = Common::converToMysqlDate($_POST['promotion_date']);
		}
		
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
		
	}
	
	
	public function edit()
	{
		
		$_POST['photo'] = $_POST['cur_file'];		
		if($_FILES['file_one']['name']!='') {
			//DataValidator::isValidPhoto(self::$file_permission_list, 'photo');
			
			$Uploader = new Uploader();
			
			$Uploader -> photoDelete($_POST['cur_file'], self::$extendent_folder_path);
			$_POST['photo'] = $Uploader -> photoNamer(1, 'file_one', 180, self::$extendent_folder_path);
			
		}
		
		
		
		if(!empty($_POST['dob']))
		{
			$_POST['dob'] = Common::converToMysqlDate($_POST['dob']);
		}
		
		if(!empty($_POST['last_mc']))
		{
			$_POST['last_mc'] = Common::converToMysqlDate($_POST['last_mc']);
		}
		
		if(!empty($_POST['dor']))
		{
			$_POST['dor'] = Common::converToMysqlDate($_POST['dor']);
		}
		
		if(!empty($_POST['doj']))
		{
			$_POST['doj'] = Common::converToMysqlDate($_POST['doj']);
		}
		if(!empty($_POST['doi']))
		{
			$_POST['doi'] = Common::converToMysqlDate($_POST['doi']);
		}
		
		if(!empty($_POST['promotion_date']))
		{
			$_POST['promotion_date'] = Common::converToMysqlDate($_POST['promotion_date']);
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
	
	public function get_combo($condition='')
	{
		$sql = "SELECT 
					ipb_troops.troops_id,
					ipb_troops.name,
					ipb_ranks.rank_name,
					ipb_troops.brash_no,
					ipb_troops.police_id,
					ipb_unit_list.unit_name
					
				FROM 
					ipb_troops
					LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_troops.police_unit
					LEFT JOIN ipb_ranks ON ipb_ranks.rank_id = ipb_troops.present_rank

				WHERE 
					ipb_troops.status!='deleted' AND 
					ipb_troops.name LIKE '%$condition%' OR ipb_troops.police_id LIKE '%$condition%' OR 
					ipb_troops.police_id LIKE '%$condition%' OR ipb_ranks.rank_name LIKE '%$condition%'
					 OR ipb_unit_list.unit_name LIKE '%$condition%'
				ORDER BY 
					name ASC";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	public function gets($condition='')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY name ASC";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public function data_count($condition='')
	{
		$sql = "SELECT
						 count(ipb_troops.troops_id) AS total 
				FROM
					 ipb_troops
					 LEFT JOIN ipb_ranks ON ipb_ranks.rank_id = ipb_troops.present_rank
				WHERE 
					ipb_troops.status='active' $condition 
			";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_ui_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT
						 ipb_troops.troops_id,
						 ipb_troops.name,
						 ipb_troops.contact_no,
						 ipb_troops.per_address,
						 ipb_troops.brash_no, 
						 ipb_troops.present_rank,
						 ipb_ranks.rank_name,
						 ipb_statuses.status_name
				FROM
					 ipb_troops
					 LEFT JOIN ipb_ranks ON ipb_ranks.rank_id = ipb_troops.present_rank
					 LEFT JOIN ipb_statuses ON ipb_statuses.status_id = ipb_troops.morning_status
				WHERE 
					ipb_troops.status='active' $condition 
				ORDER BY 
					ipb_troops.present_rank, ipb_troops.brash_no ASC
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	

	
	public function Morning_Report($police_unit)
	{
		$sql = "SELECT 
							count(ipb_troops.troops_id) AS total_trops_,
							SUM( IF(ipb_troops.present_rank<=>1, 1, 0) ) AS total_igp,
							SUM( IF(ipb_troops.present_rank<=>2, 1, 0) ) AS total_addl_igp,
							SUM( IF(ipb_troops.present_rank<=>3, 1, 0) ) AS total_dig,
							SUM( IF(ipb_troops.present_rank<=>4, 1, 0) ) AS total_addl_dig,
							SUM( IF(ipb_troops.present_rank<=>5, 1, 0) ) AS total_sp,
							SUM( IF(ipb_troops.present_rank<=>6, 1, 0) ) AS total_add_sp,
							SUM( IF(ipb_troops.present_rank<=>7, 1, 0) ) AS total_sr_asp,
							SUM( IF(ipb_troops.present_rank<=>8, 1, 0) ) AS total_asp,
							SUM( IF(ipb_troops.present_rank<=>9, 1, 0) ) AS total_insp,
							SUM( IF(ipb_troops.present_rank<=>10, 1, 0) ) AS total_si,
							SUM( IF(ipb_troops.present_rank<=>11, 1, 0) ) AS total_sergeant,
							SUM( IF(ipb_troops.present_rank<=>12, 1, 0) ) AS total_asi,
							SUM( IF(ipb_troops.present_rank<=>13, 1, 0) ) AS total_naik,
							SUM( IF(ipb_troops.present_rank<=>14, 1, 0) ) AS total_constable,
							SUM( IF(ipb_troops.present_rank<=>15, 1, 0) ) AS total_other,
							
							ipb_statuses.status_name
					  FROM 
							ipb_statuses
							LEFT JOIN ipb_troops ON (ipb_statuses.status_id =  ipb_troops.morning_status AND ipb_troops.police_unit='$police_unit' AND ipb_troops.status='active')
					  WHERE 
						   1
					GROUP BY 
						    ipb_statuses.status_id 
							";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public function Morning_Report_New($police_unit)
	{
		$sql = "SELECT 
							count(ipb_troops.troops_id) AS total_trops_,
							SUM( IF(ipb_troops.morning_status<=>1, 1, 0) ) AS total_leave,
							SUM( IF(ipb_troops.morning_status<=>2, 1, 0) ) AS total_sick,
							SUM( IF(ipb_troops.morning_status<=>3, 1, 0) ) AS total_over_duty,
							SUM( IF(ipb_troops.morning_status<=>4, 1, 0) ) AS total_duty_out_of_station,
							SUM( IF(ipb_troops.morning_status<=>5, 1, 0) ) AS total_on_duty,
							SUM( IF(ipb_troops.morning_status<=>6, 1, 0) ) AS total_on_rest,
							ipb_ranks.rank_name
					  FROM 
							ipb_ranks
							LEFT JOIN ipb_troops ON (ipb_ranks.rank_id =  ipb_troops.present_rank AND ipb_troops.police_unit='$police_unit')
					  WHERE 
						    1 
					GROUP BY 
						    ipb_ranks.rank_id
							";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public function Change_status($search_id, $status_id)
	{
		//$sql = "UPDATE ipb_troops SET morning_status=$status_id WHERE troops_id='$search_id' ";
		//$result = Database::query($sql, 2, __FILE__, __LINE__);
		//$_POST['troops_id'] = $search_id;
		$_POST['morning_status'] = $status_id;
		$_POST['troops_id'] = $search_id;
		 DataProcess::saveData($_POST, self::$tableName, false);
		return $result;
	}
	
	
	public function earn_leave($search_id){
	
		$sql = "SELECT DATEDIFF(NOW(), doj) AS DiffDate FROM ipb_troops WHERE troops_id='$search_id' ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		$show['avg_pay'] = floor($show['DiffDate']/11);
		$show['half_pay'] = floor($show['DiffDate']/12);
		$show['total_avg_pay'] = $show['avg_pay'] + $show['half_pay']/2;
		return $show;
	
	}
	

	public function leave_used($search_id, $leave_type){
		$sql = "SELECT SUM(DATEDIFF(end_date, start_date)+1) AS leave_status FROM ipb_troops_leaves WHERE troops_id='$search_id' AND leave_type= '$leave_type' AND status='active' ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return ($show['leave_status']) ? $show['leave_status'] : 0; 	
	}
	

	
	public function data_count_all($condition='')
	{
		$sql = "SELECT count(*) AS total 
				FROM 
					ipb_troops
					LEFT JOIN ipb_ranks ON ipb_ranks.rank_id = ipb_troops.present_rank
		 		WHERE 
					ipb_troops.status!='deleted' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 
		 $sql = "SELECT 
		 				ipb_troops.troops_id,
						ipb_troops.photo,
						 ipb_troops.name,
						 ipb_troops.police_id,
						 ipb_troops.contact_no,
						 ipb_troops.per_address,
						 ipb_troops.brash_no, 
						 ipb_troops.status,
						 ipb_ranks.rank_name,
						 ipb_unit_list.unit_name,
						 ipb_statuses.status_name
				FROM 
					ipb_troops
					LEFT JOIN ipb_ranks ON ipb_ranks.rank_id = ipb_troops.present_rank
					LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_troops.police_unit
					LEFT JOIN ipb_statuses ON ipb_statuses.status_id = ipb_troops.morning_status
		 		WHERE 
					ipb_troops.status!='deleted' $condition
				ORDER BY 
					ipb_troops.present_rank, ipb_troops.brash_no ASC 
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
	
	
	public function leave_Status_update($condition_status)
	{
		$sql = "UPDATE ipb_troops 
				SET 
					morning_status = 1 
				WHERE 
					$condition_status AND
				EXISTS(
					SELECT 
						troops_id 
					FROM 
						ipb_troops_leaves 
				WHERE ipb_troops_leaves.status='active' AND
					ipb_troops_leaves.troops_id = ipb_troops.troops_id 
					AND CURDATE() BETWEEN start_date AND end_date)";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
	}
	
	


}
?>