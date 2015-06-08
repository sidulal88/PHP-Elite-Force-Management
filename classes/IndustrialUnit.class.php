<?php 
class IndustrialUnit
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'industrial_unit';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	  self::$extendent_folder_path = 'unit_map/';
	}

	public function add()
	{
		$_POST['status'] = 'active';

		$_POST['recTime'] = $this->recTime;

		$_POST['recBy'] = $_SESSION['adminId'];

		
		if($_FILES['file_one']['name']!='') {
			//DataValidator::isValidPDFfile('photo');
		
			$Uploader = new Uploader();
			$_POST['photo'] = $Uploader -> file_upload_single(self::$extendent_folder_path);
		}
		$_POST['description'] = DataValidator::sanitizeSpecialChars('post', 'description', 'Please input a description.');	 
		$ret = DataProcess::saveData($_POST, self::$tableName, false);

	}
	
	
	public function edit()
	{
		
		if($_FILES['file_one']['name']!='') {
			$Uploader = new Uploader();
			$Uploader -> photoDelete($_POST['cur_file'], self::$extendent_folder_path);
			$_POST['photo'] = $Uploader -> file_upload_single(self::$extendent_folder_path);
		}
		//$_POST['description'] = DataValidator::sanitizeSpecialChars('post', 'description', 'Please input a description.');
		$_POST['description'] = str_replace("'", " ", $_POST['description']);
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	
	public function get($dataId)
	{
		$dataId = DataValidator::isNumeric('var', $dataId, SE.' (Module::get::dataId)');
		
		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$dataId";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	
	public function getByUnit($dataId)
	{
		$dataId = DataValidator::isNumeric('var', $dataId, SE.' (Module::get::dataId)');
		
		$sql = "SELECT * FROM ".self::$tableName." WHERE unit_id='$dataId' ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	
	public function gets($condition='')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY ".self::$PrimeryKey;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	

	public function data_count_all($condition='')
	{
		  $sql = "SELECT 
		 				count(ipb_industrial_unit.industry_unit_id) AS total
				FROM
					 ipb_industrial_unit
					 LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_industrial_unit.unit_id
				WHERE 
					ipb_industrial_unit.status!='deleted' $condition 
					";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		 $sql = "SELECT 
						ipb_industrial_unit.industry_unit_id,
						ipb_industrial_unit.unit_id,
						ipb_industrial_unit.photo,
						ipb_industrial_unit.status,
						ipb_industrial_unit.sort,
						ipb_unit_list.unit_name
						
				FROM
					 ipb_industrial_unit
					 LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_industrial_unit.unit_id
				WHERE 
					ipb_industrial_unit.status!='deleted' $condition 
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