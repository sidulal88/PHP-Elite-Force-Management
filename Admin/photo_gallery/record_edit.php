<?php  require_once('../../settings.php');
	$id = $_REQUEST['id'];
	
try

{
	$Uploader = new Uploader();

	$Photo = new Photo();

	$result = $Photo -> get($id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['Submit'])) {
	
		$Photo -> edit();
		echo "<script type=\"text/javascript\">location.replace(\"record_edit.php?id=$id\");</script>";

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
    <h1>Common Settings</h1>
	 <h2><?php echo EDIT; ?></h2>
	<h3> <a href="index.php" class="link_button">Record List</a></h3>
	 </div>
     
<form action="record_edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
      
		  <tr>
    <td width="19%" align="right">Category Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="category" id="category">
			<option><?php echo SELECT; ?></option>
				<?php

			$Category = new Category();
		
			$result = $Category -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
	
				  <option value="<?php echo $show['id']; ?>"<?php if($show_data['category']==$show['id']) { echo 'selected'; }?>><?php echo $show['name']; ?></option>
	
	<?php } ?>
	
	    </select>   	  </td>

       </tr>  

		  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="title" id="title" value="<?php echo $show_data['title']; ?>" size="32" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">Sort No.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="rank" id="rank" value="<?php echo $show_data['rank']; ?>" size="32" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
		<tr>
            <td align="right">Description</td>
            <th align="center"></th>
            <td align="left"><textarea name="description" id="description" class="text_area" cols="40"><?php echo $show_data['description']; ?></textarea>
			
</td>
        </tr>
		
		
	   <tr>

          <td align="right"><?php echo PHOTO; ?></td>

          <th align="center">:</th>

          <td align="left">
		  <?php
		  	$imagePath = "../../uploads/photos/".$show_data['photo_thumb'];
		  	if($show_data['photo_thumb']=='' || !is_file($imagePath)) {
					$photoPrint = '../../images/no_photo.jpg';
				}
				else if($show_data['photo_thumb']) {
						$photoPrint = $imagePath;		 
					}
		  ?>
		  <img src="<?php echo $photoPrint; ?>" width="120" height="135" />
			<input type="hidden" name="photo_thumb" value="<?php echo $show_data['photo_thumb'];?>"/>	
			<input type="hidden" name="photo_large" value="<?php echo $show_data['photo_large'];?>"/>	
		  	<input type="file" name="photo" id="photo" size="32" maxlength="37" />::Recommended  size : 480px*240px		  </td>
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