<?php
require_once('settings.php');
$gname = $_REQUEST['gname'];
$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
$rows = isset($_REQUEST['rows']) ? intval($_REQUEST['rows']) : 20;
$offset = ($page-1)*$rows;
$condition = '';


switch ($gname) {

    case "industry_list":
		

		$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
		$unit_id = isset($_REQUEST['unit_id']) ? $_REQUEST['unit_id'] : '';
		$productid = $_REQUEST['productid'];
		$condition .= !empty($search_key) ? " AND (ipb_industry_list.industry_name like '%$search_key%' OR ipb_industry_list.address like '%$search_key%'  OR ipb_industry_list.remarks like '%$search_key%' )" : '';
		$condition .= !empty($unit_id) ? " AND ipb_industry_list.unit_id='$unit_id' " : '';
		$condition .= !empty($productid) ? " AND ipb_industry_list.product_id='$productid' " : '';
		
		try
		 {
			$Industry = new Industry();
			$result = array();
			$result["total"] = $Industry -> data_count($condition);
			$query = $Industry -> get_ui_grid($condition, $offset, $rows);
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
		
    case "phone_book_list":
	
			$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
			$unit = $_REQUEST['unit'];
			
			if($_REQUEST['search_key']!='' || $_REQUEST['unit']!='')
			{
					$condition .= !empty($search_key) ? " AND (ipb_phone_book.phone like '%$search_key%' OR ipb_phone_book.mobile like '%$search_key%' OR ipb_phone_book.fax like '%$search_key%' OR ipb_phone_book.email like '%$search_key%' OR ipb_phone_book.designation_name like '%$search_key%' )" : '';
					$condition .= !empty($unit) ? " AND ipb_phone_book.unit='$unit' " : '';
				try
				 {
					$PhoneBook = new PhoneBook();
					$result = array();
					$result["total"] = $PhoneBook -> data_count($condition);
					$query = $PhoneBook -> get_ui_grid($condition, $offset, $rows);
					$items = array();
					while($row = $query -> fetch_array(MYSQL_ASSOC)){
						array_push($items, $row);
					}
					
				 }
				catch(Exception $e)
				 {
					echo $e->getMessage();
				 }
				
			}
	
        break;
		
    case "bcs_officers_list":
	
			$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
			$distrcit_name = $_REQUEST['distrcit_name'];
			
			$condition .= !empty($search_key) ? " AND (ipb_bcs_officers.name like '%$search_key%' OR ipb_bcs_officers.batch_no='$search_key' OR ipb_bcs_officers.police_id_no='$search_key') " : '';
			$condition .= !empty($distrcit_name) ? " AND ipb_bcs_officers.district_id='$distrcit_name' " : '';
			
		try
		 {
			$BCS_Officers = new BCS_Officers();
			$result = array();
			$result["total"] = $BCS_Officers -> data_count($condition);
			$query = $BCS_Officers -> get_ui_grid($condition, $offset, $rows);
			$items = array();
			$row['photo'] = '';
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				$row['name'] = $row['name'].'<br />'. $row['police_id_no'];
				
				$row['rank_name'] = $row['rank_name']. '<br />'.$row['posting_place'];
				
				$imagePath = "uploads/bcs_officers/".$row['photo'];
				
		  		if($row['photo']=='' || !is_file($imagePath)) {
					$photoPrint = 'images/no_photo.jpg';
				}
				else if($row['photo']) {
						$photoPrint = $imagePath;		 
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
		
	case "vacancy_list":
	
			$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
			
			$condition .= !empty($search_key) ? " AND (ipb_vacancy_list.title LIKE '%$search_key%' )" : '';
			
		try
		 {
			$Carrer_Vacancy = new Carrer_Vacancy();
			$result = array();
			$result["total"] = $Carrer_Vacancy -> data_count($condition);
			$query = $Carrer_Vacancy -> get_ui_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				$row['date'] = $row['date'] ? Common::converToDisplayDate($row['date']) : '';
				$row['title'] = '<a href="uploads/vacancy/'.$row['attachment'].'" style="text-decoration:none; color:#0000CC">'.$row['title'].'</a>';
				$row['web_link'] = '<a href="http://'.$row['web_link'].'"  target="_blank" style="text-decoration:none; color:#0000CC">click</a>';
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
	
        break;
		
	case "un_mission_list":
	
			$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
			
			$condition .= !empty($search_key) ? " AND (ipb_un_mission.mission_name like '%$search_key%' OR ipb_un_mission.location like '%$search_key%' OR ipb_un_mission.holder_name like '%$search_key%' )" : '';
			
		try
		 {
			$Carrer_Mission = new Carrer_Mission();
			$result = array();
			$result["total"] = $Carrer_Mission -> data_count($condition);
			$query = $Carrer_Mission -> get_ui_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				$row['joining_date'] = $row['joining_date'] ? Common::converToDisplayDate($row['joining_date']) : '';
				$row['attachment'] = '<a href="uploads/mission/'.$row['attachment'].'" ><img src="images/pdf_icon.png" /></a>';
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
	
        break;
		
	case "administrative_orders":
	
			$search_date = $_REQUEST['search_date'];
			$actual_date = !empty($search_date) ? date("Y-m-d", strtotime($search_date)) : '';
			$condition .= !empty($actual_date) ? " AND ipb_administrative_orders.date ='$actual_date' " : '';
			$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
			$condition .= !empty($search_key) ? " AND (ipb_administrative_orders.title like '%$search_key%' OR ipb_administrative_orders.order_no like '%$search_key%' )" : '';			
		try
		 {
			$Administrative_Orders = new Administrative_Orders();
			$result = array();
			$result["total"] = $Administrative_Orders -> data_count($condition);
			$query = $Administrative_Orders -> get_ui_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
			
				$row['date'] = $row['date'] ? Common::converToDisplayDate($row['date']) : '';
				$row['title'] = '<a href="uploads/administrative/'.$row['attachment'].'"  style="text-decoration:none; color:#0000CC">'.$row['title'].'</a>';
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
	
        break;
				
	case "troops_list":
	
			$_REQUEST['search_key'] = str_replace("'", "&#39;", $_REQUEST['search_key']);
			$_REQUEST['search_key'] = str_replace('"', "&#34;", $_REQUEST['search_key']);
		
			$police_unit = $_REQUEST['police_unit'];
			$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
			$morning_status = isset($_REQUEST['morning_status']) ? $_REQUEST['morning_status'] : '';
			$search_type = isset($_REQUEST['search_type']) ? $_REQUEST['search_type'] : '';
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
			
			$condition_status= ( $police_unit!='all' ) ? " police_unit ='$police_unit' " : " police_unit NOT BETWEEN 26 AND 30 ";
			$condition .= ( $police_unit!='all' ) ? " AND ipb_troops.police_unit ='$police_unit' " : " AND ipb_troops.police_unit NOT BETWEEN 26 AND 30 ";
			$condition .= !empty($morning_status) ? " AND ipb_troops.morning_status ='$morning_status' " : '';
			
			$condition .= !empty($search_key) ? " AND (ipb_troops.name like '%$search_key%' OR ipb_troops.brash_no ='$search_key' OR ipb_troops.police_id = '$search_key' OR ipb_troops.per_address like '%$search_key%' OR ipb_troops.blood_group like '%$search_key%' OR ipb_troops.height ='$search_key' OR ipb_troops.ratio_unit = '$search_key' OR ipb_ranks.rank_name='$search_key' OR ipb_troops.gender = '$search_key')" : '';
					
		try
		 {
			$Troops = new Troops();
			$Troops -> leave_Status_update($condition_status);
			$result = array();
			$result["total"] = $Troops -> data_count($condition);
			$query = $Troops -> get_ui_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				
			
				$row['name'] =  '<a href="troops_profile.php?troops_id='.$row['troops_id'].'" style="text-decoration:none; color:#0000CC">'.$row['name'].'</a>';
				
				$imagePath = "uploads/troops/".$row['photo'];
				
		  		if($row['photo']=='' || !is_file($imagePath)) {
					$photoPrint = 'images/no_photo.jpg';
				}
				else if($row['photo']) {
						$photoPrint = $imagePath;		 
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
				
	case "tender_list":
	
			$search_date = $_REQUEST['search_date'];
			$actual_date = !empty($search_date) ? date("Y-m-d", strtotime($search_date)) : '';
			$condition .= !empty($actual_date) ? " AND ipb_tenders.date ='$actual_date' " : '';
			
			$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';
			$condition .= !empty($search_key) ? " AND (ipb_tenders.title like '%$search_key%' OR ipb_tenders.tender_no like '%$search_key%'  OR ipb_unit_list.unit_name like '%$search_key%' )" : '';	
		try
		 {
			$Tenders = new Tenders();
			$result = array();
			$result["total"] = $Tenders -> data_count($condition);
			$query = $Tenders -> get_ui_grid($condition, $offset, $rows);
			$items = array();
			$today = date("Y-m-d H:i:s");
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
				$row['date'] = $row['date'] ? Common::converToDisplayDate($row['date']) : '';
			
				$row['title'] = '<a href="uploads/tender/'.$row['attachment'].'" style="text-decoration:none; color:#0000CC">'.$row['title'].'</a>';
				
				//echo $today.'==<br />'.$row['schedule_date'];
				if( strtotime($today) <= strtotime($row['schedule_date']) )
				{
					$row['tender_schedule'] = '<a href="uploads/tender/'.$row['tender_schedule'].'" >
					<img src="images/pdf_icon.png" /></a>';
				}
				else
				{
				
					/*
						* Schedule will rename so that no one can download the file by url saving After time up
						* At the same time database will update so that admin can see the file in anytime
					*/
					if( $row['expired'] != 'yes' )
					{
						$schedule_directory = 'uploads/tender/'.$row['tender_schedule'];
						$new_file = rand(1000, 5000).'_'.$row['tender_schedule'];
						$schedule_directory_new = 'uploads/tender/'.$new_file;
						rename($schedule_directory, $schedule_directory_new);
						
						$_POST['tender_schedule'] = $new_file;
						$_POST['expired'] = 'yes';
						$_POST['tender_id'] = $row['tender_id'];
						DataProcess::saveData($_POST, 'ipb_tenders', false);
					}
					
					$row['tender_schedule'] = "Expired";

				}
				array_push($items, $row);
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
	
        break;
				
	case "sacked_workers":
	
			$search_key = isset($_REQUEST['search_key']) ? $_REQUEST['search_key'] : '';

			$condition .= !empty($search_key) ? " AND (ipb_sacked_workers.name LIKE '%$search_key%' OR ipb_sacked_workers.nid LIKE '%$search_key%' OR ipb_sacked_workers.sacked_from LIKE '%$search_key%' )" : '';
		try
		 {
			$Sacked_Workers = new Sacked_Workers();
			$result = array();
			$result["total"] = $Sacked_Workers -> data_count($condition);
			$query = $Sacked_Workers -> get_ui_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
					$row['contact_info'] = $row['name'].'<br />NID : '.$row['nid'];
					$row['sacked_details'] = 'Sacked Date : '. $row['sacked_date'].'<br />Reson : '.$row['reson'];
					
					$imagePath = "uploads/sacked/".$row['photo'];
					if($row['photo']=='' || !is_file($imagePath)) {
					$photoPrint = 'images/no_photo.jpg';
					}
					else if($row['photo']) {
							$photoPrint = $imagePath;		 
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



				
	case "act_and_rules":
	
			$search_key = $_REQUEST['search_key'];
			$alpha_search = $_REQUEST['alpha_search'];
			
			$condition .= !empty($search_key) ? " AND (title LIKE '%$search_key%' OR rules_no LIKE '%$search_key%') " : '';
			$condition .= !empty($alpha_search) ? " AND (title LIKE '$alpha_search%')" : '';
		try
		 {
			$Act_Rules = new Act_Rules();
			$result = array();
			$result["total"] = $Act_Rules -> data_count($condition);
			$query = $Act_Rules -> get_ui_grid($condition, $offset, $rows);
			$items = array();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
					if($row['attachment']!='')
						{
							$row['rules_info'] = '<a href="uploads/act_rules/'.$row['attachment'].'" style="text-decoration:none; color:#0000CC">'.$row['title'].'</a>';
						}
						else if($row['link']!='')
						{
							$row['rules_info'] = '<a href="'.$row['link'].'" style="text-decoration:none; color:#0000CC">'.$row['title'].'</a>';
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
				
	case "former_dgs":
	$unit_id = $_REQUEST['unit_id'];
	$condition = ($unit_id) ? " AND ipb_former_dgs.unit_id='$unit_id' " : '';
	
		try
		 {
			$FormerDg = new FormerDg();
			$result = array();
			$result["total"] = $FormerDg -> data_count($condition);
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
		
				
    case "leave_list":
		
		$condition = '';
		$troops_id = $_REQUEST['troops_id'];
		$leave_type = $_REQUEST['leave_type'];
		$condition .= !empty($troops_id) ? " AND ipb_troops_leaves.troops_id='$troops_id' AND ipb_troops_leaves.status='active' " : '';
		$condition .= !empty($leave_type) ? " AND ipb_troops_leaves.leave_type='$leave_type' " : '';

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
				$footer['subtotal_leave'] += $row['total_leave'];
			
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