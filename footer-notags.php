<?php
	/**
	 * De hoofd footer template
	 *
	 * @author 		Brian de Geus - Sebwite
	 * @package 	Sebwite/BaseTheme
	 * @version     1.0
	 */
	 
	// Voer hier het ID in wat in functions.php is gebruikt om het menu te registreren
	$menu_id = 'footer';
?>

			<div id='footer-push'></div>
	
		</div><!-- #wrapper-global -->

		<footer id="footer-main" class="footer-main">
			<div class="wrapper-content">
				
				<p id="site-info" class="site-info"><?php echo date('Y'); ?> &#169; <?php echo get_bloginfo('name'); ?></p>
				
				<nav id="<?php echo $menu_id; ?>" class="<?php echo $menu_id; ?>">
					<?php 
						$registered_menus = get_registered_nav_menus();
						
						// We voeren een controle toe of er wel een menu is met het ID
						if( array_key_exists( $menu_id, $registered_menus ) ) {
					
							echo '<h1>' . $registered_menus[$menu_id] . '</h1>';
			
							$args = array(
								'theme_location' => 'footer', 
								'menu_class' => $menu_id 
							);
							
							wp_nav_menu( $args );
						}
					?>
				</nav>
			</div>
		</footer><!-- #footer-main -->
		
		<?php wp_footer(); ?>
	</body>
</html>