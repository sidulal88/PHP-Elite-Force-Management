<?php  require_once('../../settings.php');
	$industry_id = $_REQUEST['industry_id'];

	
try

{
	$Industry = new Industry();

	$result = $Industry -> get($industry_id);

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
	 <h2>Details</h2>
	<h3> <a href="index.php" class="link_button">Record List</a></h3>
	 </div>
     <div class="easyui-layout" style="height:300px; margin: auto;">  
    <div title="Industry Details" data-options="region:'center'" class="easyui-panel" >  
	  <table border="0" cellpadding="1" cellspacing="1" width="100%"  class="dataAdd">
		  <tr>

	    <td align="right">Industry Name</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['industry_name']; ?></td>
	    </tr>
        <tr>		
		
<tr>
    <td width="19%" align="right">Unit Name</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
				<?php

			$Unit = new Unit();
		
			$menuTree = $Unit -> get($show_data['unit_id']);
			
			$Unit = new Unit();
			$result = $Unit -> get($show_data['unit_id']);
			$show = $result->fetch_array(MYSQL_ASSOC);
			echo $show['unit_name'];	
		?>
	 	  </td>

       </tr>  

		<tr>

	    <td align="right">Owner</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['owner']; ?></td>
	    </tr>
        <tr>		
		<tr>

	    <td align="right">Contact Person</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['contact_person']; ?></td>
	    </tr><tr>

	    <td align="right">Contact No</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['contact_no']; ?></td>
	    </tr>
		 <tr>
            <td align="right">Address</td>
            <th align="center"></th>
            <td align="left"><?php echo $show_data['address']; ?></td>
        </tr>
				<tr>

	    <td align="right">Worker</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['worker_male']; ?><?php echo $show_data['worker_female']; ?>
		</td>
	    </tr>
        <tr>
<tr>
    <td width="19%" align="right">Product</td>

          <th width="3%" align="center">:</th>

          <td width="78%" align="left">
				<?php

			$Product = new Product();
			$result = $Product -> get($show_data['product_id']);
			$show = $result->fetch_array(MYSQL_ASSOC);
			echo $show['productname'];	
			?>  </td>

       </tr>
	
		<tr>

	    <td align="right">Member Ship</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['member_ship']; ?></td>
	    </tr>

	
		<tr>

	    <td align="right">Remarks</td>

	    <th align="center">:</th>

	    <td align="left"><?php echo $show_data['remarks']; ?></td>
	    </tr>

      <tr>
          <td align="right"><?php echo STATUS; ?></td>
          <th align="center">:</th>
          <td align="left"><?php echo $show_data['status']; ?></td>
        </tr>
        
      </table>
	 </div>
</div>
	
    </td>
  </tr>
</table>
<?php //include('footer.php');?>
   
</body>
</html>