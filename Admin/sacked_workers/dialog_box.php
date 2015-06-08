
<link href="../form_msg.css" rel="stylesheet" type="text/css" />
 <div id="dlg" class="easyui-dialog dataAdd" style="width:680px;height:520px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
			
        <div class="ftitle">Details Information</div>
<form id="fm" action="" enctype="multipart/form-data" method="post" novalidate>
	 <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">

	  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="name" id="name" value="" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">NID No.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="nid" id="nid" value="" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>	
	  <tr>

	    <td align="right">Contact No</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="contact_no" id="contact_no" value="" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
		<tr>

	    <td align="right">Address</td>

	    <th align="center">:</th>

	    <td align="left"><textarea name="per_address" id="per_address" class="text_area" style="width:400px;"></textarea></td>
	    </tr>
			
		<tr>

	    <td align="right">Sacked From</td>

	    <th align="center">:</th>

	    <td align="left"><textarea name="sacked_from" id="sacked_from" class="text_area" style="width:400px;"></textarea></td>
	    </tr>
		
		
	  <tr>

	    <td align="right">Sacked Date</td>

	    <th align="center">:</th>

	    <td align="left"> <input type="text" name="sacked_date" class="easyui-datebox"/></td>
	    </tr>
	   <tr>
<tr>

	    <td align="right">Sacked Reson</td>

	    <th align="center">:</th>

	    <td align="left"><textarea name="reson" id="reson" class="text_area" style="width:400px;"></textarea></td>
	    </tr>
		
          <td align="right">Photo</td>

          <th align="center">:</th>

          <td align="left">
			
		  	<input type="file" name="file_one" id="photo" size="32" maxlength="37" />::Recommended  size : 450px*253px
		  </td>

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
