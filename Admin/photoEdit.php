<?php  require_once('../settings.php');
	$pId = $_GET['pId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>
<link href="form_msg.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> <?php include('adminHead.php');?></td>
  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    
      <h1><?php echo PHOTOGALLERY_MANAGEMENT; ?></h1>
	 <h2><?php echo PHOTO_LIST.'-'.EDIT; ?></h2>
	<h3> <a href="photoView.php" class="link_button"><?php echo PHOTO_LIST; ?></a></h3>
</h3>
	 </div>
     
<form action="photoEdit.php?pId=<?php echo $pId; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="id" value="<?php echo $pId; ?>" />

	  <table border="0" cellpadding="1" cellspacing="1" width="100%" style="border:#CCCCCC 1px solid;" class="dataAdd">
      <tr><td colspan="3"><?php include('bangla_keyboard.php');?></td></tr>
       <tr>

          <td colspan="3" align="left" class="msg">

<?php		  

try

{

	$Uploader = new Uploader();

	$Photo = new Photo();

	$result = $Photo -> get($pId);

	$show = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['btnAdd'])) {

		$Photo -> edit();

	}

}

catch(Exception $e)

{

	echo $e->getMessage();

}

?>	  </td>

          </tr>

        <tr>

          <td width="36%" align="right"><?php echo CATEGORY; ?></td>

          <th width="4%" align="center">:</th>

          <td width="60%" align="left">

			<?php

				$Category = new Category();

				$Category -> getCategoriesInLB($show['category']);

			?>		  </td>

        </tr>

	  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="title" id="title" value="<?php echo $show['title']; ?>" size="32" maxlength="100" class="bng_text" /></td>

	    </tr>

   <tr>

          <td align="right"><?php echo DETAILS; ?></td>

          <th align="center">:</th>

          <td align="left"><textarea name="description" id="description" class="bng_text" cols="34" rows="6"><?php echo $show['description']; ?></textarea></td>

        </tr>
      <tr>

          <td align="right"><?php echo SERIAL; ?></td>

          <th align="center">:</th>

          <td align="left"><input type="text" name="rank" id="rank" value="<?php echo $show['rank']; ?>" size="32" maxlength="3" class="bng_text" /></td>

        </tr>

        <tr>

        <tr>

          <td align="right">&nbsp;</td>

          <th align="center">&nbsp;</th>

          <td align="left">

		  	<?php echo $Uploader -> imageViewer($show['photo_thumb'], '100', '', '', '', '', '', 'photos/');?>

			<input type="hidden" name="photo_large" value="<?php echo $show['photo_large'];?>" />

			<input type="hidden" name="photo_thumb" value="<?php echo $show['photo_thumb'];?>" />

			<input type="hidden" name="curphoto" value="<?php echo $show['photo_thumb'];?>" />

		  </td>

        </tr>

        <tr>

          <td align="right"><?php echo PHOTO; ?></td>

          <th align="center">:</th>

          <td align="left">

		  	<input type="file" name="photo" />

			<br /><!--<span class="instruction">Recommended max width 500<br />Please note: Thumbnile photo will be created automatically</span>-->					  

		  </td>

        </tr>

        <tr>

          <td align="right">&nbsp;</td>

          <th align="center"></th>

          <td align="left"><input type="submit" name="btnAdd" value="<?php echo SAVE; ?>" /></td>

        </tr>

      </table>

	</form>
	
	
    </td>
  </tr>
</table>
<?php include('footer.php');?>
</body>
</html>