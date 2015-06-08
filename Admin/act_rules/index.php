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
    <h1>Directory Entry</h1>
	 </div>   
	 

<div id="toolbar" style="padding:5px;height:auto"> 
 
    <div id="toolbar">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="addRecord()">Add</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editRecord()">Edit</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyRecord()">Remove</a>
    </div>

</div>
<fieldset>
<legend>Search </legend>

<table width="90%" cellspacing="3">
	<tr>
		<td width="27%"><input name="Input" id="search_key" style="line-height:26px;border:1px solid #ccc" size="32" placeholder="Search Key"></td>
		
		<td width="73%"><input type="button" name="submit" value="Search" class="button" onClick="doSearch()" /></td>
	</tr>
</table>
  </fieldset><br /> 
<table id="dg"></table>
	
    </td>
  </tr>
</table>
<!-----Save Page Start From Here------->
<?php include('dialog_box.php'); ?>
 <div id="edit_box" style="width:520px;height:550px;padding:10px 20px"></div>
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

function doSearch(){
    $('#dg').datagrid('load',{
        search_key: $("#search_key").val()
    });
}

function grid_view() {

    $('#dg').datagrid({
        title: 'ACT & Rules',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'rule_id',
        url: '../ajax_directory_grid.php?gname=act_rules',
        columns: [[
                {field: 'rules_info', title: 'Name', styler:cellStyler},
				{field: 'rules_no', title: 'Act. No. ', styler:cellStyler},
				{field: 'sort_no', title: 'Sort No. ', styler:cellStyler},
				{field: 'status', title: 'Status', styler:cellStyler}
            ]]

    });
}

var url;
function addRecord() {
    $('#dlg').dialog('open').dialog('setTitle', 'Add New Record');
    $('#fm').form('clear');
    url = 'ajax_record_process.php?mode=save';
}

function saveRecord(){
            $('#fm').form('submit',{
                url: url,
                success: function(respons){
					$('#dlg').dialog('close');   // close the dialog
					$.messager.alert('Success', 'Record Saved Successfully!');     
                    $('#dg').datagrid('reload');    // reload the user data
					
                }
            });
        }
	
	
        function destroyRecord(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to destroy this Record?',function(r){
                    if (r){
					$.ajax({
							url:'ajax_record_process.php',
							type:'get',
							data:{primery_key:row.rule_id, mode:'delete'},
							success: function(respons){
								$.messager.alert('Success', 'Record Deleted Successfully!');
								$('#dg').datagrid('reload');
							}
						});
                    }
                });
            }
        }
		
		

function editRecord() {
	var row = $('#dg').datagrid('getSelected');
    location.replace('record_edit.php?rule_id=' + row.rule_id);
}


	function openModel()
	{
		var row = $('#dg').datagrid('getSelected');
		var mytitle = "Share this project via email";
		var url = 'ajax_record_process.php?mode=edit';
		$("#edit_box").load("dialog_box2.php?primery_key="+ row.bcs_officer_id).dialog({
			
					title: mytitle,
					modal: true,
					width: 450
				
			});//END DIALOG
		}
		
		
    </script>
</body>
</html>