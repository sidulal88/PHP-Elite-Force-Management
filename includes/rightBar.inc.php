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

  <div  style="height:140px; margin-top:10px; border-top:1px solid #336600; padding-top:5px;">
  
  <h2>Social Media Link</h2>
  <div class="notice_headbox">
<span class='st_sharethis_large' displayText='ShareThis'></span>
<span class='st_facebook_large' displayText='Facebook'></span>
<span class='st_twitter_large' displayText='Tweet'></span>
<span class='st_linkedin_large' displayText='LinkedIn'></span>
<span class='st_pinterest_large' displayText='Pinterest'></span>
<span class='st_email_large' displayText='Email'></span>
<span class='st_digg_large' displayText='Digg'></span>
<span class='st_adfty_large' displayText='Adfty'></span>
<span class='st_google_translate_large' displayText='Google Translate'></span>
<span class='st_youtube_large' displayText='Youtube Subscribe'></span>
<span class='st_googleplus_large' displayText='Google +'></span>
  </div>
<div class="clr"></div>
</div>
</div>

