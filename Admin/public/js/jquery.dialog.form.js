$(function() {
    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		
    $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 550,
        width: 500,
        modal: true,
        close: function() {
            allFields.val( "" ).removeClass( "ui-state-error" );
        }
    });

    $( "#create" )
    .button()
    .click(function() {
        $( "#dialog-form" ).dialog( "open" );
    });
    
   
    $( "#create-dialog" )
    .button()
    .click(function() {
        $( "#dialog-confirm" ).dialog({
            resizable: false,
            height:140,
            modal: false,
            buttons: {
                "Delete all items": function() {
                    $( this ).dialog( "close" );
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });  
});