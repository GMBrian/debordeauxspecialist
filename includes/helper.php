<?php
/**
 * Bevat helper functies voor het programmeren
 *
 * @author 		Brian de Geus - Sebwite
 * @package 	Sebwite/BaseTheme
 * @version     0.3
 */


/**
 * Geeft TRUE terug als de gebruiker de superadmin is die in de config is ingesteld
 * 
 * @author 	Brian de Geus
 * @since 	0.3
 */
if( !function_exists( 'is_current_user_superadmin' ) ) {
	
	function is_current_user_superadmin() {
    	$current_user = wp_get_current_user();
		
		if ( defined( 'SUPERADMIN_USERNAME' ) && ( $current_user->user_login == SUPERADMIN_USERNAME ) )
			return TRUE;
		
		return FALSE;
	}
}


/**
 * Print waarden/arrays in een te lezen format op de pagina
 * 
 * @author 	Thijs from the Mountain
 * @since 	0.1
 */
function pre($array,$debug=null,$echo=true) {
	$return = "<div class='debug'><pre>".print_r($array,true)."</pre></div><!-- end .debug -->";
	
	if ((isset($debug)) && ($debug == true)) {
		if ((isset($echo)) && ($echo == false))
			return $return;
		else
			echo $return; return false; 
	}
	elseif ((isset($debug)) && ($debug == false))
		return false;

	if ((isset($echo)) && ($echo == false))
		return $return;
	else
		echo $return;
}
	
?>