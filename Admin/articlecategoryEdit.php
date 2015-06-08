<?php  require_once('../settings.php');
	$cId = $_GET['cId'];
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
    <h1><?php echo ARTICLE_MANAGEMENT; ?></h1>
	 <h2><?php echo ARTICLE_CATEGORY_LIST.'-'.EDIT; ?></h2>
	<h3> <a href="articlecategoryView.php" class="link_button"><?php echo ARTICLE_CATEGORY_LIST; ?></a></h3>
	 </div>
     
<form action="articlecategoryEdit.php?cId=<?php echo $cId; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="id" value="<?php echo $cId; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">
   
      <tr><td colspan="3"><?php include('bangla_keyboard.php');?></td></tr>

      <tr>
          <td colspan="3" align="left" class="msg">
<?php		  
try
{
	$ArticleCategory = new ArticleCategory();
	$result = $ArticleCategory -> get($cId);
	$show = $result -> fetch_array(MYSQL_ASSOC);
	if(isset($_POST['btnAdd'])) {
		$ArticleCategory -> edit($cId);
		echo "<script type=\"text/javascript\">location.replace(\"articlecategoryView.php?msg=ok\");</script>";
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
          <td width="60%" align="left"><input type="text" id="name" name="name" value="<?php echo $show['name']; ?>" size="32" class="bng_text"  /></td>
        </tr>
        <tr>
          <td align="right"><?php echo SERIAL; ?></td>
          <th align="center">:</th>
          <td align="left"><input type="text" name="rank" id="rank" value="<?php echo $show['rank']; ?>" size="32" maxlength="2" /></td>
        </tr>
        <tr>
          <td align="right"><?php echo POSITION; ?></td>
          <th align="center">:</th>
          <td align="left"><select name="position" id="position">
            <option><?php echo SELECT; ?></option>
            <?php
	
		$posionList = Common::ArticlePosition();
	
		foreach($posionList as $key=>$value):
	
		?>
            <option value="<?php echo $key; ?>" <?php if($show['position']==$key) {echo 'selected';}?>><?php echo $value; ?></option>
            <?php endforeach; ?>
          </select></td>
        </tr>
        	  
        <tr>
          <td align="right">&nbsp;</td>
          <th align="center">&nbsp;</th>
          <td align="left"><input type="submit" name="btnAdd" value="<?php echo SAVE; ?>" /></td>
        </tr>
        <tr>
            <td align="right">&nbsp;</td>
            <th align="center">&nbsp;</th>
            <td align="left">&nbsp;</td>
        </tr>
      </table>
	</form>
	
	
    </td>
  </tr>
</table>
<?php include('footer.php');?>
</body>
</html>