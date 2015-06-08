<?php
require_once('../settings.php');
$gname = $_REQUEST['gname'];
$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$rows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : 2;
$offset = ($page-1)*$rows;
$condition = '';


switch ($gname) {

    case "user_list":
		
/*
		$name = isset($_REQUEST['name']) ? mysql_real_escape_string($_REQUEST['name']) : '';
		$unit_id = isset($_REQUEST['unit_id']) ? $_REQUEST['unit_id'] : '';
		$productid = $_REQUEST['productid'];
		$locationid = $_REQUEST['locationid'];
		$condition .= !empty($name) ? " AND ipb_industry_list.industry_name like '%$name%' " : '';
		$condition .= !empty($unit_id) ? " AND ipb_industry_list.unit_id='$unit_id' " : '';
		$condition .= !empty($locationid) ? " AND ipb_industry_list.industry_locaton_name like '%$locationid%' " : '';
		$condition .= !empty($productid) ? " AND ipb_industry_list.product_id='$productid' " : '';
		*/
		$condition = '';
		try
		 {
					
			$Admin = new Admin();
			$result = array();
			$result["total"] = $Admin -> data_count($condition);
			$query = $Admin -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;
		
		
    case "unit_list":
		
		
		$condition = '';
		
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		$condition .= !empty($search_key) ? " AND (ul.unit_name like '%$search_key%' OR ul.address like '%$search_key%' )" : '';
		
		try
		 {
					
			$Unit = new Unit();
			$result = array();
			$result["total"] = $Unit -> data_count($condition);
			$query = $Unit -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				array_push($items, $row);
				$resultNew [] = $row;
			}
			
		$output = array();
		$menutree = Common::generateMenuArray(0, $output, Common::buildChild($items), 10, 0,null,"-->" );
		array_push($items, $menutree);

			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		print_r($items);
        break;		
		
    case "unit_strength":
		
		$condition = '';
		
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		$condition .= !empty($search_key) ? " AND (un.unit_name like '%$search_key%')" : '';

		try
		 {
					
			$UnitStrength = new UnitStrength();
			$result = array();
			$result["total"] = $UnitStrength -> data_count($condition);
			$query = $UnitStrength -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;
		
    case "security_codes":
		
		/*
		$name = isset($_REQUEST['name']) ? mysql_real_escape_string($_REQUEST['name']) : '';
		$unit_id = isset($_REQUEST['unit_id']) ? $_REQUEST['unit_id'] : '';
		$productid = $_REQUEST['productid'];
		$locationid = $_REQUEST['locationid'];
		$condition .= !empty($name) ? " AND ipb_industry_list.industry_name like '%$name%' " : '';
		$condition .= !empty($unit_id) ? " AND ipb_industry_list.unit_id='$unit_id' " : '';
		$condition .= !empty($locationid) ? " AND ipb_industry_list.industry_locaton_name like '%$locationid%' " : '';
		$condition .= !empty($productid) ? " AND ipb_industry_list.product_id='$productid' " : '';
		*/
		$condition = '';
		try
		 {
					
			$Security_Keys = new Security_Keys();
			$result = array();
			$result["total"] = $Security_Keys -> data_count($condition);
			$query = $Security_Keys -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;	
			
    case "rank_list":
		
		/*
		$name = isset($_REQUEST['name']) ? mysql_real_escape_string($_REQUEST['name']) : '';
		$unit_id = isset($_REQUEST['unit_id']) ? $_REQUEST['unit_id'] : '';
		$productid = $_REQUEST['productid'];
		$locationid = $_REQUEST['locationid'];
		$condition .= !empty($name) ? " AND ipb_industry_list.industry_name like '%$name%' " : '';
		$condition .= !empty($unit_id) ? " AND ipb_industry_list.unit_id='$unit_id' " : '';
		$condition .= !empty($locationid) ? " AND ipb_industry_list.industry_locaton_name like '%$locationid%' " : '';
		$condition .= !empty($productid) ? " AND ipb_industry_list.product_id='$productid' " : '';
		*/
		$condition = '';
		try
		 {
					
			$Ranks = new Ranks();
			$result = array();
			$result["total"] = $Ranks -> data_count($condition);
			$query = $Ranks -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
        break;
			
    case "product_list":
		
		$condition = '';
		
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		$condition .= !empty($search_key) ? " AND (productname like '%$search_key%' OR product_name_bangla like '%$search_key%' OR remarks like '%$search_key%' )" : '';
		
		try
		 {
					
			$Product = new Product();
			$result = array();
			$result["total"] = $Product -> data_count($condition);
			$query = $Product -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;
			
    case "district_list":
		
		$condition = '';
		
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		$condition .= !empty($search_key) ? " AND (distrcit_name like '%$search_key%')" : '';
		
		try
		 {
					
			$District = new District();
			$result = array();
			$result["total"] = $District -> data_count($condition);
			$query = $District -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
        break;
			
    case "designations":
		
		$condition = '';
		
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		$condition .= !empty($search_key) ? " AND (designation_name like '%$search_key%')" : '';
		
		try
		 {
					
			$Designation = new Designation();
			$result = array();
			$result["total"] = $Designation -> data_count_all($condition);
			$query = $Designation -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
        break;
}


/*----Common Area Below----*/
$result["rows"] = $items;
echo json_encode($result);
?>