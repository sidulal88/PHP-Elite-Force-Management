<?php  require_once('../../settings.php');
	$id = $_REQUEST['id'];
	
try

{
	$Uploader = new Uploader();

	$News = new News();

	$result = $News -> get($id);

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
    <h1>Common Entry</h1>
	 <h2>News Details</h2>
	<h3> <a href="index.php" class="link_button">Record List</a></h3>
	 </div>
     
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
       <tr>

	    <td align="right">News Title</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['title']; ?></td>
	    </tr>
		  <tr>

	    <td align="right">News Date</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['news_date']; ?></td>
	    </tr>
		
	  <tr>

	    <td align="right">Rank</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['rank']; ?></td>
	    </tr>
			<tr>

	    <td align="right" valign="top">Descripton</td>

	    <th align="center" valign="top">:</th>

	    <td align="left"><?php echo $show_data['description']; ?></td>
	    </tr>
		
	   <tr>

          <td align="right"><?php echo PHOTO; ?></td>

          <th align="center">:</th>

          <td align="left"><?php
		  	$imagePath = "../../uploads/newses/".$show_data['photo'];
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
          <td align="right"><?php echo STATUS; ?></td>
          <th align="center">:</th>
          <td align="left"><?php echo $show_data['status']; ?></td>
        </tr>
      
	 
      </table>
	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
</body>
</html>