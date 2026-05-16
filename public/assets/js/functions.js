jQuery(document).ready(function () {

    "use strict";

    var $window = $(window);
    $('body').each(function () {
        var $scroll = $(this);
        if ($(window).width() >= 980) {
            $(window).scroll(function () {
                var yPos = -($window.scrollTop() / $scroll.data('speed'));
                var coords = '50% ' + yPos + 'px';
                $scroll.css({ backgroundPosition: coords });
                var scroll = $(window).scrollTop();
                if (scroll >= 108) { $("body").addClass("fixed"); }
                else { $("body").removeClass("fixed"); }
            });
        }

    });
});

