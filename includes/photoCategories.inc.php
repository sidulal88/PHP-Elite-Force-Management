<li class="selected_page"><?php echo EXCLUSIVE_PHOTOGALLERY; ?></li>
	 <?php 
		try
		{
			$i = 0;
			$Category = new Category();
			$result = $Category -> gets('rank', 'visitor');
			while($show = $result -> fetch_array(MYSQL_ASSOC))
			{
				$i++;
		 ?>
        <li><a href="gallery.php?category=<?php echo $show['id']; ?>" class="next"><?php echo $show['name']; ?></a></li>
       <?php
			}
       	}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	   ?>