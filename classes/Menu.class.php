<?php 
class Menu
{
    private $recTime;
    public static $tableName;
    public static $PrimeryKey;
    function __construct()
	{
	  $this-> recTime = date ('y-m-d H:i:s');
	  self::$tableName = TABLE_PREFIX.'sys_menu';
	  self::$PrimeryKey = DataProcess::getPrimKey(self::$tableName);
	}
	  
/*	public function loginAdmin()
	{
		$email = $_POST["email"];
		$password = $_POST["password"];
		
		$sql = "SELECT id, name, email, type FROM ".self::$tableName." WHERE email='$email' AND password ='".md5($password)."'";
		//die();
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		if ($result->num_rows > 0) {
			$show = $result->fetch_array(MYSQL_ASSOC);
			$_SESSION['adminId'] = $show['id'];
			$_SESSION['adminEmail'] = $show['email'];
			$_SESSION['admintype'] = $show['type'];
			$_SESSION['userName'] = $show['name'];
			$reDirectUrl = ($_POST['NextPage']!='') ? $_POST['NextPage'] : 'adminHome.php';
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
		$_POST['status'] = 'active';
		$_POST['recDate'] = $this->recTime;
		$_POST['recBy'] = $_SESSION['adminId'];
		
		$ret = DataProcess::saveData($_POST, self::$tableName, false);
		echo "<script type=\"text/javascript\">location.replace(\"userView.php?msg=ok\");</script>";
	}
	
	public function getUser($userId)
	{
		$userId = DataValidator::isNumeric('var', $userId, SE.' (Admin::getUser::userId)');

		$sql = "SELECT * FROM ".self::$tableName." WHERE id=$userId";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;	
	}
*/	
	public function gets($conditions='')
	{
		$Admin = new Admin();
		$result = $Admin -> getUser($_SESSION['adminId']);
		$show = $result -> fetch_array(MYSQL_ASSOC);
		$accessCond = ($_SESSION['admintype']!='admin') ? " AND menu_id IN (".$show['menu_ids'].")" : ' ';
		$sql = "SELECT * FROM ".self::$tableName." WHERE status!='deleted' $accessCond $conditions ";
		
		$result = Database::query($sql, 2, __FILE__, __LINE__);
		
		return $result;
	}
	
	public static function checkAccess()
	{	
		if($_SESSION['admintype']!='admin')
		{
			if(CURRENT_FOLDER_NAME!='admin_default' && CURRENT_FILE_NAME!='banglaKeyboard.php')
			{
					$sql = "SELECT menu_id FROM ".TABLE_PREFIX."sys_menu WHERE matches_folder='".CURRENT_FOLDER_NAME."'";
					$result = Database::query($sql, 1, __FILE__, __LINE__);
					
					$sql = "SELECT menu_ids FROM ".TABLE_PREFIX."admin WHERE id=".$_SESSION['adminId'];
					$menu_access_list = Database::query($sql, 1, __FILE__, __LINE__);
					
					$menu_list = explode(",", $menu_access_list['menu_ids']);
					if(!in_array($result['menu_id'], $menu_list))
					{
						exit(UNAUTHORISED_LOGIN);
					}
			}
		}
	}
	
	
	
/*	public function editUser($userId)
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
			echo "<script type=\"text/javascript\">location.replace(\"userView.php?msg=ok\");</script>";
	}
	
	public function deleteUser($userId)
	{
		if($_SESSION['admintype']=='admin')
		$sql = "UPDATE ".self::$tableName." SET status='deleted' WHERE id=$userId AND type!='admin' ";
		
		Database::query($sql, 2, __FILE__, __LINE__);
		
	}

*/	
}
?>