<?php require_once('settings.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>
 <link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
	
	<script type="text/javascript" src="js/jquery-ui.js"></script>
</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
				<div class ="welcome_head">List of Administrative order</div>
           	  <div class="pageBody">

<div id="tb" style="padding:5px">
<table width="100%" cellspacing="3">
	<tr>
		<td width="32%"><p>Date: <input type="text" id="search_date" style="line-height:26px;border:1px solid #ccc" ></p></td>
		<td width="33%">
		
		
		<input id="search_key" style="line-height:26px;border:1px solid #ccc" size="32" placeholder="Please Input Your Search Key"></td>
		
		<td width="35%"><input type="button" name="submit" value="Search" class="button" onclick="doSearch()"></td>
	</tr>
</table>
   
</div>
<table id="dg"></table>

			  </div>
		<div class="last_updated">last updated On : 
		
		<?php
			try
			 {
				
				$last_updated_on = Common::last_update_on("ipb_administrative_orders");
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
        search_date: $("#search_date").val(),
		search_key: $("#search_key").val()
    });
}

$(function() {
	$( "#search_date" ).datepicker({
                showOn: "button",
                buttonImage: "images/calendar.gif",
                buttonImageOnly: true
            });
  });
  
  
$(document).ready(function() {


troops_list();

});


	function cellStyler(value,row,index){
            if (index % 2 != 0){
                return 'background-color:#D8E4F7';
            }
        }
			
	
function troops_list() {

    $('#dg').datagrid({
        title: 'Administrative order List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,40,50,100],
        pagePosition: 'bottom',
        idField: 'order_id',
		url: 'ajax_grid_data.php?gname=administrative_orders',
        columns: [[
                {field: 'title', title: 'Title ',width:380, styler:cellStyler},
				{field: 'order_no', title: 'Order no',width:170, styler:cellStyler},
                {field: 'date', title: 'Date',width:130, styler:cellStyler}
            ]]

    });
}
    </script>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>



</body>
</html>
