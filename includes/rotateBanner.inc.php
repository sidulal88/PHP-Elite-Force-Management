<link href="css/style.css" rel="stylesheet" type="text/css">
<script src="js/jqFancyTransitions.1.8.js" type="text/javascript"></script>
<script>
$(document).ready( function(){

	$('#slideshowHolder').jqFancyTransitions({ 
											 
					effect: 'zipper', // wave, zipper, curtain
					width: 480, // width of panel
					height: 240, // height of panel
					strips: 20, // number of strips
					delay: 5000, // delay between images in ms
					stripDelay: 70, // delay beetwen strips in ms
					titleOpacity: 0.7, // opacity of title
					titleSpeed: 2500, // speed of title appereance in ms
					position: 'alternate', // top, bottom, alternate, curtain
					direction: 'random', // left, right, alternate, random, fountain, fountainAlternate
					navigation: false, // prev and next navigation buttons
					links: false // show images as links	
											 
			});
});
</script>

<div id="banner">

<div id='slideshowHolder'>
			<?php
			try 
			{
				
				$Uploader = new Uploader();
				$Banner = new Banner();
				$result = $Banner -> gets(" AND status='active' ");
				while($show = $result->fetch_array(MYSQL_ASSOC))
				{
				$imagePath = "uploads/sliders/".$show['photo'];
				$imageView = "uploads/sliders/".$show['photo'];
				
		  		if($show['photo']=='' || !is_file($imagePath)) {
					$photoPrint = 'images/no_photo.jpg';
				}
				else if($show['photo']) {
						$photoPrint = $imageView;		 
					}				
		?>
		<img src='<?php echo $photoPrint; ?>' alt='<?php echo $show['title']; ?>' width="480" height="240"  />
		
		<?php
			}	
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
			}
		?>

<!---
 <img src='images/slider/slider_1.jpg' alt='Welcome to the oficial website of Industrial Police' width="480" height="240"  />
 <img src='images/slider/slider_2.jpg' alt='Welcome to the oficial website of Industrial Police' width="480" height="240"  />
 <img src='images/slider/slider_3.jpg' alt='Welcome to the oficial website of Industrial Police' width="480" height="240"  />
 <img src='images/slider/slider_4.jpg' alt='Welcome to the oficial website of Industrial Police' width="480" height="240"  />
 --->
</div>
</div>