<?php  require_once('../settings.php'); 
	$mId = $_GET['mId'];
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
       <h1><?php echo PAGE_MANAGEMENT; ?></h1>
	 <h2><?php echo PAGE_LIST.'-'.EDIT; ?></h2>
	<h3> <a href="moduleView.php" class="link_button"><?php echo PAGE_LIST; ?></a></h3>

	 </div>
<form action="moduleEdit.php?mId=<?php echo $mId; ?>" enctype="multipart/form-data" method="post">
	<input type="hidden" name="module_id" value="<?php echo $mId; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">

      <tr><td colspan="3"><?php include('bangla_keyboard.php');?></td></tr>

        <tr>

          <td colspan="3" align="left" class="msg">

<?php		  

try

{

	$Uploader = new Uploader();

	$Module = new Module();

	$result = $Module -> get($mId);

	$show = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['btnAdd'])) {

		$Module -> edit($mId);

		//header("Location: moduleView.php?msg=Record has been updated successfully!");

	}

}

catch(Exception $e)

{

	echo $e->getMessage();

}

?>	  </td>

          </tr>

        <tr>

	  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="name" id="name" value="<?php echo $show['name']; ?>" size="32" maxlength="100"  class="bng_text" /></td>
	    </tr>

	  <tr>

	    <td align="right"><?php echo URL; ?></td>

	    <th align="center">:</th>

	    <td align="left">domain/<input type="text" name="proxy_url" id="proxy_url" value="<?php echo $show['proxy_url']; ?>" size="32" maxlength="100" /></td>
	    </tr>

    <td width="36%" align="right"><?php echo CATEGORY; ?></td>

          <th width="4%" align="center">:</th>

          <td width="60%" align="left">
		<select name="mainCatid" id="mainCatid">
			<option><?php echo SELECT; ?></option>
		
				<?php

		$Module = new Module();
		
		$menuTree = $Module -> getsGrid();
		
		foreach($menuTree as $showMain):
	
		$spacer = ($showMain['sort_level'] > 1) ? str_repeat(" --> ", $showMain['sort_level']-1) : '';
		?>
	
				  <option value="<?php echo $showMain['module_id'].'::'.$showMain['sort_level']; ?>"<?php if($show['main_catid']==$showMain['module_id']) {echo "selected"; }?>><?php echo $spacer.$showMain['name']; ?></option>
	
	<?php endforeach; ?>


			   </select>   	  </td>

        </tr>

        <tr>
            <td align="right"><?php echo DETAILS; ?></td>
            <th align="center">&nbsp;</th>
            <td align="left"> 
		  <textarea name="description" id="description" class="mybox"><?php echo $show['description'];?></textarea>

					<script language="javascript1.1">

										  generate_wysiwyg('description',650,300);

										</script>	            
</td>
        </tr>

        <tr>

          <td align="right">&nbsp;</td>

          <th align="center">&nbsp;</th>

          <td align="left">

		  	<?php echo $Uploader -> imageViewer($show['photo'], '100', '', '', '', '', '', 'modules/');?>

			<input type="hidden" name="curphoto" value="<?php echo $show['photo'];?>" />

		  </td>

        </tr>

        <tr>

          <td align="right"><?php echo PHOTO; ?></td>

          <th align="center">:</th>

          <td align="left">

		  	<input type="file" name="photo" />::Recommended size: 450px*253px
		  </td>

        </tr>

        <tr>
          <td align="right"><?php echo POSITION; ?></td>
          <th align="center">:</th>
          <td align="left"><select name="position" id="position">
            <option><?php echo SELECT; ?></option>
            <?php
	
		$posionList = Common::BanPosition();
	
		foreach($posionList as $key=>$value):
	
		?>
            <option value="<?php echo $key; ?>" <?php if($show['position']==$key) {echo 'selected'; }?>><?php echo $value; ?></option>
            <?php endforeach; ?>
          </select></td>
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
            <option value="<?php echo $key; ?>" <?php if($show['status']==$key) {echo 'selected'; }?>><?php echo Common::Eng2BanStatus($key); ?></option>
            <?php endforeach; ?>
          </select></td>
        </tr>
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