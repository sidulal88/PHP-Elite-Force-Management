<?php  require_once('../settings.php');
	
	$aId = $_GET['aId'];
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
	 <h2><?php echo ARTICLE_LIST.'-'.EDIT; ?></h2>
	<h3> <a href="articleView.php" class="link_button"><?php echo ARTICLE_LIST; ?></a></h3>
	 </div>
     
<form action="articleEdit.php?aId=<?php echo $aId; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="id" value="<?php echo $aId; ?>" />

	  <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">
 
      <tr><td colspan="3"><?php include('bangla_keyboard.php');?></td></tr>


        <tr>

          <td colspan="3" align="left" class="msg">

<?php		  

try

{

	$Uploader = new Uploader();

	$Article = new Article();

	$result = $Article -> get($aId);

	$show = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['btnAdd'])) {

		$Article -> edit($aId);


	}

}

catch(Exception $e)

{

	echo $e->getMessage();

}

?>		  </td>

          </tr>

        <tr>

            <td align="right"><?php echo CATEGORY; ?></td>

            <th align="center">:</th>

            <td align="left"><select name="category">

			  <option><?php echo SELECT; ?></option>

	<?php

	$ArticleCategory = new ArticleCategory();

	$result = $ArticleCategory -> gets();

	while($data = $result->fetch_array(MYSQL_ASSOC)):

	?>

			  <option value="<?php echo $data['id']; ?>" <?php if($show['category']==$data['id']) echo "selected";?>><?php echo $data['name']; ?></option>

<?php endwhile; ?>

	              </select></td>

        </tr>

        <tr>

            <td align="right"><?php echo NAME; ?></td>

            <th align="center">:</th>

            <td align="left"><input type="text" name="name" id="name" value="<?php echo str_replace("@~apos~@", "'", $show['name']); ?>" size="45" class="bng_text" /></td>

        </tr>

        <tr>

            <td align="right"><?php echo TITLE; ?></td>

            <th align="center">:</th>

            <td align="left"><input type="text" name="title" id="title" value="<?php echo $show['title']; ?>" size="45" class="bng_text" /></td>

        </tr>

	      <tr>

	    <td width="36%" align="right"><?php echo SUB_TITLE; ?></td>

	    <th width="4%" align="center">:</th>

	    <td width="60%" align="left"><input type="text" name="sub_title" id="sub_title" value="<?php echo $show['sub_title']; ?>" size="45" class="bng_text"  /></td>

	    </tr>


        <tr>

            <td align="right"><?php echo DATE; ?></td>

            <th align="center">:</th>

            <td align="left"><input id='publish_date' name="publish_date" class='datepicker' value="<?php echo Common::converToDisplayDate($show['publish_date']); ?>"> :: DD-MM-YY</td>

        </tr>

<tr>

          <td align="right"><?php echo DETAILS; ?></td>

          <th align="center">:</th>

          <td align="left"> <textarea name="description" id="description"  class="bng_text" cols="34" rows="6"><?php echo $show['description'];?></textarea>
          <script language="javascript1.1">

										  generate_wysiwyg('description',650,300);

										</script>
</td>
</tr>        <tr>

          <td width="36%" align="right"><?php echo PHOTO; ?></td>

          <th width="4%" align="center">:</th>

          <td width="60%" align="left">

			<p><?php echo $Uploader -> imageViewer($show['photo'], '100', '', '', '', '', '', 'article/');?> </p>

			  <p>

			<input type="file" name="photo" />::Recommended  size : 450px*253px

			<input type="hidden" name="curphoto" value="<?php echo $show ['photo'];?>"/>

			  </p>		</td>

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