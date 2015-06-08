<link href="../form_msg.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/javascript" src="EditorEquipment/wysiwyg.js"></script>
 <div id="dlg" class="easyui-dialog dataAdd" style="width:800px;height:520px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
			
        <div class="ftitle">Details Information</div>
<form id="fm" action="" enctype="multipart/form-data" method="post">
	 <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">	 

<tr>
    <td width="19%" align="right">Unit Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="unit_id" id="unit_id">
			<option><?php echo SELECT; ?></option>
				<?php

			$Unit = new Unit();
		
			$result = $Unit -> gets(" AND is_industry=1 AND data_level > 1 ");
	
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
	
				  <option value="<?php echo $show['unit_id']; ?>"><?php echo $show['unit_name']; ?></option>
	
	<?php } ?>
		
		s
	    </select>   	  </td>

       </tr>  

<tr>
    <td width="19%" align="right">Sort</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left"><input type="text" name="sort" value="" size="26" maxlength="60" class="bng_text" /></td>

       </tr>
		<tr>

	    <td align="right">Description</td>

	    <th align="center">:</th>

	    <td align="left">
		
			 <textarea name="description" id="description" class="bng_text" cols="34" rows="6">&nbsp;</textarea>

					<script language="javascript1.1">

										  generate_wysiwyg('description',650,300);

										</script></td>
	    </tr>
        <tr>
 <tr>

          <td align="right">Unit Map</td>

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