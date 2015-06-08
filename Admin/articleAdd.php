<?php @session_start();

	require_once('../settings.php');

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
	 <h2><?php echo ARTICLE_ADD; ?></h2>
	<h3> <a href="articleView.php" class="link_button"><?php echo ARTICLE_LIST; ?></a></h3>
	 </div>
     
<form action="articleAdd.php" enctype="multipart/form-data" method="post">

	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
 
      <tr><td colspan="3"><?php include('bangla_keyboard.php');?></td></tr>

        <tr>

          <td colspan="3" class="msg">

<?php

if(isset($_POST['btnAdd']))

{

	try

	{	$Article = new Article();

		$Article->add();

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

	          <td align="right"><?php echo CATEGORY; ?></td>

	          <th align="center">:</th>

	          <td align="left">

			  <select name="category">

			  <option><?php echo SELECT; ?></option>

	<?php

	$ArticleCategory = new ArticleCategory();

	$result = $ArticleCategory -> gets();

	while($show = $result->fetch_array(MYSQL_ASSOC)):

	?>

			  <option value="<?php echo $show['id']; ?>"><?php echo $show['name']; ?></option>

<?php endwhile; ?>

	              </select>	          </td>

	          </tr>

	      <tr>

	    <td width="36%" align="right"><?php echo NAME; ?></td>

	    <th width="4%" align="center">:</th>

	    <td width="60%" align="left"><input type="text" name="name" id="name" value="<?php echo @$_POST['name']; ?>" size="45" class="bng_text"  /></td>

	    </tr>
	      <tr>

	    <td width="36%" align="right"><?php echo TITLE; ?></td>

	    <th width="4%" align="center">:</th>

	    <td width="60%" align="left"><input type="text" name="title" id="title" value="<?php echo @$_POST['title']; ?>" size="45" class="bng_text"  /></td>

	    </tr>
	      <tr>

	    <td width="36%" align="right"><?php echo SUB_TITLE; ?></td>

	    <th width="4%" align="center">:</th>

	    <td width="60%" align="left"><input type="text" name="sub_title" id="sub_title" value="<?php echo @$_POST['sub_title']; ?>" size="45" class="bng_text"  /></td>

	    </tr>

<tr>

    <td align="right"><?php echo DATE; ?></td>

    <th align="center">:</th>

    <td align="left">
    <input id="datepicker" name="publish_date" class="datebox" > :: DD-MM-YY
    </td>

</tr>

<tr>

          <td align="right"><?php echo DETAILS; ?></td>

          <th align="center">:</th>

          <td align="left">		  <textarea name="description" id="description" class="bng_text"><?php echo @$_POST['description'];?></textarea>

					<script language="javascript1.1">

										  generate_wysiwyg('description',650,300);

										</script></td>

        </tr><tr>

          <td align="right"><?php echo PHOTO; ?></td>

          <th align="center">:</th>

          <td align="left">

		  	<input type="file" name="photo" id="photo" size="32" maxlength="37" />::Recommended  size : 450px*253px
		  </td>

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