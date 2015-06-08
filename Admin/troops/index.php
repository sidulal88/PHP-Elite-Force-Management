<?php  require_once('../../settings.php');?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>
 <link href="../form_msg.css" rel="stylesheet" type="text/css"></head>

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
	  
<fieldset style="padding:5px; margin:10px;">
<legend>Search Troops</legend>
<table width="100%" cellspacing="3"  class="details_tab dataAdd">
	<tr>
		<td width="38%"><input id="search_key" style="line-height:26px;border:1px solid #ccc" size="32" placeholder="Search Key"></td>
		
		<td width="62%">
		<select name="present_rank" id="present_rank">
                      <option value="">Select Rank</option>
                      <?php

			$Ranks = new Ranks();
			$result = $Ranks -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
                      <option value="<?php echo $show['rank_id']; ?>"><?php echo $show['rank_name']; ?></option>
                      <?php } ?>
          </select></td>
	</tr>
	<tr>
	  <td><select name="police_unit" id="police_unit">
                      <option value="">Select Unit</option>
                      <?php
			
						$Unit = new Unit();
					
						$menuTree = $Unit -> getsGrid();
				
						foreach($menuTree as $show):
					
						$spacer = ($show['data_level'] > 1) ? str_repeat(" --> ", $show['data_level']-1) : '';
					?>
                      <option value="<?php echo $show['unit_id']; ?>"><?php echo $spacer.$show['unit_name']; ?></option>
                      <?php endforeach; ?>
                    </select></td>
	  <td><select name="religion_id" id="religion_id">
        <option value="">Select Religion</option>
        <?php

			$Religion = new Religion();
			$result = $Religion -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
        <option value="<?php echo $show['religion_id']; ?>"><?php echo $show['religion_name']; ?></option>
        <?php } ?>
      </select></td>
	  </tr>
<tr>
	  <td><select name="search_type" id="search_type">
        <option value="">All</option>
        <option value="Increment">Only Increment</option>
        <option value="Retirement">Only Retirement</option>
      </select></td>
	  <td><input type="button" name="submit" value="  Search " class="button" onClick="doSearch()" style="padding:5px 10px 5px 10px "></td>
</tr>

	
</table>
   </fieldset>
<table id="dg"></table>
	
    </td>
  </tr>
</table>
<!-----Save Page Start From Here------->
<?php include('dialog_box.php'); ?>
<!-----Save Page End From Here------->
<script type="text/javascript">
	

function doSearch(){
    $('#dg').datagrid('load',{
        search_key: $('#search_key').val(),
        present_rank: $('#present_rank').val(),
		police_unit: $('#police_unit').val(),
		religion_id: $('#religion_id').val(),
		search_type: $('#search_type').val()
    });
}



$(document).ready(function() {
grid_view();

$('#dob').datebox({
	onSelect: function(date){
		var dor = (date.getMonth()+1)+"/"+(date.getDate()-1)+"/"+(date.getFullYear()+59); 
		$('#dor').datebox('setValue', dor);
	}
});

});

function cellStyler(value,row,index){
     if (index % 2 != 0){
     	return 'background-color:#D8E4F7';
     }
}

function grid_view() {

    $('#dg').datagrid({
        title: 'Troops Profile List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'troops_id',
        url: '../ajax_directory_grid.php?gname=troops_list',
        columns: [[
				 {field: 'photo', title: 'Photo', styler:cellStyler},
				 {field: 'name', title: 'Name', styler:cellStyler},
				 {field: 'police_id', title: 'Police ID', styler:cellStyler},
				 {field: 'rank_name', title: 'Rank', styler:cellStyler},
				 {field: 'brash_no', title: 'Brash no', styler:cellStyler},
				{field: 'unit_name', title: 'Unit Name ', styler:cellStyler},
				{field: 'contact_no', title: 'Mobile ', styler:cellStyler},
				{field: 'status_name', title: 'Duty Status', styler:cellStyler},
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
                        $.post('ajax_record_process.php',{primery_key:row.troops_id},function(result){
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
    location.replace('record_edit.php?troops_id=' + row.troops_id);
}


function detailsRecord() {
	var row = $('#dg').datagrid('getSelected');
    location.replace('details.php?troops_id=' + row.troops_id);
}
		
		
    </script>
</body>
</html>
	<script>
	$(".text_area").jqte();
	
	// settings of status
	var jq_box_teStatus = true;
	$(".status").click(function()
	{
		jq_box_teStatus = jq_box_teStatus ? false : true;
		$('.text_area').jqte({"status" : jq_box_teStatus})
	});
	
	
</script>