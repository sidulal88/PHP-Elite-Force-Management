<?php  require_once('../../settings.php');

$q = isset($_POST['q']) ? $_POST['q'] : '';  

$Troops = new Troops();
$result = array();
$query = $Troops -> get_combo($q);
$rows = array();
while($row = $query -> fetch_array(MYSQL_ASSOC)){
    $rows[] = $row;
}

echo json_encode($rows);

?>