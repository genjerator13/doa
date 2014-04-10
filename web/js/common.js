
            
            
//$(function(){
//  //bnd to all images with te changer class for click
//  $('img.changer').click(function(){
//    //grab the image just clicked as a jquery object.
//    var img = $(this);
//    img .data('originalsrc', img.attr('src')) //stow the original src
//        .attr('src', img.data('altsrc')       //update the src
//        .data('mode','alt')                   //tag that the img isin alt mode.
//        ; //done with img
//  });
//});
    
    
    
    

            $('.thumbs ul li a img').click(function() {
                $('.image-gallery .big-image img#default').attr('src', this.src);
            });
     
     
     
     
     
//gallery = function() {
//    return{
//        init: function() {
//            $('.thumbs ul li a img').hover(function() {
//                $('img#default').attr('src', this.src);
//            });
//        }
//    };
//}();


function initialize() {
    var mapProp = {
      center:new google.maps.LatLng(51.508742,-0.120850),
      zoom:5,
      mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
}
            
//    $(document).ready(function() {
//        alert('Hello, World!');
//    });


