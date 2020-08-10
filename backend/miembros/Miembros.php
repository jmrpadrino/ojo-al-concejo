<?php
    // Register Custom Alcaldía
function oda_Miembros() {

	$labels = array(
		'name'                  => _x( 'Miembros', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Miembro', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Miembros', 'oda' ),
		'name_admin_bar'        => __( 'Miembro', 'oda' ),
		'archives'              => __( 'Archivo de Miembros', 'oda' ),
		'attributes'            => __( 'Atributos de la Miembro', 'oda' ),
		'parent_item_colon'     => __( 'Miembros padre:', 'oda' ),
		'all_items'             => __( 'Todos los Miembros', 'oda' ),
		'add_new_item'          => __( 'Agregar nuevo Miembro', 'oda' ),
		'add_new'               => __( 'Agregar nuevo', 'oda' ),
		'new_item'              => __( 'Nueva Miembro', 'oda' ),
		'edit_item'             => __( 'Editar Miembro', 'oda' ),
		'update_item'           => __( 'Actualizar Miembro', 'oda' ),
		'view_item'             => __( 'Ver Miembro', 'oda' ),
		'view_items'            => __( 'Ver Miembros', 'oda' ),
		'search_items'          => __( 'Buscar Miembro', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Miembro', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo del Miembro', 'oda' ),
		'remove_featured_image' => __( 'Remover logo del Miembro', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo del Miembro', 'oda' ),
		'insert_into_item'      => __( 'Insertar en el Miembro', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Miembro', 'oda' ),
		'items_list'            => __( 'Lista de Miembros', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Miembros', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Miembros', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'ciudad/%city_slug%/miembro',        
        'with_front'            => false,
    );
    $args = array(
        'label'                 => __( 'Miembro', 'oda' ),
        'description'           => __( 'Soporte para Miembros', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 30,
        'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todos-los-miembros',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_miembro',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_miembros',
    );
    register_post_type( 'miembro', $args );

}
add_action( 'init', 'oda_Miembros', 0 );

/**
 * Custom URL Request for Miembro
 */
add_filter( 'post_type_link', 'replace_rewrite_tags_for_miembro', 100, 2);
function replace_rewrite_tags_for_miembro ($url, $post){

    if ( 
        is_wp_error($post) || 
        'miembro' != $post->post_type ||
        empty( $post->post_name )
    )
    return $url;

    $ba = strtolower( get_post_meta($post->ID, ODA_PREFIX . 'ciudad_owner', true) );
    $alcaldia = get_post($ba);

    return str_replace('%city_slug%', $alcaldia->post_name, $url);

}

/**
 * Custom rewrite tag for Miembro
 */
add_action('init', 'miembro_rewriter_rule');
function miembro_rewriter_rule(){
    // You can use this to set a different name both query var and tag
    // add_rewrite_tag( '%alcaldia_owner%', '([^&]+)', 'alcaldia_owner=');
    add_rewrite_tag( '%city_slug%', '([^&]+)');    
    add_rewrite_tag( '%member_name%', '([^&]+)');

    add_rewrite_rule('ciudad/([^/]+)/miembro/([^/]+)/?', 'index.php?city_slug=$matches[1]&oda_template=miembro&member_name=$matches[2]', 'top');
}

/**
 * Custom query var for Miembro
 */

 /*
add_filter('query_vars', 'concejal_query_var'); 
function concejal_query_var($vars){
    $vars[] = 'alcaldia_owner';
    return $vars;
}

*/

 /**
 * Custom pre_get_post for Miembro
 */
add_action('pre_get_posts', 'pre_get_posts_miembro'); 
function pre_get_posts_miembro($query){

    // check if inside wordpress admin
    if ( is_admin() || ! $query->is_main_query() ){
        return;
    }

    $meta_query = [];
    
    $ciudad = get_query_var( 'oda_ciudad_owner' );

    
    // Get parent custom post type
    $args = array(
        'name' => $ciudad,
        'post_type' => 'ciudad',
        'post_status' => 'publish',
        'numberposts' => 1
    );
    $alcaldia_id = get_posts($args);
    //var_dump($query);
    //die;

    if ( !empty( $circunscripcion ) ) {
        $meta_query[] = array(
            'key' => ODA_PREFIX . 'ciudad_owner',
            'value' => $alcaldia_id[0]->ID,
            'compare' => '='
        );
        if ( count( $meta_query ) > 1 ) {
            $meta_query['relation'] = 'AND';
        }
        if ( count( $meta_query ) > 0 ) {
            $query->set('meta_query', $meta_query);
        }

    }else{
        return;
    }

}