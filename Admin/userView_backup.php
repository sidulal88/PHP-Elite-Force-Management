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
	<h3> <a href="userADD.php" class="link_button"><?php echo USER_ADD; ?></a></h3>
	 </div>   
   <table id="dg"></table>
	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
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