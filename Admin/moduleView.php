<?php  require_once('../settings.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>
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
	 <h2><?php echo PAGE_LIST; ?></h2>
	<h3> <a href="moduleAdd.php" class="link_button"><?php echo PAGE_ADD; ?></a></h3>
    	 </div>   
    <?php
try
{
	$Module = new Module();
	$menuTree = $Module -> getsGrid();
	if(count($menuTree) <1) {
		echo 'No record found!';
	} else {
		$sl = 0;
		echo '<table border="0" cellspacing="1" cellpadding="0" width="100%" class=listTab>
		<thead>
		<tr>
			<th width="10%" align="center" valign="top">'.SERIAL.'</th>
			<th width="25%" align="left" valign="top">'.NAME.'</th>
			<th width="25%" align="left" valign="top">'.POSITION.'</th>
			<th width="10%" align="center" valign="top">'.STATUS.'</th>
			<th width="20%" align="center" valign="top">'.ACTION.'</th>
		</tr>
		</thead>
		<tbody>
		';
		$Uploader = new Uploader();
		$class_name=" odd";
		$spacer = 0;
		$posionList = Common::BanPosition();
		foreach($menuTree as $show)
		{
			$sl ++;
			$spacer = ($show['sort_level'] > 1) ? str_repeat(" --> ", $show['sort_level']-1) : '';
			$class_name = ($class_name==" odd")?" even":" odd";
			echo '<tr class='.$class_name.'>
				<td width="10%" align="center" valign="top">'.Common::convertToBanglaNumber($sl).'</td>
				<td width="25%" align="left" valign="top">'.$spacer.$show['name'].'</td>
				<td width="25%" align="left" valign="top">'.$posionList[$show['position']].'</td>
				<td width="10%" align="center" valign="top" id="status'.$show['module_id'].'">'.Common::processStatus('display', $show['status'], TABLE_PREFIX.'module_info', 'status', 'module_id', $show['module_id'], 'status'.$show['module_id']).'</td>
				<td width="20%" align="center" valign="top">
					<a href="moduleEdit.php?mId='.$show['module_id'].'" class="button1">'.EDIT.'</a>
					<a href="moduleDelete.php?mId='.$show['module_id'].'" class="button1">'.DELETE.'</a>
					'; 
					echo '
				</td>
			</tr>';
		}
		echo '</tbody></table>';
	}
}
catch(Exception $e)
{
	echo $e->getMessage();
}
?>	
	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
</body>
</html>