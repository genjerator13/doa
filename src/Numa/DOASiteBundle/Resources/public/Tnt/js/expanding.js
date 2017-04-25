/**
 * Created by vladimir on 26.4.17..
 */

jQuery( document ).on( "click", ".panel-heading", function() {
    var row_small = jQuery(this).find('small');
    var link = jQuery(this).find('a');
    if (row_small.html() == '[click to collapse]') {
        row_small.html('[click to expand]');
    } else if (row_small.html() == '[click to expand]') {
        row_small.html('[click to collapse]');
    }
});