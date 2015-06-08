<?php  require_once('../settings.php');
	$cId = $_GET['cId'];
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
    <h1>Content Managment</h1>
	 <h2>Content Delete</h2>
	<h3> <a href="contentView.php" class="link_button">Content List</a></h3>
	 </div>   
	<form action="contentDelete.php?cId=<?php echo $cId; ?>" method="post">

	<table border="0" cellpadding="1" cellspacing="1" width="100%" style="border:#CCCCCC 1px solid;" class="table_entry">

	  <tr>

	  	<td align="center">

<?php

try

{

	$Content = new Content();

	$result = $Content->getContent($cId);

	$show = $result->fetch_array(MYSQL_ASSOC);

	

	if(isset($_POST['btnCancel'])) {

		header("Location: content-view.php");

	} else if(isset($_POST['btnDelete'])) {

		$Content -> deleteContent($cId);

		header("Location: contentView.php?msg=Record has been deleted successfully!");

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

	  	<td align="center">Are you sure you want to delete</td>

	  </tr>

	  <tr>

	    <td align="center">

			<input type="submit" name="btnCancel" value="Cancel" />

			<input type="submit" name="btnDelete" value="Delete" />

		</td>

	    </tr>

	</table>

	</form>
	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
</body>
</html>