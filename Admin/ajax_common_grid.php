<?php
require_once('../settings.php');
$gname = $_REQUEST['gname'];
$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$rows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : 2;
$offset = ($page-1)*$rows;
$condition = '';


switch ($gname) {

    case "rotate_banners":
		
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
					
			$Banner = new Banner();
			$result = array();
			$result["total"] = $Banner -> data_count_all($condition);
			$query = $Banner -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			$row['photo'] = '';
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
			
				$imagePath = "../uploads/sliders/".$row['photo'];
				$imageView = "../../uploads/sliders/".$row['photo'];
				
		  		if($row['photo']=='' || !is_file($imagePath)) {
					$photoPrint = '../../images/no_photo.jpg';
				}
				else if($row['photo']) {
						$photoPrint = $imageView;		 
					}
			
				$row['photo'] = "<img src=".$photoPrint." width=120 height=70>";
				
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;
		
		
    case "news_list":
		
		$condition = '';
		$search_date =  $_REQUEST['search_date'];
		$actual_date = !empty($search_date) ? date("Y-m-d", strtotime($search_date)) : '';
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		
		$condition .= !empty($search_key) ? " AND (title like '%$search_key%')" : '';
		$condition .= !empty($actual_date) ? " AND news_date='$actual_date' " : '';

		$condition = '';
		try
		 {
					
			$News = new News();
			$result = array();
			
			$result["total"] = $News -> data_count_all($condition);
			$query = $News -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				$row['news_date'] = $row['news_date'] ? Common::converToDisplayDate($row['news_date']) : '';
				$imagePath = "../uploads/newses/".$row['photo'];
				$imageView = "../../uploads/newses/".$row['photo'];
				
		  		if($row['photo']=='' || !is_file($imagePath)) {
					$photoPrint = '../../images/no_photo.jpg';
				}
				else if($row['photo']) {
						$photoPrint = $imageView;		 
					}
			
				$row['photo'] = "<img src=".$photoPrint." width=50 height=55>";
				
				array_push($items, $row);
			}
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;		
			
		
    case "category_list":
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
					
			$Category = new Category();
			$result = array();
			
			$result["total"] = $Category -> data_count_all($condition);
			$query = $Category -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
			
				$imagePath = "../uploads/categories/".$row['photo'];
				$imageView = "../../uploads/categories/".$row['photo'];
				
		  		if($row['photo']=='' || !is_file($imagePath)) {
					$photoPrint = '../../images/no_photo.jpg';
				}
				else if($row['photo']) {
						$photoPrint = $imageView;		 
					}
			
				$row['photo'] = "<img src=".$photoPrint." width=50 height=55>";
				
				array_push($items, $row);
			}
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;		
			
			
		
    case "photo_gallery":
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
					
			$Photo = new Photo();
			$result = array();
			
			$result["total"] = $Photo -> data_count_all($condition);
			$query = $Photo -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
			
				$imagePath = "../uploads/photos/".$row['photo_thumb'];
				$imageView = "../../uploads/photos/".$row['photo_thumb'];
				
		  		if($row['photo_thumb']=='' || !is_file($imagePath)) {
					$photoPrint = '../../images/no_photo.jpg';
				}
				else if($row['photo_thumb']) {
						$photoPrint = $imageView;		 
					}
			
				$row['photo'] = "<img src=".$photoPrint." width=50 height=55>";
				
				array_push($items, $row);
			}
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;		
		
				
    case "feed_back_list":
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
					
			$Feedback = new Feedback();
			$result = array();
			
			$result["total"] = $Feedback -> data_count_all($condition);
			$query = $Feedback -> get_admin_grid($condition, $offset, $rows);
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
		
				
    case "control_page_list":
		$condition = '';
		try
		 {
			$PageControl = new PageControl();
			$result = array();
			$result["total"] = $PageControl -> data_count($condition);
			$query = $PageControl -> gets($condition, $offset, $rows);
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