<?php
class Article
{

    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
	public static $extendent_folder_path;
	public static $file_permission_list;
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'article';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  self::$extendent_folder_path = 'article/';
	  self::$file_permission_list = 'jpg, jpeg, gif, pdf';
	}

	public function add()
	{
		if($_FILES['photo']['name']!='') {
			DataValidator::isValidPhoto(self::$file_permission_list, 'photo');
		
			$Uploader = new Uploader();
			$_POST['photo'] = $Uploader -> photoNamer(1, 'photo', WIDTH_RANGE_LARGE, self::$extendent_folder_path);
		}
		
		$_POST['publish_date'] = Common::converToMysqlDate($_POST['publish_date']);

		$_POST['status'] = 'active';

		$_POST['recTime'] = $this->recTime;

		$_POST['recBy'] = $_SESSION['adminId'];
		
		//$_POST['description'] = DataValidator::sanitizeSpecialChars('post', 'description', 'Please input a first name.');	 
		$_POST['description'] = str_replace("'", "", $_POST['description']);
		DataProcess::saveData($_POST, self::$tableName, false);
		echo "<script type=\"text/javascript\">location.replace(\"articleView.php?msg=ok\");</script>";
	}
		
	//Edit ar Dispaly
	public function get($article_id)
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$article_id AND status!='deleted'";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;	
	}
	
	public function getLastByParent($parentId)
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE category=$parentId AND status!='deleted' ORDER BY ".self::$PrimeryKey." desc";
		
		$show = Database::query($sql, 1, __FILE__, __LINE__);
		
		return $show;	
	}
	
		//Viwe
	public function gets($condition='', $orderBy = 'id')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY {$orderBy} ASC";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;
	}
	
	public function edit()
	{		
		if($_FILES['photo']['name']!='') {
			DataValidator::isValidPhoto(self::$file_permission_list, 'photo');
			
			$Uploader = new Uploader();
			$Uploader -> photoDelete($_POST['curphoto'], self::$extendent_folder_path);
			$_POST['photo'] = $Uploader -> photoNamer(1, 'photo', WIDTH_RANGE_LARGE, self::$extendent_folder_path);
		}
		$_POST['description'] = str_replace("'", "", $_POST['description']);
		//$_POST['description'] = DataValidator::sanitizeSpecialChars('post', 'description', 'Please input description name.');	 
		//echo $_POST['photo'].'===';
		$_POST['publish_date'] = Common::converToMysqlDate($_POST['publish_date']);				
		DataProcess::saveData($_POST, self::$tableName, false);
		
		echo "<script type=\"text/javascript\">location.replace(\"articleView.php?msg=ok\");</script>";
	}
	
	public function delete($articleId)
	{
		$result = $this -> get($articleId);
		
		$show = $result -> fetch_array(MYSQL_ASSOC);	
		
		$Uploader = new Uploader();
		
		$Uploader -> photoDelete($show['photo'], self::$extendent_folder_path);		
		
		$sql = "UPDATE ".self::$tableName." SET status='deleted' WHERE ".self::$PrimeryKey."=$articleId";
		
		Database::query($sql, 2, __FILE__, __LINE__);
	}
}
?>
