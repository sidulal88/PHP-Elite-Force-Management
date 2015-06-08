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
				<div class ="welcome_head">GOVT. ACTS & RULES</div>
           	  <div class="pageBody">

<div id="tb" style="padding:5px">
<table width="100%" cellspacing="3">
	<tr>
		<td width="22%"><input id="search_key" style="line-height:26px;border:1px solid #ccc; padding-left:3px" size="32" placeholder="Input Your Search Key"></td>
		
		<td width="51%"><input type="button" name="submit" value="Search" class="button" onclick="doSearch()"></td>
		
	</tr>
</table>
   
</div>

<hr style="margin-bottom:10xp; margin-top:5px;" />
<div style="margin-top:10px; padding:5px; font-size:12px; font-weight:bold; letter-spacing:2px; ">
<?php
for ($i = 'a'; $i<'z'; $i++) {
?>
  <a href="#" onclick="alphaSearch('<?php echo $i; ?>')" style=" text-decoration:none"><?php echo Ucfirst($i); ?></a> | 
   <?php } ?>
<a href="#" onclick="alphaSearch('z')"  style=" text-decoration:none">Z</a>
<hr style="margin-bottom:10xp; margin-top:10px;" />

</div>
<table id="dg"></table>

			  </div>
		<div class="last_updated">last updated On : 
		
		<?php
			try
			 {
				
				$last_updated_on = Common::last_update_on("ipb_act_rules");
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


function alphaSearch(value){
    $('#dg').datagrid('load',{
        alpha_search: value
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
        title: 'Acts and Rules',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,40,50,100],
        pagePosition: 'bottom',
        idField: 'rule_id',
		 url: 'ajax_grid_data.php?gname=act_and_rules',
        columns: [[
                {field: 'rules_info', title: 'Title',width:680, styler:cellStyler}
            ]]

    });
}
    </script>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>



</body>
</html>
