<?php
/**
 * Met het includen van dit bestand wordt een voorbeeld widget registreerd 
 * 
 * TODO Hernoem de variabelen en de classnaam Example_Widget (!!!!!)
 * TODO Verplaats naar assets/includes
 * TODO Include in je template-functions.php
 * 
 * @author Brian de Geus
 * @since 1.0
 * @version 1.0
 */

/* HTML variabelen */
$id_base = 'widget-example'; // De basis van het unieke widget id. Bijv. id="widget-example-13"
$class_name = 'widget-example'; // De classname die wordt toegevoegd naast de standaard widget class

/* Backend variabelen */
$widget_title = 'Voorbeeld widget'; // De titel van de widget in de backend
$widget_description = 'Dit is een voorbeeld widget voor Sebwite ontwikkelaars'; // De omschrijving van de widget in de backend

/*  De Widget
	------------------------------------------------------------------------------ 	*/
class Example_Widget extends WP_Widget {
 
    /**
	 * De constructor, moet dezelfde naam hebben als de class. Hier definitieren we de variabelen van de Widget
	 * Niet bijzonders, alleen de class naam en omschrijving voor de Widgets backend pagina
	 * 
	 * @see WP_Widget::widget
	 */
    function Example_Widget() {		
		$widget_ops = array('classname' => $class_name, 'description' => __($widget_description, 'Widget'));
		
		parent::WP_Widget($id_base, __($widget_title, 'Widget'), $widget_ops);
    }
 
    /**
	 * De geërfde functie van WP_Widget, deze functie wordt uitgevoerd 
	 * 
	 * @see WP_Widget::widget
	 */
    function widget( $args, $instance ) {	
        extract( $args );
				
    	$title = apply_filters( 'widget_title', $instance['title'] );  
		$content = $instance['content'];  
        
		// Deze variabele wordt gecontroleerd door het theme aan de hand van de variabele 'before_widget' in de sidebar registratie functie
		// Print de widget prepend inclusief id en classes
        echo $before_widget;
		
		if ( $title )  
   			echo $before_title . $title . $after_title;  
		
		if ( $name )  
    		echo '<p>' . $content . '</p>';  
 				
		// Deze variabele wordt gecontroleerd door het theme aan de hand van de variabele 'after_widget' in de sidebar registratie functie
		// Print de widget append
		echo $after_widget;
    }
 
 
    /**
	 * De geërfde functie van WP_Widget hier wordt het backend Widget aanpasformulier aangemaakt
	 * 
	 * @see WP_Widget::form
	 */
    function form($instance) {	
		// Widget Title: Text Input
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'Sebwite thema'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<?php
		// Text Input
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Your Name:', 'Sebwite thema'); ?></label>
			<input id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" value="<?php echo $instance['content']; ?>" style="width:100%;" />
		</p>
        <?php 
    }
 
 
    /**
	 * De geërfde functie van WP_Widget, deze functie wordt uitgevoerd na het submitten van het aanpasformulier
	 * 
	 * @see WP_Widget::update
	 */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		
	    $instance['title'] = strip_tags( $new_instance['title'] );  
	    $instance['content'] = strip_tags( $new_instance['content'] );  
		
        return $instance;
    }
}
add_action('widgets_init', create_function('', 'return register_widget("Example_Widget");')); // HERNOEM Example_Widget NAAR JE CLASSNAAM

?>