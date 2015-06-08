<?php  require_once('../settings.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>
</head>

<body>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> <?php include('adminHead.php');?></td>
  </tr>
	  <tr>
	  <td align="center" class="msg"><?php 
	  
	  if($_GET['msg'])
	  {
			echo SUCCESS_MSG;  
	  } 
	  ?></td>
	  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1><?php echo CONTACT_US; ?></h1>
    	 </div>   
<form action="contactView.php" enctype="multipart/form-data" method="post">
	<input type="hidden" name="contact_id" value="1" />
	  <table border="0"  class="dataAdd">
        <tr>
          <td colspan="3" align="left">
<?php		  
try
{
	$Contact = new Contact();
	$result = $Contact -> get();
	$show = $result -> fetch_array(MYSQL_ASSOC);
	if(isset($_POST['btnAdd'])) {
		$Contact -> edit();
	}
}
catch(Exception $e)
{
	echo $e->getMessage();
}
?>		  </td>
          </tr>
<tr>
          <td width="36%" align="right">Details</td>
          <th width="4%" align="center">:</th>
          <td width="60%" align="left">
						  <textarea name="description" id="description"  cols="34" rows="6" class="bng_text"><?php echo $show['description'];?></textarea>
</td>
        </tr><tr>
          <td align="right">&nbsp;</td>
          <th align="center">&nbsp;</th>
          <td align="left"><input type="submit" name="btnAdd" value="Submit" /></td>
        </tr>
      </table>
	</form>    </td>
  </tr>
</table>
<?php include('footer.php');?>
</body>
</html>