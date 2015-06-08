<?php require_once('settings.php');
$police_unit = $_REQUEST['police_unit'];
 try
 {
	$Troops = new Troops();
	$result_troops = $Troops->Morning_Report($police_unit);
	
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
         <th width="3%">Sl. </th>
         <th width="8%">Status</th>
		 <?php
		 	if( $police_unit == 26 )
			{
		 ?>
         <th width="8%">DIG</th>
         <th width="9%">Addl. DIG</th>
		 <?php } ?>
         <th width="4%">SP</th>
         <th width="8%">Addl.SP</th>
         <th width="8%">Sr.ASP</th>
         <th width="5%">ASP</th>
         <th width="6%">Insp</th>
         <th width="5%">SI</th>
         <th width="5%">Sgt.</th>
         <th width="5%">ASI</th>
         <th width="4%">Naik</th>
         <th width="4%">Cons.</th>
         <th width="5%">Civil </th>
         <th width="6%">Total</th>
       </tr>
       				<?php
						$sub_total_dig = 0;
						$sub_total_addl_dig = 0;
	   					$sub_total_sp= 0;
						$sub_total_add_sp = 0;
						$sub_total_sr_asp = 0;
						$sub_total_asp = 0;
						$sub_total_insp = 0;
						$sub_total_si = 0;
						$sub_total_sergeant = 0;
						$sub_total_asi = 0;
						$sub_total_naik = 0;
						$sub_total_constable = 0;
						$sub_total_trops = 0;
						$total_rank_troops = 0;
						$total_troops = 0;
						$ser = 0;
						$class = 'even';
						while($show = $result_troops -> fetch_array(MYSQL_ASSOC))
							{
							$class = ($class == 'odd') ? 'even' : 'odd' ;
							$total_rank_troops = 
							($show['total_sp'] + 
							$show['total_add_sp'] + 
							$show['total_sr_asp'] + 
							$show['total_asp'] + 
							$show['total_insp'] + 
							$show['total_si'] + 
							$show['total_sergeant'] + 
							$show['total_asi'] + 
							$show['total_naik'] + 
							$show['total_constable'] + 
							$show['total_other']);
					?>
       <tr>
         <td class="<?php echo $class; ?>"><?php echo ++$ser; ?></td>
		  <td class="<?php echo $class; ?>"><?php echo $show['status_name']; ?></td>
		 <?php
		 	if( $police_unit == 26 )
			{
		 ?>        
		  <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_dig']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_addl_dig']; ?></div></td>
		 <?php } ?>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_sp']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_add_sp']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_sr_asp']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_asp']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_insp']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_si']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_sergeant']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_asi']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_naik']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_constable']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $show['total_other']; ?></div></td>
         <td class="<?php echo $class; ?>"><div align="center"><?php echo $total_rank_troops; ?></div></td>
       </tr>
       <?php 
	   $sub_total_dig +=$show['total_dig'];
	   $sub_total_addl_dig +=$show['total_addl_dig'];
	   
	   $sub_total_sp +=$show['total_sp'];
	   $sub_total_add_sp +=$show['total_add_sp'];
	   $sub_total_sr_asp +=$show['total_sr_asp'];
	   $sub_total_asp +=$show['total_asp'];
	   $sub_total_insp +=$show['total_insp'];
	   $sub_total_si +=$show['total_si'];
	   $sub_total_sergeant +=$show['total_sergeant'];
	   $sub_total_asi +=$show['total_asi'];
	   $sub_total_naik +=$show['total_naik'];
	   $sub_total_constable +=$show['total_constable'];
	   $sub_total_other +=$show['total_other'];
	  // $sub_total_trops +=$show['total_trops'];
	   $total_troops +=$total_rank_troops;
	   } ?>
       <tr>
         <td colspan="2"><div align="right"><b>Actual Strength</b></div></td>
		 <?php
		 	if( $police_unit == 26 )
			{
		 ?>  
         <td><div align="center"><?php echo $sub_total_dig; ?></div></td>
         <td><div align="center"><?php echo $sub_total_addl_dig; ?></div></td>
		 <?php } ?>
         <td><div align="center"><?php echo $sub_total_sp; ?></div></td>
         <td><div align="center"><?php echo $sub_total_add_sp; ?></div></td>
         <td><div align="center"><?php echo $sub_total_sr_asp; ?></div></td>
         <td><div align="center"><?php echo $sub_total_asp; ?></div></td>
         <td><div align="center"><?php echo $sub_total_insp; ?></div></td>
         <td><div align="center"><?php echo $sub_total_si; ?></div></td>
         <td><div align="center"><?php echo $sub_total_sergeant; ?></div></td>
         <td><div align="center"><?php echo $sub_total_asi; ?></div></td>
         <td><div align="center"><?php echo $sub_total_naik; ?></div></td>
         <td><div align="center"><?php echo $sub_total_constable; ?></div></td>
         <td><div align="center"><?php echo $sub_total_other; ?></div></td>
         <td><div align="center"><?php echo $total_troops; ?></div></td>
       </tr>
	    <tr>
         <td colspan="2"><div align="right"><b>Authorised Strength</b></div></td>
		 <?php
		 	if( $police_unit == 26 )
			{
		 ?>  
		 <td><div align="center"><?php echo $strength_list[3]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[4]; ?></div></td>
		 <?php } ?>
         <td><div align="center"><?php echo $strength_list[5]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[6]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[7]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[8]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[9]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[10]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[11]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[12]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[13]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[14]; ?></div></td>
         <td><div align="center"><?php echo $strength_list[15]; ?></div></td>
         <td><div align="center">
           <?php $total_strength = array_sum($strength_list); echo $total_strength; ?>
         </div></td>
       </tr>
	   <tr>
         <td colspan="2"><div align="right"><b>Vacant</b></div></td>
		 <?php
		 	if( $police_unit == 26 )
			{
		 ?>  
         <td><div align="center"><?php echo $strength_list[3] - $sub_total_dig; ?></div></td>
         <td><div align="center"><?php echo $strength_list[4] - $sub_total_addl_dig; ?></div></td>
		 <?php } ?>
         <td><div align="center"><?php echo $strength_list[5] - $sub_total_sp; ?></div></td>
         <td><div align="center"><?php echo $strength_list[6] - $sub_total_add_sp; ?></div></td>
         <td><div align="center"><?php echo $strength_list[7] - $sub_total_sr_asp; ?></div></td>
         <td><div align="center"><?php echo $strength_list[8] - $sub_total_asp; ?></div></td>
         <td><div align="center"><?php echo $strength_list[9] - $sub_total_insp; ?></div></td>
         <td><div align="center"><?php echo $strength_list[10] - $sub_total_si; ?></div></td>
         <td><div align="center"><?php echo $strength_list[11] - $sub_total_sergeant; ?></div></td>
         <td><div align="center"><?php echo $strength_list[12] - $sub_total_asi; ?></div></td>
         <td><div align="center"><?php echo $strength_list[13] - $sub_total_naik; ?></div></td>
         <td><div align="center"><?php echo $strength_list[14] - $sub_total_constable; ?></div></td>
         <td><div align="center"><?php echo $strength_list[15] - $sub_total_other; ?></div></td>
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
