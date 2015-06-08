<link href="../form_msg.css" rel="stylesheet" type="text/css">
 <div id="dlg" class="easyui-dialog dataAdd" style="width:550px;height:200px;padding:10px 20px"
            closed="true" buttons="#dlg-buttons">
			
        <div class="ftitle">Details Information</div>
<form id="fm" action="" enctype="multipart/form-data" method="post">
	 <table border="0" cellpadding="1" cellspacing="1" width="100%" class="dataAdd">	 

<!---<tr>
    <td width="19%" align="right">Troops Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		  <input type="text" name="troops_id" value="<?php echo $troops_id; ?>" />
		 	  </td>

       </tr>  

<tr>
    <td width="19%" align="right">Troops Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
		  
		<select name="troops_id" id="troops_id">
			<option><?php echo SELECT; ?></option>
				<?php

			$Troops = new Troops();
		
			$result = $Troops -> gets();
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
		?>
	
				  <option value="<?php echo $show['troops_id']; ?>"><?php echo $show['name']; ?></option>
	
		<?php } ?>
	    </select>   	  </td>

       </tr>  

--->		<tr>

	    <td align="right">Leave Type</td>

	    <th align="center">:</th>

	    <td align="left"><input type="radio" name="leave_type" value="Earn" />Earn
                      <input type="radio" name="leave_type" value="Casual" />
                      Casual</td>
	    </tr> 
		
		<tr>

	    <td align="right">From Date</td>

	    <th align="center">:</th>

	    <td align="left"> <input type="text" name="start_date" class="easyui-datebox"/></td>
	    </tr>

<tr>

	    <td align="right">To Date</td>

	    <th align="center">:</th>

	    <td align="left"> <input type="text" name="end_date" class="easyui-datebox"/></td>
	    </tr>
<!------
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
--->
      </table>
	  

            <div id="dlg-buttons">
        <a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveRecord()" style="width:90px">Save</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
    </div>
	</form>
	</div>