<?php 
class Unit
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'unit_list';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  self::$ForeignKey = 'sub_under';
	 // self::$extendent_folder_path = 'modules/';
	}

	public function add()
	{
		if(!empty($_POST['mainUnit']))
		{
			$sub_under = explode("::", $_POST['mainUnit']);
			$_POST['sub_under'] = $sub_under[0];
			$_POST['data_level']  = $sub_under[1]+1;
		}
		else
		{
			$_POST['sub_under'] = '0';
			$_POST['data_level'] = 1;
		}
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function get($dataId)
	{
		$dataId = DataValidator::isNumeric('var', $dataId, SE.' (Module::get::dataId)');
		
		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."='$dataId' ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	
	public function gets($condition='')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY _sort, unit_name ASC ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public static function getName($dataId)
	{		
		$sql = "SELECT unit_name FROM ipb_unit_list WHERE unit_id=$dataId";
		
		$result = Database::query($sql, 1, __FILE__, __LINE__);

		return $result['unit_name'];	
	}
	
	
	public function data_count($condition='')
	{
		 $sql = "SELECT count(*) AS total
				FROM 
					".self::$tableName;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 $sql = "SELECT 
						ul.unit_id,
						ul.unit_name,
						ul.is_industry,
						IF(ul.is_industry<=>1, 'Yes', 'No') AS is_industry_status,
						parent_ul.unit_name AS sub_under_name,
						CONCAT(parent_ul.unit_id, '::', parent_ul.data_level) AS mainUnit,
						ul.data_level,
						ul.location,
						ul.address,
						ul.status
				FROM
					 ipb_unit_list AS ul
					 LEFT JOIN ipb_unit_list AS parent_ul ON parent_ul.unit_id = ul.sub_under
				WHERE 
					ul.status!='deleted' $condition ORDER BY ul._sort, ul.unit_name ASC
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public function get_admin_grid_chain($condition='', $offset, $rows)
	{
		 $sql = "SELECT 
						ul.unit_id,
						ul.unit_name,
						ul.is_industry,
						ul.data_level,
						IF(ul.is_industry<=>1, 'Yes', 'No') AS is_industry_status,
						parent_ul.unit_name AS sub_under_name,
						CONCAT(parent_ul.unit_id, '::', parent_ul.data_level) AS mainUnit,
						ul.data_level,
						ul.location,
						ul.address,
						ul.status
				FROM
					 ipb_unit_list AS ul
					 LEFT JOIN ipb_unit_list AS parent_ul ON parent_ul.unit_id = ul.sub_under
				WHERE 
					ul.status!='deleted' $condition ORDER BY ul._sort, ul.unit_name ASC
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
        $resultNew = array();
        while ($row = $result->fetch_array(MYSQL_ASSOC)) {
            $resultNew[] = $row;
        }
		
		$output = array();
		$menutree = Common::generateMenuArray(0, $output, Common::buildChild($resultNew), 10, 0,null,"-->" );
		return $menutree;
	}
	
	
	public static function getsGrid2($condition='')
	{
		$sql =  "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY unit_id, sub_under";
        $result = Database::query($sql, 2, __FILE__, __LINE__);
        $resultNew = array();
        while ($row = $result->fetch_array(MYSQL_ASSOC)) {
            $resultNew[] = $row;
        }
		
		$output = array();
		$menutree = Common::generateMenuArray(0, $output, Common::buildChild($resultNew), 10, 0,null,"-->" );
		return $menutree;
	}
	
	public static function getsGrid($condition='')
	{
		$sql =  "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY data_level, _sort, unit_name ASC";
        $result = Database::query($sql, 2, __FILE__, __LINE__);
        $resultNew = array();
        while ($row = $result->fetch_array(MYSQL_ASSOC)) {
            $resultNew[] = $row;
        }
		
		$output = array();
		$menutree = Common::generateMenuArray(0, $output, Common::buildChild($resultNew), 10, 0,null,"-->" );
		return $menutree;
	}
	
	
	public static function getNavMenu($page_id)
	{
		$navTree = array_reverse(Common::buildParent($page_id, $parent_list=array(), self::$tableName, self::$PrimeryKey, self::$ForeignKey));	
		return $navTree;
	}
	
	
	public static function getNextMenus($page_id)
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' AND ".self::$ForeignKey."=".$page_id;
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