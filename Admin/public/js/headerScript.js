$(document).ready(function() {

    // Table row of the items in my list.
    var listItems = $("table.ui-state-default tbody tr");
    // Our filter input.
    var input = $("input#filter");

    input.keyup(function() // On key presses
    {
        listItems.each(function() // for each items in our list
        {
            // get all the text values of that list item
            var text = $(this).text().toLowerCase();
            // does it match the text of our filter?
            if (text.indexOf(input.val()) != -1)
            {
                // yes! show it!
                $(this).show();
            }
            else
            {
                // nope! hide it!
                $(this).hide();
            }
        });
    });

    $('#attachment_tab .remove').click(function() {
        var val = $(this).attr('id');
        $.ajax({
            type: "POST",
            url: 'ajax_remove_attach_by_id.php?val=' + val,
            success: function(data) {
            }
        });
        $(this).parent().parent().remove();
    });


    //$("table:not(.ui-state-default) tr td:nth-child(odd)").css('font-weight', 'bold');
    //$("table:not(.ui-state-default) tr td:nth-child(1)").css('width', '200');
    $("table.ui-state-default thead th:nth-child(1)").css('width', '20');
    $("table.ui-state-default tr td:nth-child(1)").css('text-align', 'center');

    $('.print').click(function() {
        $('#content').printArea();
        return false;
    });

    //$('.fancybox').fancybox();

    $('.back').click(function() {
        history.back();
    });

    $('.forward').click(function() {
        history.forward();
    });

    $('.formValidate').validate();


});

function addFileMore() {
    var countTr = $('#attachment_tab tbody tr').length;
    var sl = countTr + 1;
    $('#attachment_tab tbody').append('<tr>\n\
            <td>' + sl + '.</td><td><input type="text" name="AttachmentDetails[]" class="required"/></td>\n\
            <td><input type="file" name="attachFile[]"></td>\n\
            <td><div class="remove float-right" onClick="$(this).parent().parent().remove();"><img src="../public/images/delete.png"/></div>\n\
            </td>\n\
        </tr>');
}

//alert(getParam('s'));

function getParam(query) {

    var vars = [], hash;
    var q = document.URL.split('?')[1];
    if (q !== undefined) {
        q = q.split('&');
        for (var i = 0; i < q.length; i++) {
            hash = q[i].split('=');
            vars.push(hash[1]);
            vars[hash[0]] = hash[1];
        }
    }

    return vars[query];
}

function myformatter(date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
}
function myparser(s) {
    if (!s)
        return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0], 10);
    var m = parseInt(ss[1], 10);
    var d = parseInt(ss[2], 10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
        return new Date(y, m - 1, d);
    } else {
        return new Date();
    }
}

function ComboChange(obj, id) {
    $('#loder').show();
    var url = id.toLowerCase();
    $.ajax({
        type: "GET",
        url: 'ajax_' + url + '.php',
        data: 'val=' + obj.val(),
        dataType: "text",
        success: function(data) {
            $('#' + id).html(data);
            $('#loder').hide();
        }
    });
}

function onChange(obj, id) {
    $('#' + id).html('<img src="../public/images/ajaxLoader.gif"/>');
    var url = id.toLowerCase();
    $.ajax({
        url: 'ajax_' + url + '.php',
        type: "GET",
        data: 'val=' + obj.val(),
        success: function(msg) {
            $('#' + id).html(msg);
        }
    });
}

function OnloadFunction(obj) {
    var hash = obj.attr('href').substring(1); //Puts hash in variable, and removes the # character
    console.log(hash);
    $.ajax({
        url: hash,
        data: "",
        type: "GET",
        contentType: "application/json",
        dataType: "text",
        success: function(data) {
            $('#content').html(data);
        }
    });

}



if (window.location.hash) {
    var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
    console.log(hash);
    $.ajax({
        url: hash,
        data: "",
        type: "GET",
        contentType: "application/json",
        dataType: "text",
        success: function(data) {
            $('#content').html(data);
        }
    });
}