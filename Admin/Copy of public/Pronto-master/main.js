
var useAnimation;

$(document).ready(function() {
    useAnimation = (Cookies.read("pronto-animated") == "true");

    // Init pronto
    $.pronto({
        requestDelay: (useAnimation) ? 500 : 0,
        selector: "a:not(.no-pronto)"
    });

    // Bind pronto events
    $(window).on("pronto.request", requestPage)
            .on("pronto.render", initPage)
            .on("pronto.load", destroyPage);

    // Remember to init first page
    initPage();

    $("#toggle_animation").on("change", function() {
        if ($(this).is(":checked")) {
            Cookies.create("pronto-animated", "true");
        } else {
            Cookies.create("pronto-animated", "false");
        }
        window.location.reload();
    });
});

function requestPage() {
    if (useAnimation) {
        $("#pronto").stop().animate({opacity: 0}, 500);
    }
}

function initPage() {
    // bind events and iniitalize plugins

    if (useAnimation) {
        $("#pronto").stop().animate({opacity: 1}, 500);
    }

    var href = window.location.href;
    $("nav a").removeClass("active").each(function() {
        var url = $(this).attr("href");
        if (href.indexOf(url) > -1) {
            $(this).addClass("active");
        }
    });
}

function destroyPage() {
    // unbind events and remove plugins
}

// Cookie controls
var Cookies = {
    create: function(key, value, expires) {
        var date = new Date();
        date.setTime(date.getTime() + (expires * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
        var path = "; path=/"
        var domain = "; domain=" + document.domain;
        document.cookie = key + "=" + value + expires + domain + path;
    },
    read: function(key) {
        var keyString = key + "=";
        var cookieArray = document.cookie.split(';');
        for (var i = 0; i < cookieArray.length; i++) {
            var cookie = cookieArray[i];
            while (cookie.charAt(0) == ' ') {
                cookie = cookie.substring(1, cookie.length);
            }
            if (cookie.indexOf(keyString) == 0)
                return cookie.substring(keyString.length, cookie.length);
        }
        return null;
    },
    erase: function(key) {
        Cookies.create(key, "", -1);
    }
};