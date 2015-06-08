<li class="selected_page"><?php echo DETAILS; ?></li>
<?php
try
{
	$Content = new Content();
	$resultCon = $Content->gets();
	while($showCon = $resultCon -> fetch_array(MYSQL_ASSOC))
	{
?>
<li><a href="content_details.php?c_id=<?php echo $showCon['id']; ?>"><?php echo $showCon['name'];; ?></a></li>
<?php 
	}
}
catch(Exception $e)
{
	echo $e->getMessage();
}
?>
