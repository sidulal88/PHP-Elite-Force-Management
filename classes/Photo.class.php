<?php 
class Photo
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
	public static $extendent_folder_path;
	public static $file_permission_list;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'photo';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  self::$extendent_folder_path = 'photos/';
	  self::$file_permission_list = 'jpg, jpeg, gif, pdf';
	}

	public function add()
	{
		if($_FILES['photo']['name']!='') {
			DataValidator::isValidPhoto(self::$file_permission_list, 'photo');
		
			$Uploader = new Uploader();
			$photoLarge = $_POST['photo_large'] = $Uploader -> photoNamer(1, 'photo', 600, self::$extendent_folder_path);
			$_POST['photo_thumb'] = $Uploader -> photoNamer(2, $photoLarge, 200, self::$extendent_folder_path);
		}

		$_POST['status'] = 'active';

		$_POST['recTime'] = $this->recTime;

		$_POST['recBy'] = $_SESSION['adminId'];

		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function get($photoId)
	{		
		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$photoId";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;	
	}
	
	public function gets($condition='')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;
	}
	
	
	
	public function edit()
	{
		if($_FILES['photo']['name']!='') {
			DataValidator::isValidPhoto(self::$file_permission_list, 'photo');
			
			$Uploader = new Uploader();
			
			$Uploader -> photoDelete($_POST['photo_large'], self::$extendent_folder_path);
			$Uploader -> photoDelete($_POST['photo_thumb'], self::$extendent_folder_path);
			
			$_POST['photo_large'] = $Uploader -> photoNamer(1, 'photo', 600, self::$extendent_folder_path);
			$_POST['photo_thumb'] = $Uploader -> photoNamer(2, $_POST['photo_large'], 200, self::$extendent_folder_path);
			
		}
		DataProcess::saveData($_POST, self::$tableName, false);
	}
	
		
	public function data_count_all($condition='')
	{
		$sql = "SELECT count(*) AS total
				FROM 
					ipb_photo
					LEFT JOIN ipb_category ON ipb_category.id = ipb_photo.category
 				WHERE
					ipb_photo.status!='deleted' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT 
					  ipb_photo.id,
					  ipb_category.name AS category,
					  ipb_photo.title,
					  ipb_photo.description,
					  ipb_photo.photo_thumb,
					  ipb_photo.rank,
					  ipb_photo.status
			
				FROM
					 ipb_photo
					 LEFT JOIN ipb_category ON ipb_category.id = ipb_photo.category
				WHERE 
					ipb_photo.status!='deleted' $condition 
				ORDER BY
					ipb_photo.rank ASC
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	
		
	public function delete($newsId)
	{	
		
		$sql = "UPDATE ".self::$tableName." SET status='deleted' WHERE ".self::$PrimeryKey."=$newsId";
		
		Database::query($sql, 2, __FILE__, __LINE__);
	}

}
?>