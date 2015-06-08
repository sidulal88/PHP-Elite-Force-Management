<?php 
class Contact
{
    private $recTime;
    public static $tableName;
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'contact_info';
	}

	public function get($contact_id)
	{
		$sql = "SELECT * FROM ".self::$tableName;
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;	
	}
	
	
	public function edit()
	{		
		DataProcess::saveData($_POST, self::$tableName, false);
		echo "<script type=\"text/javascript\">location.replace(\"contactView.php?msg=ok\");</script>";
	}

}	
?>