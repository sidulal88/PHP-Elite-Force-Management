<?php 
class FormerDg
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'former_dgs';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	 // self::$extendent_folder_path = 'modules/';
	}

	public function add()
	{
		$_POST['date_from'] = Common::converToMysqlDate($_POST['date_from']);
		$_POST['date_to'] = ($_POST['date_to'] > '1970-01-01') ? Common::converToMysqlDate($_POST['date_to']) : '';

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
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY ".self::$PrimeryKey;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public function data_count($condition='')
	{
		 $sql = "SELECT 
		 				count(ipb_former_dgs.former_dg_id) AS total
				FROM
					 ipb_former_dgs
					 LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_former_dgs.unit_id
				WHERE 
					ipb_former_dgs.status='active' $condition 
					";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function data_count_all($condition='')
	{
		 $sql = "SELECT 
		 				count(ipb_former_dgs.former_dg_id) AS total
				FROM
					 ipb_former_dgs
					 LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_former_dgs.unit_id
				WHERE 
					ipb_former_dgs.status!='deleted' $condition 
					";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 $sql = "SELECT 
						ipb_former_dgs.former_dg_id,
						ipb_former_dgs.unit_id,
						ipb_former_dgs.dg_name,
						ipb_former_dgs.date_from,
						ipb_former_dgs.date_to,
						ipb_former_dgs.status,
						ipb_unit_list.unit_name
				FROM
					 ipb_former_dgs
					 LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_former_dgs.unit_id
				WHERE 
					ipb_former_dgs.status!='deleted' $condition 
				ORDER BY 
					ipb_former_dgs.unit_id, ipb_former_dgs.date_from ASC
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