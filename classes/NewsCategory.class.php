<?php
class NewsCategory
{

    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $tableNews;
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'news_category';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  self::$tableNews = TABLE_PREFIX.'news';
	}

	public function addCategory()
	{
		$_POST['status'] = 'active';

		$_POST['recTime'] = $this->recTime;

		$_POST['recBy'] = $_SESSION['adminId'];

		$this -> isnews_categoryExists($_POST['title']);
		
		DataProcess::saveData($_POST, self::$tableName, false);

		echo "<script type=\"text/javascript\">location.replace(\"newscategoryView.php?msg=ok\");</script>";
	}
	
	public function isnews_categoryExists($title, $cId='')
	{
		$sql = "SELECT ".self::$PrimeryKey." FROM ".self::$tableName." WHERE name='$name' AND status!='deleted'";
		if($cId!='') {
			$sql .= " AND ".self::$PrimeryKey."!=$cId";
		}
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		if($result -> num_rows > 0) {
			throw new Exception('Error! The record is already exists.<br />Please try to edit the existing record.');
		} 
	}
	
	//Edit ar Dispaly
	public function getCategory($news_categoryId)
	{
		$news_categoryId = DataValidator::isNumeric('var', $news_categoryId, SE.' (NewsCategory::getnews_category::news_categoryId)');

		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$news_categoryId AND status!='deleted'";
		$result =Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	
	
	public function gets($condition='', $orderBy = 'rank')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE  status!='deleted' $condition ORDER BY {$orderBy} ASC";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}

	public static function getName($news_categoryId)
	{
		$sql = "SELECT name FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$news_categoryId AND status!='deleted'";
		$result =Database::query($sql, 1, __FILE__, __LINE__);
		return $result['name'];	
	}

	public static function getPrimeryKeyValue($condition)
	{
		$sql = "SELECT ".self::$PrimeryKey." FROM ".self::$tableName." WHERE status!='deleted' $condition";
		$result =Database::query($sql, 1, __FILE__, __LINE__);
		return $result[self::$PrimeryKey];	
	}
	
		//Viwe

	public function getNewsGroups($category, $orderBy = 'rank')
	{
		$sql = "SELECT c.* FROM ".self::$tableName." c
		INNER JOIN ".self::$tableNews." n ON n.category = c.id
		WHERE c.category='$category' AND c.status!='deleted'
		GROUP BY c.id ORDER BY {$orderBy} ASC";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	public function getCategories($condition='', $orderBy = 'rank')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE  status!='deleted' $condition ORDER BY {$orderBy} ASC";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	public function editCategory($categoryId)
	{
		$this -> isnews_categoryExists($_POST['title'], $categoryId);
		
		DataProcess::saveData($_POST, self::$tableName, false);

		echo "<script type=\"text/javascript\">location.replace(\"newscategoryView.php?msg=ok\");</script>";
	}
	
	public function deleteCategory($categoryId)
	{
		
		$result = $this -> getCategory($categoryId);
		
		$show = $result -> fetch_array(MYSQL_ASSOC);	
		
		$sql = "UPDATE ".self::$tableName." SET status='deleted' WHERE ".self::$PrimeryKey."=$categoryId";
		Database::query($sql, 2, __FILE__, __LINE__);
	}
}
?>
