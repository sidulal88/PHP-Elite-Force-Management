<link href="../form_msg.css" rel="stylesheet" type="text/css">
 <div id="dlg" class="easyui-dialog dataAdd" style="width:620px;height:550px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
			
        <div class="ftitle">Details Information</div>
<form id="fm" action="" enctype="multipart/form-data" method="post">
	 <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">	 
		<tr>

	    <td align="right">Industry Name</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="industry_name" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
        <tr>		
		
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

	    <td align="right">Owner</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="owner" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
        <tr>		
		<tr>

	    <td align="right">Contact Person</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="contact_person" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>		
		<tr>

	    <td align="right">Contact No</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="contact_no" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
		 <tr>
            <td align="right">Address</td>
            <th align="center"></th>
            <td align="left"><textarea name="address" id="address" class="text_area" cols="30" rows="4"></textarea>
			
</td>
        </tr>
				<tr>

	    <td align="right">Worker</td>

	    <th align="center">:</th>

	    <td align="left">
		<input type="text" name="worker_male"size="14"class="bng_text" placeholder="Male" />
		<input type="text" name="worker_female"size="14"class="bng_text" placeholder="Female" />
		</td>
	    </tr>
        <tr>
<tr>
    <td width="19%" align="right">Product</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="product_id" id="product_id">
			<option><?php echo SELECT; ?></option>
				<?php

			$Product = new Product();
			$result = $Product -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
	
				  <option value="<?php echo $show['productid']; ?>"><?php echo $show['productname']; ?></option>
	
	<?php } ?>
	    </select>   	  </td>

       </tr>
		<tr>

	    <td align="right">Member Ship</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="member_ship" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
		<tr>

	    <td align="right">Remarks</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="remarks" value="" size="38" maxlength="60" class="bng_text" /></td>
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