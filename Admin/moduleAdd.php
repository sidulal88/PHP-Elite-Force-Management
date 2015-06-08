<?php  require_once('../settings.php'); ?>
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
	 <h2><?php echo PAGE_ADD; ?></h2>
	<h3> <a href="moduleView.php" class="link_button"><?php echo PAGE_LIST; ?></a></h3>
	 </div>
<form action="" enctype="multipart/form-data" method="post">

	  <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">
      <tr><td colspan="3"><?php include('bangla_keyboard.php');?></td></tr>
          
        <tr>

          <td colspan="3" class="msg">

<?php

if(isset($_POST['btnAdd']))

{

	try

	{	
		
		$Module = new Module();
		
		$Module->add();

	}

	catch(Exception $e)

	{

		echo $e->getMessage();

	}

}

Common::displayMsg();

?>	  </td>
          </tr>`

	  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="name" id="name" value="<?php echo $show['name']; ?>" size="32" maxlength="100"  class="bng_text"/></td>
	    </tr>

	  <tr>

	    <td align="right"><?php echo URL; ?></td>

	    <th align="center">:</th>

	    <td align="left">domain/<input type="text" name="proxy_url" id="proxy_url" value="<?php echo $show['proxy_url']; ?>" size="32" maxlength="100" /></td>
	    </tr>

<tr>
    <td width="36%" align="right"><?php echo CATEGORY; ?></td>

          <th width="4%" align="center">:</th>

          <td width="60%" align="left">
		<select name="mainCatid" id="mainCatid">
			<option><?php echo SELECT; ?></option>
				<?php

		$Module = new Module();
		
		$menuTree = $Module -> getsGrid();
		
		foreach($menuTree as $show):
	
		$spacer = ($show['sort_level'] > 1) ? str_repeat(" --> ", $show['sort_level']-1) : '';
		?>
	
				  <option value="<?php echo $show['module_id'].'::'.$show['sort_level']; ?>"><?php echo $spacer.$show['name']; ?></option>
	
	<?php endforeach; ?>
			   </select>   	  </td>

        </tr>
        <tr>
        <tr>
            <td align="right"><?php echo DETAILS; ?></td>
            <th align="center">&nbsp;</th>
            <td align="left"> 
		  <textarea name="description" id="description" class="bng_text"><?php echo @$_POST['description'];?></textarea>

				<script language="javascript1.1">

										  generate_wysiwyg('description',650,300);

										</script>	
</td>
        </tr>
        <tr>

          <td align="right"><?php echo PHOTO; ?></td>

          <th align="center">:</th>

          <td align="left">

		  	<input type="file" name="photo" />::Recommended size: 450px*253px	  </td>
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
            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
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
            <option value="<?php echo $key; ?>"><?php echo Common::Eng2BanStatus($key); ?></option>
            <?php endforeach; ?>
          </select></td>
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