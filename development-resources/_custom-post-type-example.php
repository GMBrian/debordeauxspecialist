<?php
/**
 * Met het includen van dit bestand wordt een custom post type voor rules toegevoegt
 * 
 * TODO MOET NOG WORDEN AANGEPAST
 * 
 * @author Brian de Geus - Sebwite
 * @since 1.0
 * @version 1.0
 */

/*  Registratie
	------------------------------------------------------------------------------ 	*/
 
/**
 * Registreer de Custom Post Type voor rules
 */
add_action('init', function() {
	global $plugin_base_dir;
	
	// Argumenten voor registreer functie
	$args = array(
		'labels' => array(
			'name' => 'Rules',
			'singular_name' => 'Rule',
			'add_new' => 'New rule',
			'add_new_item' => 'Add new rule',
			'edit_item' => 'Edit rule',
			'new_item' => 'New rule',
			'view_item' => 'View rule',
			'search_items' => 'Search rules',
			'not_found' => 'No rules found',
			'not_found_in_trash' => 'No rules found in trash'
		),
		'query_var' => 'rule',
		'rewrite' => false, 
		'taxonomies' => array(
			'rlt_rule_header', 
			'rlt_rule_topic',
			'rlt_rule_year'
		),
		'public' => true,
		'publicly_queryable' => true,
		'menu_icon' => '',
		'show_ui' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array(
			'title',
			'editor'
		)
	);
	// Registreer de Custom Post Type
	register_post_type('rlt_rule', $args);
});

// Voeg support voor thumbnails toe aan deze post type
//add_theme_support('post-thumbnails', array('rlt_rule'));

/**
 * Registreer de custom taxonomies: merk en category
 */
add_action('init', function() {
    register_taxonomy(
        'rlt_rule_headline',
        'rlt_rule',
        array(
            'labels' => array(
                'name' => 'Headlines',
                'singular_name' => 'Headline',
                'add_new_item' => 'Add headline',
                'new_item_name' => "New headline"
            ),
		'rewrite' => array(
			'slug' => 'headline',
            'with_front'=> false,  
            'feed'=> true 
            ),
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true
        )
    );
    register_taxonomy(
        'rlt_rule_topic',
        'rlt_rule',
        array(
            'labels' => array(
                'name' => 'Topics',
                'singular_name' => 'Topic',
                'add_new_item' => 'Add topic',
                'new_item_name' => "New topic"
            ),
		'rewrite' => array(
			'slug' => 'topic',
            'with_front'=> false,  
            'feed'=> true 
            ),
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true
        )
    );
    register_taxonomy(
        'rlt_rule_year',
        'rlt_rule',
        array(
            'labels' => array(
                'name' => 'Year',
                'singular_name' => 'Year',
                'add_new_item' => 'Add year',
                'new_item_name' => "New year"
            ),
		'rewrite' => array(
			'slug' => 'year',
            'with_front'=> false,  
            'feed'=> true 
            ),
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true
        )
    );
}, 0 );


/*  Overzicht pagina
	------------------------------------------------------------------------------ 	*/


/**
 * We voegen de drie toegevoegde taxonomies toe aan het overzicht in de vorm van kolommen
 */
function add_rule_columns( $columns ) {
    $columns['rlt_rule_headline'] = 'Headline';
    $columns['rlt_rule_topic'] = 'Topic(s)';
    $columns['rlt_rule_year'] = 'Year';
	
    return $columns;
}
add_filter('manage_edit-rlt_rule_columns', 'add_rule_columns');


/**
 * We geven onze eigen kolommen hier inhoud
 */
function populate_rule_columns($column) {
    if('rlt_rule_headline' == $column) {
    	the_terms(get_the_ID(), 'rlt_rule_headline');
    }
    elseif('rlt_rule_topic' == $column) {
    	the_terms(get_the_ID(), 'rlt_rule_topic');
    }
    elseif('rlt_rule_year' == $column) {
    	the_terms(get_the_ID(), 'rlt_rule_year');
    }
}
add_action('manage_posts_custom_column', 'populate_rule_columns');


/**
 * We her-arrangeren de kolommen
 */
function rearrange_rule_columns($rule_columns) {
    $new_columns['cb'] = $rule_columns['cb'];
    $new_columns['title'] = $rule_columns['title'];
    $new_columns['rlt_rule_headline'] = $rule_columns['rlt_rule_headline'];
    $new_columns['rlt_rule_topic'] = $rule_columns['rlt_rule_topic'];
    $new_columns['rlt_rule_year'] = $rule_columns['rlt_rule_year'];
    $new_columns['icl_translations'] = $rule_columns['icl_translations'];
    $new_columns['date'] = $rule_columns['date'];
 
    return $new_columns;
}
add_filter('manage_edit-rlt_rule_columns', 'rearrange_rule_columns');


/* Dropdown filters
   ---------------- */
   
/**
 * Voeg de dropdown filters toe
 */
function filter_rule_list() {
    $screen = get_current_screen();
    global $wp_query;
	
    if($screen->post_type == 'rlt_rule') {
    	
		// De headlines dropdown filter
		$filter_taxonomy = 'rlt_rule_headline';
        wp_dropdown_categories( 
        	array(
	            'show_option_all' => 'Show all headlines',
	            'taxonomy' => $filter_taxonomy,
	            'name' => $filter_taxonomy,
	            'orderby' => 'name',
	            'selected' => ( isset( $wp_query->query[$filter_taxonomy] ) ? $wp_query->query[$filter_taxonomy] : '' ),
	            'hierarchical' => true,
	            'depth' => 3,
	            'show_count' => false,
	            'hide_empty' => true,
       		) 
		);
		
		// De topics dropdown filter
		$filter_taxonomy = 'rlt_rule_topic';
        wp_dropdown_categories( 
        	array(
	            'show_option_all' => 'Show all topics',
	            'taxonomy' => $filter_taxonomy,
	            'name' => $filter_taxonomy,
	            'orderby' => 'name',
	            'selected' => ( isset( $wp_query->query[$filter_taxonomy] ) ? $wp_query->query[$filter_taxonomy] : '' ),
	            'hierarchical' => true,
	            'depth' => 3,
	            'show_count' => false,
	            'hide_empty' => true,
       		) 
		);
		
		// De years dropdown filter
		$filter_taxonomy = 'rlt_rule_year';
        wp_dropdown_categories( 
        	array(
	            'show_option_all' => 'Show all years',
	            'taxonomy' => $filter_taxonomy,
	            'name' => $filter_taxonomy,
	            'orderby' => 'name',
	            'selected' => ( isset( $wp_query->query[$filter_taxonomy] ) ? $wp_query->query[$filter_taxonomy] : '' ),
	            'hierarchical' => true,
	            'depth' => 3,
	            'show_count' => false,
	            'hide_empty' => true,
       		) 
		);
    }
}
add_action( 'restrict_manage_posts', 'filter_rule_list' );


/**
 * Vang de dropdown filters op
 */
function perform_rule_filtering($query) {
	// Niet nodig tenzij we aanpassingen willen maken aan de standaard filter
}
add_filter('parse_query','perform_rule_filtering');

/* Sorteer kolommen
   ---------------- */
/**
 * Hier geven we aan dat onze toegevoegde kolommen sorteerbaar zijn
 * 
 * @link http://scribu.net/wordpress/sortable-taxonomy-columns.html
 */
function sortable_rule_colums($columns) {
    $columns['rlt_rule_headline'] = 'rlt_rule_headline';
    $columns['rlt_rule_topic'] = 'rlt_rule_topic';
    $columns['rlt_rule_year'] = 'rlt_rule_year';
 
    return $columns;
}
add_filter('manage_edit-rlt_rule_sortable_columns', 'sortable_rule_colums');


/**
 * Hier sorteren we op taxonomy kolom
 * 
 * Hier is een omslachtige functie voor nodig omdat het sorteren op taxonomy kolom niet standaard in de WP_Query zit
 */
function taxonomy_column_rule_orderby( $orderby, $wp_query ) {
	
	// Basis controle of we wel op een admin pagina zitten
	if(!is_admin())
		return $orderby;

    $screen = get_current_screen();
    
    // We kijken of we op de rule backend overzicht pagina zitten
    if($screen->post_type == 'rlt_rule') {
		global $wpdb;
		
		// We kijken of we sorteert wordt op headlines
		if(isset( $wp_query->query['orderby'] ) && 'rlt_rule_headline' == $wp_query->query['orderby']) {
			
			$orderby = "(
				SELECT GROUP_CONCAT(name ORDER BY name ASC)
				FROM $wpdb->term_relationships
				INNER JOIN $wpdb->term_taxonomy USING (term_taxonomy_id)
				INNER JOIN $wpdb->terms USING (term_id)
				WHERE $wpdb->posts.ID = object_id
				AND taxonomy = 'rlt_rule_headline'
				GROUP BY object_id
			) ";
			$orderby .= ('ASC' == strtoupper($wp_query->get('order'))) ? 'ASC' : 'DESC';
		}
		// We kijken of we sorteert wordt op topics
		else if(isset( $wp_query->query['orderby'] ) && 'rlt_rule_topic' == $wp_query->query['orderby']) {
			
			$orderby = "(
				SELECT GROUP_CONCAT(name ORDER BY name ASC)
				FROM $wpdb->term_relationships
				INNER JOIN $wpdb->term_taxonomy USING (term_taxonomy_id)
				INNER JOIN $wpdb->terms USING (term_id)
				WHERE $wpdb->posts.ID = object_id
				AND taxonomy = 'rlt_rule_topic'
				GROUP BY object_id
			) ";
			$orderby .= ('ASC' == strtoupper($wp_query->get('order'))) ? 'ASC' : 'DESC';
		}
		// We kijken of we sorteert wordt op years
		else if(isset( $wp_query->query['orderby'] ) && 'rlt_rule_year' == $wp_query->query['orderby']) {
			
			$orderby = "(
				SELECT GROUP_CONCAT(name ORDER BY name ASC)
				FROM $wpdb->term_relationships
				INNER JOIN $wpdb->term_taxonomy USING (term_taxonomy_id)
				INNER JOIN $wpdb->terms USING (term_id)
				WHERE $wpdb->posts.ID = object_id
				AND taxonomy = 'rlt_rule_year'
				GROUP BY object_id
			) ";
			$orderby .= ('ASC' == strtoupper($wp_query->get('order'))) ? 'ASC' : 'DESC';
		}
	}

	return $orderby;
}
add_filter('posts_orderby', 'taxonomy_column_rule_orderby', 10, 2);



/*  Bewerk pagina
	------------------------------------------------------------------------------ 	*/



/*  Frontend pagina
	------------------------------------------------------------------------------ 	*/

?>