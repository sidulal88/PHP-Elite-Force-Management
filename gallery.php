<?php require_once('settings.php');
	$category = $_REQUEST['category'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>

<link href="<?php echo CSS_DIR; ?>/gallery.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_DIR; ?>/pagination.css" rel="stylesheet" type="text/css" />
<link href="<?php echo CSS_DIR; ?>/pagination_grey.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="fancybox/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="fancybox/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

	<script type="text/javascript">
		$(document).ready(function() {

			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

		});
	</script>
</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
           	  	<div class="navigation_bar">  <a href="gallery_categories.php"><?php echo EXCLUSIVE_PHOTOGALLERY; ?></a> <?php echo PHOTO_LIST; ?></div>
			  <div class="pageBody">
		

         <?php
try

{
	$Category = new Category();
	$Category_name = $Category -> getName($category);
	$Uploader = new Uploader();
	$Photo = new Photo();
	//-----------------------
	$pagination_query = $Photo -> gets(" AND category=$category");
    $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    $limit = 6;
    $startpoint = ($page * $limit) - $limit;
	$table = "photo";
	$condition = " AND category=$category LIMIT {$startpoint} , {$limit}";
	$ViewStart = $startpoint+1;
	$checkPoint = $ViewStart+$limit;
	$ViewEnd = ($pagination_query->num_rows >=$checkPoint) ?$checkPoint-1 : $pagination_query->num_rows;
?>	           <div class="pcaption"><?php echo ' :: '.$Category_name.str_repeat("&nbsp;", 2); ?></div>
            <h3><table width="100%" border="0" cellspacing="5">
	  <tr>
		  <td class="paigination_header" colspan="3"><?php	echo Common::displayRecordStatus($pagination_query->num_rows, $ViewStart, $ViewEnd); ?></td>
		  </tr>

<?php

	$result = $Photo -> gets($condition);
		$sl = 0;
		while($show = $result->fetch_array(MYSQL_ASSOC))
		{
			$sl ++;
		if($sl==0)
		echo "<tr>";
		
			    $imagePath = ROOT_DIR.UPLOAD_DIR.'/photos/'.$show['photo_large'];
				if($show['photo_large']=='' || !is_file($imagePath)) {
					$photoPrint = 'images/noPhoto.jpg';
					$photoLink = 'images/noPhoto.jpg';
				}
				else if($show['photo_large']) {
						$photoPrint = UPLOAD_DIR.'/photos/'.$show['photo_thumb'];			 
						$photoLink = UPLOAD_DIR.'/photos/'.$show['photo_large'];			 
					}
		
?>    
		  <td class="img photo_box">
		  
		  <a rel="example_group" href="<?php echo $photoLink; ?>" title="<?php echo $show['title']; ?>">
<img src="<?php echo $photoPrint; ?>" width="<?php echo WIDTH_GALLERY_VIEW; ?>" height="<?php echo HEIGHT_GALLERY_VIEW; ?>" alt="nmbn"  />
  </a><br /><a href="gallery_details.php?p_id=<?php echo $show['id']; ?>" class="caption"><?php echo $show['title'];?></a></td>          
<?php 
				if($sl==3) {
					$sl = 0;
					echo '</tr>';
				}
			}
?>
<tr><td colspan="3" class="paiginationArea"><?php echo Common::pagination($table,$pagination_query->num_rows, $limit,$page, 'gallery.php?category='.$_REQUEST['category'].'&'); ?></td></tr>
<?php
		}
		catch(Exception $e)
		{
			echo " <div style='width:100%; padding:40px;'>".$e->getMessage()."</ div>";
		}
	 ?>		  
		  </table></h3>
			  </div>
		
			</div>
		
			</div>
            
      </div>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>

</body>
</html>
