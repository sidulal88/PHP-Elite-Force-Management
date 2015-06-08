<?php 
class PageControl
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    public static $ForeignKey;//Only for single ForeignKey applicable
	public static $extendent_folder_path;
	
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'content';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	  //self::$ForeignKey = 'sub_under';
	}

	public function save()
	{
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function get($dataId)
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."='$dataId' ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;	
	}
		
	public function data_count($condition='')
	{
		$sql = "SELECT count(*) AS total FROM ".self::$tableName;
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}

	public function gets($condition='', $offset, $rows)
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $condition ORDER BY rank ASC LIMIT 0, 10";
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