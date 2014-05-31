<?php
/**
 * Met het includen van dit bestand wordt een widget registreerd die wekelijks een recept weergeeft
 * 
 * @author Brian de Geus - GeusMedia
 * @since 1.0
 * @version 1.0
 */

/*  De Widget
	------------------------------------------------------------------------------ 	*/

/*
 * De action hook functie voor WordPress
 */
function random_column_widget() {
	register_widget('Random_Column_Widget');
}
add_action('widgets_init', 'random_column_widget');

/**
 * De class voor de widget
 */
class Random_Column_Widget extends WP_Widget {

	/**
	 * De constructor
	 */
	function Random_Column_Widget() {
		$widget_ops = array('classname' => 'column', 'description' => __('Toont een willekeurige column', 'random-column'));
		
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'random-column-widget');
		
		$this->WP_Widget('random-column-widget', __('Willekeurige column', 'random-column'), $widget_ops, $control_ops);
	}
	
	/**
	 * Maak de widget
	 */
	function widget($args, $instance) {
		global $wpdb;
		extract($args);

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title']);
		$name = $instance['name'];

		$before_widget = $args['before_widget'];
        $after_widget = $args['after_widget'];

		echo $before_widget;

		// Schrijf de titel
		if($title)
			echo $before_title . $title . $after_title;
		
		// Lees random een post uit vanuit de custom post type categorie bdx_testimonial
		$args = array('posts_per_page'=>1, 'cat'=>22, 'post_status'=>'publish', 'orderby' => 'rand');
		
		$testimonials = new WP_Query($args);
		
		while($testimonials->have_posts()) { 
			$testimonials->the_post();
			
			//$terms = get_the_terms(get_the_ID(), 'bdx_recipe_chef');
			
			/*
			$out = array();			
			if(!empty( $terms)) {
				foreach($terms as $c)
					$out[] = esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display'));
			}
			*/
			
			echo '<p class="title">'.get_the_title().'</p>';
			
			echo '<p>';
			echo substr((strlen(get_the_excerpt()) > 0) ? get_the_excerpt() : get_the_content(), 0, 230);
			echo '</p>';

            echo '<p class="by-author">door '.get_the_author().'</p>';

            echo '<p class="widget-footer">Bekijk alle columns <a href="' . home_url( 'category/columns/' ) . '">hier</a></p>';
		}
		wp_reset_postdata();

		echo $after_widget;
	}

	/*
	 * Update functie voor de WordPress backend
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		// HTML escaping
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['name'] = strip_tags($new_instance['name']);

		return $instance;
	}
	
	/**
	 * Het formulier voor de WordPress backend
	 */
	function form($instance) {

		$defaults = array('title' => __('Column', 'column'), 'show_column' => true);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titel:', 'column'); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<!--<p class="description">Beheer de inhoud van de lijst via Options > Widgets</p>-->

	<?php
	}
}

?>