<?php  //require_once('../settings.php');
$police_unit = $_REQUEST['police_unit'];
	date_default_timezone_set('Europe/London');
	
	define('HOST', '172.18.18.18');
	define('DB_USER', 'industrialpolice');
	define('DB_PASS', 'I@n$d#P@Bc@C@2021');	
	define('DATABASE', 'industrialpolice_db');
	
	
	/*define('HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');	
	define('DATABASE', 'ipolice_website');
	*/
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
	
	if($police_unit!='')
	{
		$Unit = new Unit();
		$result = $Unit -> get($police_unit);
		$troops_show = $result->fetch_array(MYSQL_ASSOC);								
	}
	
	$last_updated_on = Common::last_update_on("ipb_troops");
	$last_update_date = date("d M, Y  -  H:i:s", strtotime($last_updated_on));
 }
catch(Exception $e)
 {
	echo $e->getMessage();
 }
	
$html = '
<h1 align=center>MORNING REPORT</h1>
<h2 align=center>'.$troops_show['unit_name'].'</h2>
<h3 align=center>Date : '.date('d-m-Y').'</h3>
 <table width="100%" cellpadding="5" cellspacing="5" border="1" bordercolor="#000099" class="list_grid">
      <thead> 
	   <tr>
         <th width="3%">Sl.</th>
         <th width="12%">Status</th>';
		 
if( $police_unit == 26 )
{
$html .= '<th width="6%">DIG</th>
         <th width="10%">Addl. DIG</th>';
} 
		 
 $html .= ' 
         <th width="6%">SP</th>
         <th width="8%">Addl.SP</th>
         <th width="8%">Sr.Asp</th>
         <th width="6%">ASP</th>
         <th width="8%">Insp</th>
         <th width="5%">SI</th>
         <th width="10%">Sgt.</th>
         <th width="5%">ASI</th>
         <th width="6%">Naik</th>
         <th width="8%">Cons.</th>
         <th width="6%">Civil</th>
         <th width="6%">Total</th>
       </tr></thead><tbody>';
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
							
							$class = ($class = 'odd') ? 'even' : 'odd' ;
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

						   $html .=    '<tr>
								 <td >'.++$ser.'</td>
								  <td >'.$show['status_name'].'</td>';
							if( $police_unit == 26 )
							{
								$html .=  '<td align=center>'.$show['total_dig'].'</td>
        								   <td align=center>'.$show['total_addl_dig'].'</td>';
							}
								  
							 $html .=  '
							 
							    <td align=center>'.$show['total_sp'].'</td>
								 <td align=center>'.$show['total_add_sp'].'</td>
								 <td align=center>'.$show['total_sr_asp'].'</td>
								 <td align=center>'.$show['total_asp'].'</td>
								 <td align=center>'.$show['total_insp'].'</td>
								 <td align=center>'.$show['total_si'].'</td>
								 <td align=center>'.$show['total_sergeant'].'</td>
								 <td align=center>'.$show['total_asi'].'</td>
								 <td align=center>'.$show['total_naik'].'</td>
								 <td align=center>'.$show['total_constable'].'</td>
								 <td align=center>'.$show['total_other'].'</td>
								 <td align=center>'.$total_rank_troops.'</td>
							   </tr>';
							   
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
			
			}
	   
	       $html.= ' <tr>
         <td colspan="2"><div align="right"><b>Actual Strength</b></div></td>';
		 	if( $police_unit == 26 )
			{
				$html .=  '<td align=center><b>'.$sub_total_dig.'</b></td>
        				   <td align=center><b>'.$sub_total_addl_dig.'</b></td>';
			}
			
		$html .= '<td align=center><b>'.$sub_total_sp.'</b></td>
         <td align=center><b>'.$sub_total_add_sp.'</b></td>
         <td align=center><b>'.$sub_total_sr_asp.'</b></td>
         <td align=center><b>'.$sub_total_asp.'</b></td>
         <td align=center><b>'.$sub_total_insp.'</b></td>
         <td align=center><b>'.$sub_total_si.'</b></td>
         <td align=center><b>'.$sub_total_sergeant.'</b></td>
         <td align=center><b>'.$sub_total_asi.'</b></td>
         <td align=center><b>'.$sub_total_naik.'</b></td>
         <td align=center><b>'.$sub_total_constable.'</b></td>
         <td align=center><b>'.$sub_total_other.'</b></td>
         <td align=center><b>'.$total_troops.'</b></td>
       </tr>
	    <tr>
         <td colspan="2"><div align="right"><b>Authorised Strength</b></div></td>
		';
		 	if( $police_unit == 26 )
			{
				$html .= ' <td align=center><b>'.$strength_list[3].'</b></td>
         				<td align=center><b>'.$strength_list[4].'</b></td>
				';
			}
			$total_strength = array_sum($strength_list);
	
		$html .= '<td align=center><b>'.$strength_list[5].'</b></td>
         <td align=center><b>'.$strength_list[6].'</b></td>
         <td align=center><b>'.$strength_list[7].'</b></td>
         <td align=center><b>'.$strength_list[8].'</b></td>
         <td align=center><b>'.$strength_list[9].'</b></td>
         <td align=center><b>'.$strength_list[10].'</b></td>
         <td align=center><b>'.$strength_list[11].'</b></td>
         <td align=center><b>'.$strength_list[12].'</b></td>
         <td align=center><b>'.$strength_list[13].'</b></td>
         <td align=center><b>'.$strength_list[14].'</b></td>
         <td align=center><b>'.$strength_list[15].'</b></td>
         <td align=center><b>'.$total_strength.'</b></td>
       </tr>
	   <tr>
         <td colspan="2"><div align="right"><b>Vacant</b></div></td>';
		 
		 $final_dg = $strength_list[3] - $sub_total_dig;
		 $final_addl_dg = $strength_list[4] - $sub_total_addl_dig;
		 $final_sp = $strength_list[5] - $sub_total_sp;
		 $final_addl_sp = $strength_list[6] - $sub_total_add_sp;
		 $final_sr_asp = $strength_list[7] - $sub_total_sr_asp;
		 $final_asp = $strength_list[8] - $sub_total_asp;
		 $final_insp = $strength_list[9] - $sub_total_insp;
		 $final_si = $strength_list[10] - $sub_total_si;
		 $final_sergeant = $strength_list[11] - $sub_total_sergeant;
		 $final_asi = $strength_list[12] - $sub_total_asi;
		 $final_naik = $strength_list[13] - $sub_total_naik;
		 $final_constable = $strength_list[14] - $sub_total_constable;
		 $final_other = $strength_list[15] - $sub_total_other;
		 $final_troops = $total_strength - $total_troops;
		 
		if( $police_unit == 26 )
			{
				$html .= '<td  align=center><b>'.$final_dg.'</b></td>
         				<td  align=center><b>'.$final_addl_dg.'</b></td>';

			}
			
         $html .= '<td align=center><b>'.$final_sp.'</b></td>
         <td align=center><b>'.$final_addl_sp.'</b></td>
         <td align=center><b>'.$final_sr_asp.'</b></td>
         <td align=center><b>'.$final_asp.'</b></td>
         <td align=center><b>'.$final_insp.'</b></td>
         <td align=center><b>'.$final_si.'</b></td>
         <td align=center><b>'.$final_sergeant.'</b></td>
         <td align=center><b>'.$final_asi.'</b></td>
         <td align=center><b>'.$final_naik.'</b></td>
         <td align=center><b>'.$final_constable.'</b></td>
         <td align=center><b>'.$final_other.'</b></td>
         <td align=center><b>'.$final_troops.'</b></td>
       </tr>';
	   
	   
	   
    $html .= '</tobdy></table>';
	
 $html .='<div class="last_updated" style="margin-top:20px">Last Updated On :'; 
 $html .= $last_update_date;
		
 $html .= '</div>';

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
