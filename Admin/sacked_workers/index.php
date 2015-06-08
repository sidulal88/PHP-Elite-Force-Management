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
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onClick="detailsRecord()">Details</a>
    </div>

</div>
<table id="dg" class="easyui-datagrid" style="width:100%;height:780px"
        url="../ajax_directory_grid.php?gname=sacked_workers" toolbar="#tb" pageList="[20, 30, 40]"
        title="List of Sacked Worker" sortName="sacked_worker_id" 
        rownumbers="true" pagination="true" data-options="fit:true,fitColumns:true">
		
    <thead>
	<tr>
			<th  field="photo_view" width="100" rowspan="2"  data-options="styler:cellStyler">Photo</th> 
			<th  field="worker_info" width="150" rowspan="2" data-options="styler:cellStyler" >Name & NID</th> 
			<th  field="per_address" width="190" rowspan="2" data-options="styler:cellStyler">Address</th> 
			<th  width="500" colspan="3" data-options="styler:cellStyler">Sacked Info</th>
			<th  field="status" width="80" rowspan="2" data-options="styler:cellStyler">Status</th>
        </tr>
        <tr>
		    <th field="sacked_from" width="180" align="right"  data-options="styler:cellStyler">Sacked From</th>
			<th field="sacked_date" width="100" align="right"  data-options="styler:cellStyler">Sacked Date</th>
			<th field="reson" width="200" align="right" class="hello"  data-options="styler:cellStyler">Sacked Reson</th>
        </tr>
    </thead>
</table>
	
    </td>
  </tr>
</table>
<!-----Save Page Start From Here------->
<?php include('dialog_box.php'); ?>
<!-----Save Page End From Here------->
<script type="text/javascript">
var url;
function addRecord() {
    $('#dlg').dialog('open').dialog('setTitle', 'Add New Record');
    $('#fm').form('clear');
    url = 'ajax_record_process.php?mode=save';
}



function cellStyler(value,row,index){
     if (index % 2 != 0){
     	return 'background-color:#D8E4F7';
     }
}

function editRecordpp(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Edit Record');  
                $('#fm').form('load',row);
                url = 'ajax_record_process.php?primery_key='+ row.sacked_worker_id +'&mode=save';
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
                        $.post('ajax_record_process.php',{primery_key:row.sacked_worker_id},function(result){
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
		
		

function editRecord() {
	var row = $('#dg').datagrid('getSelected');
    location.replace('record_edit.php?sacked_worker_id=' + row.sacked_worker_id);
}
			

function detailsRecord() {
	var row = $('#dg').datagrid('getSelected');
    location.replace('details.php?sacked_worker_id=' + row.sacked_worker_id);
}
		
		
	$(".text_area").jqte();
	
	// settings of status
	var jq_box_teStatus = true;
	$(".status").click(function()
	{
		jq_box_teStatus = jq_box_teStatus ? false : true;
		$('.text_area').jqte({"status" : jq_box_teStatus})
	});	
 
		
    </script>
</body>
</html>