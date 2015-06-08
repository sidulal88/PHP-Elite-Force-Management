<?php require_once('settings.php');

$troops_id = $_REQUEST['troops_id'];
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
	
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>

</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
				<div class ="welcome_head"><a href="troops_summeries.php?police_unit=<?php echo $data['police_unit']; ?>"><?php
							//print_r($_SESSION);
							if($data['police_unit']!='')
							{
								$Unit = new Unit();
								$result = $Unit -> get($data['police_unit']);
								$troops_show = $result->fetch_array(MYSQL_ASSOC);
								echo $troops_show['unit_name'];	
							}
						?></a>  >> [<?php echo $data['name'];?>] </div>
       	      <div class="pageBody">
       	        <table class="details_tab" border="0"  cellpadding="0" cellspacing="0" width="99%">
				  <tr>
                    <td colspan="3" class="dv-label"><div class='title' >General information :</div></td>
                  </tr>
                  <tr>
                    <td width="37%" class="dv-label">Name: </td>
                    <td width="42%"><?php echo $data['name'];?></td>
                    <td width="20%" rowspan="6"><span class="dv-label"><img src="uploads/troops/<?php echo $data['photo'];?>" height="180" style="padding:5px; border:2px solid #000" /></span></td>
                  </tr>
				  <tr>
                    <td class="dv-label">Police ID </td>
                    <td><?php echo $data['police_id'];?></td>
                    </tr>
					
                  <tr>
                    <td class="dv-label">Unit Name </td>
                    <td><?php echo $troops_show['unit_name'];?></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Unit Brash No </td>
                    <td><?php echo $data['brash_no']; ?>
					</td>
                  </tr>
                  <tr>
                    <td class="dv-label">Present Rank </td>
                    <td><?php
						if($data['present_rank']!='')
						{
							$Ranks = new Ranks();
							$result = $Ranks -> get($data['present_rank']);
							$show = $result->fetch_array(MYSQL_ASSOC);
							echo $show['rank_name'];
						}	
						?>
					</td>
                  </tr>
				  
                  <tr>
                    <td class="dv-label">Father's name</td>
                    <td><?php echo $data['fname'];?></td>
                    </tr><tr>
                    <td class="dv-label">Mother's name:</td>
                    <td  colspan="2"><?php echo $data['mname'];?></td>
                    </tr>
					<tr>
                    <td class="dv-label">Sex:</td>
                    <td colspan="2"><?php echo $data['gender'];?></td>
                    </tr>
					
                  <tr>
                    <td class="dv-label">Date of birth:</td>
                    <td colspan="2"><?php echo ($data['dob']) ? Common::converToDisplayDate($data['dob']): '';//$data['dob'];?></td>
                  </tr>
				  
				  <tr>
                    <td class="dv-label">Qualification:</td>
                    <td colspan="2"><?php echo $data['qualification'];?></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Personal contact no:</td>
                    <td colspan="2"><?php echo $data['contact_no'];?></td>
                  </tr>
                  <tr>
                    <td class="dv-label" valign="top">Permanent address</td>
					<td colspan="2"><?php echo $data['per_address'];?></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Present address</td>
                    <td colspan="2"><?php echo $data['pre_address'];?></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Emergency contact no:</td>
					<td colspan="2"><?php echo $data['emegency_contact_no'];?></td>
                  </tr> 
				  <tr>
                    <td class="dv-label">Religion:</td>
					<td colspan="2"><?php
					if($data['religion_id']!='')
						{
							$Religion = new Religion();
							$result = $Religion -> get($data['religion_id']);
							$show = $result->fetch_array(MYSQL_ASSOC);
							echo $show['religion_name'];
						}	
						?></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Marital status</td>
                    <td colspan="2"><?php echo $data['meritial_status'];?></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Spouse name:</td>
                    <td colspan="2"><?php echo $data['spouse_name'];?></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Children no.</td>
                    <td colspan="2"><?php echo $data['children_no'];?></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="dv-label"><div class='title' >Health information :</div></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Hight</td>
                    <td colspan="2"><?php echo $data['height'];?></td>
                  </tr>
				  <tr>
				    <td class="dv-label">Weight</td>
				    <td colspan="2"><?php echo $data['weight'];?></td>
			      </tr>
				  <tr>
				    <td class="dv-label">Chest</td>
				    <td colspan="2"><?php echo $data['chest'];?></td>
			      </tr>
				  <tr>
				    <td class="dv-label">Identification Marks</td>
				    <td colspan="2"><?php echo $data['identification_marks'];?></td>
			      </tr>
				  <tr>
                    <td class="dv-label">Blood group</td>
                    <td colspan="2"><?php echo $data['blood_group'];?></td>
                  </tr>
				    <tr>
				      <td class="dv-label">Eye</td>
				      <td colspan="2"><?php echo $data['eye'];?></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Blood Pressure</td>
				      <td colspan="2"><?php echo $data['bp'];?></td>
			      </tr>
				    <tr>
                    <td class="dv-label">Last Medical Check up Date </td>
                    <td colspan="2"><?php echo ($data['last_mc']) ? Common::converToDisplayDate($data['last_mc']) : ''; //$data['last_mc'];?></td>
                  </tr>
				    <tr>
				      <td colspan="3" class="dv-label"><div class='title' >Service record:</div></td>
			      </tr>
				    
				    <tr>
				      <td class="dv-label">Date of Joining</td>
				      <td colspan="2"><?php echo ($data['doj']) ? Common::converToDisplayDate($data['doj']) : '';?></td>
			      </tr>
				     <tr>
				      <td class="dv-label">Date of promotion</td>
				      <td colspan="2"><?php echo($data['promotion_date']) ? Common::converToDisplayDate($data['promotion_date']) : '';?></td>
			      </tr>	
				    <tr>
				      <td class="dv-label">Approximate Date of Retirement</td>
				      <td colspan="2"><?php echo($data['dor']) ? Common::converToDisplayDate($data['dor']) : '';?></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Rank of joining</td>
				      <td colspan="2">
					  <?php
					  	
					if($data['rank_join']!='')
						{
							$Ranks = new Ranks();
							$result = $Ranks -> get($data['rank_join']);
							$show = $result->fetch_array(MYSQL_ASSOC);
							echo $show['rank_name'];
						}	
						?></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Joining Pay scale</td>
				      <td colspan="2"><?php echo $data['joining_scal'];?></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Training</td>
				      <td colspan="2"><?php echo $data['training'];?></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Posting places</td>
				      <td colspan="2"><?php echo $data['posting_place'];?></td>
			      </tr>
				    <tr>
				      <td height="20" class="dv-label">UN mission</td>
				      <td colspan="2"><?php echo $data['un_mission'];?></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Rewards</td>
				      <td colspan="2"><?php echo $data['rewards'];?></td>
			      </tr>
				   
				    <tr>
				      <td class="dv-label">Punishments</td>
				      <td colspan="2"><?php echo $data['punishments'];?></td>
			      </tr>
				    
				
					<tr>
				      <td colspan="3" class="dv-label"><div class='title' >Pays &amp; issues:</div></td>
			      </tr>
				   
				    <tr>
				      <td class="dv-label">Current Pay Scale</td>
				      <td colspan="2"><?php echo $data['scal'];?></td>
				  </tr>
				    <tr>
				      <td class="dv-label">Date Of Increment </td>
				      <td colspan="2"> <?php echo ($data['doi'] > '1970-01-01') ? Common::converToDisplayDate($data['doi']) : ' ';?><?php //echo $data['doi'];?></td>
			      </tr>
				    <tr>
				      
				      <td class="dv-label">Ration unit</td>
				      <td colspan="2"><?php echo $data['ratio_unit'];?></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Items issued</td>
				      <td colspan="2"><?php echo $data['item_issued'];?></td>
			      </tr>
				    <tr>
				      
				      <td class="dv-label">Comments:</td>
				      <td colspan="2"><?php echo $data['comments'];?></td>
			      </tr>
					<tr>
				      <td colspan="3" class="dv-label"><div class='title' >Leave Balance :</div></td>
			      </tr>
				  <tr>
				      <td colspan="3">
					  		<table width="100%" class="leave_table">
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
									<td><?php echo $record['avg_pay']; ?></td>
									<td><?php echo $record['half_pay']; ?></td>
									<td><?php echo $record['total_avg_pay']; ?></td>
									<td><a href="leave_details.php?troops_id=<?php echo $troops_id; ?>&leave_type=Earn"><?php echo $earn_used; ?></a></td>
									<td><?php echo $earn_remaining; ?></td>
								</tr>
								<tr>
									<td>2</td>
									<td>Casual Leave</td>
									<td colspan="3"><?php echo $casual_leave; ?></td>
									<td><a href="leave_details.php?troops_id=<?php echo $troops_id; ?>&leave_type=Casual"><?php echo $casual_used; ?></a></td>
									<td><?php echo $casual_remaining; ?></td>
								</tr>
								
								</tbody>
							</table>
					  </td>
			      </tr>
				  
				  					<tr>
				      <td colspan="3" class="dv-label" align="center"><div class='title' style="text-align:center" ><a href="troops_profile_print.php?troops_id=<?php echo $troops_id; ?>" target="_blank"  ><input type="button" value="Print Profile" style="text-decoration:none; color:#00CC00; font-weight:bold; letter-spacing:2px;" /></a></div></td>
			      </tr>

                </table>
       	      </div>
		
       	      </div>
		
			</div>
            
      </div>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>

</body>
</html>
