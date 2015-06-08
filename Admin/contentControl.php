<?php  require_once('../settings.php'); 
	$content_id = $_REQUEST['content_id'];
	
	$Content = new Content();
		
	$result = $Content -> get($content_id);
	
	$showdata = $result -> fetch_array(MYSQL_ASSOC);
	
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
	  <td align="center" class="msg"><?php 
	  
	  if($_GET['msg'])
	  {
			echo SUCCESS_MSG;  
	  } 
	  ?></td>
	  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1><?php echo PAGE_MANAGEMENT; ?></h1>
	 <h2><?php echo $showdata['name']; ?></h2>
	 </div>
<form action="" enctype="multipart/form-data" method="post">
<input type="hidden" name="id" value="<?php echo $content_id; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">
          
        <tr>

          <td colspan="3" class="msg">

<?php


	try

	{	
		
		$Uploader = new Uploader();

		if(isset($_POST['btnAdd'])) {
	
			$Content -> save();
	
			//header("Location: moduleView.php?msg=Record has been updated successfully!");
	
		}

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}


//Common::displayMsg();

?>	  </td>
          </tr>
	  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="name" id="name" value="<?php echo $showdata['name']; ?>" size="62" maxlength="50"  class="bng_text"/></td>
	    </tr>

	  <tr>

	    <td align="right"><?php echo TITLE; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="title" id="title" value="<?php echo $showdata['title']; ?>" size="62" maxlength="100"  class="bng_text"/></td>
	    </tr>

        <tr>
        <tr>
            <td align="right"><?php echo DETAILS; ?></td>
            <th align="center">&nbsp;</th>
            <td align="left"> 
		  <textarea name="description" id="description" class="bng_text"><?php echo $showdata['description'];?></textarea>

				<script language="javascript1.1">

										  generate_wysiwyg('description',650,300);

										</script>	
</td>
        </tr>
        <tr>

          <td align="right"><?php echo PHOTO; ?></td>

          <th align="center">&nbsp;</th>

          <td align="left">

		  	<?php echo $Uploader -> imageViewer($showdata['photo'], '200', '', '', '', '', '', 'contents/');?>

			<input type="hidden" name="curphoto" value="<?php echo $showdata['photo'];?>" />
          <input type="hidden" name="cur_photo" value="<?php echo $showdata['photo']; ?>" />
	  	<input type="file" name="photo" />::Recommended size: 450px*253px
		  </td>

        </tr>
        
        
        <tr>

          <td align="right">&nbsp;</td>

          <th align="center"></th>

          <td align="left">
          <input type="submit" name="btnAdd" value="<?php echo SAVE; ?>" /></td>
        </tr>
      </table>

	</form>
	
    </td>
  </tr>
</table>
<?php include('footer.php');?>
</body>
</html>