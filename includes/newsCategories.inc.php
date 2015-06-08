<li class="selected_page"><?php echo SONGBAD; ?></li>
     <?php 
		try
		{
			$NewsCategory = new NewsCategory();
			$result = $NewsCategory->gets(" AND status='active' ");
			while($show = $result -> fetch_array(MYSQL_ASSOC))
			{
				$sn++;
			$link_url = 'news/'.$show['proxy_url'];
			?>
        <li><a href="<?php echo $link_url; ?>" class="next"><?php echo $show['name']; ?></a></li>
       <?php
			}
       	}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	   ?>