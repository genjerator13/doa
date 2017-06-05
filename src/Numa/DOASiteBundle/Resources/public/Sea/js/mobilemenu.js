jQuery(document).ready(function () {
    jQuery(".mobile-menu .mobmenu li ul").hide();
    /* hide sublinks */
    jQuery(".separator").click(function () {
        jQuery(this).next().slideToggle(300);
        /* display sublinks */
    });
});