<?php  require_once('../settings.php'); 
	$uId = $_GET['uId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include(ROOT_DIR.'/'.INCLUDE_DIR.'/title-admin.inc.php'); ?>

<link href="form_msg.css" rel="stylesheet" type="text/css" />
<style>
.menu_parent
{
	padding:5px;
	background-color:#EBEBEB;
	
}
</style>
</head>

<body>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> <?php include('adminHead.php');?></td>
  </tr>
  <tr>
    <td height="328" valign="top" class="ad_color">
    
 <div class="title_nav_bar">
       <h1><?php echo USER_MANAGEMENT; ?></h1>
	 <h2><?php echo ACCESS_MENU_LIST; ?></h2>

	 </div>
<form action="saveAccess.php?uId=<?php echo $uId; ?>" enctype="multipart/form-data" method="post">
	<input type="hidden" name="id" value="<?php echo $uId; ?>" />
	  <table border="0" cellpadding="1" cellspacing="1" width="100%" class="listTab">

		<thead>
	  <tr>

	    <th width="31%" align="right"><?php echo ACCESS_MENU_LIST; ?></th>

	    <th width="3%" align="center">:</th>

	    <th width="66%" align="left"><?php echo PERMITED; ?></th>
	    </tr>
		</thead>
		<tbody>
<?php		  

try

{
	
	$Admin = new Admin();
	$result = $Admin -> getUser($uId);
	$show = $result -> fetch_array(MYSQL_ASSOC);
	$access_menus = explode(",", $show['menu_ids']);

if(isset($_POST['btnAdd'])) {
		
		$_POST['menu_ids'] = implode(",", $_POST['menu_list']);

		$Admin->saveUser();

	}
	$Menu = new Menu();
	

	$resultMenu = $Menu -> gets(" AND menu_parent_id IS NULL ORDER BY menu_sort ASC");
	
	while($showMenu = $resultMenu->fetch_array(MYSQL_ASSOC))

		{
			$is_checked = (in_array($showMenu['menu_id'], $access_menus)) ? 'checked="checked"'  : ' ';
			
?>
        <tr>

	  <tr class="menu_parent">

	    <td align="right"><?php echo $showMenu['menu_name']; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="checkbox" name="menu_list[]" id="checkbox" value="<?php echo $showMenu['menu_id']; ?>" <?php echo $is_checked; ?> /></td>
	    </tr>
                    <?php
						$resultChild = $Menu -> gets(" AND menu_parent_id=".$showMenu['menu_id']."  ORDER BY menu_sort ASC");
						
						while($showChild = $resultChild->fetch_array(MYSQL_ASSOC))
					
							{
								$is_child_checked = (in_array($showChild['menu_id'], $access_menus)) ? 'checked="checked"'  : ' ';
					?>
	  <tr>

	    <td align="right"><?php echo $showChild['menu_name']; ?></td>

	    <th align="center">:</th>

	    <td align="left"><input type="checkbox" name="menu_list[]" id="checkbox" value="<?php echo $showChild['menu_id']; ?>" <?php echo $is_child_checked; ?> /></td>
	    </tr>                    

<?php
							}
		}
}

catch(Exception $e)

{

	echo $e->getMessage();

}

?>	

        <tr>

          <td align="right">&nbsp;</td>

          <th align="center">&nbsp;</th>

          <td align="left"><input type="submit" name="btnAdd" value="<?php echo SAVE; ?>" /></td>

        </tr>
</tbody>      </table>

	</form>
	
    </td>
  </tr>
</table>
<?php include('footer.php');?>
</body>
</html>