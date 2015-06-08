<?php 
class TroopsLeave
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'troops_leaves';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	 // self::$extendent_folder_path = 'modules/';
	}

	public function add()
	{
		$_POST['start_date'] = ($_POST['start_date']) ? Common::converToMysqlDate($_POST['start_date']) : '';
		$_POST['end_date'] = ($_POST['end_date']) ? Common::converToMysqlDate($_POST['end_date']) : '';

		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function get($dataId)
	{
		$dataId = DataValidator::isNumeric('var', $dataId, SE.' (Module::get::dataId)');
		
		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$dataId";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	
	public function gets($condition='')
	{
		$sql = "SELECT *, DATEDIFF(end_date, start_date)+1 AS DiffDate FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY ".self::$PrimeryKey;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public function data_count($condition='')
	{
		$sql = "SELECT 
		 				count(ipb_troops_leaves.leave_id) AS total
				FROM
					 ipb_troops_leaves
					 LEFT JOIN ipb_troops ON ipb_troops.troops_id = ipb_troops_leaves.troops_id
				WHERE 
					ipb_troops_leaves.status='active' $condition 
					";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function data_count_all($condition='')
	{
		 $sql = "SELECT 
		 				count(ipb_troops_leaves.leave_id) AS total
				FROM
					 ipb_troops_leaves
					 LEFT JOIN ipb_troops ON ipb_troops.troops_id = ipb_troops_leaves.troops_id
				WHERE 
					ipb_troops_leaves.status!='deleted' $condition 
					";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 $sql = "SELECT 
						ipb_troops_leaves.leave_id,
						-- CONCAT(ipb_troops.troops_id, ' ', ipb_troops.name) AS troops_info,
						ipb_troops.name AS troops_id,
						ipb_troops_leaves.leave_type,
						ipb_troops.name,
						ipb_troops_leaves.start_date,
						ipb_troops_leaves.end_date,
						DATEDIFF(ipb_troops_leaves.end_date, ipb_troops_leaves.start_date)+1 AS total_leave,
						ipb_troops_leaves.status
				FROM
					 ipb_troops_leaves
					 LEFT JOIN ipb_troops ON ipb_troops.troops_id = ipb_troops_leaves.troops_id
				WHERE 
					ipb_troops_leaves.status!='deleted' $condition 
				ORDER BY 
					ipb_troops_leaves.troops_id, ipb_troops_leaves.leave_type ASC
					
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public function data_count_summery($condition='')
	{
		 $sql = "SELECT 
		 				count(ipb_troops_leaves.troops_id) AS total
				FROM
					 ipb_troops_leaves
					 LEFT JOIN ipb_troops ON ipb_troops.troops_id = ipb_troops_leaves.troops_id
				WHERE 
					ipb_troops_leaves.status!='deleted' $condition 
				GROUP BY
					ipb_troops_leaves.troops_id
					";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_summery($condition='', $offset, $rows)
	{
		 $sql = "SELECT 
						ipb_troops.name,
						ipb_troops.troops_id,
						SUM( IF(ipb_troops_leaves.leave_type<=>'Earn', DATEDIFF(ipb_troops_leaves.end_date, ipb_troops_leaves.start_date)+1, 0) ) AS total_earn,
						SUM( IF(ipb_troops_leaves.leave_type<=>'Casual', DATEDIFF(ipb_troops_leaves.end_date, ipb_troops_leaves.start_date)+1, 0) ) AS total_casual
						
				FROM
					 ipb_troops_leaves
					 LEFT JOIN ipb_troops ON ipb_troops.troops_id = ipb_troops_leaves.troops_id
				WHERE 
					ipb_troops_leaves.status!='deleted' $condition
				GROUP BY
					ipb_troops_leaves.troops_id
				ORDER BY 
					ipb_troops_leaves.troops_id ASC
				LIMIT
					$offset,$rows ";
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