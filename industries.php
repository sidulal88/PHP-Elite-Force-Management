<?php require_once('settings.php');
 try
 {
	
	$Product = new Product();
	$resultProduct = $Product->gets(" AND status='active' ");
 }
catch(Exception $e)
 {
	echo $e->getMessage();
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
				<div class ="welcome_head">List of Industry</div>
           	  <div class="pageBody">
			  
<div id="tb" style="padding:10px">
<table width="90%" cellspacing="3">
	<tr>
		<td width="29%"><input id="search_key" style="line-height:26px;border:1px solid #ccc" size="38"  placeholder="Search By Industry Name / Address"></td>
		<td width="9%"><div align="center">OR</div></td>
		<td width="26%"><select name="unit_id" id="unit_id" style="padding:7px">
          <option value="">Search By Police Unit</option>
          <option value="">All</option>
          <?php
			

			$Unit = new Unit();
		
			$menuTree = $Unit -> getsGrid(" AND is_industry=1 ");
	
			foreach($menuTree as $show):
			if($show['data_level']==1)
			continue;
			$spacer = ($show['data_level'] > 2) ? str_repeat(" ---> ", $show['data_level']-1) : '';

		?>
          <option value="<?php echo $show['unit_id']; ?>" <?php if($unit_id == $show['unit_id']) {echo 'selected'; }?>><?php echo $spacer.$show['unit_name']; ?></option>
          <?php endforeach; ?>
        </select></td>
		<td width="6%"><div align="center">OR</div></td>
		<td width="30%"><select name="productid" id="productid" style="padding:7px">
          <option value="">Search By Product</option>
          <option value="">All</option>
          <?php
		
		while($show = $resultProduct -> fetch_array(MYSQL_ASSOC))
		{
		?>
          <option value="<?php echo $show['productid']; ?>"><?php echo $show['productname']; ?></option>
          <?php } ?>
        </select></td>
	</tr><tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><div align="center">
		  <input type="button" name="submit" value="Search" class="button" onclick="doSearch()" />
		  </div></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
</table>
   
</div>
<input type="hidden" id="gname" value="industry_list" />
<table id="dg" class="easyui-datagrid" style="width:710px;height:700px"
        url="ajax_grid_data.php?unit_id=<?php echo $unit_id; ?>&gname=industry_list" toolbar="#tb"
        title="List of Industry" iconCls="icon-save" sortName="industry_id"  sortOrder="asc"
        rownumbers="true" pagination="true" pageList="[20, 25, 30, 40, 50, 75, 100]">
		
    <thead>
	<tr><th  field="industry_name" width="180" rowspan="2" data-options="styler:cellStyler" sortable="true">Industry Name</th> 
			<th  field="address" width="180" rowspan="2" data-options="styler:cellStyler" sortable="true">Address</th>       
			<th  width="150" colspan="3" data-options="styler:cellStyler" sortable="true">Worker</th>
			<th  width="160"field="product_name"  rowspan="2" data-options="styler:cellStyler" sortable="true">Products</th>
        </tr>
        <tr>
		    <th field="worker_male" width="50" align="right" data-options="styler:cellStyler" >Male</th>
			<th field="worker_female" width="50" align="right" data-options="styler:cellStyler" >Female</th>
			<th field="total_worker" width="50" align="right" class="hello" data-options="styler:cellStyler" >Total</th>
        </tr>
    </thead>
</table>

			  </div>
		<div class="last_updated">last updated On : 
		
		<?php
			try
			 {
				
				$last_updated_on = Common::last_update_on("ipb_industry_list");
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

function cellStyler(value,row,index){
     if (index % 2 != 0){
     	return 'background-color:#D8E4F7';
     }
}

        function doSearch(){
    $('#dg').datagrid('load',{
        gname: $('#gname').val(),
		search_key: $('#search_key').val(),
        unit_id: $('#unit_id').val(),
		productid: $('#productid').val()
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
            href:'industry_details.php?industry_id='+row.industry_id,
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
