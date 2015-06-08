<?php require_once('settings.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>
<link href="css/gallery.css" rel="stylesheet" type="text/css" />
</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
				<div class ="welcome_head">Exclusive Photo Gallery </div>
           	  <div class="pageBody">
			  <h3>
	 <?php 
		try
		{
			$i = 0;
			$Uploader = new Uploader();
			$Category = new Category();
			$result = $Category -> gets('rank', 'visitor');
			while($show = $result -> fetch_array(MYSQL_ASSOC))
			{
				$i++;
		 ?>
    <div class="img photo_box">
	<a href="gallery.php?category=<?php echo $show['id']; ?>" >
<?php echo $Uploader -> imageViewer($show['photo'], WIDTH_GALLERY_VIEW, HEIGHT_GALLERY_VIEW, '', '', '', '', 'categories/', 2); ?>
  </a><br />
<a href="gallery.php?category=<?php echo $show['id']; ?>" class="caption"><?php echo $show['name']; echo ($show['num_rec'] > 0)?str_repeat("&nbsp;", 1).'<font class=wr>('.$show['num_rec'].')</font>':'';
?></a>
</div>
<?php 
				if($i==4) {
					$i = 0;
					echo '<div style="float:left; width:100%; padding:5px 0px 0px 0px;">&nbsp;</div>';
				}
			}
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	 ?>     </h3> 
			  </div>
		
			</div>
		
			</div>
            
      </div>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>

</body>
</html>
