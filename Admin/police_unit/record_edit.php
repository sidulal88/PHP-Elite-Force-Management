<?php  require_once('../../settings.php');
	$unit_id = $_REQUEST['unit_id'];
	
try

{

	$Unit = new Unit();

	$result = $Unit -> get($unit_id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['Submit'])) {
	
		$Unit -> add();
		echo "<script type=\"text/javascript\">location.replace(\"record_edit.php?unit_id=$unit_id\");</script>";

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
    <h1>Master Entry</h1>
	 <h2><?php echo EDIT; ?></h2>
	<h3> <a href="index.php" class="link_button">Record List</a></h3>
	 </div>
     
<form action="record_edit.php?unit_id=<?php echo $unit_id; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
      <tr><td colspan="3"><?php //include('bangla_keyboard.php');?></td></tr>
 <tr>
          <td colspan="3" class="msg">
 </td>

          </tr>	  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="unit_name" id="unit_name" value="<?php echo $show_data['unit_name']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
<tr>
          <td align="right">Relavent to Industry ? </td>
          <th align="center">:</th>
          <td align="left">
		  <input type="radio" name="is_industry" value="1" <?php if($show_data['is_industry']==1) {echo 'checked'; }?> />Yes
		  <input type="radio" name="is_industry" value="0" <?php if($show_data['is_industry']==0) {echo 'checked'; }?> />No</td>
        </tr>

	  

<tr>
    <td width="19%" align="right">Unit Under</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="mainUnit" id="mainUnit">
			<option value=""><?php echo SELECT; ?></option>
				<?php

			$Unit = new Unit();
		
			$menuTree = $Unit -> getsGrid();
	
			foreach($menuTree as $show):
		
			$spacer = ($show['data_level'] > 1) ? str_repeat(" ---> ", $show['data_level']-1) : '';
		?>
	
				  <option value="<?php echo $show['unit_id'].'::'.$show['data_level']; ?>" <?php if($show_data['sub_under']==$show['unit_id']) {echo 'selected'; }?>><?php echo $spacer.$show['unit_name']; ?></option>
	
	<?php endforeach; ?>
	    </select>   	  </td>

       </tr>
		<tr>

	    <td align="right">Location</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="location" value="<?php echo $show_data['location']; ?>" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
        <tr>
        <tr>
            <td align="right">Address</td>
            <th align="center"></th>
            <td align="left"><textarea name="address" id="address" class="text_area" cols="40"><?php echo $show_data['address']; ?></textarea>
			
</td>
        </tr>
		<tr>

	    <td align="right">Sort</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="_sort" value="<?php echo $show_data['_sort']; ?>" size="26" maxlength="60" class="bng_text" /></td>
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
<script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="../css/jquery-te-1.4.0.css">
	<script>
	$(".text_area").jqte();
	
	// settings of status
	var jq_box_teStatus = true;
	$(".status").click(function()
	{
		jq_box_teStatus = jq_box_teStatus ? false : true;
		$('.text_area').jqte({"status" : jq_box_teStatus})
	});
	
	
</script>