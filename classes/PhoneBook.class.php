<?php 
class PhoneBook
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'phone_book';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	 // self::$extendent_folder_path = 'modules/';
	}

	public function add()
	{
	
		if($_POST['add_unit']==1) {
			$additiona_part = Unit::getName($_POST['unit']);
			$_POST['designation_name'] = $_POST['designation_name'].', '.$additiona_part;
		}
		
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function get($dataId)
	{
		$dataId = DataValidator::isNumeric('var', $dataId, SE.' (Module::get::dataId)');
		
		$sql = "SELECT * FROM ipb_industry_list WHERE ".self::$PrimeryKey."=$dataId";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	
	public function gets($condition='')
	{
		$sql = "SELECT * FROM ipb_phone_book WHERE status!='deleted' $condition ORDER BY ".self::$PrimeryKey;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	public function data_count($condition='')
	{
		$sql = "SELECT count(ipb_phone_book.book_id) AS total
				FROM 
					ipb_phone_book
 				WHERE
					ipb_phone_book.status='active' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_ui_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT
						 ipb_phone_book.phone,
						 ipb_phone_book.mobile,
						 ipb_phone_book.fax,
						 ipb_phone_book.email,
						 ipb_phone_book.designation_name
				FROM
					 ipb_phone_book
				WHERE 
					ipb_phone_book.status='active' $condition
				ORDER BY
					 ipb_phone_book._sort ASC 
				LIMIT
					$offset,$rows";
	
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
		
	
	public function data_count_all($condition='')
	{
		 $sql = "SELECT 
		 				count(ipb_phone_book.book_id) AS total
				FROM
					 ipb_phone_book
					 LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_phone_book.unit
				WHERE 
					ipb_phone_book.status!='deleted' $condition 
					";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 $sql = "SELECT 
						ipb_phone_book.book_id,
						ipb_phone_book.phone,
						ipb_phone_book.mobile,
						ipb_phone_book.status,
						ipb_phone_book.fax,
						ipb_phone_book.email,
						ipb_phone_book.unit,
						ipb_phone_book._sort,
						ipb_phone_book.status,
						ipb_unit_list.unit_name,
						ipb_phone_book.designation_name
				FROM
					 ipb_phone_book
					 LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_phone_book.unit
				WHERE 
					ipb_phone_book.status!='deleted' $condition 
				ORDER BY
					ipb_phone_book._sort  ASC
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