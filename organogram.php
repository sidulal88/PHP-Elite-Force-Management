<?php require_once('settings.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php include_once(INCLUDE_DIR.'/title.inc.php');?>
<script src="js/sidebar.feedback.js"></script>
</head>

<body>

	<div class="wrapper"><?php include_once(INCLUDE_DIR.'/topBar.inc.php');?>
    
        <div class="contentWrapper">
        		<div class="leftside">

				<?php include_once(INCLUDE_DIR.'/leftBar.inc.php');?>
				
            </div>
            
			<div class="blogContent">
				<div class ="welcome_head">Organogram </div>
           	  <div class="pageBody">
			  <section style=" font-size:14px; font-family:Verdana, Arial, Helvetica, sans-serif; padding:10px">
              	
			  </sction>
			  
				<h3 class="first_toggler expand_toggler"><a href="#"><span id="expanderSign" class="expanderSign">-</span>Industrial Police Headquarters</a> </h3>
<p class="first_panel expand_panel">
<img src="images/ORGANOGRAM/Dg office.png" width="680" />
</p>
<h3 class="remain_toggler expand_toggler"><a href="#"><span class="expanderSign">+</span>Industrial Police-1,Dhaka</a></h3>
<p class="remain_panel expand_panel">
<img src="images/ORGANOGRAM/SP 1.png" width="680" />
</p>
<h3 class="remain_toggler expand_toggler"><a href="#"><span class="expanderSign">+</span>Industrial Police-2,Gazipur</a></h3>
<p class="remain_panel expand_panel">
<img src="images/ORGANOGRAM/SP2.png" width="680" />
</p>
<h3 class="remain_toggler expand_toggler"><a href="#"><span class="expanderSign">+</span>Industrial Police-3,Chittagong</a></h3>
<p class="remain_panel expand_panel">
<img src="images/ORGANOGRAM/SP 3 .png" width="680" />
</p>
<h3 class="remain_toggler expand_toggler"><a href="#"><span class="expanderSign">+</span>Industrial Police-4,Narayanganj</a></h3>
<p class="remain_panel expand_panel">
<img src="images/ORGANOGRAM/SP 4.png" width="680" />
</p>
			  
			  </div>
		
			</div>
		
			</div>
            
      </div>
   <div class="footerarea"><?php include_once(INCLUDE_DIR.'/footer.inc.php');?></div>
<?php include_once(INCLUDE_DIR.'/feedback.inc.php');?>

</body>
</html>
<script>
$(document).ready(function(){
	//$('.first_panel').hide();
	$('.first_toggler').click(function()
	{
		$(this).next('.first_panel').slideToggle(600);
		if ($("#expanderSign").text() == "+"){
			$("#expanderSign").html("−")
		}
		else {
			$("#expanderSign").text("+")
		}
		
	});
	
	$('.remain_panel').hide();
	$('.remain_toggler').click(function()
	{
	$(this).next('.remain_panel').slideToggle(600);
	var text_sign = $(this).find('.expanderSign').text();
	
	if (text_sign == "+"){
			$(this).find('.expanderSign').html("−")
		}
		else {
			$(this).find('.expanderSign').html("+")
		}
	
	});
	
});
</script>
