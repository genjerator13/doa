$(".saveAd").on("click", function() {
    var itemId = $(this).closest('.item-row').attr("data");
    console.log(itemId);
    var act = "add";
    if (!$(this).prop('checked')) {
        act = "remove";
    }
    var jqxhr = $.post("{{path('item_savead')}}", {itemid: itemId, act: act}, function(data) {
        htmlx = "";
        if (data.savedAds > 0) {
            htmlx = "(" + data.savedAds + ")";
        }
        $('.savedAds').html(htmlx);
    })

});
$(".compareAd").on("click", function() {
    var itemId = $(this).closest('.item-row').attr("data");
    var url = $(this).closest('.item-row').attr("url");
    alert(url);
    console.log(url);
    var act = "add";
    if (!$(this).prop('checked')) {
        act = "remove";
    }
    var jqxhr = $.ajax(url, {itemid: itemId, act: act}, function(data) {
        htmlx = "";
        if (data.comparedItes > 0) {
            htmlx = "(" + data.comparedItes + ")";
        }
        $('.savedAds').html(htmlx);
    })

});
/*
 * 
 * 
 */
