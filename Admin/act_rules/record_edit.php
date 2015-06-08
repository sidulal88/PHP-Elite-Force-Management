<?php  require_once('../../settings.php');
	$rule_id = $_REQUEST['rule_id'];
	
try

{
	$Uploader = new Uploader();

	$Act_Rules = new Act_Rules();

	$result = $Act_Rules -> get($rule_id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['Submit'])) {
	
		$Act_Rules -> edit();
		echo "<script type=\"text/javascript\">location.replace(\"record_edit.php?rule_id=$rule_id\");</script>";

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
    <h1>Directory Entry</h1>
	 <h2><?php echo EDIT; ?></h2>
	<h3> <a href="index.php" class="link_button">Record List</a></h3>
	 </div>
     
<form action="record_edit.php?rule_id=<?php echo $rule_id; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="rule_id" value="<?php echo $rule_id; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
      <tr><td colspan="3"><?php //include('bangla_keyboard.php');?></td></tr>
 <tr>
          <td colspan="3" class="msg">
 </td>

          </tr><tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="title" id="title" value="<?php echo $show_data['title']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">Act. No</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="rules_no" id="rules_no" value="<?php echo $show_data['rules_no']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">Sort No</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="sort_no" id="sort_no" value="<?php echo $show_data['sort_no']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">Link</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="link" id="link" value="<?php echo $show_data['link']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>		

	   
	   <tr>

          <td align="right">Attachment</td>

          <th align="center">:</th>

          <td align="left">
		  <?php 
		  	 $file_ext = pathinfo($show_data['attachment'], PATHINFO_EXTENSION);
		  	 $image_ext = array('jpg', 'jpeg', 'gif', 'png');
			if (!in_array($file_ext, $image_ext)) {
			
				?><a href="../../uploads/act_rules/<?php echo $show_data['attachment']; ?>" target="_blank" style="text-decoration:none; color:#0000CC">
				<img src="../../images/download_icon.png" /></a>
			<?php
			}
			else
			{
			?>
				<img src="../../uploads/act_rules/<?php echo $show_data['attachment']; ?>" width="70" height="80" />
		<?php
			}
		  
		    ?>
		  
			<input type="hidden" name="cur_file" value="<?php echo $show_data ['attachment'];?>"/>	
		  	<input type="file" name="file_one" id="file_one" size="32" maxlength="37" />::Recommended  size : 450px*253px		  </td>
        </tr>

	   
      <tr>
          <td align="right"><?php echo STATUS; ?></td>
          <th align="center">:</th>
          <td align="left"><select name="status" id="status">
            <option><?php echo SELECT; ?></option>
            <?php
	
		$statusList = Common::systemStatus();
	
		foreach($statusList as $key=>$value):
	
		?>
            <option value="<?php echo $key; ?>" <?php if($show_data['status']==$key) {echo 'selected'; }?>><?php echo Common::Eng2BanStatus($key); ?></option>
            <?php endforeach; ?>
          </select></td>
        </tr>
        <tr>

          <td align="right">&nbsp;</td>

          <th align="center">&nbsp;</th>

          <td align="left"><input type="submit" name="Submit" value="<?php echo SAVE; ?>" /></td>

        </tr>        <tr>
            <td align="right">&nbsp;</td>
            <th align="center">&nbsp;</th>
            <td align="left">&nbsp;</td>
        </tr>
      </table>
	</form>
	
	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
</body>
</html>