<?php  require_once('../../settings.php');
	$sacked_worker_id = $_REQUEST['sacked_worker_id'];

	
try

{
	$Uploader = new Uploader();

	$Sacked_Workers = new Sacked_Workers();

	$result = $Sacked_Workers -> get($sacked_worker_id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['Submit'])) {
	
		$Sacked_Workers -> edit();
		echo "<script type=\"text/javascript\">location.replace(\"record_edit.php?sacked_worker_id=$sacked_worker_id\");</script>";

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
     <div class="easyui-layout" style="height:700px; margin: auto;">  
    <div title="Sacked Worker" data-options="region:'center'" class="easyui-panel" >  
<form action="record_edit.php?sacked_worker_id=<?php echo $sacked_worker_id; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="sacked_worker_id" value="<?php echo $sacked_worker_id; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
      <tr><td colspan="3"><?php //include('bangla_keyboard.php');?></td></tr>
 <tr>
          <td colspan="3" class="msg">
 </td>

          </tr>
		  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="name" id="name" value="<?php echo $show_data['name']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
		 <tr>

	    <td align="right">NID No.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="nid" id="nid" value="<?php echo $show_data['nid']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>	
	  <tr>

	    <td align="right">Contact No</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="contact_no" id="contact_no" value="<?php echo $show_data['contact_no']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
		<tr>

	    <td align="right">Address</td>

	    <th align="center">:</th>

	    <td align="left"><textarea name="per_address" id="per_address" class="text_area" style="width:400px;"><?php echo $show_data['per_address']; ?></textarea></td>
	    </tr>
			
		<tr>

	    <td align="right">Sacked From</td>

	    <th align="center">:</th>

	    <td align="left"><textarea name="sacked_from" id="sacked_from" class="text_area" style="width:400px;"><?php echo $show_data['sacked_from']; ?></textarea></td>
	    </tr>
		
		
	  <tr>

	    <td align="right">Sacked Date</td>

	    <th align="center">:</th>

	    <td align="left">
		<?php
						
		$date = $show_data['sacked_date'];
		$selected_date = date('Y-m-d', strtotime($date));
		?>
		<input type="text" name="sacked_date" value="<?php echo $selected_date; ?>"  class="easyui-datebox"/>
		</td>
	    </tr>
	   <tr>
<tr>

	    <td align="right">Sacked Reson</td>

	    <th align="center">:</th>

	    <td align="left"><textarea name="reson" id="reson" class="text_area" style="width:400px;"><?php echo $show_data['reson']; ?></textarea></td>
	    </tr>
	   
	   <tr>

          <td align="right">Photo</td>

          <th align="center">:</th>

          <td align="left">
		<?php
		  	$imagePath = "../../uploads/sacked/".$show_data['photo'];
		  	if($show_data['photo']=='' || !is_file($imagePath)) {
					$photoPrint = '../../images/no_photo.jpg';
				}
				else if($show_data['photo']) {
						$photoPrint = $imagePath;		 
					}
		  ?>
				<img src="<?php echo $photoPrint; ?>" width="70" height="80" />
		
		  
			<input type="hidden" name="cur_file" value="<?php echo $show_data ['photo'];?>"/>	
		  	<input type="file" name="file_one" id="file_one" size="32" maxlength="37" />  </td>
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
    </div>
</div>
</body>
</html><script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
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