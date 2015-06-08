<?php 
class Category
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $tablePhoto;
	public static $extendent_folder_path;
	public static $file_permission_list;

    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'category';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  self::$tablePhoto = TABLE_PREFIX.'photo';
	  self::$extendent_folder_path = 'categories/';
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

		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	
	
	public function edit()
	{
		
		if($_FILES['file_one']['name']!='') {
			$Uploader = new Uploader();
			$Uploader -> photoDelete($_POST['cur_file'], self::$extendent_folder_path);
			$_POST['photo'] = $Uploader -> file_upload_single(self::$extendent_folder_path);
		}
		//$_POST['news_date'] = Common::converToMysqlDate($_POST['news_date']);
		
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function isCategoryExists($categoryName)
	{
		$categoryName = DataValidator::sanitizeSpecialChars('var', $categoryName, SE.' (Category::getCategory::categoryName)');

		$sql = "SELECT * FROM ".self::$tableName." WHERE name='$categoryName' AND status!='deleted'";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		if($result -> num_rows > 0) {
			throw new Exception('Error! This category name is already exists!<br />Please input another one.');
		} 
	}

	public function get($categoryId)
	{
		$categoryId = DataValidator::isNumeric('var', $categoryId, SE.' (Category::getCategory::categoryId)');

		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$categoryId";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;	
	}
	
	public function getName($categoryId)
	{
		$categoryId = DataValidator::isNumeric('var', $categoryId, SE.' (Category::getCategoryName::categoryId)');

		$sql = "SELECT name FROM ".TABLE_PREFIX."category WHERE ".self::$PrimeryKey."=$categoryId";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		$show = $result->fetch_array(MYSQL_ASSOC);
		return $show['name'];	
	}
	
	public function gets($orderBy = 'name', $displaType = 'admin')
	{
		/*
			expected param for $displaType is admin/visitor
		*/
		$condition = " ";
		if($displaType=='visitor') {
			$condition .= " AND status='active'";
		}
		$sql = "SELECT c.*, (SELECT COUNT(id) FROM ".self::$tablePhoto." p where p.category = c.id AND p.status!='deleted') num_rec FROM ".self::$tableName." c WHERE status!='deleted' $condition ORDER BY {$orderBy} ASC";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;
	}
	
	public function getCategoriesInLB($recSelected='')
	{
		$recSelected = DataValidator::isNumeric('var', $recSelected, SE.' (Category::getCategoriesInLB::recSelected)', 1);

		$categorirs = $this -> gets('rank');
		echo '<select name="category"><option value=""></option>';
		while($show = $categorirs -> fetch_array(MYSQL_ASSOC))
		{
			$selected = '';
			if($recSelected==$show['id']) {
				$selected = ' selected="selected"';
			}
			echo '<option value="'.$show['id'].'"'.$selected.'>'.$show['name'].'</option>';
		}
		echo '</select>';
	}
	
	
	
	
	public function data_count_all($condition='')
	{
		$sql = "SELECT count(*) AS total
				FROM 
					ipb_category
 				WHERE
					ipb_category.status!='deleted' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT *
			
				FROM
					 ipb_category
				WHERE 
					ipb_category.status!='deleted' $condition 
				ORDER BY
					ipb_category.rank ASC
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