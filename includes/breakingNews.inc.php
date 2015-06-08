<div class="sidebar_widget dg_msg">
  <h2>Latest News</h2>
  <div class="notice_headbox">
    <marquee direction="up" scrollamount="3" scrolldelay="200"style="padding:0px" >
        <ul style="padding:2px 5px 2px 5px;">
		
		<?php
			try
		 {
			$News = new News();
			$query = $News -> gets();
			while($row = $query -> fetch_array(MYSQL_ASSOC)){
			$imagePath = "uploads/newses/".$row['photo'];
		
		?>
        	<li>
			<div>
			<?php
				if($row['photo']!='' && is_file($imagePath)) {
					$photoPrint = "uploads/newses/".$row['photo'];
			?>
            	<div class="nws_thumb"><img src="<?php echo $photoPrint; ?>" alt="" width="70" height="60" /></div>
				<?php } ?>
                <div class="nws_dtls">
                	<div class="nws_tle"><a href="news_details.php?n_id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></div>
            </div>
			        <div class="nws_dt">
                    	<span class="nws_dt left"><?php echo $row['news_date'] ? Common::converToDisplayDate($row['news_date']) : '';; ?></span>
                    	<!---<span class="nws_dt right"><?php echo date("H:i:s A",strtotime($row['recTime'])); ?> </span>-->
                    </div>
                </div>
            </li>
		<?php
			}
			
		 }
		catch(Exception $e)
		 {
			echo $e->getMessage();
		 }
		?>

        </ul>
    </marquee>
  </div>
<div class="clr"></div>
</div>