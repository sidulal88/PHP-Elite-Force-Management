<?php require_once('settings.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>
        <link rel="stylesheet" type="text/css" href="Admin/public/themes/default/easyui.css"/>
        <link rel="stylesheet" type="text/css" href="Admin/public/themes/icon.css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
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
				<div class ="welcome_head">List of Tender</div>
           	  <div class="pageBody">

<div id="tb" style="padding:5px">
<table width="100%" cellspacing="3">
	<tr>
		<td width="32%"><p>Date: <input type="text" id="search_date" class="easyui-datebox" ></p></td>
		<td width="22%"><input id="search_key" style="line-height:26px;border:1px solid #ccc; padding-left:3px" size="32" placeholder="Input Your Search Key"></td>
		
		<td width="51%"><input type="button" name="submit" value="Search" class="button" onclick="doSearch()"></td>
		
	</tr>
</table>
   
</div>
<table id="dg"></table>

			  </div>
		 <div class="last_updated">last updated On : 
		
		<?php
			try
			 {
				
				$last_updated_on = Common::last_update_on("ipb_tenders");
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
        search_date: $('#search_date').datebox('getValue'),
		search_key: $("#search_key").val()
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
        title: 'Tender List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,40,50,100],
        pagePosition: 'bottom',
        idField: 'tender_id',
		 url: 'ajax_grid_data.php?gname=tender_list',
        columns: [[
                {field: 'title', title: 'Tender Title',width:180, styler:cellStyler},
				{field: 'tender_no', title: 'No',width:50, styler:cellStyler},
				{field: 'date', title: 'Date',width:90, styler:cellStyler},
                {field: 'unit_name', title: 'Unit Name',width:200, styler:cellStyler},
				{field: 'tender_schedule', title: 'Download Schedule',width:160, styler:cellStyler}
            ]]

    });
}
    </script>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>



</body>
</html>
