<?php  require_once('../../settings.php');
	
try

{
	
	$Admin = new Admin();
	$result = $Admin -> getUser($_SESSION['adminId']);
	$show = $result -> fetch_array(MYSQL_ASSOC);

if(isset($_POST['btnAdd'])) {
		$_POST['id'] = $_SESSION['adminId'];
		$_POST['password'] = md5($_POST['password']);
		$Admin->saveUser();
		
		echo "<script type=\"text/javascript\">location.replace(\"../admin_default\");</script>";

	}
	
}

catch(Exception $e)

{

	echo $e->getMessage();

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>
<link href="../form_msg.css" rel="stylesheet" type="text/css" />




</head>

<body>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php include(ROOT_DIR.'Admin/adminHead.php');?></td>
  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1>Password Control</h1>
	 <h2><?php echo EDIT; ?></h2>
	 </div>

     <div class="easyui-layout" style="height:200px; margin: auto;">  
    <div title="Password Change" data-options="region:'center'" class="easyui-panel" >  
<form action="password_change.php" enctype="multipart/form-data" method="post">
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">

		 <tr>
          <td align="right">New Password</td>
          <th align="center">:</th>
          <td align="left"><input type="password" name="password" value="<?php echo $show['password']; ?>" size="32" maxlength="30" /></td>
        </tr>
        <tr>

          <td align="right">&nbsp;</td>

          <th align="center">&nbsp;</th>

          <td align="left"><input type="submit" name="btnAdd" value="<?php echo SAVE; ?>" /></td>

        </tr>
</tbody>      </table>

	</form>
	</div>	</div>
	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
</body>
</html>