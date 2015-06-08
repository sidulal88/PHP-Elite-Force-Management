<?php 
class Module
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'module_info';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  self::$ForeignKey = 'main_catid';
	  self::$extendent_folder_path = 'modules/';
	}

	public function add()
	{
		//$_POST['name'] = DataValidator::sanitizeSpecialChars('post', 'name', 'Please input a name.');	 
		if($_FILES['photo']['name']!='') {
			DataValidator::isValidPhoto('jpg', 'photo');
		
			$Uploader = new Uploader();
			$_POST['photo'] = $Uploader -> photoNamer(1, 'photo', WIDTH_RANGE_LARGE, self::$extendent_folder_path);
			
		}
		
		if(!empty($_POST['mainCatid']))
		{
			$mainCatid = explode("::", $_POST['mainCatid']);
			$_POST['main_catid'] = $mainCatid[0];
			$_POST['sort_level']  = $mainCatid[1]+1;
		}
		//$_POST['description'] = DataValidator::sanitizeSpecialChars('post', 'description', 'Please input a first name.');	 
		$_POST['description'] = str_replace("'", "", $_POST['description']);
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
		echo "<script type=\"text/javascript\">location.replace(\"moduleView.php?msg=ok\");</script>";
	}
	
	public function get($dataId)
	{
		$dataId = DataValidator::isNumeric('var', $dataId, SE.' (Module::get::dataId)');
		
		$sql = "SELECT * FROM ".self::$tableName." WHERE module_id=$dataId";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	
	public function gets($condition='')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY module_id, main_catid $condition";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
	public static function getsGrid()
	{
		$sql =  "SELECT * FROM ".self::$tableName." WHERE status!='deleted' ORDER BY module_id, main_catid";
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
	
	public function getName($dataId)
	{		
		$sql = "SELECT name FROM ".self::$tableName." WHERE module_id=$dataId";
		
		$result = Database::query($sql, 1, __FILE__, __LINE__);

		return $result['name'];	
	}
	
	
	public function edit($dataId)
	{
		$_POST['photo'] = $_POST['curphoto'];
		if($_FILES['photo']['name']!='') {
			DataValidator::isValidPhoto('jpg', 'photo');
			
			$Uploader = new Uploader();
			$Uploader -> photoDelete($_POST['curphoto'], self::$extendent_folder_path);
			$_POST['photo'] = $Uploader -> photoNamer(1, 'photo', WIDTH_RANGE_LARGE, self::$extendent_folder_path);
		}
			
		if(!empty($_POST['mainCatid']))
		{
			$mainCatid = explode("::", $_POST['mainCatid']);
			$_POST['main_catid'] = $mainCatid[0];
			$_POST['sort_level']  = $mainCatid[1]+1;
		}
		//$_POST['description'] = DataValidator::sanitizeSpecialChars('post', 'description', 'Please input a first name.');	 
		$_POST['description'] = str_replace("'", "", $_POST['description']);
		DataProcess::saveData($_POST, self::$tableName, false);
		
		echo "<script type=\"text/javascript\">location.replace(\"moduleView.php?msg=ok\");</script>";
	}
	
	public function delete($dataId)
	{
		$result = $this -> get($dataId);
		
		$show = $result -> fetch_array(MYSQL_ASSOC);	
		
		$Uploader = new Uploader();
		
		$Uploader -> photoDelete($show['photo'], self::$extendent_folder_path);	
	
		$sql = "UPDATE ".self::$tableName." SET status='deleted' WHERE module_id=$dataId";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
	}


}
?>