<?php
    // Register Custom Alcaldía
function oda_Miembros() {

	$labels = array(
		'name'                  => _x( 'Miembros', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Miembro', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Miembros', 'text_domain' ),
		'name_admin_bar'        => __( 'Miembro', 'text_domain' ),
		'archives'              => __( 'Archivo de Miembros', 'text_domain' ),
		'attributes'            => __( 'Atributos de la Miembro', 'text_domain' ),
		'parent_item_colon'     => __( 'Miembros padre:', 'text_domain' ),
		'all_items'             => __( 'Todas las Miembros', 'text_domain' ),
		'add_new_item'          => __( 'Agregar nueva Miembro', 'text_domain' ),
		'add_new'               => __( 'Agregar nueva', 'text_domain' ),
		'new_item'              => __( 'Nueva Miembro', 'text_domain' ),
		'edit_item'             => __( 'Editar Miembro', 'text_domain' ),
		'update_item'           => __( 'Actualizar Miembro', 'text_domain' ),
		'view_item'             => __( 'Ver Miembro', 'text_domain' ),
		'view_items'            => __( 'Ver Miembros', 'text_domain' ),
		'search_items'          => __( 'Buscar Miembro', 'text_domain' ),
		'not_found'             => __( 'No se encuentra', 'text_domain' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'text_domain' ),
		'featured_image'        => __( 'Logo de la Miembro', 'text_domain' ),
		'set_featured_image'    => __( 'Colocar logo de la Miembro', 'text_domain' ),
		'remove_featured_image' => __( 'Remover logo de la Miembro', 'text_domain' ),
		'use_featured_image'    => __( 'Usar como logo de la Miembro', 'text_domain' ),
		'insert_into_item'      => __( 'Insertar en la Miembro', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Subir a esta Miembro', 'text_domain' ),
		'items_list'            => __( 'Lista de Miembros', 'text_domain' ),
		'items_list_navigation' => __( 'Navegación de lista de Miembros', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de Miembros', 'text_domain' ),
	);
	$rewrite = array(
        'slug'                  => 'ciudad/%' .ODA_PREFIX . 'circunscripcion_owner%/miembro',
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
        'menu_position'         => 5,
        'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todos-los-miembros',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'miembro',
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

    $ba = strtolower( get_post_meta($post->ID, ODA_PREFIX . 'circunscripcion_owner', true) );
    $alcaldia = get_post($ba);

    return str_replace('%'.ODA_PREFIX.'circunscripcion_owner%', $alcaldia->post_name, $url);

}

/**
 * Custom rewrite tag for Miembro
 */
add_action('init', 'miembro_rewriter_rule');
function miembro_rewriter_rule(){
    // You can use this to set a different name both query var and tag
    // add_rewrite_tag( '%alcaldia_owner%', '([^&]+)', 'alcaldia_owner=');
    add_rewrite_tag( '%'.ODA_PREFIX.'circunscripcion_owner%', '([^&]+)');

    //add_rewrite_rule('^circunscripcion/([^/]+)/miembro/([^/]+)/?', 'index.php?circunscripcion_owner=$matches[1]', 'top');
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
    
    $circunscripcion = get_query_var( 'circunscripcion_owner' );

    
    // Get parent custom post type
    $args = array(
        'name' => $circunscripcion,
        'post_type' => 'circunscripcion',
        'post_status' => 'publish',
        'numberposts' => 1
    );
    $alcaldia_id = get_posts($args);
    //var_dump($query);
    //die;

    if ( !empty( $circunscripcion ) ) {
        $meta_query[] = array(
            'key' => ODA_PREFIX . 'circunscripcion_owner',
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