/* ==========================================================================
   RuleTool scripts
   ========================================================================== */

jQuery(document).ready(function($){
	
	// Scripts voor de frontend
	
	var intervalId = enableBannerSlider();
	
	jQuery('#hero-slider-blocks li a').live({
		click: function(e) {
			e.preventDefault();
			clearInterval(intervalId);
			
			var className = jQuery(this).parent().attr('class');
			var number = className.substr(className.length - 1);
			
			var currentClassName = jQuery('#hero-slider-blocks .active').parent().attr('class');
			var currentNumber = currentClassName.substr(currentClassName.length - 1);
						
			jQuery('.slider-image-' + currentNumber).fadeOut(1000)
			 .appendTo('#hero-slider-images');
			jQuery('.slider-image-' + number).fadeIn(1000);
			
			jQuery('.slider-backgroundimage-' + currentNumber).fadeOut(1000)
			 .appendTo('#hero-slider-backgroundimages');
			jQuery('.slider-backgroundimage-' + number).fadeIn(1);
			
			jQuery('.slider-content-' + currentNumber).css('display', 'none')
			 .appendTo('#hero-slider-content');
			jQuery('.slider-content-' + number).fadeIn(1000);
			
			var imageCount = jQuery('#hero-slider-images img').length;
			
			var i = 0;
			while(i <= imageCount) {
				
				if(i != number) {
					jQuery('.hero-slider-block-' + i + ' a').removeClass('active');
				} else {
					jQuery('.hero-slider-block-' + i + ' a').addClass('active');
				}
				
				i++;
			}
		}
	});
});

function enableBannerSlider() {
	var imageCount = jQuery('#hero-slider-images img').length;
		
	if(imageCount > 1) {
		// Verberg alle afbeeldingen behalve de eerste
		jQuery('#hero-slider-images img:gt(0)').hide();
		jQuery('#hero-slider-backgroundimages img:gt(0)').hide();
		jQuery('#hero-slider-content li:gt(0)').hide();
		
		jQuery('#hero-slider :first-child').addClass('active');
		
		jQuery('.hero-slider-block-1 a').addClass('active');
		
		var prev = imageCount;
		var current = 1;
		var next = 2;
		
		// Start de interval functie
		intervalId = setInterval(function() {
			
			if(current > imageCount) {
				current = 1;
			}
			if(next > imageCount) {
				next = 1;
			}
			if(prev > imageCount) {
				prev = 1;
			}
			
			jQuery('.slider-image-' + prev).fadeOut(1000)
			 .appendTo('#hero-slider-images');
			jQuery('.slider-image-' + current).fadeIn(1000);
			
			jQuery('.slider-backgroundimage-' + prev).fadeOut(1000)
			 .appendTo('#hero-slider-backgroundimages');
			jQuery('.slider-backgroundimage-' + current).fadeIn(1);
			
			jQuery('.slider-content-' + prev).css('display', 'none')
			 .appendTo('#hero-slider-content');
			jQuery('.slider-content-' + current).fadeIn(1000);
			
			jQuery('.hero-slider-block-' + prev + ' a').removeClass('active');
			jQuery('.hero-slider-block-' + current + ' a').addClass('active');
			
			prev++;
			current++;
			next++;
		}, 
		6000); // Om de 5 seconden
		
		return intervalId;
	}
}