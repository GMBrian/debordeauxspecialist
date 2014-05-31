<?php
/**
 * Met het includen van dit bestand wordt een widget registreerd waarin een lijst met registratievoordelen geplaatst kan worden
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
function promo_widget() {
	register_widget('Promo_Widget');
}
add_action('widgets_init', 'promo_widget');

/**
 * De class voor de widget
 */
class Promo_Widget extends WP_Widget {

	/**
	 * De constructor
	 */
	function Promo_Widget() {
		$widget_ops = array('classname' => 'promo', 'description' => __('Toont een lijst met voordelen na registratie', 'promo'));
		
		$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'promo-widget');
		
		$this->WP_Widget('promo-widget', __('Promo', 'promo'), $widget_ops, $control_ops);
	}
	
	/**
	 * Maak de widget
	 */
	function widget($args, $instance) {
		extract($args);
		
		//pre($args);

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title']);
		$name = $instance['name'];
		$show_button = isset($instance['show_button']) ? $instance['show_button'] : false;

		$before_widget = $args['before_widget'];
        $after_widget = $args['after_widget'];

		echo $before_widget;

		// Schrijf de titel
		if($title)
			echo $before_title . $title . $after_title;

		// Lees de lijst uit via een advanced custom field
		$promolist = get_field('promolijst', 'option');
		if($promolist) {
			echo '<ul class="promo-list">';
			foreach($promolist as $listitem) {
				echo '<li>'.$listitem['lijstregel'].'</li>';
			}
			echo '</ul>';
		}
		
		// Laat de button zien indien deze aangevinkt is
		if($show_button)
			$url = get_field('lid_worden', 'option');
			echo '<div class="button-container"><a class="big-button button-subscribe" href="'.$url.'">Lid worden</a></div>';

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
		$instance['show_button'] = $new_instance['show_button'];

		return $instance;
	}
	
	/**
	 * Het formulier voor de WordPress backend
	 */
	function form($instance) {

		$defaults = array('title' => __('Promo', 'promo'), 'show_button' => true);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titel:', 'promo'); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php if($instance['show_button']) echo 'checked="checked"'; ?> id="<?php echo $this->get_field_id('show_button'); ?>" name="<?php echo $this->get_field_name('show_button'); ?>" /> 
			<label for="<?php echo $this->get_field_id('show_button'); ?>"><?php _e("Voeg de 'Wordt nu lid!' knop toe", 'promo'); ?></label>
		</p>
		<p class="description">Beheer de inhoud van de lijst via Options > Widgets</p>

	<?php
	}
}

?>