<?php  require_once('../../settings.php');
	$bcs_officer_id = $_REQUEST['bcs_officer_id'];
	
try

{
	$Uploader = new Uploader();

	$BCS_Officers = new BCS_Officers();

	$result = $BCS_Officers -> get($bcs_officer_id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['Submit'])) {
	
		$BCS_Officers -> edit();
		echo "<script type=\"text/javascript\">location.replace(\"record_edit.php?bcs_officer_id=$bcs_officer_id\");</script>";

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
     
<form action="record_edit.php?bcs_officer_id=<?php echo $bcs_officer_id; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="bcs_officer_id" value="<?php echo $bcs_officer_id; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
      <tr><td colspan="3"><?php //include('bangla_keyboard.php');?></td></tr>
 <tr>
          <td colspan="3" class="msg">
 </td>

          </tr><tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="name" id="name" value="<?php echo $show_data['name']; ?>" size="32" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">ID No.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="police_id_no" id="police_id_no" value="<?php echo $show_data['police_id_no']; ?>" size="32" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">Merit No.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="merit_no" id="merit_no" value="<?php echo $show_data['merit_no']; ?>" size="32" maxlength="100"  class="bng_text"/></td>
	    </tr>		
	  <tr>

	    <td align="right">Batch No.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="batch_no" id="batch_no" value="<?php echo $show_data['batch_no']; ?>" size="32" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
		<tr>

	    <td align="right">Contact No.</td>

	    <th align="center">:</th>

	    <td align="left">
		<input type="text" name="contact_no" id="contact_no" value="<?php echo $show_data['contact_no']; ?>" size="32" maxlength="100"  class="bng_text"/>
		</td>
	    </tr>
		
		<tr>

	    <td align="right">Email Address.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="email_address" value="<?php echo $show_data['email_address']; ?>" size="32" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
		<tr>
    <td width="19%" align="right">District</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="district_id" id="district_id">
			<option><?php echo SELECT; ?></option>
				<?php

			$District = new District();
			$result = $District -> gets();
			while($data = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
	
				  <option value="<?php echo $data['district_id']; ?>"<?php if($show_data['district_id']==$data['district_id']) {echo 'selected'; }?>><?php echo $data['distrcit_name']; ?></option>
	
	<?php } ?>
	    </select>   	  </td>
       </tr>
		
		<tr>
    <td width="19%" align="right">Current Rank</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="current_rank" id="current_rank">
			<option><?php echo SELECT; ?></option>
				<?php

			$Ranks = new Ranks();
			$result = $Ranks -> gets();
			while($row = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
	
				  <option value="<?php echo $row['rank_id']; ?>" <?php if($show_data['current_rank']==$row['rank_id']) {echo 'selected'; }?>><?php echo $row['rank_name']; ?></option>
	
	<?php } ?>
	    </select>   	  </td>
       </tr>
	   
	   		
		<tr>
    <td width="19%" align="right">Posting Place</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		  <textarea name="posting_place" id="posting_place" class="text_area" style="width:400px;"><?php echo $show_data['posting_place']; ?></textarea></td>

       </tr>
	   
	   <tr>

          <td align="right"><?php echo PHOTO; ?></td>

          <th align="center">:</th>

          <td align="left">
		  <?php
		  	$imagePath = "../../uploads/bcs_officers/".$show_data['photo'];
		  	if($show_data['photo']=='' || !is_file($imagePath)) {
					$photoPrint = '../../images/no_photo.jpg';
				}
				else if($show_data['photo']) {
						$photoPrint = $imagePath;		 
					}
		  ?>
		  <img src="<?php echo $photoPrint; ?>" width="120" height="135" />
			<input type="hidden" name="cur_file" value="<?php echo $show_data['photo'];?>"/>	
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