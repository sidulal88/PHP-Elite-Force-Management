<?php
   require_once('settings.php');
    $industry_id = $_REQUEST['industry_id'];
   
 try
 {
	$Industry = new Industry();
	$result = $Industry->getSummery($industry_id);
	$data = $result -> fetch_array(MYSQL_ASSOC);
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }
 
 
	
	
?>
 
<table class="dv-table grid_details">
    
    <tr>
	<th width="15%" class="dv-label"><div align="center">Contact person</div></th>
	<th width="10%"><div align="center">Contact no</div></th>
      <th width="15%" class="dv-label"><div align="center">Owner</div></th>
      <th width="13%" class="dv-label"><div align="center">Unit</div></th>
      <th width="10%"><div align="center">Membership</div></th>
      <th width="16%"><div align="center">Remarks</div></th>
    </tr>
    <tr>
        <td><?php echo $data['contact_person'];?></td>		
        <td><?php echo $data['contact_no'];?></td>
		<td><?php echo $data['owner'];?></td>    
        <td><?php echo $data['unit_name'];?></td>
        <td><?php echo $data['member_ship'];?></td>
        <td><?php echo $data['remarks'];?></td>
    </tr>
</table>
