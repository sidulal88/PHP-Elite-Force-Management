<?php  require_once('../../settings.php');
$troops_id = $_REQUEST['troops_id']; 
?>
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
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="addRecord()">Add</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editRecord()">Edit</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyRecord()">Remove</a>
        <a href="index.php" class="easyui-linkbutton" iconCls="icon-ok" plain="true" >Back</a>
		
    </div>

</div>

<table id="dg"></table>
	
    </td>
  </tr>
</table>
<!-----Save Page Start From Here------->
<?php include('dialog_box.php'); ?>
<!-----Save Page End From Here------->
<script type="text/javascript">
	


$(document).ready(function() {
grid_view();


        $('#troops_id').combogrid({
            panelWidth: 630,
            url: 'get_data.php',
            idField: 'troops_id',
            textField: 'name',
            mode: 'remote',
            fitColumns: true,
            columns: [[
                    {field: 'name', title: 'Troops Name', align: 'left', width: 150},
                    {field: 'rank_name', title: 'Rank', align: 'left', width: 80},
                    {field: 'police_id', title: 'Police ID', align: 'left', width: 120},
                    {field: 'brash_no', title: 'Brash No', align: 'left', width: 90},
                    {field: 'unit_name', title: 'Unit', align: 'left', width: 180}
                ]]
        });



});


function cellStyler(value,row,index){
     if (index % 2 != 0){
     	return 'background-color:#D8E4F7';
     }
}

function grid_view() {

    $('#dg').datagrid({
        title: "Troops Leaves",
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
		showFooter:"true",
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'leave_id',
        url: '../ajax_directory_grid.php?gname=leave_list&troops_id=<?php echo $troops_id; ?>',
        columns: [[
				 {field: 'troops_id', title: 'Troops Name', styler:cellStyler},
                {field: 'leave_type', title: 'Leave Type', styler:cellStyler},
				{field: 'start_date_dis', title: 'From', styler:cellStyler},
				{field: 'end_date_dis', title: 'To', styler:cellStyler},
				{field: 'total_leave', title: 'Total', styler:cellStyler},
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
function editRecord(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Edit Record');  
                $('#fm').form('load',row);
                url = 'ajax_record_process.php?primery_key='+ row.leave_id +'&mode=save';
            }
}

      
   function saveRecord(){
            $('#fm').form('submit',{
                url: url,
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success: function(result){
                    var result = eval('('+result+')');
                    if (result.errorMsg){
                        $.messager.show({
                            title: 'Error',
                            msg: result.errorMsg
                        });
                    } else {
                        $('#dlg').dialog('close');  
						$.messager.alert('Success', 'Record Saved Successfully!');           // close the dialog
                        $('#dg').datagrid('reload');    // reload the user data
                    }
                }
            });
        }
		
				
		function destroyRecord(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $.messager.confirm('Confirm','Are you sure you want to destroy this Record?',function(r){
                    if (r){
                        $.post('ajax_record_process.php',{primery_key:row.leave_id},function(result){
                            if (result.success){
								$.messager.alert('Success', 'Record Deleted Successfully!');
                                $('#dg').datagrid('reload');    // reload the user data
                            } else {
                                $.messager.show({    // show error message
                                    title: 'Error',
                                    msg: result.errorMsg
                                });
                            }
                        },'json');
                    }
                });
            }
        }
		
       
    </script>
</body>
</html>