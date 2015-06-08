<?php @session_start();

	  require_once('../settings.php');
	   $path = LOGGED_IN_PATH;
	  
		if(@$_SESSION['adminId']!='') {
						echo "<script type=\"text/javascript\">location.replace(\"$path\");</script>";
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>
<link href="style_admin.css" rel="stylesheet" type="text/css" />
</head>

<body class="body1">
 <table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr align="center" valign="top">
    <td class="he"><div id="head_s" >
<center>
<h2><?php echo COMPANY_NAME; ?></h2>

</center>
</div></td>
  </tr>
  <tr>
    <td align="center" valign="top">
    <center>
    <div id="L_panal">
		 <em><?php echo ADMIN_LOGIN; ?></em>
    <span>
		<?php 
		if( (isset($_POST['btnLogin'])) || (!empty($_REQUEST['msg'])))

		{

			if(isset($_POST['btnLogin']))
			{
				try
	
				{	$Admin = new Admin();
	
					$Admin->loginAdmin();
	
				}
	
				catch(Exception $e)
	
				{
					echo '<h1>'.$e->getMessage().'</h1>';
	
				}
			}
			else
			{
				$msg = ($_REQUEST['msg']=='log_out') ? SUCCESSFULLY_LOGOUT : UNAUTHORISED_LOGIN;
				
				echo '<h1>'.$msg.'</h1>';
			}
	 } 
 ?>
    
    </span>
<form action="index.php" method="post">
<input type="hidden" name="NextPage" value="<?php echo @$_SESSION['PrevPage']; ?>" />
  <table  border="0" cellspacing="0" cellpadding="0">
 
  <tr>
    <td height="34" align="right"><?php echo USER_NAME; ?> :</td>
    <td align="left"><input name="email" type="text"  class="inputField" value="<?php echo @$_POST['email']; ?>"/></td>
  </tr>
  <tr>
    <td height="34" align="right"><?php echo USER_PASSWORD; ?> :</td>
    <td align="left"><input name="password" type="password"  class="inputField" value="<?php echo @$_POST['password']; ?>"/></td>
  </tr>
  <tr>
    <td height="33">&nbsp;</td>
    <td align="right"><input type="submit" name="btnLogin" value="<?php echo LOGIN_BUTTON; ?>" class="button1" /></td>
  </tr>
  </table>
</form>
    
    </div>
    </center>
    
    </td>
  </tr>
 
</table>

</body>
</html>