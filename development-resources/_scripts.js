/* ==========================================================================
   CODE SNIPPETS VOOR IN JE SCRIPTS
   ========================================================================== */


/* ==========================================================================
   AJAX - Ajax relateerde snippets
   ========================================================================== */

/**
 * Een voorbeeld Ajax post op WordPress manier
 * 
 * We roepen de functie example_callback aan
 */
var data = {
	action: 'example_callback', 
	var1: 'string123'
};

jQuery.post(ajaxUrl, data, function(response) {			
	
	// Doe hier iets met de respons
	alert(response);
});