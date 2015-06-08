<?php require_once('settings.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>
</head>

<body>

	<div class="wrapper">
		<?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        	<div class="leftside">
				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
            </div>
            
			<div class="blogContent">
			<section id="section-1" class='section'>
			<div class="content">
				<div class ="welcome_head">About us</div>
                	<div class="pageBody">
					<div class="caption_page_name">Vission :</div>
				Our vision is to provide a peaceful and secure working environment in the industrial area. To increase the production as well as to develop our national economy for better future of Bangladesh. </div>
				<hr />
                <div class="link_box">
                    <a href="#top"class="link">&uarr; Back to top</a>
                    <a href="#" rel="next"class="link">&darr; Next section</a>
                </div>

			</div>
		</section>
		<section id="section-2">
			<div class="content">
				<!--<h1 class ="welcome_head">About us >> Mission</h1>-->
                	<div class="pageBody"><div class="caption_page_name">Mission :</div>
           	 The mission of the industrial police is to ensure safety and security of industries. To uphold the rule of law for the owners & workers. To take necessary measures to prevent any labour unrest in the industrial area. Bringing the criminal to justice</div>
				<hr />
                <div class="link_box">
                    <a href="#top"class="link">&uarr; Back to top</a>
                    <a href="#" rel="next"class="link">&darr; Next section</a>
                </div>
			</div>
		</section>
		<section id="section-3">
			<div class="content">
				<!--<h1 class ="welcome_head">About us >> HISTORY </h1>-->
                	<div class="pageBody"><div class="caption_page_name">HISTORY :</div>
           	  Industrial sector is playing a vital role in the national economy of Bangladesh. About eighty percent of total foreign currency is earned from garments sector. But in the last couple of years, some labour unrest and violence in this sector pull a thread to our economy. To save our economy there was a demand for a specialized police force to enforce law & order in the industrial area. Finally Honorable Prime Minister Sheikh Hasina felt the same & officially inaugurated the “Industrial Police” on 31 October 2010 in BICC with a colorful program.  </div>
				<hr />
                <div class="link_box">
                    <a href="#top"class="link">&uarr; Back to top</a>
                    <a href="#" rel="next"class="link">&darr; Next section</a>
                </div>
			</div>
		</section>
		<section id="section-4">
			<div class="content">
				<!--<h1 class ="welcome_head">About us >> FLAG & LOGO </h1>-->
                	<div class="pageBody about">
					<div class="caption_page_name">FLAG & LOGO :</div>
					<img src="images/flag_logo.jpg" /> </div>
				<hr />
                <div class="link_box">
                    <a href="#top"class="link">&uarr; Back to top</a>
                    <a href="#" rel="next"class="link">&darr; Next section</a>
                </div>
			</div>
		</section>
		
		<section id="section-5">
			<div class="content">
				<!--<h1 class ="welcome_head">About us >> National Anthem </h1>-->
                	<div class="pageBody">
					<div class="caption_page_name">National Anthem:</div>
					<p style="font-size:12px; font-weight:bold; letter-spacing:2px; color:#003399; padding-top:15px; padding-bottom:5px">National Anthem (Song):</p>
					<object type="application/x-shockwave-flash" data="images/dewplayer.swf" width="200" height="40" id="dewplayer" name="dewplayer"> <param name="wmode" value="transparent" /><param name="movie" value="dewplayer.swf" /> <param name="flashvars" value="mp3=images/bd_anthom_song.mp3&amp;autoreplay=1&amp;showtime=1" /> </object>
					
					<p style="font-size:12px; font-weight:bold; letter-spacing:2px; color:#003399; padding-top:15px; padding-bottom:5px">National Anthem (Music):</p>
					<object type="application/x-shockwave-flash" data="images/dewplayer.swf" width="200" height="40" id="dewplayer" name="dewplayer"> <param name="wmode" value="transparent" /><param name="movie" value="dewplayer.swf" /> <param name="flashvars" value="mp3=images/bd_anthom_music.mp3&amp;autoreplay=1&amp;showtime=1" /> </object>
					</div>
				<hr />
                <div class="link_box">
                    <a href="#top"class="link">&uarr; Back to top</a>
                    <a href="#" rel="next"class="link">&darr; Next section</a>
                </div>
			</div>
		</section>
		
			</div>
			</div>
            
      </div>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>

        
		
	<!-- jquery-hashchange plugin CDN -->
	<!--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-hashchange/v1.3/jquery.ba-hashchange.min.js"></script>-->
	<!-- jquery-hashchange plugin local copy (with fixed browser detection) -->
	<script src="js/jquery.hashchange.min.js"></script>
	
	<!-- Page Scroll to id plugin -->
	<script src="js/jquery.malihu.PageScroll2id.js"></script>
	
	<script>
		(function($){
			$(window).load(function(){
				
				/* Page Scroll to id fn call */
				$("#navigation-menu a,a[href='#top'],a[rel='m_PageScroll2id']").mPageScroll2id({
					highlightSelector:"#navigation-menu a"
				});
				
				/* jquery-hashchange fn */
				$(window).hashchange(function(){
					var loc=window.location,
						to=loc.hash.split("/")[1] || "#top";
					$.mPageScroll2id("scrollTo",to,{
						clicked:$("a[href='"+loc+"'],a[href='"+loc.hash+"']")
					});
				});
				
				/* demo functions */
				$("a[rel='next']").click(function(e){
					e.preventDefault();
					var val="#/"+$(this).parent().parent("section").next().attr("id");
					window.location.hash=val;
				});
				
			});
		})(jQuery);
	</script>
	
</body>
</html>
