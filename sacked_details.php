<?php
   require_once('settings.php');
    $sacked_worker_id = $_REQUEST['sacked_worker_id'];
   
 try
 {
	$Sacked_Workers = new Sacked_Workers();
	$result = $Sacked_Workers->get($sacked_worker_id);
	$data = $result -> fetch_array(MYSQL_ASSOC);
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }
 
 
	
	
?>
 
<table class="dv-table grid_details" width="90%">
    
    <tr>
      <th width="20%" class="dv-label">Sacked Date</th>
      <th width="70%">Sacked Reson</th>
    </tr>
    <tr>
      <td><?php echo ($data['sacked_date']) ? Common::converToDisplayDate($data['sacked_date']) : '';?></td>
      <td><?php echo $data['reson'];?></td>
    </tr>
    
</table>
