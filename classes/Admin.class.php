<?php 
class Admin
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'admin';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	}
	  
	public function loginAdmin()
	{
		$email = $_POST["email"];
		$password = $_POST["password"];
		
		$sql = "SELECT * FROM ".self::$tableName." WHERE email='$email' AND password ='".md5($password)."'";
		//die();
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		if ($result->num_rows > 0) {
			$show = $result->fetch_array(MYSQL_ASSOC);
			$_SESSION['adminId'] = $show['id'];
			$_SESSION['adminEmail'] = $show['email'];
			$_SESSION['admintype'] = $show['type'];
			$_SESSION['userName'] = $show['name'];
			$_SESSION['userAccess'] = $show['menu_ids'];
			$path = LOGGED_IN_PATH;
			$reDirectUrl = ($_POST['NextPage']!='') ? $_POST['NextPage'] : 'admin_default/';
			unset($_SESSION['PrevPage']);			
			echo "<script type=\"text/javascript\">location.replace(\"".$reDirectUrl."\");</script>";
		} else {
			throw new Exception(WRONG_LOGIN);
		}
	}
	public function addUser()
	{
		//$_POST['name'] = DataValidator::sanitizeSpecialChars('post', 'name', 'Please input your name.');
		$_POST['email'] = DataValidator::isEmail('post', 'email', 'E-mail address seems to be incorrect');
		$_POST['password'] = md5($_POST['password']);
		$_POST['type'] = 'user';
		$_POST['recDate'] = $this->recTime;
		$_POST['recBy'] = $_SESSION['adminId'];
		
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function saveUser()
	{
		DataProcess::saveData($_POST, self::$tableName, false);
	}
	
	public function getUser($userId)
	{
		$userId = DataValidator::isNumeric('var', $userId, SE.' (Admin::getUser::userId)');

		$sql = "SELECT * FROM ".self::$tableName." WHERE id=$userId";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;	
	}
	
	public function getUsers($orderBy = 'name', $displaType = 'admin')
	{
		/*
			expected param for $displaType is admin/visitor
		*/
		$condition = ($_SESSION['admintype']=='admin')?'':" AND id =".$_SESSION['adminId'];
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' AND display='yes' $condition ORDER BY {$orderBy} ASC";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;
	}
	
	
	public function data_count($condition='')
	{
		 $sql = "SELECT count(*) AS total
				FROM 
					".self::$tableName." WHERE status!='deleted'  AND display='yes'";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		return $show['total'];
	}
	
	public function get_admin_grid($condition='', $offset, $rows)
	{
		$sql = "SELECT *
				FROM
					 ".self::$tableName."
				WHERE 
					".self::$tableName.".status!='deleted'  AND display='yes' $condition 
				LIMIT
					$offset,$rows";
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		return $result;
	}
	
	public function editUser($userId)
	{
		$name = DataValidator::sanitizeSpecialChars('post', 'name', 'Please input your name.');
		$email = DataValidator::isEmail('post', 'email', 'E-mail address seems to be incorrect');
		$password = md5($_POST['password']);

		$sql = "UPDATE ".self::$tableName." SET
				name='$name',
				email='$email',
				password='$password'
				WHERE id=$userId";
				
		Database::query($sql, 2, __FILE__, __LINE__);
	}
	
	public function deleteUser($userId)
	{
		if($_SESSION['admintype']=='admin')
		$sql = "UPDATE ".self::$tableName." SET status='deleted' WHERE id=$userId AND type!='admin' ";
		
		Database::query($sql, 2, __FILE__, __LINE__);
		
	}

	
}
?>