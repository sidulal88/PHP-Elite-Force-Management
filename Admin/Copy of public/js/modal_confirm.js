/*
* SimpleModal Confirm Modal Dialog
* http://www.ericmmartin.com/projects/simplemodal/
* http://code.google.com/p/simplemodal/
*
* Copyright (c) 2010 Eric Martin - http://ericmmartin.com
*
* Licensed under the MIT license:
*   http://www.opensource.org/licenses/mit-license.php
*
* Revision: $Id: confirm.js 254 2010-07-23 05:14:44Z emartin24 $

updated by : muktadiur 
*/


var ModalConfirmDom = "<div id='modal-confirm'><div class='header'><span>Confirm</span></div><div class='message'></div><div class='buttons'><div class='no simplemodal-close'>No</div><div class='yes'>Yes</div></div></div>";

var ModalAlertDom = "<div id='modal-alert'><div class='header'><span></span></div><div class='message'></div><div class='buttons'><div class='yes'>OK</div></div></div>";

var ModalPopupDom = "<div id='modal-popup'>\
                        <div class='header'>\
                            <span></span>\
                        </div>\
                        <div class='message'></div>\
                        <div class='input-box-div'>\
                            <span class='label'>Reason for Change:</span><span class='mandatoryLabel'></span>\
                            <textarea class='input-box' onkeypress='LimitMaximumLength(this, 250);' rows=\"3\" cols=\"45\">Enter your coment here</textarea></div>\
                            <div class='buttons'>\
                                <div class='no simplemodal-close'>Cancel</div>\
                                <div class='yes'>Save</div>\
                            </div>\
                        </div>";

/* The container_id is not used in the functions. */



function ModalPopup(dom, whereToPlace, callbackYes, callbackNo, heading, inputText) {
    container_id = $(ModalPopupDom);
    var positionXY = $(whereToPlace).position();
    $(container_id).modal({
        closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
        position: positionXY,
        overlayId: 'popup-overlay',
        containerId: 'popup-container',
        onShow: function (dialog) {
            var modal = this;
            $('.header', dialog.data[0]).append(heading);
            $('.input-box', dialog.data[0]).val(inputText);
            $('.message', dialog.data[0]).append(dom);
            // if the user clicks "yes"
            $('.yes', dialog.data[0]).click(function () {
                // call the callback
                var comment = $('.input-box', dialog.data[0]).val();
                if (IsNull(comment)) {
                    var mandatoryLabel = $('.input-box', dialog.data[0]).parent().find('span.mandatoryLabel');
                    mandatoryLabel.addClass('text-color-red');
                    mandatoryLabel.html(' Comment is must');
                }
                else {
                    SetComment(whereToPlace, comment);
                    if ($.isFunction(callbackYes)) {
                        callbackYes.apply();
                    }

                    // close the dialog
                    modal.close(); // or $.modal.close();
                }
            });
            $('.no', dialog.data[0]).click(function () {
                // call the callback
                if ($.isFunction(callbackNo)) {
                    callbackNo.apply();
                }
                modal.close();
            });
        }
    });

    this.SetComment = function (whereToPlace, comment) {
        $(whereToPlace).closest('td[tag="rep-segment"]').attr('title', comment);
    }   //SetComment
}

function ModalConfirm(container_id, message, callback) {
    container_id = $(ModalConfirmDom);
    $(container_id).modal({
        closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
        position: ["25%", ],
        overlayId: 'confirm-overlay',
        containerId: 'confirm-container',
        onShow: function (dialog) {
            var modal = this;

            $('.message', dialog.data[0]).append(message);

            // if the user clicks "yes"
            $('.yes', dialog.data[0]).click(function () {
                // call the callback
                if ($.isFunction(callback)) {
                    callback.apply();
                }
                // close the dialog
                modal.close(); // or $.modal.close();
            });
        }
    });
}

function ModalConfirmExtended(container_id, message, callbackYes, callbackNo) {
    container_id = $(ModalConfirmDom);
    $(container_id).modal({
        closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
        position: ["25%", ],
        overlayId: 'confirm-overlay',
        containerId: 'confirm-container',
        onShow: function (dialog) {
            var modal = this;

            $('.message', dialog.data[0]).append(message);

            // if the user clicks "yes"
            $('.yes', dialog.data[0]).click(function () {
                // call the callback
                if ($.isFunction(callbackYes)) {
                    callbackYes.apply();
                }

                // close the dialog
                modal.close(); // or $.modal.close();
            });
            $('.no', dialog.data[0]).click(function () {
                modal.close();
                // call the callback
                if ($.isFunction(callbackNo)) {
                    callbackNo.apply();
                }

            });
        }
    });
}

function ModalAlert(container_id, message, heading, callback) {
    container_id = $(ModalAlertDom);
    $(container_id).modal({
        closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
        position: ["20%", ],
        overlayId: 'alert-overlay',
        containerId: 'alert-container',
        onShow: function (dialog) {
            var modal = this;
            $('.message', dialog.data[0]).append(message);
            $('.header', dialog.data[0]).append(heading);

            $('.yes', dialog.data[0]).click(function () {
                // call the callback
                if ($.isFunction(callback)) {
                    callback.apply();
                }
                // close the dialog
                modal.close();
            });
            return dialog;
        }
    });
}

function GenerateTable(id) {

    if (id > 0) {

        var url = '/ProductionStep/GetJson/' + id;
        $.get(url).done(function (data) {
            var jsonData = $(data);
            var rows = "";

            $.each(jsonData, function (k, val) {
                rows += "<tr><td>" + val.Id + "</td><td>" + val.ProductionName + "</td><td>" + val.StepName + "</td><td class='status'>" + val.ProductionStepStatus + "</td><td><a class='start' href='/ProductionExecution/StartProductionStep/" + val.Id + "'>Start</a> | <a class='log' href='#" + val.Id + "'>View Log</a></td></tr>";

            });
            $('.tblListSimple tbody').empty();
            $('.tblListSimple tbody').append($(rows)).find('a.start').click(Exucute);
            if ($('.tblListSimple tbody').html() != '') {
                var start = $("<a class='start' href='/ProductionExecution/StartProduction/" + $('#ProductionId').val() + "'>Start</a> | <a class='log' href='#'>View Log</a>"); ///ProductionExecution/GetExecutionLog/

                $('#divStart').empty();
                $('#divStart').show().append(start).find('a.start').click(Exucute);

            }
        });
    } else { $('.tblListSimple tbody').empty(); $('.divStart').hide(); }
}



