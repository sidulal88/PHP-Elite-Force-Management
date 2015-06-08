
<link href="../../form_msg.css" rel="stylesheet" type="text/css">

 <div id="dlg" class="easyui-dialog dataAdd" style="width:880px;height:450px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
			
        <div class="ftitle">Details Information</div>
<form id="fm" action="" enctype="multipart/form-data" method="post">
	<table width="100%" border="0"  cellpadding="2" cellspacing="3" class="details_tab dataAdd">
				  <tr>
                    <td colspan="4" class="dv-label"><h1>General information :</h1></td>
                  </tr>
         
                  <tr>
                    <td width="17%" class="dv-label">Name:</td>
                    <td width="33%"><input type="text" name="name" id="name" value="" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Unit Name </td>
                    <td><select name="police_unit" id="police_unit">
                      <option><?php echo SELECT; ?></option>
                      <?php
			
						$Unit = new Unit();
					
						$menuTree = $Unit -> getsGrid();
				
						foreach($menuTree as $show):
					
						$spacer = ($show['data_level'] > 1) ? str_repeat(" --> ", $show['data_level']-1) : '';
					?>
                      <option value="<?php echo $show['unit_id']; ?>"><?php echo $spacer.$show['unit_name']; ?></option>
                      <?php endforeach; ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Unit Brash No</td>
                    <td><input type="text" name="brash_no" id="brash_no" value="" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Present Rank</td>
                    <td><select name="present_rank" id="present_rank">
                      <option><?php echo SELECT; ?></option>
                      <?php

			$Ranks = new Ranks();
			$result = $Ranks -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
                      <option value="<?php echo $show['rank_id']; ?>"><?php echo $show['rank_name']; ?></option>
                      <?php } ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Father's name</td>
                    <td><input type="text" name="fname" id="fname" value="" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Mother's name:</td>
                    <td><input type="text" name="mname" id="mname" value="" size="26" maxlength="100"  class="bng_text"/></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Police ID </td>
                    <td width="33%"><input type="text" name="police_id" id="nid" value="" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Sex:</td>
                    <td><input type="radio" name="gender" value="Male" />
                      Male
                        <input type="radio" name="gender" value="Female" />
                    Female</td>
                  </tr>
                  <tr>
                    <td class="dv-label">Date of birth:</td>
                    <td width="33%"><input type="text" name="dob" id="dob" class="easyui-datebox"/></td>
                    <td class="dv-label">Qualification:</td>
                    <td><input type="text" name="qualification" id="qualification" value="" size="26" maxlength="100"  class="bng_text"/></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Personal contact no:</td>
                    <td width="33%"><input type="text" name="contact_no" id="contact_no" value="" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Religion</td>
                    <td><select name="religion_id" id="religion_id">
                      <option><?php echo SELECT; ?></option>
                      <?php

			$Religion = new Religion();
			$result = $Religion -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
                      <option value="<?php echo $show['religion_id']; ?>"><?php echo $show['religion_name']; ?></option>
                      <?php } ?>
                    </select></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Per. address</td>
                    <td>
					<textarea name="per_address" id="per_address" class="text_area" ></textarea></td>
                    <td width="11%" class="dv-label">Pre. address</td>
                    <td width="39%"><textarea name="pre_address" id="pre_address" class="text_area" ></textarea></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Emergency contact no:</td>
                    <td><input type="text" name="emegency_contact_no" id="emegency_contact_no" value="" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Marital status</td>
                    <td><input type="radio" name="meritial_status" value="Married" />Married
                      <input type="radio" name="meritial_status" value="Single" />
                      Single
                      <input type="radio" name="meritial_status" value="Divorced" />
Divorced
<input type="radio" name="meritial_status" value="Widowed" />
Widowed</td>
                  </tr>
                  <tr>
                    <td class="dv-label">Spouse name:</td>
                    <td><input type="text" name="spouse_name" id="spouse_name" value="" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Children no.</td>
                    <td><input type="text" name="children_no" id="children_no" value="" size="26" maxlength="100"  class="bng_text"/></td>
                  </tr>
                  <tr>
                    <td colspan="4" class="dv-label"><h1>Health information :</h1></td>
                  </tr>
                  <tr>
                    <td class="dv-label">Hight</td>
                    <td><input type="text" name="height"placeholder="X Feet Y Inch" size="26"  class="bng_text"/></td>
                    <td class="dv-label">Weight</td>
                    <td><input type="text" name="weight" placeholder="X KG" size="26" class="bng_text"/></td>
                  </tr>
				  <tr>
				    <td class="dv-label">Identification Marks</td>
				    <td><input type="text" name="identification_marks" id="identification_marks" value="" size="26" maxlength="100"  class="bng_text"/></td>
				    <td class="dv-label">Chest</td>
				    <td><input type="text" name="chest" id="chest" value="" size="26" maxlength="100"  class="bng_text"/></td>
      </tr>
				  <tr>
                    <td class="dv-label">Blood group</td>
                    <td><input type="text" name="blood_group" id="blood_group" value="" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Eye</td>
                    <td><input type="text" name="eye" id="eye" value="" size="26" maxlength="100"  class="bng_text"/></td>
                  </tr>
				    <tr>
                    <td class="dv-label">Blood Pressure</td>
                    <td><input type="text" name="bp" placeholder="80*120" size="26" maxlength="100"  class="bng_text"/></td>
                    <td class="dv-label">Last MC</td>
                    <td><input type="text" name="last_mc" class="easyui-datebox"/></td>
                  </tr>
				    <tr>
				      <td colspan="4" class="dv-label"><h1>Service record:</h1></td>
			      </tr>
				    
				    <tr><td class="dv-label">DOJ</td>
				      <td><input type="text" name="doj" class="easyui-datebox"/></td>
				      <td class="dv-label">Approximate Date of Retirement</td>
				      <td><input type="text" name="dor" id="dor" class="easyui-datebox"/></td>
				      
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
                        <option value="<?php echo $show['rank_id']; ?>"><?php echo $show['rank_name']; ?></option>
                        <?php } ?>
                      </select></td>
				      <td class="dv-label">Joining Pay scale</td>
				      <td><input type="text" name="joining_scal" id="joining_scal" value="" size="26" maxlength="100"  class="bng_text"/></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Training</td>
				      <td colspan="3"><textarea name="training" id="training" class="text_area" ></textarea></td>
			      </tr>
				    <tr>
				      <td class="dv-label">Posting places</td>
				      <td colspan="3"><textarea name="posting_place" id="posting_place" class="text_area" ></textarea></td>
      </tr>
				    <tr>
				      <td class="dv-label">UN mission</td>
				      <td colspan="3"><textarea name="un_mission" id="un_mission" class="text_area" ></textarea></td>
      </tr>
				    <tr>
				      <td class="dv-label">Rewards</td>
				      <td colspan="3"><textarea name="rewards" id="rewards" class="text_area" ></textarea></td>
      </tr>
				    <tr>
				      <td class="dv-label">Date of promotion</td>
				      <td><input type="text" name="promotion_date" class="easyui-datebox"/></td>
				      <td class="dv-label">&nbsp;</td>
				      <td>&nbsp;</td>
			      </tr>
				  
				    <tr>
				      <td class="dv-label">Punishments</td>
				      <td colspan="3">
			          <textarea name="punishments" id="punishments" class="text_area" ></textarea></td>
			      </tr>
				    <tr>
				      <td colspan="4" class="dv-label"><h1>Pays &amp; issues:</h1></td>
			      </tr>
				  
				    <tr>
				      <td class="dv-label">Current Pay Scale</td>
				      <td><input type="text" name="scal" id="scal" value="" size="26" maxlength="100"  class="bng_text"/></td>
					  <td class="dv-label">Date Of Increment</td>
				      <td><input type="text" name="doi" class="easyui-datebox"/></td>
			      </tr>
				    <tr>
				      
				      <td class="dv-label">Ration unit</td>
				      <td><input type="text" name="ratio_unit" id="ratio_unit" value="" size="26" maxlength="100"  class="bng_text"/></td>
			      <td class="dv-label">&nbsp;</td>
				      <td>&nbsp;</td></tr>
				    <tr>
				      <td class="dv-label">Items issued</td>
				      <td colspan="3"><textarea name="item_issued" id="item_issued" class="text_area" ></textarea></td>
      </tr>
				    <tr>
				      
				      <td class="dv-label">Comments:</td>
				      <td colspan="3"><textarea name="comments" id="comments" class="text_area" ></textarea></td>
			      </tr>
               
	
      <tr>
          <td align="right">Photo</td>
          <td align="left"><input type="file" name="file_one" id="file_one" size="32" maxlength="37" /></td><td align="right"><?php echo STATUS; ?></td>
          <td align="left"><select name="status" id="status">
            <option><?php echo SELECT; ?></option>
            <?php
	
		$statusList = Common::systemStatus();
	
		foreach($statusList as $key=>$value):
	
		?>
            <option value="<?php echo $key; ?>"><?php echo Common::Eng2BanStatus($key); ?></option>
            <?php endforeach; ?>
          </select></td>
      </tr>
      </table>
	  

            <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveRecord()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
   </form>
 </div>