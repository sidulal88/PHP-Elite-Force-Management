<?php require_once('settings.php');
$troops_id = $_REQUEST['troops_id'];
$condition = " AND ipb_troops_leaves.troops_id=$troops_id";

$leave_type = $_REQUEST['leave_type'];
$condition .= ($leave_type) ? " AND ipb_troops_leaves.leave_type='$leave_type'": '';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>
        <link rel="stylesheet" type="text/css" href="Admin/public/themes/default/easyui.css"/>
        <link rel="stylesheet" type="text/css" href="Admin/public/themes/icon.css"/>
		 <script type="text/javascript" src="Admin/public/js/jquery-1.7.2.js"></script>		
        <script type="text/javascript" src="Admin/public/js/jquery.easyui.min.js"></script>
</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
			<div class="blogContent">
           
			<div class="content">
				<div class ="welcome_head"><a href="troops_profile.php?troops_id=<?php echo $troops_id; ?>">Profile</a> >> Leave Details</div>
                	<div class="pageBody">
<div id="toolbar" style="padding:5px;height:auto"> 
 
    <div id="toolbar">
        <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onClick="addRecord()">Add</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onClick="editRecord()">Edit</a>
        <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onClick="destroyRecord()">Remove</a>
	</div>

</div>
<table id="dg"></table>

			</div>
				<div class="last_updated">last updated On : 
		
		<?php
			try
			 {
				
				$last_updated_on = Common::last_update_on("ipb_troops_leaves");
				echo date("d M, Y  -  H:i:s", strtotime($last_updated_on));
			 }
			catch(Exception $e)
			 {
				echo $e->getMessage();
			 }
		?></div>
			</div>
            </div>
            
      </div>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
	

</body>
</html>
	  <script type="text/javascript">
	

function doSearch(){
    $('#dg').datagrid('load',{
        search_key: $("#search_key").val(),
		search_type: $("#search_type").val()
    });
}


$(document).ready(function() {
	leave_list();

});


	function cellStyler(value,row,index){
            if (index % 2 != 0){
                return 'background-color:#D8E4F7';
            }
        }
			
	
function leave_list() {

    $('#dg').datagrid({
        title: 'Leave List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
		showFooter: true,
        singleSelect: true,
		pageList: [20,30,40,50,100],
        pagePosition: 'bottom',
        idField: 'leave_id',
		url: 'ajax_grid_data.php?gname=leave_list&troops_id=<?php echo $troops_id; ?>&leave_type=<?php echo $leave_type; ?>',
        columns: [[
                    {field: 'leave_type', title: 'Leave Type', align: 'left', width: 150},
                    {field: 'start_date_dis', title: 'From', align: 'left', width: 100},
                    {field: 'end_date_dis', title: 'To', align: 'left', width: 100},
                    {field: 'total_leave', title: 'Total', align: 'left', width: 100}
            ]],
			onLoadSuccess: function(data){
				var rows = data.rows;
				var sub_total_leave = 0;
				for(var i=0; i<rows.length; i++){
					var row = rows[i];
					sub_total_leave += parseFloat(rows[i].total_leave);
				}
				$('#dg').datagrid('reloadFooter', [{leave_type:'Total <?php echo $leave_type; ?> Leave',total_leave:sub_total_leave}]);
				
			}

    });
	
}


function addRecord() {
    $('#dlg').dialog('open').dialog('setTitle', 'Add New Record');
    $('#fm').form('clear');
    url = 'ajax_record_process.php?mode=save&troops_id=<?php echo $troops_id; ?>&leave_type=<?php echo $leave_type; ?>';
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
<?php include('dialog_box.php'); ?>
