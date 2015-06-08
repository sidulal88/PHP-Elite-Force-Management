<?php  require_once('../../settings.php');
	$tender_id = $_REQUEST['tender_id'];

	
try

{
	$Uploader = new Uploader();

	$Tenders = new Tenders();

	$result = $Tenders -> get($tender_id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);

	if(isset($_POST['Submit'])) {
	
		$Tenders -> edit();
		echo "<script type=\"text/javascript\">location.replace(\"record_edit.php?tender_id=$tender_id\");</script>";

	}

}

catch(Exception $e)

{

	echo $e->getMessage();

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>
<link href="../form_msg.css" rel="stylesheet" type="text/css" />




</head>

<body>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php include(ROOT_DIR.'Admin/adminHead.php');?></td>
  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
    <h1>Directory Entry</h1>
	 <h2><?php echo EDIT; ?></h2>
	<h3> <a href="index.php" class="link_button">Record List</a></h3>
	 </div>
     <div class="easyui-layout" style="height:330px; margin: auto;">  
    <div title="Tender Info." data-options="region:'center'" class="easyui-panel" >  
<form action="record_edit.php?tender_id=<?php echo $tender_id; ?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="tender_id" value="<?php echo $tender_id; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
      <tr><td colspan="3"><?php //include('bangla_keyboard.php');?></td></tr>
 <tr>
          <td colspan="3" class="msg">
 </td>

          </tr>
		  <tr>

	    <td align="right">Title</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="title" id="title" value="<?php echo $show_data['title']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">Tender No</td>

	    <th align="center">:</th>

	    <td align="left"><input type="text" name="tender_no" id="tender_no" value="<?php echo $show_data['tender_no']; ?>" size="26" maxlength="100"  class="bng_text"/></td>
	    </tr>
		
	  <tr>

	    <td align="right">Tender Date</td>

	    <th align="center">:</th>

	    <td align="left"> 
		<?php
						
		$date = $show_data['date'];
		$selected_date = date('Y-m-d', strtotime($date));
		?>
		<input type="text" name="date" value="<?php echo $selected_date; ?>"  class="easyui-datebox"/>
		
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
	
				  <option value="<?php echo $show['unit_id']; ?>" <?php if($show_data['unit_id']==$show['unit_id']) {echo 'selected'; }?>><?php echo $spacer.$show['unit_name']; ?></option>
	
	<?php endforeach; ?>
	    </select>   	  </td>

       </tr>  

	   
	   <tr>

          <td align="right">Tender Attachment</td>

          <th align="center">:</th>

          <td align="left">
		  <?php 
		  	 $file_ext = pathinfo($show_data['attachment'], PATHINFO_EXTENSION);
		  	 $image_ext = array('jpg', 'jpeg', 'gif', 'png');
			if (!in_array($file_ext, $image_ext)) {
			
				?>
					<a href="../../uploads/tender/<?php echo $show_data['attachment']; ?>" target="_blank" style="text-decoration:none; color:#0000CC"><img src="../../images/download_icon.png" /></a>
			<?php
			}
			else
			{
			?>
				<img src="../../uploads/tender/<?php echo $show_data['attachment']; ?>" width="70" height="80" />
		<?php
			}
		  
		    ?>
		  
			<input type="hidden" name="cur_file" value="<?php echo $show_data['attachment'];?>"/>	
		  	<input type="file" name="file_one" id="file_one" size="32" maxlength="37" />		  </td>
        </tr>
		
	  <tr>

	    <td align="right">Schedule Date</td>

	    <th align="center">:</th>

	    <td align="left"> 

		<input type="text" name="schedule_date" value="<?php echo $show_data['schedule_date']; ?>"  class="easyui-datetimebox"/>
		
		</td>
	    </tr>
	    
	   <tr>

          <td align="right">Schedule Attachment</td>

          <th align="center">:</th>

          <td align="left">
		  <?php 
		  	 $file_ext2 = pathinfo($show_data['tender_schedule'], PATHINFO_EXTENSION);
			if (!in_array($file_ext2, $image_ext)) {
			
				?><a href="../../uploads/tender/<?php echo $show_data['tender_schedule']; ?>" target="_blank" style="text-decoration:none; color:#0000CC">
				<img src="../../images/download_icon.png" /></a>
			<?php
			}
			else
			{
			?>
				<img src="../../uploads/tender/<?php echo $show_data['tender_schedule']; ?>" width="70" height="80" />
		<?php
			}
		  
		    ?>
		  
			<input type="hidden" name="cur_file2" value="<?php echo $show_data ['tender_schedule'];?>"/>	
		  	<input type="file" name="file_two" id="file_two" size="32" maxlength="37" />	  </td>
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
            <option value="<?php echo $key; ?>" <?php if($show_data['status']==$key) {echo 'selected'; }?>><?php echo Common::Eng2BanStatus($key); ?></option>
            <?php endforeach; ?>
          </select></td>
        </tr>
        <tr>

          <td align="right">&nbsp;</td>

          <th align="center">&nbsp;</th>

          <td align="left"><input type="submit" name="Submit" value="<?php echo SAVE; ?>" /></td>

        </tr>        <tr>
            <td align="right">&nbsp;</td>
            <th align="center">&nbsp;</th>
            <td align="left">&nbsp;</td>
        </tr>
      </table>
	</form>
	
	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
    </div>
</div>
</body>
</html>