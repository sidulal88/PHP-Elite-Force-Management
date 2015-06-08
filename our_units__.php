<?php require_once('settings.php');
$unit_id = $_REQUEST['unit_id'];
$board_title = ($unit_id==26) ? "DG's" : "Director's";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
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
            <?php
			try
		 {
		 	$IndustrialUnit = new IndustrialUnit();
			$result = $IndustrialUnit -> getByUnit($unit_id);
			$show = $result->fetch_array(MYSQL_ASSOC);
			
			$Unit = new Unit();
			$result_unit = $Unit -> get($show['unit_id']);
			$show_unit = $result_unit->fetch_array(MYSQL_ASSOC);
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
			
		?>
			<div class="content">
				<div class ="welcome_head"><?php echo $show_unit['unit_name']; ?></div>
                	<div class="pageBody">
					<table width="100%">
						<tr>
							<td><?php echo $show['description']; ?></td>
						</tr>
					</table>
					</div>
					<p style="margin-top:10px; margin-bottom:10px">
					<?php
					$imagePath = "uploads/unit_map/".$show['photo'];
					//if($show['photo']=='' || !is_file($imagePath)) {
							//$photoPrint = 'images/no_photo.jpg';
						//}
						//else if($show['photo']) {
							//	$photoPrint = $imagePath;		 
							//}
						if( $show['photo']!='' || is_file($imagePath) )
						{
						$photoPrint = $imagePath;	
				  ?>
				  <h2>Jurisdiction Map: </h2>
				  <img src="<?php echo $photoPrint; ?>" width="500" height="250" style="padding:5px; border:1px solid #003366" />
				  <?php } ?>					</p>
					<table id="dg" style="width:91%"></table>
					<p>&nbsp;</p>
			</div>
		
			</div>
            </div>
            
      </div>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
	

</body>
</html>
 <script type="text/javascript">
	
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
        title: "<?php echo $board_title; ?> Honour Board",
        iconCls: 'icon-save',
        toolbar: "#toolbar",
        rownumbers: 'true',
        singleSelect: true,
		pageList: [20,30,40,50,100],
        pagePosition: 'bottom',
        idField: 'industry_unit_id',
		 url: 'ajax_grid_data.php?gname=former_dgs&unit_id=<?php echo $unit_id; ?>',
        columns: [[
                {field: 'dg_name', title: 'Name',width:275, styler:cellStyler},
				{field: 'date_from', title: 'From',width:180, styler:cellStyler},
                {field: 'date_to', title: 'To',width:180, styler:cellStyler}
            ]]

    });
}
    </script>
