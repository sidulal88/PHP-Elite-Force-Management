<link href="../form_msg.css" rel="stylesheet" type="text/css">
 <div id="dlg" class="easyui-dialog dataAdd" style="width:450px;height:250px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
			
        <div class="ftitle">Details Information</div>
<form id="fm" action="" enctype="multipart/form-data" method="post">
	 <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">	 

		 <tr>
          <td width="36%" align="right"><?php echo NAME; ?></td>
          <th width="4%" align="center">:</th>
          <td width="60%" align="left"><input type="text" name="name" id="name" value="<?php echo @$_POST['name']; ?>" size="32" class="bng_text" /></td>
        </tr>
        <tr>
          <td align="right"><?php echo EMAIL; ?></td>
          <th align="center">:</th>
          <td align="left"><input type="text" name="email" value="<?php echo @$_POST['email']; ?>" size="32" maxlength="30" /></td>
        </tr>
        <tr>
          <td align="right"><?php echo USER_PASSWORD; ?></td>
          <th align="center">:</th>
          <td align="left"><input type="password" name="password" value="<?php echo @$_POST['password']; ?>" size="32" maxlength="30" /></td>
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