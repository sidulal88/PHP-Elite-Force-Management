<?php require_once('settings.php');
	$p_id = $_REQUEST['p_id'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>
<link href="<?php echo CSS_DIR; ?>/gallery.css" rel="stylesheet" type="text/css" />
</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
			<?php 
		try
		{
			$Uploader = new Uploader();
			$Photo = new Photo();
			$Category = new Category();
			$result = $Photo->get($p_id);
			$show = $result -> fetch_array(MYSQL_ASSOC);
			$category_name = $Category->getName($show['category']);

		 ?>
			<div class="navigation_bar"><a href="gallery_categories.php"><?php echo EXCLUSIVE_PHOTOGALLERY; ?></a><a href="gallery.php?category=<?php echo $show['category']; ?>"><?php echo $category_name; ?></a>  <?php echo DETAILS; ?>
		   
		   </div>
           	  <div class="pageBody">

           
            <div class="pcaption"><div class="category"><?php echo $category_name; ?></div></div>
            <h3>
            <div class="title"><?php echo $show['title']; ?></div>
		<div style="float:none; widht:200; padding:0px 5px 5px 0px;">
        
<?php 

		 if($show['photo_large']) {
			    $imagePath = ROOT_DIR.UPLOAD_DIR.'/photos/'.$show['photo_large'];
			    $linkPath = '#';
				$imageInfo = getimagesize($imagePath);		
				$width = $imageInfo[0];
				$width = ($imageInfo[0] < WIDTH_RANGE) ? $imageInfo[0] : WIDTH_RANGE;
				$height = ($imageInfo[1] < HEIGHT_RANGE) ? $imageInfo[1] : HEIGHT_RANGE;
			 
				echo $Uploader -> imageViewer($show['photo_large'], $width, $height, $linkPath, '', '', '', 'photos/', 2);
			}
			 ?>
			</div>
            <div class="writer"><?php echo $show['title']; ?></div>
			<?php echo $show['description']; ?>            </h3>
            
       <?php
       	}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	   ?>
			  </div>
		
			</div>
		
			</div>
            
      </div>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>

</body>
</html>
