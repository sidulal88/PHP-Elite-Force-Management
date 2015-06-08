<?php  require_once('../settings.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>
</head>

<body>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> <?php include('adminHead.php');?></td>
  </tr>

  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1>Master Entry</h1>
	 </div>   
	 

<div id="toolbar" style="padding:5px;height:auto"> 
 
    <div id="toolbar">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="AddNew()">Add</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editUser()">Edit</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyUser()">Remove</a>
    </div>

</div>

<table id="dg"></table>
	
    </td>
  </tr>
</table>
<!-----Save Page Start From Here------->
<?php include('unit_dialog_box.php'); ?>
<!-----Save Page End From Here------->
<script type="text/javascript">
	


$(document).ready(function() {
grid_view();

});

function grid_view() {

    $('#dg').datagrid({
        title: 'Unit List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'unit_id',
        url: 'ajax_admin_grid.php?gname=unit_list',
        columns: [[
				 {field: 'unit_name', title: 'Unit Name'},
                {field: 'data_level', title: 'Unit Level'},
				{field: 'is_industry_status', title: 'Is Relavant with Industry ? '},
				{field: 'sub_under_name', title: 'Sub Unit Of'},
				{field: 'location', title: 'Unit Location'},
				{field: 'address', title: 'Address'},
				{field: 'status', title: 'Status'}
            ]]

    });
}

var url;
function AddNew() {
    $('#dlg').dialog('open').dialog('setTitle', 'Add New');
    $('#fm').form('clear');
    url = 'ajax_unit_process.php?mode=save';
}
function editUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Edit User');  
                $('#fm').form('load',row);
                url = 'ajax_unit_process.php?unit_id='+ row.unit_id +'&mode=save';
            }
}

function saveUser(){
            $('#fm').form('submit',{
                url: url,
                success: function(respons){
					$('#dlg').dialog('close');   // close the dialog
					$.messager.alert('Success', 'Record Saved Successfully!');     
                    $('#dg').datagrid('reload');    // reload the user data
					
                }
            });
        }
	
	
        function destroyUser(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to destroy this data?',function(r){
                    if (r){
					$.ajax({
							url:'ajax_unit_process.php',
							type:'get',
							data:{unit_id:row.unit_id, mode:'delete'},
							success: function(respons){
								$.messager.alert('Success', 'Record Deleted Successfully!');
								$('#dg').datagrid('reload');
							}
						});
                    }
                });
            }
        }
	
       
    </script>
</body>
</html>