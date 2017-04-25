function startCarousel(id,interval){
    $(id).carousel({
        interval: interval,
        pause: false
    }).on('slide.bs.carousel', function (e) {
        var nextH = $(e.relatedTarget).height();
        $(this).find('.active.item').parent().animate({
            height: nextH
        }, 500);
    });
};