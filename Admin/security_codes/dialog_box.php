<link href="../form_msg.css" rel="stylesheet" type="text/css">
 <div id="dlg" class="easyui-dialog dataAdd" style="width:450px;height:300px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
			
        <div class="ftitle">Details Information</div>
<form id="fm" action="" enctype="multipart/form-data" method="post">
	 <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">	 

<tr>
    <td width="19%" align="right">Security Type</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="type" id="type">
			<option><?php echo SELECT; ?></option>
				  <option value="troops_profile">Troops Profile</option>
				  <option value="sacked_worker">Sacked Worker</option>
	    </select>   	 
		 </td>

       </tr>  

<tr>
    <td width="19%" align="right">Unit Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="unit_id" id="unit_id">
			<option><?php echo SELECT; ?></option>
				<?php

			$Unit = new Unit();
		
			$menuTree = $Unit -> getsGrid(" AND is_industry=1 ");
	
			foreach($menuTree as $show):
		
			$spacer = ($show['data_level'] > 1) ? str_repeat(" --> ", $show['data_level']-1) : '';
		?>
	
				  <option value="<?php echo $show['unit_id']; ?>"><?php echo $spacer.$show['unit_name']; ?></option>
	
	<?php endforeach; ?>
	    </select>   	  </td>

       </tr>  

		<tr>

	    <td align="right">Security Code</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="security_code" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
        <tr>

      <tr>
          <td align="right"><?php echo STATUS; ?></td>
          <th align="center">:</th>
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