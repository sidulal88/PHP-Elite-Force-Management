<?php  require_once('../../settings.php');
	$industry_unit_id = $_REQUEST['industry_unit_id'];
	
try

{
	$Uploader = new Uploader();

	$IndustrialUnit = new IndustrialUnit();

	$result = $IndustrialUnit -> get($industry_unit_id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);


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
	 <h2>Details</h2>
	<h3> <a href="index.php" class="link_button">Record List</a></h3>
	 </div>
     <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
		<tr>
    <td width="19%" align="right">Unit Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
				<?php
			$Unit = new Unit();
			$result = $Unit -> get($show_data['unit_id']);
			$show = $result->fetch_array(MYSQL_ASSOC);
			echo $show['unit_name'];	
		?>
	 	  </td>

       </tr>  
        <tr>		
		 <tr>

	    <td align="right">Sort</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['sort']; ?></td>
	    </tr>
        <tr>		
		
		<tr>

	    <td align="right" valign="top">Description</td>

	    <th align="center" valign="top">:</th>

	    <td align="left"><?php echo $show_data['description']; ?></td>
	    </tr>
        <tr>		
		<tr>

	    <td align="right" valign="top">Unit Map</td>

	    <th align="center" valign="top">:</th>

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
		  <img src="<?php echo $photoPrint; ?>" width="120" height="135" /></td>
	    </tr>
        <tr>

      <tr>
          <td align="right"><?php echo STATUS; ?></td>
          <th align="center">:</th>
          <td align="left"><?php echo $show_data['status']; ?></td>
        </tr>
        
      </table>
<?php //include('footer.php');?>
</body>
</html>