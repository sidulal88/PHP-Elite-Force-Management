<?php
class ArticleCategory
{

    private $recTime;
    public static $tableName;
    public static $tableChild;
    public static $PrimeryKey;
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'article_category';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  self::$tableChild = TABLE_PREFIX.'article';
	}

	public function add()
	{
		$this -> is_categoryExists($_POST['title']);
		
		$_POST['status'] = 'active';

		$_POST['recTime'] = $this->recTime;

		$_POST['recBy'] = $_SESSION['adminId'];

		
		DataProcess::saveData($_POST, self::$tableName, false);

		echo "<script type=\"text/javascript\">location.replace(\"articlecategoryView.php?msg=ok\");</script>";
	}
	
	public function is_categoryExists($name, $cId='')
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
	public function get($categoryId)
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$categoryId AND status!='deleted'";
		$result =Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
	
	//Edit ar Dispaly
	public static function getName($categoryId)
	{
		$sql = "SELECT name FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$categoryId AND status!='deleted'";
		$result =Database::query($sql, 1, __FILE__, __LINE__);
		return $result['name'];	
	}
	
		//Viwe
	public function getFeatureds($condition, $orderBy = 'rank')
	{
		$sql = "SELECT t.* FROM ".self::$tableName." t
		INNER JOIN ".self::$tableChild." tc ON tc.category = t.id
		WHERE t.status!='deleted' $condition
		GROUP BY t.".self::$PrimeryKey." ORDER BY {$orderBy} ASC";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	public function getFeaturedsRight($condition, $orderBy = 'rank')
	{
		$sql = "SELECT t.* FROM ".self::$tableName." t
		LEFT JOIN ".self::$tableChild." tc ON tc.category = t.id
		WHERE t.status!='deleted' $condition GROUP BY t.id ORDER BY {$orderBy} ASC";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	public function gets($condition='', $orderBy = 'rank')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE  status!='deleted' $condition ORDER BY {$orderBy} ASC";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	public function edit($categoryId)
	{
		$this -> is_categoryExists($_POST['title'], $categoryId);
				
		DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function delete($categoryId)
	{
		$sql = "UPDATE ".self::$tableName." SET status='deleted' WHERE ".self::$PrimeryKey."=$categoryId";
		Database::query($sql, 2, __FILE__, __LINE__);
	}
}
?>
