$(document).ready(function(){
    $("#nav > li > a").on("click", function(e){
        if($(this).parent().has("ul")) {
            e.preventDefault();
        }
       
        
        
        //$('.MainMenu').prop('checked', true);
        //$('.MainMenu').prop('checked', false);
        //console.log(cl.attr('id'));
        $('ul > li :checkbox').change(function() {
            $(this).parents('li:first')
            //.children("input")
            .attr("disabled", this.checked);
        });
        
       
        if(!$(this).hasClass("open")) {
            // hide any open menus and remove all other classes
            $("#nav li ul").slideUp(350);
            $("#nav li a").removeClass("open");
            
            
            // open our new menu and add the open class
            $(this).next("ul").slideDown(350);
            $(this).addClass("open");
        }else if($(this).hasClass("open")) {
            $(this).removeClass("open");
            $(this).next("ul").slideUp(350);
        //$('.MainMenu').removeAttr('checked'); 
        }
    });
});