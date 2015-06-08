<?php require_once('settings.php');
try
 {
	$District = new District();
	$resultDistrict = $District->gets();
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
 <link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
<script src="js/sidebar.feedback.js"></script>
	<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="js/datagrid-detailview.js"></script>
</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
				<div class ="welcome_head">List of BCS Police Officer</div>
           	  <div class="pageBody">
			  
<div id="tb" style="padding:10px">
<table width="90%" cellspacing="3">
	<tr>
		<td width="27%"><input id="search_key" style="line-height:26px;border:1px solid #ccc" size="38" placeholder="Search By Name/ Batch No/ ID No"></td>		
		<td width="14%"> <div align="center">OR </div></td>
		<td width="59%"><select name="distrcit_name" id="distrcit_name">
		<option value="">Select Home District</option>
		<?php
			while($show = $resultDistrict -> fetch_array(MYSQL_ASSOC))
			{

		?>
		<option value="<?php echo $show['district_id']; ?>"><?php echo $show['distrcit_name']; ?></option>
		<?php } ?>
	</select></td>
	</tr>
	<tr>
		<td colspan="3"><input type="button" name="submit" value="Search" class="button" onclick="doSearch()"></td>
	</tr>
</table>
   
</div>


<table id="dg"></table>
			  </div>
		<div class="last_updated">last updated On : 
		
		<?php
			try
			 {
				
				$last_updated_on = Common::last_update_on("ipb_bcs_officers");
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
	  <script type="text/javascript">
	

        function doSearch(){
    $('#dg').datagrid('load',{
        search_key: $('#search_key').val(),
		distrcit_name: $('#distrcit_name').val()
    });
}

$(document).ready(function() {
bcs_officer_list();

});
	
	function cellStyler(value,row,index){
            if (index % 2 != 0){
                return 'background-color:#D8E4F7';
            }
        }
	
function bcs_officer_list() {

    $('#dg').datagrid({
        title: 'BCS Police Officers',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [10, 20,30,50,100],
        pagePosition: 'bottom',
        idField: 'bcs_officer_id',
        url: 'ajax_grid_data.php?gname=bcs_officers_list',
        columns: [[
                {field: 'photo', title: 'Photo',width:57, styler:cellStyler},
                {field: 'name', title: 'Name & ID No.',width:180, styler:cellStyler},
				{field: 'batch_no', title: 'BCS Batch No.',width:90, styler:cellStyler},
				{field: 'distrcit_name', title: 'Home District',width:110, styler:cellStyler},
				{field: 'rank_name', title: 'Current Rank',width:222, styler:cellStyler}
            ]]

    });
}


$('#dg').datagrid({
    view: detailview,
    detailFormatter:function(index,row){
        return '<div class="ddv" style="padding:5px 0"></div>';
    },
    onExpandRow: function(index,row){
        var ddv = $(this).datagrid('getRowDetail',index).find('div.ddv');
        ddv.panel({
            border:false,
            cache:false,
            href:'bcs_officers_details.php?bcs_officer_id='+row.bcs_officer_id,
            onLoad:function(){
                $('#dg').datagrid('fixDetailRowHeight',index);
            }
        });
        $('#dg').datagrid('fixDetailRowHeight',index);
    }
});

		
    </script>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>



</body>
</html>
