<?php  require_once('../../settings.php');
	$sacked_worker_id = $_REQUEST['sacked_worker_id'];

	
try

{
	$Sacked_Workers = new Sacked_Workers();

	$result = $Sacked_Workers -> get($sacked_worker_id);

	$show_data = $result -> fetch_array(MYSQL_ASSOC);

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
	 <h2>DETAILS</h2>
	<h3> <a href="index.php" class="link_button">Record List</a></h3>
	 </div>
     <div class="easyui-layout" style="height:350px; margin: auto;">  
    <div title="Sacked Worker" data-options="region:'center'" class="easyui-panel" >  
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
     
		  <tr>

	    <td align="right"><?php echo NAME; ?></td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['name']; ?></td>
	    </tr>
		
		 <tr>

	    <td align="right">NID No.</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['nid']; ?></td>
	    </tr>	
	  <tr>

	    <td align="right">Contact No</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['contact_no']; ?></td>
	    </tr>
		
		<tr>

	    <td align="right">Address</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['per_address']; ?></td>
	    </tr>
			
		<tr>

	    <td align="right">Sacked From</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['sacked_from']; ?></td>
	    </tr>
		
		
	  <tr>

	    <td align="right">Sacked Date</td>

	    <th align="center">:</th>

	    <td align="left">

		
		<?php echo ($show_data['sacked_date'] > '1970-01-01') ? Common::converToDisplayDate($show_data['sacked_date']) : ' ';?>
		</td>
	    </tr>
	   <tr>
<tr>

	    <td align="right">Sacked Reson</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['reson']; ?></td>
	    </tr>
	   
	   <tr>

          <td align="right">Photo</td>

          <th align="center">:</th>

          <td align="left">
		
				<img src="../../uploads/sacked/<?php echo $show_data['photo']; ?>" width="70" height="80" />
		
		   </td>
        </tr>

	   
      <tr>
          <td align="right"><?php echo STATUS; ?></td>
          <th align="center">:</th>
          <td align="left"><?php echo $show_data['status']; ?></td>
        </tr>

      </table>

	
	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
    </div>
</div>
</body>
</html>