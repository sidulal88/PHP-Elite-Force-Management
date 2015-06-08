<?php
   require_once('settings.php');
    $bcs_officer_id = $_REQUEST['bcs_officer_id'];
   
 try
 {
	$BCS_Officers = new BCS_Officers();
	$result = $BCS_Officers->get($bcs_officer_id);
	$data = $result -> fetch_array(MYSQL_ASSOC);
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }
 
 
	
	
?>
 
<table class="dv-table grid_details">
    
    <tr>
      <th width="21%" class="dv-label">Merit Sl. No. </th>
      <th width="19%">Contact No. </th>
	  <th width="19%">Contact Email </th>
    </tr>
    <tr>
      <td><?php echo $data['merit_no'];?></td>
      <td><?php echo $data['contact_no'];?></td>
	   <td><?php echo $data['email_address'];?></td>
    </tr>
    
</table>
