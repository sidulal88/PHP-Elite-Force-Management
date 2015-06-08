<?php  require_once('../../settings.php');
	$industry_unit_id = $_REQUEST['industry_unit_id'];
	
try

{
	$Uploader = new Uploader();

	$IndustrialUnit = new IndustrialUnit();

	$result = $IndustrialUnit -> get($industry_unit_id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['Submit'])) {
	
		$IndustrialUnit -> edit();
		echo "<script type=\"text/javascript\">location.replace(\"record_edit.php?industry_unit_id=$industry_unit_id\");</script>";

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
<script language="JavaScript" type="text/javascript" src="EditorEquipment/wysiwyg.js"></script>
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
     
<form action="record_edit.php?industry_unit_id=<?php echo $industry_unit_id; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="industry_unit_id" value="<?php echo $industry_unit_id; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
      
		  <tr>
    <td width="19%" align="right">Unit  Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="unit_id" id="unit_id">
			<option><?php echo SELECT; ?></option>
				<?php

			$Unit = new Unit();
		
			$result = $Unit -> gets(" AND is_industry=1 AND data_level > 1 ");
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
	
				  <option value="<?php echo $show['unit_id']; ?>"<?php if($show_data['unit_id']==$show['unit_id']) { echo 'selected'; }?>><?php echo $show['unit_name']; ?></option>
	
	<?php } ?>
	
	    </select>   	  </td>

       </tr>  
		
	  <tr>

	    <td align="right">Sort</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="sort" id="sort" value="<?php echo $show_data['sort']; ?>" size="32" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
		<tr>
            <td align="right">Description</td>
            <th align="center"></th>
            <td align="left">
			 <textarea name="description" id="description" class="bng_text" cols="34" rows="6"><?php echo $show_data['description']; ?></textarea>

					<script language="javascript1.1">

										  generate_wysiwyg('description',650,300);

										</script>
</td>
        </tr>
		
		
	   <tr>

          <td align="right"><?php echo PHOTO; ?></td>

          <th align="center">:</th>

          <td align="left">
		  <?php
		  	$imagePath = "../../uploads/unit_map/".$show_data['photo'];
		  	if($show_data['photo']=='' || !is_file($imagePath)) {
					$photoPrint = '../../images/no_photo.jpg';
				}
				else if($show_data['photo']) {
						$photoPrint = $imagePath;		 
					}
		  ?>
		  <img src="<?php echo $photoPrint; ?>" width="120" height="135" />		
		  <input type="hidden" name="cur_file" value="<?php echo $show_data['photo'];?>"/>	
		  	<input type="file" name="file_one" id="file_one" size="32" maxlength="37" />::Recommended  size : 480px*240px		  </td>
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