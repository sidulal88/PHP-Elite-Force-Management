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
	  <td align="center" class="msg">
	  <?php 
	  if($_GET['msg'])
	  {
			echo SUCCESS_MSG;  
	  } 
	  ?>
      </td>
	  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1><?php echo USER_MANAGEMENT; ?></h1>
	 <h2><?php echo USER_LIST; ?></h2>
	<h3> <a href="user_add.php" class="link_button"><?php echo USER_ADD; ?></a></h3>
	 </div>   
	 <!---
    <?php
try
{
	$Admin = new Admin();
	$result = $Admin -> getUsers();
	if($result->num_rows <1) {
		echo 'No record found!';
	} else {
		$sl = 0;
		echo '<table border="0" cellspacing="1" cellpadding="0" width="100%" class=listTab>
		<thead>
		<tr>
			<th width="10%" align="center" valign="top">'.SERIAL.'</th>
			<th width="25%" align="center" valign="top">'.NAME.'</th>
			<th width="10%" align="center" valign="top">'.EMAIL.'</th>
			<th width="10%" align="center" valign="top">'.RECORD_TYPE.'</th>
			<th width="10%" align="center" valign="top">'.STATUS.'</th>
			<th width="20%" align="center" valign="top">'.ACTION.'</th>
		</tr>
		</thead>
		<tbody>
		';
		$Uploader = new Uploader();
		$class_name=" odd";
		while($show = $result->fetch_array(MYSQL_ASSOC))
		{
			$sl ++;
			$class_name = ($class_name==" odd")?" even":" odd";
			echo '<tr class='.$class_name.'>
				<td width="10%" align="center" valign="top">'.Common::convertToBanglaNumber($sl).'</td>
				<td width="25%" align="center" valign="top">'.$show['name'].'</td>
				<td width="10%" align="center" valign="top">'.$show['email'].'</td>
				<td width="10%" align="center" valign="top">'.Common::userType($show['type']).'</td>
				<td width="10%" align="center" valign="top" id="status'.$show['id'].'">'.Common::processStatus('display', $show['status'], TABLE_PREFIX.'admin', 'status', 'id', $show['id'], 'status'.$show['id']).'</td>
				<td width="20%" align="center" valign="top">
					<a href="userEdit.php?uId='.$show['id'].'" class="button1">'.EDIT.'</a>
					<a href="saveAccess.php?uId='.$show['id'].'" class="button1">'.ACCESS_PERMISSION.'</a>
					'; 
					if($show['type']!='admin'):
					?>
					<a href="userDelete.php?uId=<?php echo $show['id']; ?>" class="button1"><?php echo DELETE; ?></a>
					<?php 
					endif;
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
</table>--->
<table id="dg"></table>
	
    </td>
  </tr>
</table>
<script type="text/javascript">
	


$(document).ready(function() {
grid_view();

});

function grid_view() {

    $('#dg').datagrid({
        title: 'User List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'id',
        url: 'ajax_admin_grid.php?gname=user_list',
        columns: [[
                {field: 'name', title: 'Name'},
                {field: 'email', title: 'Email'},
				{field: 'type', title: 'User Type'}
            ]]

    });
}
    </script>
</body>
</html>