<?php 
class UnitStrength
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'unit_strength';
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
	
	public function gets($condition='')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY ".self::$PrimeryKey;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public function data_count($condition='')
	{
		 $sql = "SELECT 
		 				count(un_st.strength_id) AS total
				FROM
					 ipb_unit_strength AS un_st
					 LEFT JOIN ipb_unit_list AS un ON un.unit_id = un_st.unit_id
					 LEFT JOIN ipb_ranks AS rank ON rank.rank_id = un_st.rank_id
				WHERE 
					un_st.status!='deleted' $condition 
					";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 $sql = "SELECT 
						un_st.strength_id,
						un_st.unit_id,
						un_st.rank_id,
						un_st.authorised_strength,
						un_st.status,
						un.unit_name,
						rank.rank_name
				FROM
					 ipb_unit_strength AS un_st
					 LEFT JOIN ipb_unit_list AS un ON un.unit_id = un_st.unit_id
					 LEFT JOIN ipb_ranks AS rank ON rank.rank_id = un_st.rank_id
				WHERE 
					un_st.status!='deleted' $condition 
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