<?php  require_once('../../settings.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>
</head>

<body>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> <?php include(ROOT_DIR.'Admin/adminHead.php');?></td>
  </tr>

  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1>Master Entry</h1>
	 </div>   
	 

<div id="toolbar" style="padding:5px;height:auto"> 
 
    <div id="toolbar">
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editRecord()">Edit</a>
    </div>

</div>
		  
  <table id="dg"></table>
	
    </td>
  </tr>
</table>
<!-----Save Page Start From Here------->
<?php //include('dialog_box.php'); ?>
<!-----Save Page End From Here------->
<script type="text/javascript">
	


$(document).ready(function() {
grid_view();

});

function cellStyler(value,row,index){
     if (index % 2 != 0){
     	return 'background-color:#D8E4F7';
     }
}

function grid_view() {

    $('#dg').datagrid({
        title: 'Page List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'control_id',
        url: '../ajax_common_grid.php?gname=control_page_list',
        columns: [[
				 {field: 'name', title: 'Name', styler:cellStyler},
				{field: 'status', title: 'Status', styler:cellStyler}
            ]]

    });
}


function editRecord() {
	var row = $('#dg').datagrid('getSelected');
    location.replace('record_edit.php?control_id=' + row.control_id);
}

    </script>
</body>
</html>