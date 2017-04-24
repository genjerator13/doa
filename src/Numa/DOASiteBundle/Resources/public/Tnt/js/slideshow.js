WebFontConfig = {
    google: {families: ['Roboto:400,300,400italic,500,500italic,700,700italic:latin']}
};
(function() {
    var wf = document.createElement('script');
    wf.src = ('https:' === document.location.protocol ? 'https' : 'http') + '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
})();

//When we click on thumb img
jQuery('.thumb li', '.slideshow').click(function() {

    var
    //SlideShow
        sshow = jQuery(this).closest('.slideshow'),
    //Big
        big = sshow.find('.big'),
    //thumb
        thumb = sshow.find('.thumb'),
    //Get index
        indx = thumb.find('li').index(this),
    //Current index
        currentIndx = big.find('li').index(big.find('li:visible'));

    //If currentIndx is same as clicked indx don't do anything
    if (currentIndx === indx) {
        return;
    }

    big
    //Fadeout current image
        .find('li:visible').fadeOut().end()
        //Fadein new image
        .find('li:eq(' + indx + ')').fadeIn();
});

//When we click on any li inside controls section
jQuery('.controls li').click(function() {
    var
    //Slideshow
        sshow = jQuery(this).closest('.slideshow'),
    //Increment
        incr = jQuery(this).hasClass('prev') ? -1 : 1,
    //Current Index
        currentIndx = sshow.find('.big li').index(sshow.find('.big li:visible')),
    //Final Index
        finalIndx = currentIndx + incr;
    var count = jQuery("#imgList li").length;

    //Check ranges
    finalIndx = (finalIndx >= count) ? 0 : ((finalIndx < 0) ? jQuery(".slider-hortizontal-conteiner ul.thumb li").size() - 1  : finalIndx);
    //Now trigger click event on respective image in nav
    sshow.find('.thumb li:eq(' + finalIndx + ')').trigger('click');
});

function inputFocus(i) {
    if (i.value === i.defaultValue) {
        i.value = "";
        i.style.color = "#000";
    }
}

function inputBlur(i) {
    if (i.value === "") {
        i.value = i.defaultValue;
        i.style.color = "#888";
    }
}

jQuery('.carousel').carousel({
    pause: true,
    interval: false
});