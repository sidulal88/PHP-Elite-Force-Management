$(function(){
    $('.unique').change(function() {
        var $current = $(this);
        $('.unique').each(function() {
            if ($(this).attr('name') == $current.attr('name')){ 
                if($(this).val() == $current.val() && $(this).attr('id') != $current.attr('id')){
                    $(this).addClass('unique-mess');
                }else{
                    $(this).removeClass('unique-mess');
                }
            }
        });
    });
	
    //key board navigation
    //count table first tr all cjield td all input field 
    var col = $("#entry_table tr:first-child").find("input").length;
    var current=0;
    var next=0;
        
    document.onkeydown = check;
    function check(e){
        if (!e) var e = window.event;
        (e.keyCode) ? key = e.keyCode : key = e.which;
        try{
            switch(key){
                case 37:
                    next = current - 1;
                    break; //left
                case 38:
                    next = current - col;
                    break; //up
                case 39:
                    next = (1*current) + 1;
                    break; //right
                case 40:
                    next = (1*current) + col;
                    break; //down
            }
            if (key==37|key==38|key==39|key==40){
                document.forms['form'].elements[next].focus();
                current = next;
            }	
        }catch(Exception){
        //alert(Exception);
        }
    }
        
    $('input').click(function(){
        var string = $(this).attr('id');
        current = string;
    });
      
        
        
});