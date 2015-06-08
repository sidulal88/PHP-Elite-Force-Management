<?php
require_once('settings.php');

$search_id = $_REQUEST['search_id'];
$status_id = $_REQUEST['status_id'];

try
 {
	$Troops = new Troops();
	$result = $Troops->Change_status($search_id, $status_id);
	if($result){
			echo 'Status Changed successfully!';
		}
		else {
			echo mysql_error();
		}
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }

?>