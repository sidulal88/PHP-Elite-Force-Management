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
    </div>

</div>
		  
<fieldset style="padding:5px; margin:10px;">
<legend>Search BCS Police Officer</legend>
<table width="90%" cellspacing="3">
	<tr>
		<td width="33%">
		<input id="search_key" style="line-height:26px;border:1px solid #ccc" size="38" placeholder="Search By Name/ Batch No/ ID No"></td>
		
		<td width="8%"><div align="center">OR</div></td>
		<td width="59%"><select name="distrcit_name" id="distrcit_name">
		<option value="">Select Home District</option>
		<?php
			try
			 {
				$District = new District();
				$resultDistrict = $District->gets();
			 }
			catch(Exception $e)
			 {
				echo $e->getMessage();
			 }
			while($show = $resultDistrict -> fetch_array(MYSQL_ASSOC))
			{

		?>
		<option value="<?php echo $show['district_id']; ?>"><?php echo $show['distrcit_name']; ?></option>
		<?php } ?>
	</select></td>
	</tr>
	<tr>
		<td colspan="3"><input type="button" name="submit" value="Search" class="button" onClick="doSearch()"></td>
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
		distrcit_name: $('#distrcit_name').val()
    });
}


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
        title: 'BCS Police Officer List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'bcs_officer_id',
        url: '../ajax_directory_grid.php?gname=bcs_officer_list',
        columns: [[
				 {field: 'photo', title: 'Photo', styler:cellStyler},
                {field: 'name', title: 'Name', styler:cellStyler},
				{field: 'police_id_no', title: 'ID No. ', styler:cellStyler},
				{field: 'merit_no', title: 'Merit', styler:cellStyler},
				{field: 'batch_no', title: 'Batch No.', styler:cellStyler},
				{field: 'distrcit_name', title: 'District ', styler:cellStyler},
				{field: 'contact_no', title: 'Contact', styler:cellStyler},
				{field: 'rank_name', title: 'Cur.Rank.', styler:cellStyler},
				{field: 'posting_place', title: 'Posting Place', styler:cellStyler},
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
                        $.post('ajax_record_process.php',{primery_key:row.bcs_officer_id},function(result){
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
    location.replace('record_edit.php?bcs_officer_id=' + row.bcs_officer_id);
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