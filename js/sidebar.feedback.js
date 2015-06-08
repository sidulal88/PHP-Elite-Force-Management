
jQuery(function(){
	amazonmenu.init({
		menuid: 'mysidebarmenu'
	})
})

//--------News Feed
	$(function() {
    $('marquee').mouseover(function() {
        $(this).attr('scrollamount',0);
    }).mouseout(function() {
         $(this).attr('scrollamount',5);
    });

});

$(document).ready(function() {
		$('.myMenu > li').bind('mouseover', openSubMenu);
		$('.myMenu > li').bind('mouseout', closeSubMenu);
		
		function openSubMenu() {
			$(this).find('ul').css('visibility', 'visible');	
		};
		
		function closeSubMenu() {
			$(this).find('ul').css('visibility', 'hidden');	
		};
		
		
				   
});