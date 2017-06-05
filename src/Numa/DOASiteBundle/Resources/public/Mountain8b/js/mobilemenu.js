jQuery(document).ready(function () {
    jQuery(".mobile-menu .menu li ul").hide();
    /* hide sublinks */
    jQuery(".separator").click(function () {
        jQuery(this).next().slideToggle(300);
        /* display sublinks */
    });
});