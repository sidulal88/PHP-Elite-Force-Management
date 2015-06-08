<li class="selected_page"><?php echo PUBLICATION; ?></li>
     <?php 
		try
		{
			$ArticleCategory = new ArticleCategory();
			$result = $ArticleCategory->gets(" AND status='active' ");
			while($show = $result -> fetch_array(MYSQL_ASSOC))
			{
				$sn++;
			?>
        <li><a href="articles.php?a_cid=<?php echo $show['id']; ?>" class="arrow"><?php echo $show['name']; ?></a></li>
       <?php
			}
       	}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
	   ?>