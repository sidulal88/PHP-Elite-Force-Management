<?php  require_once('../settings.php');
	$bId = $_GET['bId'];
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
    <h1><?php echo BANNER_MANAGEMENT; ?></h1>
	 <h2><?php echo BANNER_LIST.'-'.EDIT; ?></h2>
	<h3> <a href="bannerAdd.php" class="link_button"><?php echo BANNER_ADD; ?></a></h3>
	 </div>
     
<form action="bannerEdit.php?bId=<?php echo $bId; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="id" value="<?php echo $bId; ?>" />

	  <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">

      <tr><td colspan="3"><?php include('bangla_keyboard.php');?></td></tr>


        <tr>

          <td colspan="3" align="left" class="msg">

<?php		  

try

{

	$Uploader = new Uploader();

	$Banner = new Banner();

	$result = $Banner -> get($bId);

	$show = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['btnAdd'])) {

		$Banner -> edit($bId);

		//header("Location: bannerView.php?msg=Record has been updated successfully!");

	}

}

catch(Exception $e)

{

	echo $e->getMessage();

}

?>		  </td>

          </tr>
        <tr>

          <td width="36%" align="right"><?php echo NAME; ?></td>

          <th width="4%" align="center">:</th>

          <td width="60%" align="left"><input type="text" id="title" name="title" value="<?php echo $show['title']; ?>" size="32" class="bng_text" /></td>

        </tr>
        <tr>

          <td width="36%" align="right"><?php echo SERIAL; ?></td>

          <th width="4%" align="center">:</th>

          <td width="60%" align="left"><input type="text" id="rank" name="rank" value="<?php echo $show['rank']; ?>" size="32" maxlength="100" /></td>

        </tr>
        <tr>
          <td align="right"><?php echo DETAILS; ?></td>
          <th align="center">&nbsp;</th>
          <td align="left"><textarea name="description" id="description" rows="6" cols="34" class="bng_text"><?php echo $show['description']; ?></textarea>
                                       
         

				</td>
        </tr>
        <tr>

          <td width="36%" align="right"><?php echo PHOTO; ?></td>

          <th width="4%" align="center">:</th>

          <td width="60%" align="left">

			<p>
            <?php echo $Uploader -> imageViewer($show['photo'], '200', '', '', '', '', '', 'banners/');?>
             </p>

			  <p>

			<input type="file" name="photo" />

			<input type="hidden" name="curphoto" value="<?php echo $show ['photo'];?>"/> ::Recommended  size : <?php echo BANNER_WIDTH; ?>px*<?php echo BANNER_HEIGHT; ?>px

			  </p>

		</td>

        <tr>

          <td align="right">&nbsp;</td>

          <th align="center">&nbsp;</th>

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