//gallery = function() {
//    return{
//        init: function() {
//            $('.pictureThumbs img').hover(function() {
//                $('img#picture').attr('src', this.src);
//            });
//        }
//    };
//}();

            $('.pictureThumbs img').hover(function() {
                $('img#picture').attr('src', this.src);
            });
            

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