<?php
/**
 * Met het includen van dit bestand wordt een custom post type voor recepten toegevoegt
 * 
 * @author Brian de Geus - GeusMedia
 * @since 1.0
 * @version 1.0
 */

/*  Registratie
	------------------------------------------------------------------------------ 	*/
 
/**
 * Registreer de Custom Post Type voor recepten
 */
add_action('init', function() {
	global $plugin_base_dir;
	
	// Argumenten voor registreer functie
	$args = array(
		'labels' => array(
			'name' => 'Recepten',
			'singular_name' => 'Recept',
			'add_new' => 'Nieuw recept',
			'add_new_item' => 'Nieuw recept toevoegen',
			'edit_item' => 'Bewerk recept',
			'new_item' => 'Nieuw recept',
			'view_item' => 'Bekijk recept',
			'search_items' => 'Zoek recepten',
			'not_found' => 'Geen recepten gevonden',
			'not_found_in_trash' => 'Geen recepten gevonden in de prullenbak'
		),
		'query_var' => 'recept',
		'rewrite' => array(
			'slug' => 'recept' 		// 'slug' => 'recept/' 
		),
		'taxonomies' => array(
			'bdx_recipe_ingredient',
			'bdx_recipe_chef'
		),
		'public' => true,
		'publicly_queryable' => true,
		'menu_icon' => '',
		'show_ui' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array(
			'title',
			'editor',
			'excerpt',
			'thumbnail'
		),
        'has_archive' => true

	);
	// Registreer de Custom Post Type
	register_post_type('bdx_recipe', $args);
});

/**
 * Registreer de custom taxonomies: ingrediënten en chefs
 */
add_action('init', function() {
	register_taxonomy(
        'bdx_recipe_ingredient',
        'bdx_recipe',
        array(
            'labels' => array(
                'name' => 'Ingrediënten',
                'add_new_item' => 'Ingrediënt toevoegen',
                'new_item_name' => "Nieuw ingrediënt"
            ),
            'rewrite' => array(
                'slug' => 'ingredient'
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => false
        )
    );
	register_taxonomy(
		'bdx_recipe_chef',
		'bdx_recipe',
		array(
			'labels' => array(
				'name' => 'Chefs',
				'add_new_item' => 'Chef toevoegen',
				'new_item_name' => "Nieuwe chef"
			),
            'rewrite' => array(
                'slug' => 'chef'
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
 * Voeg de kolommen toe in correcte volgorde
 */
add_filter('manage_edit-bdx_recipe_columns', function($columns) {
	$temp = array(
		'cb' => $columns['cb'],
		'title' => $columns['title'],
		'bdx_recipe_chef' => 'Chef',
		'bdx_recipe_ingredient' => 'Ingrediënten'
	);
	
	$columns = $temp + $columns;
	
    return $columns;
});

/**
 * Vul de kolommen
 */
add_action('manage_posts_custom_column', function($column) {
    if('bdx_recipe_chef' == $column) {
			$_taxonomy = 'bdx_recipe_chef';
			$terms = get_the_terms(get_the_ID(), $_taxonomy);
			if(!empty( $terms)) {
				$out = array();
				foreach($terms as $c)
					$out[] = "<a href='edit-tags.php?action=edit&taxonomy=$_taxonomy&post_type=book&tag_ID={$c->term_id}'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
				echo join(', ', $out);
			}
			else {
				_e('Uncategorized');
			}
        }
        else if('bdx_recipe_ingredient' == $column) {
			$_taxonomy = 'bdx_recipe_ingredient';
			$terms = get_the_terms(get_the_ID(), $_taxonomy);
			if(!empty( $terms)) {
				$out = array();
				foreach($terms as $c)
					$out[] = "<a href='edit-tags.php?action=edit&taxonomy=$_taxonomy&post_type=book&tag_ID={$c->term_id}'> " . esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display')) . "</a>";
				echo join(', ', $out);
			}
			else {
				_e('Uncategorized');
			}
        }
    
});

/**
 * Sorteer de tabel op chef voor WordPress
 */
add_filter('request', function($vars) {
    if(!is_admin())
        return $vars;
    if(isset($vars['orderby']) && 'bdx_recipe_chef' == $vars['orderby']) {
        $vars = array_merge($vars, array('meta_key' => 'bdx_recipe_chef', 'orderby' => 'meta_value'));
    }
    return $vars;
});

/**
 * Implementeer de functie voor filter dropdown met chefs
 */
add_action('restrict_manage_posts', function() {
    $screen = get_current_screen();
    global $wp_query;
    if($screen->post_type == 'bdx_recipe') {
        wp_dropdown_categories( 
	        array(
	            'show_option_all' => 'Alle chefs tonen',
	            'taxonomy' => 'bdx_recipe_chef',
	            'name' => 'bdx_recipe_chef',
	            'orderby' => 'name',
	            'selected' => (isset( $wp_query->query['bdx_recipe_chef']) ? $wp_query->query['bdx_recipe_chef'] : ''),
	            'hierarchical' => false,
	            'depth' => 3,
	            'show_count' => false,
	            'hide_empty' => true,
	        )
		);
    }
});

/**
 * Filter de resultaten als de dropdown gebruikt wordt
 */
add_filter('parse_query', function($query) {
    $qv = &$query->query_vars;
    if(isset($qv['bdx_recipe_chef']) && ($qv['bdx_recipe_chef']) && is_numeric($qv['bdx_recipe_chef'])) {
        $term = get_term_by('id', $qv['bdx_recipe_chef'], 'bdx_recipe_chef');
        $qv['bdx_recipe_chef'] = $term->slug;
    }
});

/*  Bewerk pagina
	------------------------------------------------------------------------------ 	*/



/*  Frontend pagina
	------------------------------------------------------------------------------ 	*/

?>