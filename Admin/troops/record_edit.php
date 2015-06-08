<?php  require_once('../../settings.php');
	$troops_id = $_REQUEST['troops_id'];
	
try

{
	$Uploader = new Uploader();

	$Troops = new Troops();

	$result = $Troops -> get($troops_id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['Submit'])) {
	
		$Troops -> edit();
		echo "<script type=\"text/javascript\">location.replace(\"record_edit.php?troops_id=$troops_id\");</script>";

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
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>

<link href="../form_msg.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php include(ROOT_DIR.'Admin/adminHead.php');?></td>
  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1>Directory Entry</h1>
	 <h2><?php echo EDIT; ?></h2>
	<h3> <a href="index.php" class="link_button">Record List</a></h3>
	 </div>
     
<form action="record_edit.php?troops_id=<?php echo $troops_id; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="troops_id" value="<?php echo $troops_id; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
      <tr>
                    <td colspan="4" class="dv-label"><h1>General information :</h1></td>
                  </tr>
         <tr>
                    <td width="17%" class="dv-label">Name:</td>
                    <td width="33%"><input type="text" name="name" id="name" value="<?php echo $show_data['name']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Unit Name </td>
                    <td><select name="police_unit" id="police_unit">
                      <option><?php echo SELECT; ?></option>
                      <?php
			
						$Unit = new Unit();
					
						$menuTree = $Unit -> getsGrid();
				
						foreach($menuTree as $show):
					
						$spacer = ($show['data_level'] > 1) ? str_repeat(" --> ", $show['data_level']-1) : '';
					?>
                      <option value="<?php echo $show['unit_id']; ?>" <?php if($show_data['police_unit']==$show['unit_id']) {echo 'selected'; }?>><?php echo $spacer.$show['unit_name']; ?></option>
                      <?php endforeach; ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Unit Brash No</td>
                    <td><input type="text" name="brash_no" value="<?php echo $show_data['brash_no']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Present Rank</td>
                    <td><select name="present_rank" id="present_rank">
                      <option><?php echo SELECT; ?></option>
                      <?php

			$Ranks = new Ranks();
			$result = $Ranks -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
                      <option value="<?php echo $show['rank_id']; ?>" <?php if($show_data['present_rank']==$show['rank_id']) {echo 'selected'; }?>><?php echo $show['rank_name']; ?></option>
                      <?php } ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Father's name</td>
                    <td><input type="text" name="fname" value="<?php echo $show_data['fname']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Mother's name:</td>
                    <td><input type="text" name="mname" value="<?php echo $show_data['mname']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Police ID </td>
                    <td width="33%"><input type="text" name="police_id" value="<?php echo $show_data['police_id']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Sex:</td>
                    <td><input type="radio" name="gender" value="Male" <?php if($show_data['gender']=="Male") {echo 'checked'; }?> />
                      Male
                        <input type="radio" name="gender" value="Female" <?php if($show_data['gender']=="Female") {echo 'checked'; }?> />
                    Female</td>
                  </tr>
                  <tr>
                    <td class="dv-label">Date of birth:</td>
                    <td width="33%">
					<?php
					$dob = $show_data['dob'];
					$dob_date = date('Y-m-d', strtotime($dob));
					?>
					<input type="text" id="dob" name="dob" class="easyui-datebox" value="<?php echo $dob_date; ?>"/></td>
                    <td class="dv-label">Qualification:</td>
                    <td><input type="text" name="qualification" value="<?php echo $show_data['qualification']; ?>" size="26"class="bng_text"/></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Personal contact no:</td>
                    <td width="33%"><input type="text" name="contact_no"value="<?php echo $show_data['contact_no']; ?>" size="26"  class="bng_text"/></td>
                    <td class="dv-label">Religion</td>
                    <td><select name="religion_id" id="religion_id">
                      <option><?php echo SELECT; ?></option>
                      <?php

			$Religion = new Religion();
			$result = $Religion -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
                      <option value="<?php echo $show['religion_id']; ?>" <?php if($show_data['religion_id']==$show['religion_id']) {echo 'selected'; }?>><?php echo $show['religion_name']; ?></option>
                      <?php } ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Per. address</td>
                    <td>
					<textarea name="per_address" id="per_address" class="text_area" ><?php echo $show_data['per_address']; ?></textarea></td>
                    <td width="11%" class="dv-label">Pre. address</td>
                    <td width="39%"><textarea name="pre_address" id="pre_address" class="text_area" ><?php echo $show_data['pre_address']; ?></textarea></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Emergency contact no:</td>
                    <td><input type="text" name="emegency_contact_no" value="<?php echo $show_data['emegency_contact_no']; ?>" size="26" class="bng_text"/></td>
                    <td class="dv-label">Marital status</td>
                    <td>
					<input type="radio" name="meritial_status" value="Married" <?php if($show_data['meritial_status']=="Married") {echo 'checked'; }?>/>Married
                      <input type="radio" name="meritial_status" value="Single"  <?php if($show_data['meritial_status']=="Single") {echo 'checked'; }?>/>
                      Single
                      <input type="radio" name="meritial_status" value="Divorced"  <?php if($show_data['meritial_status']=="Divorced") {echo 'checked'; }?>/>
Divorced
<input type="radio" name="meritial_status" value="Widowed"  <?php if($show_data['meritial_status']=="Widowed") {echo 'checked'; }?> />
Widowed</td>
                  </tr>
                  <tr>
                    <td class="dv-label">Spouse name:</td>
                    <td><input type="text" name="spouse_name" id="spouse_name" value="<?php echo $show_data['spouse_name']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Children no.</td>
                    <td><input type="text" name="children_no" id="children_no" value="<?php echo $show_data['children_no']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
                  </tr>
                  
                  <tr>
                    <td colspan="4" class="dv-label"><h1>Health information :</h1></td>
                  </tr>
				  <tr>
                    <td class="dv-label">Hight</td>
                    <td><input type="text" name="height"placeholder="X Feet Y Inch" size="26" value="<?php echo $show_data['height']; ?>" class="bng_text"/></td>
                    <td class="dv-label">Weight</td>
                    <td><input type="text" name="weight" placeholder="X KG" size="26" class="bng_text" value="<?php echo $show_data['weight']; ?>" /></td>
                  </tr>
				  <tr>
				    <td class="dv-label">Identification Marks</td>
				    <td><input type="text" name="identification_marks" id="identification_marks" value="<?php echo $show_data['identification_marks']; ?>" size="26" class="bng_text"/></td>
				    <td class="dv-label">Chest</td>
				    <td><input type="text" name="chest" value="<?php echo $show_data['chest']; ?>" size="26" class="bng_text"/></td>
      </tr>
				  <tr>
                    <td class="dv-label">Blood group</td>
                    <td><input type="text" name="blood_group" id="blood_group" size="26" value="<?php echo $show_data['blood_group']; ?>" class="bng_text"/></td>
                    <td class="dv-label">Eye</td>
                    <td><input type="text" name="eye" size="26" value="<?php echo $show_data['eye']; ?>" class="bng_text"/></td>
                  </tr>
				    <tr>
                    <td class="dv-label">Blood Pressure</td>
                    <td><input type="text" name="bp" placeholder="80*120" size="26" value="<?php echo $show_data['bp']; ?>" class="bng_text"/></td>
                    <td class="dv-label">Last MC</td>
                    <td>
					<?php
					$last_mc = $show_data['last_mc'];
					$last_mc_date = date('Y-m-d', strtotime($last_mc));
					?>
					<input type="text" name="last_mc" class="easyui-datebox" value="<?php echo $last_mc_date; ?>"/></td>
                  </tr>
				  
				
				    <tr>
				      <td colspan="4" class="dv-label"><h1>Service record:</h1></td>
			      </tr>
				    
				    <tr>
					  <td class="dv-label">DOJ</td>
				      <td>
					  <?php
					$doj = $show_data['doj'];
					$doj_date = date('Y-m-d', strtotime($doj));
					?>
					  <input type="text" name="doj" class="easyui-datebox" value="<?php echo $doj_date; ?>"/></td>
					  
				      <td class="dv-label">Approximate Date of Retirement</td>
				      <td>
					  <?php
					$dor = $show_data['dor'];
					$dor_date = date('Y-m-d', strtotime($dor));
					?>
					  <input type="text" id="dor" name="dor" class="easyui-datebox" value="<?php echo $dor_date; ?>"/></td>
				    
      </tr>
				    <tr>
				      <td class="dv-label">Rank of joining</td>
				      <td><select name="rank_join" id="rank_join">
                        <option><?php echo SELECT; ?></option>
                        <?php

			$Ranks = new Ranks();
			$result = $Ranks -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
                        <option value="<?php echo $show['rank_id']; ?>" <?php if($show_data['rank_join']==$show['rank_id']) {echo 'selected'; }?>><?php echo $show['rank_name']; ?></option>
                        <?php } ?>
                      </select></td>
				      <td class="dv-label">Joining Pay scale</td>
				      <td><input type="text" name="joining_scal" value="<?php echo $show_data['joining_scal']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Training</td>
				      <td colspan="3"><textarea name="training" id="training" class="text_area" ><?php echo $show_data['training']; ?></textarea></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Posting places</td>
				      <td colspan="3"><textarea name="posting_place" id="posting_place" class="text_area" ><?php echo $show_data['posting_place']; ?></textarea></td>
      </tr>
				    <tr>
				      <td class="dv-label">UN mission</td>
				      <td colspan="3"><textarea name="un_mission" id="un_mission" class="text_area" ><?php echo $show_data['un_mission']; ?></textarea></td>
      </tr>
				    <tr>
				      <td class="dv-label">Rewards</td>
				      <td colspan="3"><textarea name="rewards" id="rewards" class="text_area" ><?php echo $show_data['rewards']; ?></textarea></td>
      </tr>
				    <tr>
				      <td class="dv-label">Date of promotion</td>
				      <td>
					   <?php
					$promotion_date = $show_data['promotion_date'];
					$promotion_date = date('Y-m-d', strtotime($promotion_date));
					?>
					  <input type="text" name="promotion_date" class="easyui-datebox" value="<?php echo $promotion_date; ?>"/></td>
				      <td class="dv-label">&nbsp;</td>
				      <td>&nbsp;</td>
			      </tr>
				  
				    <tr>
				      <td class="dv-label">Punishments</td>
				      <td colspan="3">
			          <textarea name="punishments" id="punishments" class="text_area" ><?php echo $show_data['punishments']; ?></textarea></td>
			      </tr> 
					
					
				
				    <tr>
				      <td colspan="4" class="dv-label"><h1>Pays &amp; issues:</h1></td>
			      </tr>
				   <tr>
				      <td class="dv-label">Current Pay Scale</td>
				      <td><input type="text" name="scal" value="<?php echo $show_data['scal']; ?>" size="26" class="bng_text"/></td>
					  <td class="dv-label">Date Of Increment</td>
				      <td>
					   <?php
					$doi = $show_data['doi'];
					$doi_date = date('Y-m-d', strtotime($doi));
					?>
					  <input type="text" name="doi" class="easyui-datebox" value="<?php echo $doi_date; ?>"/></td>
			      </tr>
				    <tr>
				      
				      <td class="dv-label">Ration unit</td>
				      <td><input type="text" name="ratio_unit" value="<?php echo $show_data['ratio_unit']; ?>" size="26" class="bng_text"/></td>
			      <td class="dv-label">&nbsp;</td>
				      <td>&nbsp;</td></tr>
				    <tr>
				      <td class="dv-label">Items issued</td>
				      <td colspan="3"><textarea name="item_issued" id="item_issued" class="text_area" ><?php echo $show_data['item_issued']; ?></textarea></td>
      </tr>
				    <tr>
				      
				      <td class="dv-label">Comments:</td>
				      <td colspan="3"><textarea name="comments" id="comments" class="text_area" ><?php echo $show_data['comments']; ?></textarea></td>
			      </tr>
				  
	
      <tr>
          <td align="right">Photo</td>
          <td align="left"><img src="../../uploads/troops/<?php echo $show_data['photo']; ?>" width="70" height="80" />
		
		  
			<input type="hidden" name="cur_file" value="<?php echo $show_data ['photo'];?>"/>	
		  	<input type="file" name="file_one" id="file_one" size="32" maxlength="37" /></td><td align="right"><?php echo STATUS; ?></td>
          <td align="left"><select name="status" id="status">
            <option><?php echo SELECT; ?></option>
            <?php
	
		$statusList = Common::systemStatus();
	
		foreach($statusList as $key=>$value):
	
		?>
            <option value="<?php echo $key; ?>" <?php if($show_data['status']==$key) {echo "selected"; }?>><?php echo Common::Eng2BanStatus($key); ?></option>
            <?php endforeach; ?>
          </select></td>
      </tr>
	  <tr>

          <td align="right">&nbsp;</td>

         

          <td align="left"><input type="submit" name="Submit" value="<?php echo SAVE; ?>" /></td>
 <th align="center">&nbsp;</th>
        </tr>   
      </table>
	</form>
	
	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
</body>
</html>
<script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
<link type="text/css" rel="stylesheet" href="../css/jquery-te-1.4.0.css">
	<script>
	
$(document).ready(function() {
//grid_view();


$('#dob').datebox({
	onSelect: function(date){
		var dor = (date.getMonth()+1)+"/"+(date.getDate()-1)+"/"+(date.getFullYear()+59); 
		$('#dor').datebox('setValue', dor);
	}
});

});

	
	$(".text_area").jqte();
	
	// settings of status
	var jq_box_teStatus = true;
	$(".status").click(function()
	{
		jq_box_teStatus = jq_box_teStatus ? false : true;
		$('.text_area').jqte({"status" : jq_box_teStatus})
	});
	
	
</script>