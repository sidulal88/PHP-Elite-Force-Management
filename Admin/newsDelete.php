<?php  require_once('../settings.php');
	$nId = $_GET['nId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>
<link href="form_msg.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> <?php include('adminHead.php');?></td>
  </tr>
	  <tr>
	  <td align="center" class="msg"><?php Common::displayMsg(); ?></td>
	  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1><?php echo NEWS_MANAGEMENT; ?></h1>
	 <h2><?php echo NEWS_LIST.'-'.DELETE; ?></h2>
	<h3> <a href="newsView.php" class="link_button"><?php echo NEWS_LIST; ?></a></h3>
	 </div>   
	<form action="newsDelete.php?nId=<?php echo $nId; ?>" method="post">

	<table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">

	  <tr>

	  	<td align="center">

<?php

try

{

	$News = new News();

	if(isset($_POST['btnCancel'])) {

		header("Location: newsView.php");
		echo "<script type=\"text/javascript\">location.replace(\"newsView.php\");</script>";
	} else if(isset($_POST['btnDelete'])) {

		$News -> delete($nId);

		echo "<script type=\"text/javascript\">location.replace(\"newsView.php?msg=ok\");</script>";

	}

}

catch(Exception $e)

{

	echo $e->getMessage();

}

?>

		</td>

	  </tr>

	  <tr>

	  	<td align="center"><?php echo DELETE_CONF; ?></td>

	  </tr>

	  <tr>

	    <td align="center">

			<input type="submit" name="btnCancel" value="<?php echo CANCEL; ?>" />

			<input type="submit" name="btnDelete" value="<?php echo DELETE; ?>" />

		</td>

	    </tr>

	</table>

	</form>
	
    </td>
  </tr>
</table>
<?php include('footer.php');?>
</body>
</html>