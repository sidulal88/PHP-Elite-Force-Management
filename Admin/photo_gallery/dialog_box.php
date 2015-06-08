
<link href="../../form_msg.css" rel="stylesheet" type="text/css">

 <div id="dlg" class="easyui-dialog dataAdd" style="width:660px;height:500px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
			
        <div class="ftitle">Details Information</div>
<form id="fm" action="" enctype="multipart/form-data" method="post">
	 <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">
<tr>
    <td width="19%" align="right">Category Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		<select name="category" id="category">
			<option><?php echo SELECT; ?></option>
				<?php

			$Category = new Category();
		
			$result = $Category -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
	
				  <option value="<?php echo $show['id']; ?>"><?php echo $show['name']; ?></option>
	
	<?php } ?>
	
	    </select>   	  </td>

       </tr>  

	  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="title" id="title" value="" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">Rank</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="rank" id="rank" value="" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
		<tr>
            <td align="right">Description</td>
            <th align="center"></th>
            <td align="left"><textarea name="description" id="description" class="text_area" cols="40"></textarea>
			
</td>
        </tr>
		
	   <tr>

          <td align="right"><?php echo PHOTO; ?></td>

          <th align="center">:</th>

          <td align="left">

		  	<input type="file" name="photo" id="photo" size="32" maxlength="37" />::Recommended  size : 480px*240px
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