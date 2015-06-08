<?php require_once('settings.php');
$data = $_REQUEST['data'];
$condition = " AND type='sacked_worker' ";
try
 {
	$Industry = new Industry();
	$resultIndustry = $Industry->gets();
	
	$Security_Keys = new Security_Keys;
	$real_code = $Security_Keys->security_key($condition);
	
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }
if(isset($_POST['verify']))
{
	unset($_SESSION['authentic_access_sec']);	
	$security_code = $_POST['security_code'];
	if( strcasecmp($security_code, $real_code) == 0 )
	{
		$_SESSION['authentic_access_sec'] = 'yes';
	}
	else
	{
		$_SESSION['authentic_access_sec'] = 'no';
	}
}
 
 $unit_id = $_REQUEST['unit_id'];
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
				<div class ="welcome_head">List of Sacked Worker</div>
           	  <div class="pageBody">
			  <?php
	if ($_SESSION['authentic_access_sec'] != 'yes' ) {
?>
<div id="tb" style="padding:5px">
<h1 style="color:#FF0000; font-weight:bold; font-size:14px; line-height:20px">Entry Restricted,<br />Please Input Your Security Key for access </h1>
<form name="" method="post" action="sacked_workers.php?data=<?php echo $data; ?>">
<table width="100%" cellspacing="3">
	<tr>
		<td width="27%"><input type="password" name="security_code" style="line-height:26px;border:1px solid #ccc; padding:2px;" size="36" placeholder="Input your Security Key"></td>
		
		<td width="73%"><input type="submit" name="verify" value="Verify" class="button"></td>
		
	</tr>
</table>
   </form>
</div>
<?php
}
else
{
?>
<div id="tb" style="padding:10px">
<table width="90%" cellspacing="3">
	<tr>
		<td width="36%"><input id="search_key" style="line-height:28px;border:1px solid #ccc; text-indent:5px" size="45" placeholder="Search By Name/ NID No. / Industry Name"></td>
		
		<td width="64%"><input type="button" name="submit" value="Search" class="button" onclick="doSearch()" /></td>
	</tr>
</table>
   
</div>
<table id="dg"></table>
	<?php } ?>		  </div>
		 <div class="last_updated">last updated On : 
		
		<?php
			try
			 {
				
				$last_updated_on = Common::last_update_on("ipb_sacked_workers");
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
        search_key: $('#search_key').val()
    });
}


$(document).ready(function() {
grid_view();

});

	function cellStyler(value,row,index){
            if (index % 2 != 0){
                return 'background-color:#D8E4F7; font-size:12px;';
            }
			else
			{
				return 'font-size:12px;';
			}
        }
	
function grid_view() {

    $('#dg').datagrid({
        title: 'Sacked Worker List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,40,50,100],
        pagePosition: 'bottom',
        idField: 'sacked_worker_id',
		 url: 'ajax_grid_data.php?gname=sacked_workers',
        columns: [[
                {field: 'photo', title: 'Photo',width:55, styler:cellStyler},
				{field: 'contact_info', title: 'Name & NID',width:150, styler:cellStyler},
                {field: 'per_address', title: 'Address',width:190, styler:cellStyler},
				{field: 'sacked_from', title: 'Sacked From',width:265, styler:cellStyler}
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
            href:'sacked_details.php?sacked_worker_id='+row.sacked_worker_id,
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
