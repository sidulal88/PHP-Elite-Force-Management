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
<fieldset>
<legend>Search </legend>

<table width="90%" cellspacing="3">
	<tr>
				<td width="27%"><input name="Input" id="search_key" style="line-height:26px;border:1px solid #ccc" size="32" placeholder="Search Key"></td>
		
		<td width="73%"><input type="button" name="submit" value="Search" class="button" onClick="doSearch()" /></td>
	</tr>
</table>
  </fieldset><br /> 
<div id="toolbar" style="padding:5px;height:auto"> 
 
    <div id="toolbar">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="addRecord()">Add</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editRecord()">Edit</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyRecord()">Remove</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onClick="detailsRecord()">Details</a>
    </div>

</div>


<table id="dg" class="easyui-datagrid" style="width:100%;height:650px"
        url="../ajax_directory_grid.php?gname=industry_list" toolbar="#tb" pageList="[20, 30, 40]"
        title="List of Industry" sortName="industry_id" 
        rownumbers="true" pagination="true" data-options="fit:true,fitColumns:true">
		
    <thead>
	<tr><th  field="industry_name" width="150" rowspan="2"  data-options="styler:cellStyler">Industry Name</th> 
			<th  field="address" width="150" rowspan="2" data-options="styler:cellStyler">Address</th> 
			<th  field="owner" width="100" rowspan="2" data-options="styler:cellStyler">Owner</th> 
			<th  field="contact_no" width="100" rowspan="2" data-options="styler:cellStyler">Contact No.</th> 
			<th  width="120" colspan="3" data-options="styler:cellStyler">Worker</th>
			<th  width="120"field="product_name"  rowspan="2"  data-options="styler:cellStyler">Product</th>
        </tr>
        <tr>
		    <th field="worker_male" width="40" align="right"  data-options="styler:cellStyler">Male</th>
			<th field="worker_female" width="40" align="right"  data-options="styler:cellStyler">Female</th>
			<th field="total_worker" width="40" align="right" class="hello"  data-options="styler:cellStyler">Total</th>
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


function doSearch(){
    $('#dg').datagrid('load',{
		search_key: $("#search_key").val()
    });
}
  

function editRecordpp(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Edit Record');  
                $('#fm').form('load',row);
                url = 'ajax_record_process.php?primery_key='+ row.industry_id +'&mode=save';
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
                        $.post('ajax_record_process.php',{primery_key:row.industry_id},function(result){
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
    location.replace('record_edit.php?industry_id=' + row.industry_id);
}
			

function detailsRecord() {
	var row = $('#dg').datagrid('getSelected');
    location.replace('details.php?industry_id=' + row.industry_id);
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