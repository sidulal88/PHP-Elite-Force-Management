<?php  require_once('../settings.php');
	$fId = DataValidator::isNumeric('get', 'fId', SE.' (fId)', 0, 2);
?>
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
	  <td align="center" class="msg"> <?php 	 
	  if($_GET['msg'])
	  {
			echo SUCCESS_MSG;  
	  } 
	?></td>
	  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1><?php echo FEEDBACK_MANAGEMENT; ?></h1>
	 <h2><?php echo DETAILS; ?></h2>
	<h3> <a href="feedbackView.php" class="link_button"><?php echo FEEDBACK_LIST; ?></a></h3>
	 </div>
        
	  <table border="0" cellpadding="1" cellspacing="3" width="100%" class="listTab">
        <tr>
          <td colspan="3" align="left">
<?php		  
try
{
	$Feedback = new Feedback();
	$result = $Feedback -> get($fId);
	$show = $result -> fetch_array(MYSQL_ASSOC);
}
catch(Exception $e)
{
	echo $e->getMessage();
}
?>		  </td>
          </tr>
        <tr>
          <td width="13%" align="right">Date</td>
          <td width="5%" align="center" widtd="4%">:</td>
          <td width="82%" align="left" widtd="60%"><?php echo Common::convertToBanglaDate(date('Y-m-d', strtotime($show['recTime']))); ?></td>
        </tr>
        <tr>
          <td widtd="36%" align="right">Name</td>
          <td widtd="4%" align="center">:</td>
          <td widtd="60%" align="left"><?php echo $show['name']; ?></td>
        </tr>
		<tr>
          <td widtd="36%" align="right">Email</td>
          <td widtd="4%" align="center">:</td>
          <td widtd="60%" align="left"><?php echo $show['email']; ?></td>
		</tr>        <tr>
          <td widtd="36%" align="right" valign="top">Description</td>
          <td widtd="4%" align="center" valign="top">:</td>
          <td widtd="60%" align="left" style="text-align:justify; padding:3px;"><?php echo $show['message']; ?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
</body>
</html>