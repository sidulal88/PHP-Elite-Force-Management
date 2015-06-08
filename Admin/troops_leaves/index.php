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
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="addRecord()">Add</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onClick="detailsRecord()">Details</a>
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
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'troops_id',
        url: '../ajax_directory_grid.php?gname=leave_summery_list',
        columns: [[
				 {field: 'name', title: 'Troops Name', styler:cellStyler},
                {field: 'total_earn', title: 'Earn', styler:cellStyler},
                {field: 'total_casual', title: 'Casual', styler:cellStyler},
				{field: 'total_leave', title: 'Total', styler:cellStyler}
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
		

	function detailsRecord() {
		var row = $('#dg').datagrid('getSelected');
		location.replace('details.php?troops_id=' + row.troops_id);
	}
		

       
    </script>
</body>
</html>