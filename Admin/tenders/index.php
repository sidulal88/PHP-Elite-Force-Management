<?php  require_once('../../settings.php');
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
				<td width="21%"> <select name="unit_id" id="unit_id">
			<option value="">Select Unit</option>
			<?php

			$Unit = new Unit();
		
			$menuTree = $Unit -> getsGrid(" AND is_industry=1 ");
	
			foreach($menuTree as $show):
		?>
	
				  <option value="<?php echo $show['unit_id']; ?>"><?php echo $show['unit_name']; ?></option>
	
	<?php endforeach; ?>
	    </select> </td>
		<td width="25%"><p>Tender: <input type="text" id="search_date" class="easyui-datebox" ></p></td>
		<td width="25%"><p>Schedule Date: <input type="text" id="schedule_date" class="easyui-datebox" ></p></td>
		  <td width="23%"><input name="Input" id="search_key" style="line-height:26px;border:1px solid #ccc" size="32" placeholder="Search Key"></td>
		
		<td width="31%"><input type="button" name="submit" value="Search" class="button" onClick="doSearch()" /></td>
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
        search_date: $('#search_date').datebox('getValue'),
        schedule_date: $('#schedule_date').datebox('getValue'),
		unit_id : $('#unit_id').val(),
		search_key: $("#search_key").val()
    });
}

function grid_view() {

    $('#dg').datagrid({
        title: 'Tender List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'tender_id',
        url: '../ajax_directory_grid.php?gname=tender_list',
        columns: [[
                {field: 'title', title: 'Title', styler:cellStyler},
				{field: 'tender_no', title: 'Tender No. ', styler:cellStyler},
				{field: 'date', title: 'Tender Date ', styler:cellStyler},
				{field: 'unit_name', title: 'Unit', styler:cellStyler},
				{field: 'tender_schedule', title: 'Schedule', styler:cellStyler},
				{field: 'schedule_date', title: 'Schedule Date', styler:cellStyler},
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
                url: 'ajax_record_process.php?mode=save',
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
                        $.post('ajax_record_process.php',{primery_key:row.tender_id},function(result){
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
    location.replace('record_edit.php?tender_id=' + row.tender_id);
}
  
    </script>
</body>
</html>