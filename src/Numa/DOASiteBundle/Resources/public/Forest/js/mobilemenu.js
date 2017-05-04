jQuery(document).ready(function () {
    jQuery(".mobile-menu ul div").hide();
    /* hide sublinks */
    jQuery(".separator").click(function () {
        jQuery(this).next().slideToggle(300);
        /* display sublinks */
    });
});