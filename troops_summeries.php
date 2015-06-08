<?php require_once('settings.php');

$police_unit = $_REQUEST['police_unit'];
$condition = " AND unit_id=$police_unit ";
 try
 {
	$Unit = new Unit();
	$resultUnit = $Unit->gets(" AND data_level=1 ");
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }


if($police_unit!='all')
{ 
	
	try
	 {
		
		$Security_Keys = new Security_Keys;
		$real_code = $Security_Keys->security_key($condition);
		
	 }
	catch(Exception $e)
	 {
		echo $e->getMessage();
	 }
	 
	 
	$access_point = $authentic_access.$police_unit;
	
	
	if(isset($_POST['verify']))
	{
		unset($_SESSION[$access_point]);	
		
		$security_code = $_POST['security_code'];
		if( strcasecmp($security_code, $real_code) == 0 )
		{
			$_SESSION[$access_point] = 'yes';
			$_SESSION['police_unit'.$police_unit] = 'yes';
		}
		else
		{
			$_SESSION[$access_point] = 'no';
			$_SESSION['police_unit'.$police_unit] = 'no';
		}
		
	}
}
else if($police_unit=='all')
{ 
	$real_code = 'ip1234';
	$access_point = $authentic_access.$police_unit;
	if(isset($_POST['verify']))
	{
		unset($_SESSION[$access_point]);	
		$security_code = $_POST['security_code'];
		if( strcasecmp($security_code, $real_code) == 0 )
		{
			$_SESSION[$access_point] = 'yes';
			$_SESSION['police_unit'.$police_unit] = 'yes';
		}
		else
		{
			$_SESSION[$access_point] = 'no';
			$_SESSION['police_unit'.$police_unit] = 'no';
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>
 <link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
<script src="js/sidebar.feedback.js"></script>
	<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
<script>
  
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
   
</script></head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
				<div class ="welcome_head">List of Troops [ 
						<?php
							//print_r($_SESSION);
							if($police_unit!='' && $police_unit!='all')
							{
								$Unit = new Unit();
								$result = $Unit -> get($police_unit);
								$troops_show = $result->fetch_array(MYSQL_ASSOC);
								echo $troops_show['unit_name'];	
							}
							else if( $police_unit=='all' )
							{
								echo 'Other Units';
							}
						?>]</div>
           	  <div class="pageBody">
<?php
	if ($_SESSION['police_unit'.$police_unit] != 'yes') {
?>
<div id="tb" style="padding:5px">
<h1 style="color:#FF0000; font-weight:bold; font-size:14px; line-height:20px">Entry Restricted,<br />Please Input Your Security Key for access </h1>
<form name="" method="post" action="troops_summeries.php?police_unit=<?php echo $police_unit; ?>">
<table width="100%" cellspacing="3">
	<tr>
		<td width="23%"><input name="security_code" type="password" style="line-height:26px;border:1px solid #ccc; padding:2px;" size="36" placeholder="Input your Security Key"></td>	

		
		<td width="58%"><input type="submit" name="verify" value="Verify" class="button"></td>
		
	</tr>
</table>
   </form>
</div>
<?php
}
else
{
?>
<fieldset>
<legend>Search Troops</legend>
<div id="tb" style="padding:5px">
<table width="100%" cellspacing="3">
	<tr>
	  <td colspan="4">Search By [ Name, Brash No, Police ID, Permanent Address, Blood Group, Height, Ration Uint, Rank, Gender ] </td>
	  </tr>
	  
	  <?php if($police_unit=='all') { ?>
	  
	<tr>
	  <td colspan="4"><table width="90%" cellspacing="3">
	<tr>
		<td width="37%"><select name="unit" id="unit" class="unit_change">
		<option value="">Select Unit</option>
		
		<?php
			while($show = $resultUnit -> fetch_array(MYSQL_ASSOC))
			{

		?>
		<option value="<?php echo $show['unit_id']; ?>"><?php echo $show['unit_name']; ?></option>
		<?php } ?>
		</select></td>
	  <td><select name="unit2" id="unit2" class="unit_change">
      </select></td>
	</tr>
	<tr>
		<td><select name="unit3" id="unit3" class="unit_change">
		
		</select></td>
	  <td><select name="unit4" id="unit4" class="unit_change">
      </select></td>
	  </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>
	  
	  <?php } ?>
	  
</table></td>
	  </tr>
	<tr>
	  <td><input name="Input" id="search_key" style="line-height:26px;border:1px solid #ccc; padding-left:3px" size="32" placeholder="Input Your Search Key" /></td>
	  <td>
<?php if($police_unit!='all') { ?>
	  
	  <select name="morning_status" id="morning_status">
        <option value="">Search By Status</option>
        <option value="">All</option>
        <option value="1">Leave</option>
        <option value="2">Sick</option>
        <option value="3">Over stay</option>
        <option value="4">Duty out of station</option>
        <option value="5">On duty</option>
        <option value="6">On rest</option>
      </select>
<?php } ?>
	  </td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  </tr>
	<tr>
		<td width="25%"><input type="button" name="submit2" value="Search" class="button" onclick="doSearch()" /></td>
					<td width="18%">
					<?php if($police_unit!='all') { ?>
					<select name="search_type" id="search_type">
                      <option value="">All</option>
                      <option value="Increment">Next Increment</option>
                      <option value="Retirement">Next Retirement</option>
                    </select>
					<?php } ?>
					</td>
					<td width="7%">&nbsp;</td>
		<td width="50%"><a href="morning_report.php?police_unit=<?php echo $police_unit; ?>">
<?php if($police_unit!='all') { ?>
		  <input type="button" name="submit3" value="Morning Report" class="button" />
<?php } ?>
		</a></td>
	</tr>
</table>
   
</div>
</fieldset>
<?php if($police_unit!='all') { ?>
<hr style="margin-bottom:10xp; margin-top:10px;" />
<div style="margin-top:10px; padding:5px; font-size:14px; font-weight:bold; color:#00CC33">
Set Status to Prepare Morning Report<br /><br />
<input type="button" name="submit" value="Leave" class="button_icon" onclick="ChangeStatus(1);">
<input type="button" name="submit" value="Sick" class="button_icon" onclick="ChangeStatus(2);">
<input type="button" name="submit" value="Over stay" class="button_icon" onclick="ChangeStatus(3);">
<input type="button" name="submit" value="Duty out of station" class="button_icon" onclick="ChangeStatus(4);">
<input type="button" name="submit" value="On duty" class="button_icon" onclick="ChangeStatus(5);">
<input type="button" name="submit" value="On rest" class="button_icon" onclick="ChangeStatus(6);">
</div>
<?php } ?>
  <!---  <input class="button" type="button" onclick="tableToExcel('show_excel', 'YTD Cost Variance Report')" value="Export to Excel">--->
    <div id="show_excel" >
<table id="dg"></table>
</div>
<?php } ?>
			  </div>
			  <div class="last_updated">last updated On : 
		
		<?php
			try
			 {
				
				$last_updated_on = Common::last_update_on("ipb_troops");
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
        search_key: $("#search_key").val(),
        morning_status: $("#morning_status").val(),
		search_type: $("#search_type").val()
    });
}

function loadData(unit_val){
    $('#dg').datagrid('load',{
        police_unit: unit_val
    });
}

$(document).ready(function() {
troops_list();


$("select#unit").change(function(){
    $("select#unit2").load("ajax_unit_data.php",{unit_id: $(this).val(),select_name:'Sub', ajax: 'true'});
});


$("select#unit2").change(function(){
    $("select#unit3").load("ajax_unit_data.php",{unit_id: $(this).val(),select_name:'Sub Sub', ajax: 'true'});
});


$("select#unit3").change(function(){
    $("select#unit4").load("ajax_unit_data.php",{unit_id: $(this).val(),select_name:'Sub Sub', ajax: 'true'});
});

$("select.unit_change").change(function(){
    loadData($(this).val());
});



});


	function cellStyler(value,row,index){
            if (index % 2 != 0){
                return 'background-color:#D8E4F7';
            }
        }
			
	
function troops_list() {

    $('#dg').datagrid({
        title: 'Troops List',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
		pageList: [20,30,40,50,100],
        pagePosition: 'both',
        idField: 'troops_id',
		url: 'ajax_grid_data.php?gname=troops_list&police_unit=<?php echo $police_unit; ?>',
        columns: [[
				{field:'troops_id',title:'All',checkbox:true, styler:cellStyler},
                {field: 'rank_name', title: 'Rank',width:87, styler:cellStyler},
				{field: 'brash_no', title: 'Brash no',width:60, styler:cellStyler},
                {field: 'name', title: 'Name',width:140, styler:cellStyler},
				{field: 'contact_no', title: 'Mobile',width:100, styler:cellStyler},
				{field: 'per_address', title: 'Address',width:180, styler:cellStyler},
				{field: 'status_name', title: 'Status',width:90, styler:cellStyler}
				
            ]]

    });
}



function ChangeStatus(this_status_id){
    var ids = [];
        var rows = $('#dg').datagrid('getSelections');
        for(var i=0; i<rows.length; i++){
            ids.push(rows[i].troops_id);
            $.ajax({
                url:'ajax_change_status.php',
                type:'get',
                data:{save:'save',search_id:rows[i].troops_id,status_id:this_status_id},
                success: function(respons){
                    $('#dg').datagrid('reload');
					$.messager.alert('Information',data,'info');
                }
            });
        }
    
}


    </script>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>



</body>
</html>
