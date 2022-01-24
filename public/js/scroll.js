//Scroll top
jQuery(function () {
    $(function () {
        $(window).scroll(function () {
            if ($(this).scrollTop() > 400) {
                $('#scrollUp').css('right', '45px',);
                $('#scrollUp').css('position', 'fixed',);
            } else {
                $('#scrollUp').removeAttr('style');
            }
        });
    });
});