<?php
class Feedback
{

    private $recTime;
    public static $tableName;
	public static $PrimeryKey;

    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'feedback';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	}

	public function add()
	{
		$_POST['name'] = DataValidator::sanitizeSpecialChars('post', 'name', 'Please input your name.');
		$_POST['email'] = DataValidator::isEmail('post', 'email', 'E-mail address seems to be incorrect');
		$_POST['message'] = DataValidator::sanitizeSpecialChars('post', 'message', 'Please input message.');
						
		DataProcess::saveData($_POST, self::$tableName, false);
		//Common::sendMail();
		echo "<script type=\"text/javascript\">location.replace(\"contact_us.php?msg=Your feedback has been saved!\");</script>";
	}
	
	//Edit ar Dispaly
	public function get($feedbackId)
	{
	
		$sql = "SELECT * FROM ".self::$tableName." WHERE ".self::$PrimeryKey."=$feedbackId";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;	
	}
	
	//Viwe
	public function gets($feedbackId = 'id', $orderBy='recTime')
	{
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' ORDER BY {$orderBy} DESC";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;
	}
	
	
	
	public function data_count_all($condition='')
	{
		$sql = "SELECT count(*) AS total
				FROM 
					ipb_feedback
					LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_feedback.unit_id
 				WHERE
					ipb_feedback.status!='deleted' $condition ";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT 
						ipb_feedback.id,
						ipb_feedback.name,
						ipb_feedback.email,
						ipb_feedback.message,
						ipb_feedback.status,
						ipb_feedback.recTime,
						ipb_unit_list.unit_name
			
				FROM
					 ipb_feedback
					 LEFT JOIN ipb_unit_list ON ipb_unit_list.unit_id = ipb_feedback.unit_id
				WHERE 
					ipb_feedback.status!='deleted' $condition 
				ORDER BY
					ipb_feedback.recTime DESC
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
