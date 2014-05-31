<?php
/**
 * Met het includen van dit bestand wordt een widget registreerd waarmee een willekeurig referentiecitaat wordt weergegeven
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
function reference_widget() {
	register_widget('Reference_Widget');
}
add_action('widgets_init', 'reference_widget');

/**
 * De class voor de widget
 */
class Reference_Widget extends WP_Widget {

	/**
	 * De constructor
	 */
	function Reference_Widget() {
		$widget_ops = array('classname' => 'reference', 'description' => __('Toont een willekeurig citaat van een referentie', 'reference'));
		
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'reference-widget');
		
		$this->WP_Widget('reference-widget', __('Referentie', 'reference'), $widget_ops, $control_ops);
	}
	
	/**
	 * Maak de widget
	 */
	function widget($args, $instance) {
		extract($args);

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title']);
		$name = $instance['name'];
		$show_reference = isset($instance['show_reference']) ? $instance['show_reference'] : false;

		$before_widget = $args['before_widget'];
        $after_widget = $args['after_widget'];

		echo $before_widget;

		// Schrijf de titel
		if($title)
			echo $before_title . $title . $after_title;

		if($show_reference) {
			// Lees random een post uit vanuit de custom post type categorie bdx_testimonial
			$query_args = array('post_type'=>'bdx_testimonial', 'orderby'=>'rand', 'posts_per_page'=>'1');
			$testimonials = new WP_Query($query_args);
			//print_r($testimonials);
			while($testimonials->have_posts()) { 
				$testimonials->the_post();
				
				echo '<p class="quote">"'.get_the_excerpt().'"</p>';
				echo
					'<p class="reference"><span class="size15">'.
						esc_html(get_post_meta(get_the_ID(), 'testimonial_by', true)).'</span><br>'.
						get_post_meta(get_the_ID(), 'testimonial_desc', true).
					'</p>';
			}
			wp_reset_postdata();
		}

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
		$instance['show_reference'] = $new_instance['show_reference'];

		return $instance;
	}
	
	/**
	 * Het formulier voor de WordPress backend
	 */
	function form($instance) {

		$defaults = array('title' => __('Referentie', 'reference'), 'show_reference' => true);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titel:', 'promo'); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php if($instance['show_reference']) echo 'checked="checked"'; ?> id="<?php echo $this->get_field_id('show_reference'); ?>" name="<?php echo $this->get_field_name('show_reference'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_reference'); ?>"><?php _e("Voeg de informatie van de referentiepersoon toe", 'reference'); ?></label>
		</p>
		<!--<p class="description">Beheer de inhoud van de lijst via Options > Widgets</p>-->

	<?php
	}
}

?>