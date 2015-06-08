<?php  require_once('../settings.php');?>
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
	  <td align="center" class="msg">  <?php 	 
	  if($_GET['msg'])
	  {
			echo SUCCESS_MSG;  
	  } 
	?></td>
	  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1><?php echo ARTICLE_MANAGEMENT; ?></h1>
	 <h2><?php echo ARTICLE_CATEGORY_LIST; ?></h2>
	<h3> <a href="articlecategoryAdd.php" class="link_button"><?php echo ARTICLE_CATEGORY_ADD; ?></a></h3>
	 </div>   
	<form action="articlecategoryView.php" method="post">
	<table border="0" cellpadding="1" cellspacing="1" width="100%" style="border:#CCCCCC 1px solid;">
	  <tr>
	  	<td colspan="3" align="center">
<?php
try
{
	$ArticleCategory = new ArticleCategory();
	$result = $ArticleCategory -> gets();
	if($result->num_rows <1) {
		echo 'No record found!';
	} else {
		$sl = 0;
		echo '<table border="0" cellspacing="1" cellpadding="0" width="100%" class=listTab>
		<tr>
			<th width="10%" align="center" valign="top">'.SERIAL.'</th>
			<th width="25%" align="center" valign="top">'.NAME.'</th>
			<th width="10%" align="center" valign="top">'.SERIAL.'</th>
			<th width="10%" align="center" valign="top">'.POSITION.'</th>
			<th width="10%" align="center" valign="top">'.STATUS.'</th>
			<th width="20%" align="center" valign="top">'.ACTION.'</th>
		</tr>';
		$Uploader = new Uploader();
		$class_name=" odd";
		$posionList = Common::ArticlePosition();
		while($show = $result->fetch_array(MYSQL_ASSOC))
		{
			$sl ++;
			$class_name = ($class_name==" odd")?" even":" odd";
			echo '<tr class='.$class_name.'>
				<td width="5%" align="center" valign="top">'.Common::convertToBanglaNumber($sl).'</td>
				<td width="25%" align="left" valign="top">'.$show['name'].'</td>
				<td width="5%" align="center" valign="top">'.Common::convertToBanglaNumber($show['rank']).'</td>
				<td width="5%" align="center" valign="top">'.$posionList[$show['position']].'</td>
				<td width="10%" align="center" valign="top" id="status'.$show['id'].'">'.Common::processStatus('display', $show['status'], TABLE_PREFIX.'article_category', 'status', 'id', $show['id'], 'status'.$show['id']).'</td>
				<td width="20%" align="center" valign="top">
					<a href="articlecategoryEdit.php?cId='.$show['id'].'"  class="button1">'.EDIT.'</a>
					<a href="articlecategoryDelete.php?cId='.$show['id'].'"  class="button1">'.DELETE.'</a>
				</td>
			</tr>';
		}
		echo '</table>';
	}
}
catch(Exception $e)
{
	echo $e->getMessage();
}
?>		</td>
	  </tr>
	  <tr>	  </tr>
	</table>
	</form>	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
</body>
</html>