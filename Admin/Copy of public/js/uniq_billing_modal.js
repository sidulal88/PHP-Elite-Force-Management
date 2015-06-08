$(function () {
    // Cache for modalDialogs
    var modalDialogs = {};

    var getValidationSummaryErrors = function ($form) {
        // We verify if we created it beforehand
        var errorSummary = $form.find('.validation-summary-errors, .validation-summary-valid');
        if (!errorSummary.length) {
            errorSummary = $('<div class="validation-summary-errors"><span>Please correct the errors and try again.</span><ul></ul></div>')
            .prependTo($form);
        }

        return errorSummary;
    };

    var displayErrors = function (form, errors) {
        var errorSummary = getValidationSummaryErrors(form)
        .removeClass('validation-summary-valid')
        .addClass('validation-summary-errors');

        var items = $.map(errors, function (error) {
            return '<li>' + error + '</li>';
        }).join('');

        var ul = errorSummary
        .find('ul')
        .empty()
        .append(items);
    };

    var resetForm = function ($form) {

        if ($form.length < 1) {
            // No form inside the partial => we have nothing more to do here
            return;
        }
        // We reset the form so we make sure unobtrusive errors get cleared out.
        $form[0].reset();

        getValidationSummaryErrors($form)
        .removeClass('validation-summary-errors')
        .addClass('validation-summary-valid')
    };

    


    var DeleteItem = function (url, callback) {
        ModalConfirm('#confirm', 'Do you really want to delete this item?', function () {

            $.ajax({
                type: "POST",
                url: url,
                cache: false,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    if (data.errors) {
                        var errors = data.errors;
                        var msg = $.map(errors, function (error) {
                            return error;
                        }).join('');

                        alert(msg);
                    } else {

                        if ($.isFunction(callback)) {
                            callback.apply();
                        }

                        location = location.href;
                    }
                },
                error: function (xhr) {
                }
            });

        });

    }

    var Exucute = function (url) {

        ModalConfirm('#confirm', 'Do you really want to execute production?', function () {
            $.ajax({
                type: "POST",
                url: url,
                cache: false,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {
                    if (data.status) {
                        location = location.href;
                    }
                    
                },
                error: function (xhr) {
                }
            });
        });

    }

    function loadAndShowDialog(id, link, url) {
        var separator = url.indexOf('?') >= 0 ? '&' : '?';
        $("div.modal-popup").remove();
        // Save an empty jQuery in our cache for now.
        modalDialogs[id] = $();
        //console.log(separator);
        // Load the dialog with the content=1 QueryString in order to get a PartialView
        $.get(url + separator + 'content=1')
        .done(function (content) {
            modalDialogs[id] = $('<div class="modal-popup" title="Create Property">' + content + '</div>')
            .hide() // Hide the dialog for now so we prevent flicker
            .appendTo(document.body)
            .filter('div') // Filter for the div tag only, script tags could surface
            .dialog({ // Create the jQuery UI dialog
                //title: link.data('dialog-title'),
                modal: true,
                resizable: true,
                draggable: true,
                height:"auto",
                width: "auto"
                
            })
            .find('form') // Attach logic on forms
            .submit(function formSubmitHandler(e) {
                var $form = $(this);

                // We check if jQuery.validator exists on the form
                //if (!$form.valid || $form.valid()) {
                    //alert(url);
                    $.ajax({
                        type: 'POST',
                        url: 'RequisitionDAL.php',
                        data: $form.serializeArray(),
                        success: function(data){
                        alert(data);
                        }
                    });
            
        
                //}

                // Prevent the normal behavior since we opened the dialog
               e.preventDefault();
            })
            .end();
        });
        
    };


    // List of link ids to have an ajax dialog
    var links = ['#loginLink', '#registerLink', '.create', '.edit', '.delete', '#modal_create'];
    var exucuteLinks = ['.start'];
    $.each(exucuteLinks, function (i, id) {
        $(id).click(function (e) {
            var obj = $(this);
            var url = obj.attr('href');
           
            obj.parent('td').parent('tr').find('td.status').text('InProgress');
            Exucute(url);

            e.preventDefault();
        });

    });

    $.each(links, function (i, id) {
        $(id).click(function (e) {
            
            $('<div id="ModalOverlay"></div>').appendTo('body');
            $("#ModalOverlay").show();
            //$('#ddd').addClass('fancybox-loading');
            var link = $(this),
            url = link.attr('href');
            //console.log(link.attr('title'));
            if (id == '.delete')
                DeleteItem(url, function () {
                    link.closest('tr').remove();
                });
            if (!modalDialogs[id] || id == '.edit' || id == '.create') {
                loadAndShowDialog(id, link, url);
            } else {
            //modalDialogs[id].dialog('open');
            }

            // Prevent the normal behavior since we use a dialog
            e.preventDefault();
        });
    });


});