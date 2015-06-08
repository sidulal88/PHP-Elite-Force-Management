<?php require_once('settings.php');
	$n_id = $_REQUEST['n_id'];
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
			<div class="pageBody" >
			<?php 
		try
		{
			$Uploader = new Uploader();
			$News = new News();
			$result = $News->get($n_id);
			$show = $result -> fetch_array(MYSQL_ASSOC);


		 ?>
            <div class="pcaption"><div class="welcome_head"><?php //echo $category_name; ?>News Details</div>
            <div class="date">
            <?php echo $show['news_date'] ? Common::converToDisplayDate($show['news_date']) : ''; ?><br />
				<?php 
				$weeks_day = date('D', strtotime($show['news_date']));
				echo Common::banglaDay($weeks_day); 
				?>
                <br />
			</div></div>
            <h3>
            <div class="title_details"><?php echo $show['title']; ?></div>
		<div style="float:none; widht:200; padding:0px 5px 5px 0px;">
        
<?php 

		 if($show['photo']) {
		 		$imagePath = "uploads/newses/".$show['photo'];
				$imageInfo = getimagesize($imagePath);		
				$width = $imageInfo[0];
				$width = ($imageInfo[0] < WIDTH_RANGE) ? $imageInfo[0] : WIDTH_RANGE;
				$height = ($imageInfo[1] < HEIGHT_RANGE) ? $imageInfo[1] : HEIGHT_RANGE;
			 
				echo $Uploader -> imageViewer($show['photo'], $width, $height, '', '', '', '', 'newses/', 2);
			}
			 ?>
			</div>
            <div class="writer"><?php echo $show['title']; ?></div>
			<?php 
			
			echo $show['description']; ?>         
            
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
