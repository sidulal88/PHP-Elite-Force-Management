
<link href="../form_msg.css" rel="stylesheet" type="text/css" />
 <div id="dlg" class="easyui-dialog dataAdd" style="width:520px;height:340px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
			
        <div class="ftitle">Details Information</div>
<form id="fm" action="" enctype="multipart/form-data" method="post">
	 <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">

	  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="title" id="title" value="" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">Act. No.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="rules_no" id="rules_no" value="" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		<tr>

	    <td align="right">Sort No.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="sort_no" id="sort_no" value="" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">Link.</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="link" id="link" value="" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
	   <tr>

          <td align="right">Attachment</td>

          <th align="center">:</th>

          <td align="left">

		  	<input type="file" name="file_one" id="file_one" size="32" maxlength="37" />::Recommended  size : 450px*253px
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