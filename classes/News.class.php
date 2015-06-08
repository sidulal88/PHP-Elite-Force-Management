<?php
class News
{

    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
	public static $extendent_folder_path;
	public static $file_permission_list;
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'news';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$tableNewsCategory = TABLE_PREFIX.'news_category';
	  self::$extendent_folder_path = 'newses/';
	  self::$file_permission_list = 'jpg, jpeg, gif, pdf';
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

		$_POST['news_date'] = Common::converToMysqlDate($_POST['news_date']);

		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	
	public function edit()
	{
		
		if($_FILES['file_one']['name']!='') {
			$Uploader = new Uploader();
			$Uploader -> photoDelete($_POST['cur_file'], self::$extendent_folder_path);
			$_POST['photo'] = $Uploader -> file_upload_single(self::$extendent_folder_path);
		}
		$_POST['news_date'] = Common::converToMysqlDate($_POST['news_date']);
		
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	
	
	public function get($bannerId)
	{
		//$contentId = DataValidator::isNumeric('var', $bannerId, SE.' (banner::getbanner::bannerId)');

		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$bannerId";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;	
	}
	
	public function gets($condition='')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;
	}
	
	
	
	public function data_count_all($condition='')
	{
		$sql = "SELECT count(*) AS total
				FROM 
					ipb_news
 				WHERE
					ipb_news.status!='deleted' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT *
			
				FROM
					 ipb_news
				WHERE 
					ipb_news.status!='deleted' $condition 
				ORDER BY
					ipb_news.rank ASC
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
