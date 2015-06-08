<?php
class Content
{

    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
	public static $extendent_folder_path;
	public static $file_permission_list;
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'content';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  self::$extendent_folder_path = 'contents/';
	  self::$file_permission_list = 'jpg, jpeg, gif, pdf';
	}

	public function save()
	{
		$content_id = $_POST['id'];

		if($_FILES['photo']['name']!='') {
			DataValidator::isValidPhoto(self::$file_permission_list, 'photo');
		
		$Uploader = new Uploader();
		$Uploader -> photoDelete($_POST['cur_photo'], self::$extendent_folder_path);
		$_POST['photo'] = $Uploader -> photoNamer(1, 'photo', '', self::$extendent_folder_path);
		}
		
		$_POST['status'] = 'active';
		$_POST['recTime'] = $this->recTime;
		$_POST['recBy'] = $_SESSION['adminId'];
		//check whether home-bottom is exists or not
		$_POST['description'] = DataValidator::sanitizeSpecialChars('post', 'description', 'Please input a description.');
		DataProcess::saveData($_POST, self::$tableName, false);
		
		echo "<script type=\"text/javascript\">location.replace(\"contentControl.php?content_id=$content_id\");</script>";
	}
		
	public function get($contentId)
	{
		$contentId = DataValidator::isNumeric('var', $contentId, SE.' (content::getcontent::contentId)');

		$sql = "SELECT * FROM ".self::$tableName." WHERE id=$contentId AND status!='deleted'";

		$result = Database::query($sql, 2, __FILE__, __LINE__);

		return $result;	
	}
	
	
	public function gets($condition='')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY ".self::$PrimeryKey." ASC";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
}
?>
