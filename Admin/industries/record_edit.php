<?php  require_once('../../settings.php');
	$industry_id = $_REQUEST['industry_id'];

	
try

{
	$Industry = new Industry();

	$result = $Industry -> get($industry_id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['Submit'])) {
	
		$Industry -> add();
		echo "<script type=\"text/javascript\">location.replace(\"record_edit.php?industry_id=$industry_id\");</script>";

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
    <div title="Industry Data Edit" data-options="region:'center'" class="easyui-panel" >  
<form action="record_edit.php?industry_id=<?php echo $industry_id; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="industry_id" value="<?php echo $industry_id; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
      <tr><td colspan="3"><?php //include('bangla_keyboard.php');?></td></tr>
 <tr>
          <td colspan="3" class="msg">
 </td>

          </tr>
		  <tr>

	    <td align="right">Industry Name</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="industry_name" value="<?php echo $show_data['industry_name']; ?>" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
        <tr>		
		
<tr>
    <td width="19%" align="right">Unit Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="unit_id" id="unit_id">
			<option><?php echo SELECT; ?></option>
				<?php

			$Unit = new Unit();
		
			$menuTree = $Unit -> getsGrid(" AND is_industry=1 ");
	
			foreach($menuTree as $show):
		
			$spacer = ($show['data_level'] > 1) ? str_repeat(" --> ", $show['data_level']-1) : '';
		?>
	
				  <option value="<?php echo $show['unit_id']; ?>" <?php if($show_data['unit_id']==$show['unit_id']) {echo 'selected'; }?>><?php echo $spacer.$show['unit_name']; ?></option>
	
	<?php endforeach; ?>
	    </select>   	  </td>

       </tr>  

		<tr>

	    <td align="right">Owner</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="owner" value="<?php echo $show_data['owner']; ?>" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
        <tr>		
		<tr>

	    <td align="right">Contact Person</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="contact_person" value="<?php echo $show_data['contact_person']; ?>" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>		
		<tr>

	    <td align="right">Contact No</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="contact_no" value="<?php echo $show_data['contact_no']; ?>" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
		 <tr>
            <td align="right">Address</td>
            <th align="center"></th>
            <td align="left"><textarea name="address" id="address" class="text_area" cols="30" rows="4"><?php echo $show_data['address']; ?></textarea>
			
</td>
        </tr>
				<tr>

	    <td align="right">Worker</td>

	    <th align="center">:</th>

	    <td align="left">
		<input type="text" name="worker_male"size="14"class="bng_text" placeholder="Male" value="<?php echo $show_data['worker_male']; ?>" />
		<input type="text" name="worker_female"size="14"class="bng_text" placeholder="Female"  value="<?php echo $show_data['worker_female']; ?>" />
		</td>
	    </tr>
        <tr>
<tr>
    <td width="19%" align="right">Product</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="product_id" id="product_id">
			<option><?php echo SELECT; ?></option>
				<?php

			$Product = new Product();
			$result = $Product -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
	
				  <option value="<?php echo $show['productid']; ?>" <?php if($show_data['product_id']==$show['productid']) {echo 'selected'; }?>><?php echo $show['productname']; ?></option>
	
	<?php } ?>
	    </select>   	  </td>

       </tr>
		<tr>

	    <td align="right">Remarks</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="remarks" value="<?php echo $show_data['remarks']; ?>" size="38" maxlength="60" class="bng_text" /></td>
	    </tr>
		  
		<tr>

	    <td align="right">Member Ship</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="member_ship" value="<?php echo $show_data['member_ship']; ?>" size="26" maxlength="60" class="bng_text" /></td>
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
	 </div>
</div>
	
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