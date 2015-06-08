<?php  require_once('../../settings.php'); 
try
 {
	$Unit = new Unit();
	$resultUnit = $Unit->gets(" AND data_level=1 ");
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }
 
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
<fieldset><legend>Search</legend>
			  
<div id="tb" style="padding:10px">
<table width="90%" cellspacing="3">
	<tr>
		<td width="37%"><select name="unit_id" id="unit_id">
			<option value=""><?php echo SELECT; ?></option>
				<?php

			$Unit = new Unit();
		
			$menuTree = $Unit -> getsGrid();
	
			foreach($menuTree as $show):
		
			$spacer = ($show['data_level'] > 1) ? str_repeat(" --> ", $show['data_level']-1) : '';
		?>
	
				  <option value="<?php echo $show['unit_id']; ?>"><?php echo $spacer.$show['unit_name']; ?></option>
	
	<?php endforeach; ?>
	    </select></td>
		<td width="12%"><input name="Input" id="search_key" style="line-height:26px;border:1px solid #ccc" size="32" placeholder="Search Key"></td>
		
		<td width="3%">&nbsp;</td>
		<td width="48%"><input type="button" name="submit" value="Search" class="button" onClick="doSearch()" /></td>
	</tr>
</table>
   </fieldset><br />
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

});


function cellStyler(value,row,index){
     if (index % 2 != 0){
     	return 'background-color:#D8E4F7';
     }
}	

function doSearch(){
    $('#dg').datagrid('load',{
		unit_id: $('#unit_id').val(),
        search_key: $("#search_key").val()
    });
}


$("#unit").val($("#unit").find('option[selected]'));


function grid_view() {

    $('#dg').datagrid({
        title: 'Police Phone Book',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'book_id',
        url: '../ajax_directory_grid.php?gname=phone_book',
        columns: [[
				 {field: 'designation_name', title: 'Designaton', styler:cellStyler},
                {field: 'phone', title: 'Phone', styler:cellStyler},
				{field: 'mobile', title: 'Mobile', styler:cellStyler},
				{field: 'fax', title: 'Fax', styler:cellStyler},
				{field: 'email', title: 'Email', styler:cellStyler},
				{field: 'unit_name', title: 'Unit', styler:cellStyler},
				{field: '_sort', title: 'Sort', styler:cellStyler},
				{field: 'status', title: 'Status', styler:cellStyler}
            ]]

    });
}

var url;
function addRecord() {
    $('#dlg').dialog('open').dialog('setTitle', 'Add New Record');
    //$('#fm').form('clear');
	$('#fm').find('input[type=text], textarea').val('');
    url = 'ajax_record_process.php?mode=save';
}
function editRecord(){
            var row = $('#dg').datagrid('getSelected');
            if (row){
                $('#dlg').dialog('open').dialog('setTitle','Edit Record');  
                $('#fm').form('load',row);
                url = 'ajax_record_process.php?primery_key='+ row.book_id +'&mode=save';
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
                        $.post('ajax_record_process.php',{primery_key:row.book_id},function(result){
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