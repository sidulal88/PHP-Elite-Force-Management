<?php //require_once('settings.php');

	$troops_id = $_REQUEST['troops_id'];
	date_default_timezone_set('Europe/London');
	define('HOST', '172.18.18.18');
	define('DB_USER', 'industrialpolice');
	define('DB_PASS', 'I@n$d#P@Bc@C@2021');	
	define('DATABASE', 'industrialpolice_db');
	define('CLASS_DIR', 'classes');
	define('TABLE_PREFIX', 'ipb_');
	define('POLL_PREFIX', 'poll_');

	function __autoload($className)
	{
		/*
			This function load classes on-call
		*/
        if(is_file(CLASS_DIR.'/'.$className.'.class.php'))
		{
			require_once(CLASS_DIR.'/'.$className.'.class.php');
		}
		elseif(is_file(CLASS_DIR.'/'.$className.'.class.php'))
		{
			require_once(CLASS_DIR.'/'.$className.'.class.php');
		}
	}
    
    
	try
	{
		$Database = new Database();
		$Database->getConnection();
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		exit();
	}


$casual_leave = 20; 
 try
 {
	$Troops = new Troops();
	$result = $Troops->get($troops_id);
	$data = $result -> fetch_array(MYSQL_ASSOC);
	
	$record = $Troops->earn_leave($troops_id);
	$earn_used = $Troops->leave_used($troops_id, 'Earn');
	$casual_used = $Troops->leave_used($troops_id, 'Casual');
	$earn_remaining = $record['total_avg_pay'] - $earn_used;
	$casual_remaining = $casual_leave - $casual_used;
	
	/*------Assign Important variables--------*/
	
	if($data['present_rank']!='')
		{
			$Ranks = new Ranks();
			$result = $Ranks -> get($data['present_rank']);
			$show_rank = $result->fetch_array(MYSQL_ASSOC);
		}
	$dob_show = ($data['dob']) ? Common::converToDisplayDate($data['dob']): '';
	
	if($data['police_unit']!='')
		{
			$Unit = new Unit();
			$result = $Unit -> get($data['police_unit']);
			$troops_show = $result->fetch_array(MYSQL_ASSOC);
		}
	
	if($data['religion_id']!='')
		{
			$Religion = new Religion();
			$result = $Religion -> get($data['religion_id']);
			$show_religon = $result->fetch_array(MYSQL_ASSOC);
			$show_religon['religion_name'];
		}
		
		$show_last_mc=($data['last_mc']) ? Common::converToDisplayDate($data['last_mc']) : ''; //$data['last_mc'];
		$show_doj =($data['doj']) ? Common::converToDisplayDate($data['doj']) : '';
		$show_promotion_date =($data['promotion_date']) ? Common::converToDisplayDate($data['promotion_date']) : '';
		$show_dor = ($data['dor']) ? Common::converToDisplayDate($data['dor']) : '';
		
		if($data['rank_join']!='')
		{
			$Ranks = new Ranks();
			$result = $Ranks -> get($data['rank_join']);
			$show_jon_rank = $result->fetch_array(MYSQL_ASSOC);
		}
		
		$show_doi = ($data['doi'] > '1970-01-01') ? Common::converToDisplayDate($data['doi']) : ' ';	
		
	
	
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }
$html = '<table class="details_tab" border=""  cellpadding="2" cellspacing="3" width="100%" >
				  <tr>
                    <td colspan="3" align="center" ><h1>TROOPS PROFILE<h2></div></td>
                  </tr>
				  <tr>
                    <td colspan="3" align="center" ><h2>'.$data['name'].'<h2></div></td>
                  </tr>
				  <tr>
                    <td colspan="3" align="center" ><h2>'.$show_rank['rank_name'].'<h2></div></td>
                  </tr>
				  <tr>
                    <td colspan="3" >&nbsp;</td>
                  </tr>
				  <tr>
                    <td colspan="3" ><h3>General information :<h3></div></td>
                  </tr>
                  <tr>
                    <td width="37%" >Name: </td>
                    <td width="42%">'.$data['name'].'</td>
                    <td width="20%" rowspan="6"><span ><img src="uploads/troops/'.$data['photo'].'" height="165" style="padding:5px; border:2px solid #000" /></span></td>
                  </tr>
				  <tr>
                    <td >Police ID </td>
                    <td>'.$data['police_id'].'</td>
                    </tr>
					
                  <tr>
                    <td >Unit Name </td>
                    <td>'.$troops_show['unit_name'].'</td>
                  </tr>
                  <tr>
                    <td >Unit Brash No </td>
                    <td>'.$data['brash_no'].'
					</td>
                  </tr>
                  <tr>
                    <td >Present Rank </td>
                    <td>'.$show_rank['rank_name'].'
					</td>
                  </tr>
				  
                  <tr>
                    <td >Father name</td>
                    <td>'.$data['fname'].'</td>
                    </tr><tr>
                    <td >Mothers name:</td>
                    <td  colspan="2">'.$data['mname'].'</td>
                    </tr>
					<tr>
                    <td >Sex:</td>
                    <td colspan="2">'.$data['gender'].'</td>
                    </tr>
					
                  <tr>
                    <td >Date of birth:</td>
                    <td colspan="2">'.$dob_show.'</td>
                  </tr>
				  <tr>
                    <td >Qualification:</td>
                    <td colspan="2">'.$data['qualification'].'</td>
                  </tr>
                  <tr>
                    <td >Personal contact no:</td>
                    <td colspan="2">'.$data['contact_no'].'</td>
                  </tr>
                  <tr>
                    <td  valign="top">Permanent address</td>
					<td colspan="2" valign="top">'.$data['per_address'].'</td>
                  </tr>
                  <tr>
                    <td  valign="top">Present address</td>
                    <td colspan="2">'.$data['pre_address'].'</td>
                  </tr>
                  <tr>
                    <td >Emergency contact no:</td>
					<td colspan="2">'.$data['emegency_contact_no'].'</td>
                  </tr> 
				  <tr>
                    <td >Religion:</td>
					<td colspan="2">'.$show_religon['religion_name'].'</td>
                  </tr>
                  <tr>
                    <td >Marital status</td>
                    <td colspan="2">'.$data['meritial_status'].'</td>
                  </tr>
                  <tr>
                    <td >Spouse name:</td>
                    <td colspan="2">'.$data['spouse_name'].'</td>
                  </tr>
                  <tr>
                    <td >Children no.</td>
                    <td colspan="2">'.$data['children_no'].'</td>
                  </tr>
				  
				                    <tr>
                    <td colspan="3" ><h3>Health information :</h3></td>
                  </tr>
                  <tr>
                    <td >Hight</td>
                    <td colspan="2">'.$data['height'].'</td>
                  </tr>
				  <tr>
				    <td >Weight</td>
				    <td colspan="2">'.$data['weight'].'</td>
			      </tr>
				  <tr>
				    <td >Chest</td>
				    <td colspan="2">'.$data['chest'].'</td>
			      </tr>
				  <tr>
				    <td >Identification Marks</td>
				    <td colspan="2">'.$data['identification_marks'].'</td>
			      </tr>
				  <tr>
                    <td >Blood group</td>
                    <td colspan="2">'.$data['blood_group'].'</td>
                  </tr>
				    <tr>
				      <td >Eye</td>
				      <td colspan="2">'.$data['eye'].'</td>
			      </tr>
				    <tr>
				      <td >Blood Pressure</td>
				      <td colspan="2">'.$data['bp'].'</td>
			      </tr>
				    <tr>
                    <td >Last Medical Check up Date </td>
                    <td colspan="2">'.$show_last_mc.'</td>
                  </tr>
				  
				    <tr>
				      <td colspan="3" ><h3>Service record:</h3></td>
			      </tr>
				    
				    <tr>
				      <td >Date of Joining</td>
				      <td colspan="2">'.$show_doj.'</td>
			      </tr>
				     <tr>
				      <td >Date of promotion</td>
				      <td colspan="2">'.$show_promotion_date.'</td>
			      </tr>	
				    <tr>
				      <td >Approximate Date of Retirement</td>
				      <td colspan="2">'.$show_dor.'</td>
			      </tr>
				    <tr>
				      <td >Rank of joining</td>
				      <td colspan="2">'.$show_jon_rank['rank_name'].'</td>
			      </tr>
				    <tr>
				      <td >Joining Pay scale</td>
				      <td colspan="2">'.$data['joining_scal'].'</td>
			      </tr>
				    <tr>
				      <td  valign="top">Training</td>
				      <td colspan="2" valign="top">'.$data['training'].'</td>
			      </tr>
				    <tr>
				      <td  valign="top">Posting places</td>
				      <td colspan="2" valign="top">'.$data['posting_place'].'</td>
			      </tr>
				    <tr>
				      <td height="20"  valign="top">UN mission</td>
				      <td colspan="2" valign="top">'.$data['un_mission'].'</td>
			      </tr>
				    <tr>
				      <td  valign="top">Rewards</td>
				      <td colspan="2" valign="top">'.$data['rewards'].'</td>
			      </tr>
				   
				    <tr>
				      <td  valign="top">Punishments</td>
				      <td colspan="2" valign="top">'.$data['punishments'].'</td>
			      </tr>
				  
					<tr>
				      <td colspan="3" ><h3>Pays &amp; issues:</h3></td>
			      </tr>
				   
				    <tr>
				      <td >Current Pay Scale</td>
				      <td colspan="2">'.$data['scal'].'</td>
				  </tr>
				    <tr>
				      <td >Date Of Increment </td>
				      <td colspan="2">'.$show_doi.'</td>
			      </tr>
				    <tr>
				      
				      <td >Ration unit</td>
				      <td colspan="2">'.$data['ratio_unit'].'</td>
			      </tr>
				    <tr>
				      <td  valign="top">Items issued</td>
				      <td colspan="2" valign="top">'.$data['item_issued'].'</td>
			      </tr>
				    <tr>
				      
				      <td  valign="top">Comments:</td>
				      <td colspan="2" valign="top">'.$data['comments'].'</td>
			      </tr>

				<tr>
				      <td colspan="3" ><h3>Leave Balance :</h3></td>
			      </tr>
				  <tr>
				      <td colspan="3">
					  		<table width="100%" border="1" class="leave_table">
							<thead>
								<tr>
								<th width="8%" rowspan="2">sl. No.</th>
								<th width="15%" rowspan="2">Leave Type</th>
								<th colspan="3"> Accrued  Balance</th>
								<th width="18%" rowspan="2"> Used Leave</th>
								<th width="19%" rowspan="2">Available Leave</th>
							
							  <tr>
							    <th width="12%"> Avg. Pay</th>
								  <th width="10%"> Half Pay</th>
								  <th width="18%"> Total Avg. Pay</th>
							  </tr>
							  </thead>
							<tbody>	<tr>
									<td>1</td>
									<td>Earn Leave</td>
									<td>'.$record['avg_pay'].'</td>
									<td>'.$record['half_pay'].'</td>
									<td>'.$record['total_avg_pay'].'</td>
									<td>'.$earn_used.'</td>
									<td>'.$earn_remaining.'</td>
								</tr>
								<tr>
									<td>2</td>
									<td>Casual Leave</td>
									<td colspan="3">'.$casual_leave.'</td>
									<td>'.$casual_used.'</td>
									<td>'.$casual_remaining.'</td>
								</tr>
								</tbody>
							</table>
					  </td>
			      </tr>


                </table>
';


//==============================================================
//==============================================================
//==============================================================

include("MPDF/mpdf.php");

$mpdf=new mPDF(); 

$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

//==============================================================
//==============================================================
//==============================================================


?>
