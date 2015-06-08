<?php
require_once('../settings.php');
$gname = $_REQUEST['gname'];
$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$rows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : 2;
$offset = ($page-1)*$rows;
$condition = '';


switch ($gname) {

    case "bcs_officer_list":
		
			
			$condition = '';
			$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
			$batch_no = isset($_REQUEST['batch_no']) ? $_REQUEST['batch_no'] : '';
			$bp_id_no = $_REQUEST['bp_id_no'];
			$distrcit_name = $_REQUEST['distrcit_name'];
			
			$condition .= !empty($search_key) ? " AND (ipb_bcs_officers.name like '%$search_key%' OR ipb_bcs_officers.batch_no='$search_key' OR ipb_bcs_officers.police_id_no='$search_key') " : '';
			$condition .= !empty($distrcit_name) ? " AND ipb_bcs_officers.district_id='$distrcit_name' " : '';
		try
		 {
					
			$BCS_Officers = new BCS_Officers();
			$result = array();
			$result["total"] = $BCS_Officers -> data_count($condition);
			$query = $BCS_Officers -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			$row['photo'] = '';
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
			
				$imagePath = "../uploads/bcs_officers/".$row['photo'];
				$imageView = "../../uploads/bcs_officers/".$row['photo'];
				
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
		
		
    case "act_rules":
		
		$condition = '';
		
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		$condition .= !empty($search_key) ? " AND (title like '%$search_key%' OR rules_no like '%$search_key%' )" : '';
		

		try
		 {
					
			$Act_Rules = new Act_Rules();
			$result = array();
			$result["total"] = $Act_Rules -> data_count($condition);
			$query = $Act_Rules -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
					if($row['attachment']!='')
						{
							$row['rules_info'] = '<a href="../../uploads/act_rules/'.$row['attachment'].'" target="_blank" style="text-decoration:none; color:#0000CC">'.$row['title'].'</a>';
						}
						else if($row['link']!='')
						{
							$row['rules_info'] = '<a href="'.$row['link'].'" target="_blank" style="text-decoration:none; color:#0000CC">'.$row['title'].'</a>';
						}
						else
						{
							$row['rules_info'] = $row['title'];
						}
				array_push($items, $row);
			}
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;		
		
		
    case "administrative_orders":
		
		$condition = '';
		$search_date =  $_REQUEST['search_date'];
		$actual_date = !empty($search_date) ? date("Y-m-d", strtotime($search_date)) : '';
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		
		$condition .= !empty($search_key) ? " AND (title like '%$search_key%' OR order_no like '%$search_key%' )" : '';
		$condition .= !empty($actual_date) ? " AND date='$actual_date' " : '';

		try
		 {
					
			$Administrative_Orders = new Administrative_Orders();
			$result = array();
			$result["total"] = $Administrative_Orders -> data_count_all($condition);
			$query = $Administrative_Orders -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				$row['date'] = $row['date'] ? Common::converToDisplayDate($row['date']) : '';
			
					if($row['attachment']!='')
						{
							$row['title'] = '<a href="../../uploads/administrative/'.$row['attachment'].'" target="_blank" style="text-decoration:none; color:#0000CC">'.$row['title'].'</a>';
						}
				array_push($items, $row);
			}
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;			
		
    case "industry_list":
		
		$condition = '';
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		
		$condition .= !empty($search_key) ? " AND (ipb_industry_list.industry_name like '%$search_key%' OR ipb_industry_list.address like '%$search_key%'  OR ipb_product.productname like '%$search_key%'  OR ipb_industry_list.owner like '%$search_key%'  OR ipb_industry_list.remarks like '%$search_key%' )" : '';

		try
		 {
					
			$Industry = new Industry();
			$result = array();
			$result["total"] = $Industry -> data_count_all($condition);
			$query = $Industry -> get_admin_grid($condition, $offset, $rows);
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
		
    case "phone_book":
		
		$condition = '';
		
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		$unit_id = $_REQUEST['unit_id'];
		$condition .= !empty($search_key) ? " AND (ipb_phone_book.phone like '%$search_key%' OR ipb_phone_book.mobile like '%$search_key%' OR ipb_phone_book.fax like '%$search_key%' OR ipb_phone_book.email like '%$search_key%' OR ipb_phone_book.designation_name like '%$search_key%' )" : '';
		$condition .= !empty($unit_id) ? " AND ipb_phone_book.unit='$unit_id' " : '';

		
		try
		 {
					
			$PhoneBook = new PhoneBook();
			$result = array();
			$result["total"] = $PhoneBook -> data_count_all($condition);
			$query = $PhoneBook -> get_admin_grid($condition, $offset, $rows);
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

	
		
    case "sacked_workers":
		
		$condition = '';
		try
		 {
					
			$Sacked_Workers = new Sacked_Workers();
			$result = array();
			$result["total"] = $Sacked_Workers -> data_count_all($condition);
			$query = $Sacked_Workers -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){//worker_info
			
				$row['sacked_date'] = ($row['sacked_date'] > '1970-01-01') ? Common::converToDisplayDate($row['sacked_date']) : ' ';
				
				$row['worker_info'] = $row['name'].'<br />'.$row['nid'];
					
				$imagePath = "../uploads/sacked/".$row['photo'];
				$imageView = "../../uploads/sacked/".$row['photo'];
				
		  		if($row['photo']=='' || !is_file($imagePath)) {
					$photoPrint = '../../images/no_photo.jpg';
				}
				else if($row['photo']) {
						$photoPrint = $imageView;		 
					}
			
				$row['photo_view'] = "<img src=".$photoPrint." width=50 height=55>";
					
					
				array_push($items, $row);
			}
			
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;		


		
    case "tender_list":
		
		$condition = '';
		$unit_id = $_REQUEST['unit_id'];
		$search_date =  $_REQUEST['search_date'];
		$schedule_date =  $_REQUEST['schedule_date'];
		$search_date = !empty($search_date) ? date("Y-m-d", strtotime($search_date)) : '';
		$schedule_date = !empty($schedule_date) ? date("Y-m-d", strtotime($schedule_date)) : '';
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		
		$condition .= !empty($search_key) ? " AND (title like '%$search_key%' OR tender_no like '%$search_key%' )" : '';
		$condition .= !empty($search_date) ? " AND date='$search_date' " : '';
		$condition .= !empty($schedule_date) ? " AND schedule_date='$schedule_date' " : '';
		$condition .= !empty($unit_id) ? " AND ipb_unit_list.unit_id='$unit_id' " : '';

		try
		 {
					
			$Tenders = new Tenders();
			$result = array();
			$result["total"] = $Tenders -> data_count_all($condition);
			$query = $Tenders -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){//worker_info
				$row['date'] = $row['date'] ? Common::converToDisplayDate($row['date']) : '';
				$row['schedule_date'] = $row['schedule_date'] ? Common::converToDisplayDateTime($row['schedule_date']) : '';
			
					$row['title'] = '<a href="../../uploads/tender/'.$row['attachment'].'" target="_blank" style="text-decoration:none; color:#0000CC">'.$row['title'].'</a>';
			
					$row['tender_schedule'] = '<a href="../../uploads/tender/'.$row['tender_schedule'].'" target="_blank"><img src="../../images/pdf_icon.png" /></a>';
				array_push($items, $row);
			}
			
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
		
		
        break;		


		
    case "troops_list":
		
		$condition = '';
		//echo $_REQUEST['search_key'].'====';
		$_REQUEST['search_key'] = str_replace("'", "&#39;", $_REQUEST['search_key']);
		$_REQUEST['search_key'] = str_replace('"', "&#34;", $_REQUEST['search_key']);
		
		$police_unit = $_REQUEST['police_unit'];
		$present_rank = $_REQUEST['present_rank'];
		$religion_id = $_REQUEST['religion_id'];
		$search_type = isset($_REQUEST['search_type']) ? $_REQUEST['search_type'] : '';
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		//echo $_REQUEST['search_key'].'===';
		
		if($search_type=='Increment')			
		{
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d',(strtotime('next month',strtotime(date($start_date)))));
			$condition .= !empty($start_date) ? " AND ipb_troops.doi between '$start_date' AND  '$end_date' " : '';
		}
		else if($search_type=='Retirement')
		{
			$start_date = date('Y-m-d');
			$end_date = date('Y-m-d',(strtotime('+2 months',strtotime(date($start_date)))));
			$condition .= !empty($start_date) ? " AND ipb_troops.dor between '$start_date' AND  '$end_date' " : '';
				
		}
		
		$condition .= !empty($police_unit) ? " AND ipb_troops.police_unit ='$police_unit' " : '';
		$condition .= !empty($present_rank) ? " AND ipb_troops.present_rank ='$present_rank' " : '';
		$condition .= !empty($religion_id) ? " AND ipb_troops.religion_id ='$religion_id' " : '';
		
		$condition .= !empty($search_key) ? " AND (ipb_troops.name like '%$search_key%' OR ipb_troops.brash_no like '%$search_key%' OR ipb_troops.police_id like '%$search_key%' OR ipb_troops.qualification like '%$search_key%' OR ipb_troops.contact_no like '%$search_key%' OR ipb_troops.per_address like '%$search_key%' OR ipb_troops.blood_group like '%$search_key%' OR ipb_troops.height ='$search_key' OR ipb_troops.ratio_unit like '%$search_key%' OR ipb_troops.gender like '%$search_key%' )" : '';
		
		try
		 {
					
			$Troops = new Troops();
			//$Troops -> leave_Status_update($police_unit);
			$result = array();
			$result["total"] = $Troops -> data_count_all($condition);
			$query = $Troops -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){//worker_info
			
					if($row['photo']!='')
					{
						$row['photo'] = "<img src=../../uploads/troops/".$row['photo']." width=80 height=90>";
					}
				array_push($items, $row);
			}
			
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
        break;		

		

		
    case "industrial_units":
		
		$condition = '';
		try
		 {
					
			$IndustrialUnit = new IndustrialUnit();
			$result = array();
			$result["total"] = $IndustrialUnit -> data_count_all($condition);
			$query = $IndustrialUnit -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){//worker_info
			
				$imagePath = "../uploads/unit_map/".$row['photo'];
				$imageView = "../../uploads/unit_map/".$row['photo'];
				
		  		if($row['photo']=='' || !is_file($imagePath)) {
					$photoPrint = '../../images/no_photo.jpg';
				}
				else if($row['photo']) {
						$photoPrint = $imageView;		 
					}
			
				$row['photo'] = "<img src=".$photoPrint." width=75 height=55>";
					
					
				array_push($items, $row);
			}
			
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
        break;		

		
    case "un_mission_list":
		
		$condition = '';
		$search_date =  $_REQUEST['search_date'];
		$actual_date = !empty($search_date) ? date("Y-m-d", strtotime($search_date)) : '';
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		
		$condition .= !empty($search_key) ? " AND (mission_name like '%$search_key%' OR location like '%$search_key%'  OR holder_name like '%$search_key%' )" : '';
		$condition .= !empty($actual_date) ? " AND joining_date='$actual_date' " : '';

		try
		 {
					
			$Carrer_Mission = new Carrer_Mission();
			$result = array();
			$result["total"] = $Carrer_Mission -> data_count_all($condition);
			$query = $Carrer_Mission -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){//worker_info
				$row['joining_date'] = $row['joining_date'] ? Common::converToDisplayDate($row['joining_date']) : '';
					if($row['attachment']!='')
					{
						$row['attachment'] = '<a href="../../uploads/mission/'.$row['attachment'].'" target="_blank"><img src="../../images/pdf_icon.png" /></a>';
					}
				array_push($items, $row);
			}
			
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
        break;	
				
    case "vacancy_list":
		
		$condition = '';
		$search_date =  $_REQUEST['search_date'];
		$actual_date = !empty($search_date) ? date("Y-m-d", strtotime($search_date)) : '';
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		
		$condition .= !empty($search_key) ? " AND (title like '%$search_key%' OR web_link like '%$search_key%')" : '';
		$condition .= !empty($actual_date) ? " AND date='$actual_date' " : '';

		try
		 {
					
			$Carrer_Vacancy = new Carrer_Vacancy();
			$result = array();
			$result["total"] = $Carrer_Vacancy -> data_count_all($condition);
			$query = $Carrer_Vacancy -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){//worker_info
					$row['date'] = $row['date'] ? Common::converToDisplayDate($row['date']) : '';
					if($row['title']!='')
					{
						$row['title'] = '<a href="../../uploads/vacancy/'.$row['attachment'].'" target="_blank" style="text-decoration:none; color:#0000CC">'.$row['title'].'</a>';
					}
					if($row['web_link']!='')
					{
						$row['web_link'] = '<a href="http://'.$row['web_link'].'" target="_blank" style="text-decoration:none; color:#0000CC">'.$row['web_link'].'</a>';
					}
				array_push($items, $row);
			}
			
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
        break;		


				
    case "former_dg_list":
		
		$condition = '';
		$unit_id = $_REQUEST['unit_id'];
		$from_date =  $_REQUEST['from_date'];
		$from_date = !empty($from_date) ? date("Y-m-d", strtotime($from_date)) : '';
		
		$to_date =  $_REQUEST['to_date'];
		$to_date = !empty($to_date) ? date("Y-m-d", strtotime($to_date)) : '';
		
		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		
		$condition .= !empty($search_key) ? " AND (dg_name like '%$search_key%')" : '';
		$condition .= !empty($from_date) ? " AND date_from='$from_date' " : '';
		$condition .= !empty($to_date) ? " AND date_to='$to_date' " : '';
		$condition .= !empty($unit_id) ? " AND ipb_unit_list.unit_id='$unit_id' " : '';

		try
		 {
					
			$FormerDg = new FormerDg();
			$result = array();
			$result["total"] = $FormerDg -> data_count_all($condition);
			$query = $FormerDg -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
			
				$row['date_from'] = ($row['date_from'] > '1970-01-01') ? Common::converToDisplayDate($row['date_from']) : ' ';
				$row['date_to'] = ($row['date_to'] > '1970-01-01') ? Common::converToDisplayDate($row['date_to']) : '';
			
				array_push($items, $row);
			}
			
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
        break;		


				
    case "leave_summery_list":
		
		$condition = '';
		try
		 {
					
			$TroopsLeave = new TroopsLeave();
			$result = array();
			$result["total"] = $TroopsLeave -> data_count_summery($condition);
			$query = $TroopsLeave -> get_admin_summery($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
			
				  $row['total_leave'] = $row['total_earn'] + $row['total_casual'];
				  array_push($items, $row);
				  
			}
			
			
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		
        break;		


				
    case "leave_list":
		
		$condition = '';
		$troops_id = $_REQUEST['troops_id'];
		$condition .= !empty($troops_id) ? " AND ipb_troops_leaves.troops_id='$troops_id' " : '';

		try
		 {
					
			$TroopsLeave = new TroopsLeave();
			$result = array();
			$result["total"] = $TroopsLeave -> data_count_all($condition);
			$query = $TroopsLeave -> get_admin_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
			
				$row['start_date_dis'] = ($row['start_date'] > '1970-01-01') ? Common::converToDisplayDate($row['start_date']) : ' ';
				$row['end_date_dis'] = ($row['end_date'] > '1970-01-01') ? Common::converToDisplayDate($row['end_date']) : '';
			
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