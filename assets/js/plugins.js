/* ==========================================================================
   Plugin opties en aanpassingen
   ========================================================================== */

/* Avoid `console` errors in browsers that lack a console.
   ========================================================================== */
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());


/* jQuery plugins/helper opties/aanpassingen
   ========================================================================== */

jQuery(document).ready(function($){
	
	if( prettyPhotoOn ) {
		// Mogelijke taken gekoppeld aan prettyPhoto
    	$("a[rel^='prettyPhoto']").prettyPhoto({
    		deeplinking: false, 
    		social_tools: false
    	});													// Standaard prettyPhoto activatie
    	
    	/*
    	$(".gallery .gallery-item .gallery-icon a").prettyPhoto({
    		deeplinking: false, 
    		social_tools: false
    	});
    	*/
	}
	
	if( modernizrOn ) {
		// Mogelijke taken gekoppeld aan modernizr
	}
	


	/* Google Maps Implementatie
	   ========================================================================== */
	
	if($('#maps-container').length != 0) {
	  
		function initializeMaps() {
			var myLocation = new google.maps.LatLng(mapsLatitude, mapsLongitude);
	
			var mapOptions = {
				center: new google.maps.LatLng(52.019156, 4.4031208),
				zoom: 11,
				scrollwheel: false,
				navigationControl: false,
				draggable: true,
				mapTypeControl: false,
			  	styles: [{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#b5cbe4"}]},{"featureType":"landscape","stylers":[{"color":"#efefef"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#83a5b0"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#bdcdd3"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e3eed3"}]},{"featureType":"administrative","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"road"},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{},{"featureType":"road","stylers":[{"lightness":20}]}]
			};
	
			var map = new google.maps.Map(document.getElementById("maps-container"), mapOptions);
	
			var image = templateUrl + '/assets/images/ic-pin.png';
	
			//alert(image);
	
			var marker = new google.maps.Marker({
				position: myLocation,
				map: map,
				title: mapsMarkertitel,
				icon: image
			});
			
			var contentString = '<div id="maps-tooltip" class="maps-tooltip">' +
			  mapsTooltip +
			  '</div>';
	
			var infowindow = new google.maps.InfoWindow({
				content: contentString,
				maxWidth: 400,
				width: 400
			});
	
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map, marker);
				map.setCenter(marker.getPosition());
			});		
	
			infowindow.open(map, marker); 	
		}
	
		google.maps.event.addDomListener(window, 'load', initializeMaps);
	}
});




