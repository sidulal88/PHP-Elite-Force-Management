<?php
	Common::isLogedIn();
	Menu::checkAccess();
?>
        <link rel="stylesheet" type="text/css" href="../public/themes/default/easyui.css"/>
        <link rel="stylesheet" type="text/css" href="../public/themes/icon.css"/>
		
<link type="text/css" rel="stylesheet" href="../css/jquery-te-1.4.0.css">
     <script type="text/javascript" src="../public/js/jquery-1.7.2.js"></script>		
<script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
		
   
        <script type="text/javascript" src="../public/js/jquery.easyui.min.js"></script>
        <script type="text/javascript" src="../public/js/jquery.treegrid.js"></script>
		<!---------
		
		
        <script type='text/javascript' src='../public/fancy_light_box/jquery.fancybox.js'></script>
        <script type='text/javascript' src='../public/menu/js/superfish.js'></script>
        <script type='text/javascript' src='../public/menu/js/hoverIntent.js'></script>
        <script type='text/javascript' src='../public/js/headerScript.js'></script>
		---------->
        <script type='text/javascript' src='../public/js/ajax.js'></script>
        <script type='text/javascript' src='../public/js/jquery.validate.min.js'></script>

<link href="../style_admin.css" rel="stylesheet" type="text/css">
<link href="../css/simple_menu.css" rel="stylesheet" type="text/css" />
<table width="980" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="112" class="main_head"> 
    <h2><?php echo COMPANY_NAME; ?></h2> 
    <span>
    <h3><a href="<?php echo SITE_URL; ?>" class="url" target="_blank"><?php echo SITE_VISITE; ?></a> &nbsp;|&nbsp; <a href="../logout.php" class="url"><?php echo LOG_OUT; ?></a> </h3> 
    <h4><?php echo WELCOME; ?> :<?php echo $_SESSION['userName']; ?> <br /> <a href="../users/password_change.php"  class="url_pass">Change Password ? </a></h4>  
    </span>   </td>
  </tr>
  <tr>
    <td width="16"  >
    
<ul class="admin_menu">
 
           <!--- <li><a href="banglaKeyboard.php"><?php echo BANGLA_KEYBOARD; ?></a></li>--->
<?php

try

{

	$Menu = new Menu();
	

	$result = $Menu -> gets(" AND menu_parent_id IS NULL AND menu_view='yes' ORDER BY menu_sort ASC");
	
	while($show = $result->fetch_array(MYSQL_ASSOC))

		{
?>            
			<li><a href="#"><?php echo $show['menu_name']; ?></a>
					<ul>
                    <?php
						$resultChild = $Menu -> gets(" AND menu_parent_id=".$show['menu_id']." AND menu_view='yes'  ORDER BY menu_sort ASC");
						
						while($showChild = $resultChild->fetch_array(MYSQL_ASSOC))
					
							{
					?>
						<li><a href="<?php echo $showChild['menu_target']; ?>"><?php echo $showChild['menu_name']; ?></a></li>
                        <?php } ?>
					</ul>
				</li>
				
<?php
	}
		}
catch(Exception $e)

	{

		echo $e->getMessage();

	}


?>	                
    </ul>


    
           
            </td>
  </tr>
</table>
