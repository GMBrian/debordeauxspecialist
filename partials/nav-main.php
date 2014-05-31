<?php
	/**
	 * De partial voor het hoofdmenu
	 *
	 * @author 		Brian de Geus - Sebwite
	 * @package 	Sebwite/BaseTheme
	 * @since		0.3.1
	 * @version     0.3.1
	 */
?>

<?php
	// Voer hier het ID in wat in functions.php is gebruikt om het menu te registreren
	$menu_id = '';
	
	if(is_user_logged_in()) {
		$menu_id = 'primary-left-loggedin';
	}
	else {
		$menu_id = 'primary-left';
	}
?>

<nav id="nav-<?php echo $menu_id; ?>" class="nav-primary nav-<?php echo $menu_id; ?>">
	<?php 
		$registered_menus = get_registered_nav_menus();
		
		// We voeren een controle toe of er wel een menu is met het ID
		if( array_key_exists( $menu_id, $registered_menus ) ) {
	
			echo '<h1>' . $registered_menus[$menu_id] . '</h1>';
			
			$args = array(
				'container' => null, 
				'theme_location' => $menu_id, 
				'menu_class' => $menu_id 
			);
			
			wp_nav_menu( $args );
		}
	?>
</nav>

<?php
	// Voer hier het ID in wat in functions.php is gebruikt om het menu te registreren
	$menu_id = '';
	
	if(is_user_logged_in()) {
		$menu_id = 'primary-right-loggedin';
	}
	else {
		$menu_id = 'primary-right';
	}
?>

<nav id="nav-<?php echo $menu_id; ?>" class="nav-primary nav-<?php echo $menu_id; ?>">
	<?php 
		$registered_menus = get_registered_nav_menus();
		
		// We voeren een controle toe of er wel een menu is met het ID
		if( array_key_exists( $menu_id, $registered_menus ) ) {
			
			echo '<h1>' . $registered_menus[$menu_id] . '</h1>';
			
			$args = array(
				'container' => null, 
				'theme_location' => $menu_id, 
				'menu_class' => $menu_id 
			);
			
			wp_nav_menu( $args );
		}
	?>
</nav>

<h1 id="home-icon" class="home-icon">
	<a href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('name'); ?>">
		<img src="<?php echo get_stylesheet_directory_uri().'/assets/images/img-logo.png'; ?>" alt="<?php echo get_bloginfo('name'); ?>">
	</a>
</h1>