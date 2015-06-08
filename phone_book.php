<?php require_once('settings.php');
 try
 {
	$Unit = new Unit();
	$resultUnit = $Unit->gets(" AND data_level=1 ");
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
<script src="js/sidebar.feedback.js"></script>
 <link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
    <script type="text/javascript" src="js/jquery.easyui.min.js"></script>
</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
				<div class ="welcome_head">Police Phone Book</div>
           	  <div class="pageBody">
			  
<div id="tb" style="padding:10px">
<table width="90%" cellspacing="3">
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
		<td width="12%"><div align="center"><strong>OR</strong> </div></td>
		
		<td width="3%">&nbsp;</td>
		<td width="48%"><input id="search_key" style="line-height:26px;border:1px solid #ccc" size="32" placeholder="Search Key"></td>
	</tr>
	<tr>
	  <td><select name="unit2" id="unit2" class="unit_change">
      </select></td>
	  <td>&nbsp;</td>
	  <td></td>
	  <td><input type="button" name="submit" value="Search" class="button" onclick="doSearch()" /></td>
	  </tr>
	<tr>
		
		<td><select name="unit3" id="unit3" class="unit_change">
		
		</select></td>
		<td>&nbsp;</td>
	<td></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
	  <td><select name="unit4" id="unit4" class="unit_change">
      </select></td>
	  <td>&nbsp;</td>
	  <td></td>
	  <td>&nbsp;</td>
	  </tr>
</table>
   
</div>
<table id="dg"></table>
</div>
			<div class="last_updated">last updated On : 
		
		<?php
			try
			 {
				
				$last_updated_on = Common::last_update_on("ipb_phone_book");
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

function loadData(unit_val){
    $('#dg').datagrid('load',{
        unit: unit_val
    });
}

$(document).ready(function() {
phone_book_list();

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
function phone_book_list() {

    $('#dg').datagrid({
        title: 'Phone Book',
        iconCls: 'icon-save',
        pagination: 'true',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,50,100],
        pagePosition: 'bottom',
        idField: 'book_id',
        url: 'ajax_grid_data.php?gname=phone_book_list',
        columns: [[
                {field: 'designation_name', title: 'Designaton', width:165, styler:cellStyler},
                {field: 'phone', title: 'Phone', width:104, styler:cellStyler},
				{field: 'mobile', title: 'Mobile', width:130, styler:cellStyler},
				{field: 'fax', title: 'Fax', width:100, styler:cellStyler},
				{field: 'email', title: 'Email', width:185, styler:cellStyler}
            ]]

    });
}
    </script>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>

</body>
</html>
