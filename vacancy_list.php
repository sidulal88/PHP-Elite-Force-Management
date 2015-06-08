<?php require_once('settings.php');?>
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
</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
				<div class ="welcome_head">List of Vacancy</div>
           	  <div class="pageBody">

<div id="tb" style="padding:5px">
<table width="100%" cellspacing="3">
	<tr>
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
				
				$last_updated_on = Common::last_update_on("ipb_vacancy_list");
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
        title: 'Vacancy List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,40,50,100],
        pagePosition: 'bottom',
        idField: 'vacancy_id',
        url: 'ajax_grid_data.php?gname=vacancy_list',
        columns: [[
                {field: 'title', title: 'Title',width:460, styler:cellStyler},
				{field: 'date', title: 'Date',width:120, styler:cellStyler},
				{field: 'web_link', title: 'Link',width:100, styler:cellStyler}
            ]]

    });
}
    </script>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>



</body>
</html>
