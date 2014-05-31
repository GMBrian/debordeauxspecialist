<?php
/**
 * Met het includen van dit bestand wordt een custom post type voor referenties toegevoegt
 * 
 * @author Brian de Geus - GeusMedia
 * @since 1.0
 * @version 1.0
 */

/*  Registratie
	------------------------------------------------------------------------------ 	*/

/**
 * Registreer de Custom Post Type voor referenties
 */
add_action('init', function() {
	global $plugin_base_dir;
	
	// Argumenten voor registreer functie
	$args = array(
		'labels' => array(
			'name' => 'Referenties',
			'singular_name' => 'Referentie',
			'add_new' => 'Nieuwe referentie',
			'add_new_item' => 'Nieuwe referentie toevoegen',
			'edit_item' => 'Bewerk referentie',
			'new_item' => 'Nieuwe referentie',
			'view_item' => 'Bekijk referentie',
			'search_items' => 'Zoek referenties',
			'not_found' => 'Geen referenties gevonden',
			'not_found_in_trash' => 'Geen referenties gevonden in de prullenbak'
		),
		'query_var' => 'referentie',
		'rewrite' => array(
			'slug' => 'referentie/'
		),
		'public' => true,
		'publicly_queryable' => true,
		'menu_icon' => '',
		'show_ui' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array(
			'excerpt'
		)
	);
	// Registreer de Custom Post Type
	register_post_type('bdx_testimonial', $args);
});

/**
 * Registreer de custom taxonomies: referentiecategoriën
 */
add_action('init', function() {
	register_taxonomy(
        'bdx_testimonial_category',
        'bdx_testimonial',
        array(
            'labels' => array(
                'name' => 'Referentiecategoriën',
                'add_new_item' => 'Referentiecategorie toevoegen',
                'new_item_name' => "Nieuwe referentiecategorie"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );
}, 0);


/*  Overzicht pagina
	------------------------------------------------------------------------------ 	*/

/**
 * Voeg de kolom toe
 */
add_filter('manage_edit-bdx_testimonial_columns', function($columns) {
	unset($columns['date']);
	
	$temp = array(
		'cb' => $columns['cb'], 
		'title' => 'Referentie door',
		'bdx_testimonial_excerpt' => 'Samenvatting'
	);
	
	$columns = $temp ;
	
    return $columns;
});

/**
 * Vul de kolom
 */
add_action('manage_posts_custom_column', function($column) {
	if('bdx_testimonial_excerpt' == $column) {
		echo esc_html(get_the_excerpt());
	}
});

/**
 * Identificeer de kolom die sorteerbaar moet worden
 */
add_filter('manage_edit-bdx_testimonial_sortable_columns', function($columns) {
    $columns['bdx_testimonial_excerpt'] = 'bdx_testimonial_excerpt';
    $columns['bdx_testimonial_testimonial_by'] = 'bdx_testimonial_testimonial_by';
    $columns['bdx_testimonial_testimonial_desc'] = 'bdx_testimonial_testimonial_desc';
 
    return $columns;
});

/*  Bewerk pagina
	------------------------------------------------------------------------------ 	*/

/**
 * Declareer de extra metabox
 */
add_action('admin_init', function() {
	add_meta_box(
		'testimonial_by_meta_box',
        'Referentie details',
        'display_testimonial_by_meta_box',
        'bdx_testimonial', 'normal', 'low'
    );
});

/**
 * Maak de metabox voor de referentie details
 */
function display_testimonial_by_meta_box($testimonial) {
    // Haal de waarde op van de referentiegever op basis van het referentie ID
    $testimonial_by = esc_html(get_post_meta($testimonial->ID, 'testimonial_by', true));
    $testimonial_desc = esc_html(get_post_meta($testimonial->ID, 'testimonial_desc', true));
    ?>
    <table>
        <tr>
            <td style="width: 100%">Referentie door</td>
            <td><input type="text" size="80" name="bdx_testimonial_testimonial_by" value="<?php echo $testimonial_by; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Referentie omschrijving</td>
            <td><input type="text" size="80" name="bdx_testimonial_testimonial_desc" value="<?php echo $testimonial_desc; ?>" /></td>
        </tr>
    </table>
    <?php
}

/**
 * Vervang de titel in de referentiegever
 */
add_filter('title_save_pre', function($title_to_ignore) {
	global $post;
	if(get_post_type() == 'bdx_testimonial') {
		$custom = get_post_custom($post->ID);
		$my_post_title = $custom["testimonial_by"][0];
		return $my_post_title;
	}
	
	return $title_to_ignore;
});

/**
 * Vervang de naam in de referentiegever
 */
add_filter('name_save_pre', function($name_to_ignore) {
	global $post;
	if(get_post_type() == 'bdx_testimonial') {
		$custom = get_post_custom($post->ID);
		$my_post_name = $custom["testimonial_by"][0];
		return $my_post_name;
	}
	
	return $name_to_ignore;
});

/**
 * Update de post meta met de refentiegever
 */
add_action('save_post', function($testimonial_id, $testimonial) {
	// Check post type for movie reviews
    if($testimonial->post_type == 'bdx_testimonial') {
    	
        // Store data in post meta table if present in post data
        if(isset($_POST['bdx_testimonial_testimonial_by'] ) && $_POST['bdx_testimonial_testimonial_by'] != '') {
            update_post_meta($testimonial_id, 'testimonial_by', $_POST['bdx_testimonial_testimonial_by']);
        }
        // Store data in post meta table if present in post data
        if(isset($_POST['bdx_testimonial_testimonial_desc'] ) && $_POST['bdx_testimonial_testimonial_desc'] != '') {
            update_post_meta($testimonial_id, 'testimonial_desc', $_POST['bdx_testimonial_testimonial_desc']);
        }
    }
}, 10, 2);


/*  Frontend pagina
	------------------------------------------------------------------------------ 	*/

?>