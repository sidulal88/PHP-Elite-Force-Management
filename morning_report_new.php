<?php require_once('settings.php');
$police_unit = $_REQUEST['police_unit'];
 try
 {
	$Troops = new Troops();
	$result_troops = $Troops->Morning_Report_New($police_unit);
	
	$condition = " AND unit_id='$police_unit' ";
	$UnitStrength = new UnitStrength();
	$resultRanks = $UnitStrength->gets($condition);
	$strength_list = array();
	while($data = $resultRanks -> fetch_array(MYSQL_ASSOC))
	{
		$strength_list[$data['rank_id']] = $data['authorised_strength'];
	}
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
 <link rel="stylesheet" type="text/css" href="easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="easyui/demo/demo.css">
<script src="js/sidebar.feedback.js"></script>
	<script type="text/javascript" src="js/jquery.easyui.min.js"></script>
</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
				<div class ="welcome_head">Morning Report::
				
						<a href="#">[
						<?php
							//print_r($_SESSION);
							if($police_unit!='')
							{
								$Unit = new Unit();
								$result = $Unit -> get($police_unit);
								$troops_show = $result->fetch_array(MYSQL_ASSOC);
								echo $troops_show['unit_name'];	
							}
						?>]</a></div>
           	  <div class="pageBody">

<div id="tb" style="padding:2px"> <table width="100%" cellpadding="0" cellspacing="0" border="0" bordercolor="#000099" class="list_grid">
       <tr>
         <th width="7%">Sl. </th>
         <th width="19%">Rank</th>
         <th width="10%">Leave</th>
         <th width="7%">Sick</th>
         <th width="11%">Over stay</th>
         <th width="20%">Duty out of station</th>
         <th width="9%">On duty</th>
         <th width="9%">On rest</th>
         <th width="8%">Total</th>
       </tr>
       				<?php
						$sub_total_leave = 0;
						$sub_total_sick = 0;
						$sub_total_over_stay = 0;
	   					$sub_total_out_station= 0;
						$sub_total_duty = 0;
						$sub_total_rest = 0;

						$sub_total_trops = 0;
						$total_rank_troops = 0;
						$total_troops = 0;
						$ser = 0;
						$class = 'even';
						$number = 1; 
						while($show = $result_troops -> fetch_array(MYSQL_ASSOC))
							{
							
							$number++;
							if( $police_unit != 26 &&  $number <= 3 )
							continue;
							
							$class = ($class = 'odd') ? 'even' : 'odd' ;
							
							//if( $police_unit != 26 && $ser < 1 )
							//continue;											
							
							$total_rank_troops = 
							(
							$show['total_leave'] + 
							$show['total_sick'] + 
							$show['total_over_duty'] + 
							$show['total_duty_out_of_station'] + 
							$show['total_on_duty'] + 
							$show['total_on_rest']);
					?>
       <tr>
         <td ><?php echo ++$ser; ?></td>
		  <td ><?php echo $show['rank_name']; ?></td>
		  <td ><div align="center"><?php echo $show['total_leave']; ?></div></td>
         <td ><div align="center"><?php echo $show['total_sick']; ?></div></td>
         <td ><div align="center"><?php echo $show['total_over_duty']; ?></div></td>
         <td ><div align="center"><?php echo $show['total_duty_out_of_station']; ?></div></td>
         <td ><div align="center"><?php echo $show['total_on_duty']; ?></div></td>
         <td ><div align="center"><?php echo $show['total_on_rest']; ?></div></td>
         <td ><div align="center"><?php echo $total_rank_troops; ?></div></td>
       </tr>
       <?php 
	   $sub_total_leave +=$show['total_leave'];
	   $sub_total_sick +=$show['total_sick'];
	   $sub_total_over_stay +=$show['total_over_duty'];
	   $sub_total_out_station +=$show['total_duty_out_of_station'];
	   $sub_total_duty +=$show['total_on_duty'];
	   $sub_total_rest +=$show['total_on_rest'];
	   $total_troops +=$total_rank_troops;
	   } ?>
       <tr>
         <td colspan="2"><div align="right"><b>Actual Strength</b></div></td>
         <td><div align="center"><?php echo $sub_total_leave; ?></div></td>
         <td><div align="center"><?php echo $sub_total_sick; ?></div></td>
         <td><div align="center"><?php echo $sub_total_over_stay; ?></div></td>
         <td><div align="center"><?php echo $sub_total_out_station; ?></div></td>
         <td><div align="center"><?php echo $sub_total_duty; ?></div></td>
         <td><div align="center"><?php echo $sub_total_rest; ?></div></td>
         <td><div align="center"><?php echo $total_troops; ?></div></td>
       </tr>
	    <tr>
         <td colspan="2"><div align="right"><b>Authorised Strength</b></div></td>
		 <td><div align="center"><?php echo $strength_list[3]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[4]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[5]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[6]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[7]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[8]; ?></div></td>
         <td><div align="center">
           <?php $total_strength = array_sum($strength_list); echo $total_strength; ?>
         </div></td>
       </tr>
	   <tr>
         <td colspan="2"><div align="right"><b>Vacant</b></div></td>
         <td><div align="center"><?php echo $strength_list[3] - $sub_total_dig; ?></div></td>
         <td><div align="center"><?php echo $strength_list[4] - $sub_total_addl_dig; ?></div></td>
         <td><div align="center"><?php echo $strength_list[5] - $sub_total_sp; ?></div></td>
         <td><div align="center"><?php echo $strength_list[6] - $sub_total_add_sp; ?></div></td>
         <td><div align="center"><?php echo $strength_list[7] - $sub_total_sr_asp; ?></div></td>
         <td><div align="center"><?php echo $strength_list[8] - $sub_total_asp; ?></div></td>
         <td><div align="center"><?php echo $total_strength - $total_troops; ?></div></td>
       </tr>
     </table>
   
</div>

			  </div>
		  <div class="last_updated">last updated On : 
		
		<?php
			try
			 {
				
				$last_updated_on = Common::last_update_on("ipb_troops");
				echo date("d M, Y  -  H:i:s", strtotime($last_updated_on));
			 }
			catch(Exception $e)
			 {
				echo $e->getMessage();
			 }
		?></div>
			</div>
			<div class='title' style="text-align:center" ><a href="morning_report_print.php?police_unit=<?php echo $police_unit; ?>" target="_blank"  ><input type="button" value="Print Report" style="text-decoration:none; color:#00CC00; font-weight:bold; letter-spacing:2px;" /></a></div>

        </div>
            
      </div>
	  
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>



</body>
</html>
