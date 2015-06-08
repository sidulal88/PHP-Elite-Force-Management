<li class="selected_page"><?php echo BANNER_LIST; ?></li>
     <?php 
		try
		{
				$sn = 0;
			$Banner = new Banner();
			$result = $Banner -> gets(" AND status='active' ");
			while($show = $result->fetch_array(MYSQL_ASSOC))
			{
				$sn++;
			?>
        <li><a href="banner_details.php?b_id=<?php echo $show['id']; ?>" class="next">Home Page Banner-<?php echo $sn; ?></a></li>
       <?php
			}
       	}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	   ?>