<?php
require_once('settings.php');
$unit_id = $_REQUEST['unit_id'];
$select_name = $_REQUEST['select_name'];
$condition = '';
$condition .= isset($unit_id) ? " AND ipb_unit_list.sub_under='$unit_id' " : '';

try
 {
	
	$Unit = new Unit;
	$result = $Unit->gets($condition);
	
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }
 
 
?>
<option value="">Select <?php echo $select_name; ?> Unit</option>
		<?php
		while($show = $result -> fetch_array(MYSQL_ASSOC))
			{

		?>
<option value="<?php echo $show['unit_id']; ?>"><?php echo $show['unit_name']; ?></option>
<?php } ?>