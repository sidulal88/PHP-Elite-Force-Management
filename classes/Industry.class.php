<?php 
class Industry
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'industry_list';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	 // self::$extendent_folder_path = 'modules/';
	}

	public function add()
	{
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function get($dataId)
	{
		$dataId = DataValidator::isNumeric('var', $dataId, SE.' (Module::get::dataId)');
		
		$sql = "SELECT * FROM ipb_industry_list WHERE ".self::$PrimeryKey."=$dataId";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	public function getSummery($dataId)
	{
		$dataId = DataValidator::isNumeric('var', $dataId, SE.' (Module::get::dataId)');
		
		
		$sql = "SELECT
						 ipb_industry_list.contact_no,
						 ipb_industry_list.contact_person,
						 ipb_industry_list.member_ship,
						 ipb_unit_list.unit_name,
						 ipb_industry_list.owner,
						 ipb_industry_list.remarks
				FROM
					 ipb_industry_list
					 LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_industry_list.unit_id
				WHERE  
					ipb_industry_list.industry_id='$dataId' 
				";
					
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	
	public function gets($condition='')
	{
		$sql = "SELECT * FROM ipb_industry_list WHERE status!='deleted' $condition ORDER BY ".self::$PrimeryKey;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	public function data_count($condition='')
	{
		$sql = "SELECT COUNT(*) AS total FROM ipb_industry_list WHERE status='active' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function data_count_all($condition='')
	{
		$sql = "SELECT COUNT(ipb_industry_list.industry_id) as total
				FROM
					ipb_industry_list
					LEFT JOIN ipb_product ON ipb_product.productid =  ipb_industry_list.product_id
			   WHERE 
			   		ipb_industry_list.status!='deleted' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_ui_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT
					ipb_industry_list.industry_id,
					ipb_industry_list.industry_name,
					ipb_industry_list.address,
					ipb_industry_list.worker_male, 
					ipb_industry_list.worker_female,
					(ipb_industry_list.worker_male + ipb_industry_list.worker_female) AS total_worker,
					ipb_product.productname AS product_name
				FROM
					ipb_industry_list
					LEFT JOIN ipb_product ON ipb_product.productid =  ipb_industry_list.product_id
			   WHERE 
			   		ipb_industry_list.status!='deleted' $condition
			   ORDER BY
			   		ipb_industry_list.industry_name ASC 
			   LIMIT 
			   		$offset,$rows";
						
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 
		$sql = "SELECT
					ipb_industry_list.industry_id,
					ipb_industry_list.industry_name,
					ipb_industry_list.address,
					ipb_industry_list.contact_no,
					ipb_industry_list.owner,
					ipb_industry_list.unit_id,
					ipb_unit_list.unit_name,
					ipb_industry_list.worker_male, 
					ipb_industry_list.worker_female,
					(ipb_industry_list.worker_male + ipb_industry_list.worker_female) AS total_worker,
					ipb_industry_list.product_id,
					ipb_product.productname AS product_name,
					ipb_industry_list.member_ship,
					ipb_industry_list.status
				FROM
					ipb_industry_list
					LEFT JOIN ipb_product ON ipb_product.productid =  ipb_industry_list.product_id
					LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_industry_list.unit_id
			   WHERE 
			   		ipb_industry_list.status!='deleted' $condition 
			   ORDER BY
			   		ipb_industry_list.industry_name ASC 
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