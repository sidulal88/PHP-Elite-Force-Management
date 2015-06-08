<link href="../form_msg.css" rel="stylesheet" type="text/css">
 <div id="dlg" class="easyui-dialog dataAdd" style="width:550px;height:400px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
			
        <div class="ftitle">Details Information</div>
<form id="fm" action="" enctype="multipart/form-data" method="post">
	 <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">	
<tr>

	    <td align="right">Designation</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="designation_name" value="" size="26" maxlength="60" class="bng_text" /> - Add Unit <input type="checkbox" value="1" name="add_unit" /></td>
	    </tr>


<tr>

	    <td align="right">Phone</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="phone" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>


<tr>

	    <td align="right">Mobile</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="mobile" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
        <tr>


<tr>

	    <td align="right">Fax</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="fax" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
        <tr>


<tr>

	    <td align="right">Email</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="email" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>
        <tr>

<tr>
    <td width="19%" align="right">Unit Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="unit" id="unit">
			<option><?php echo SELECT; ?></option>
				<?php

			$Unit = new Unit();
		
			$menuTree = $Unit -> getsGrid2();
	
			foreach($menuTree as $show):
		
			$spacer = ($show['data_level'] > 1) ? str_repeat(" --> ", $show['data_level']-1) : '';
		?>
	
				  <option value="<?php echo $show['unit_id']; ?>"><?php echo $spacer.$show['unit_name']; ?></option>
	
	<?php endforeach; ?>
	    </select>   	  </td>

       </tr>  


<tr>

	    <td align="right">Sort/ sl No.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="_sort" value="" size="26" maxlength="60" class="bng_text" /></td>
	    </tr>

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