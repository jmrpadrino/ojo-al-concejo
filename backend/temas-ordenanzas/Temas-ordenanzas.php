<?php

// Register Custom Tema
function oda_Tema_ordenanza() {

	$labels = array(
		'name'                  => _x( 'Temas', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Tema', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Temas Ordenanzas', 'oda' ),
		'name_admin_bar'        => __( 'Tema Ordenanza', 'oda' ),
		'archives'              => __( 'Archivo de Temas', 'oda' ),
		'attributes'            => __( 'Atributos de la Tema', 'oda' ),
		'parent_item_colon'     => __( 'Temas padre:', 'oda' ),
		'all_items'             => __( 'Todas las Temas', 'oda' ),
		'add_new_item'          => __( 'Agregar nueva Tema', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Tema', 'oda' ),
		'edit_item'             => __( 'Editar Tema', 'oda' ),
		'update_item'           => __( 'Actualizar Tema', 'oda' ),
		'view_item'             => __( 'Ver Tema', 'oda' ),
		'view_items'            => __( 'Ver Temas', 'oda' ),
		'search_items'          => __( 'Buscar Tema', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Tema', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Tema', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Tema', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Tema', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Tema', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Tema', 'oda' ),
		'items_list'            => __( 'Lista de Temas', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Temas', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Temas', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'tema-ordenanza',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Tema', 'oda' ),
        'description'           => __( 'Soporte para Temas', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'excerpt' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => false,
		'menu_position'         => 26,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todas-los-temas-de-ordenanza',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_tema_ord',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_temas_ord',
    );
    register_post_type( 'tema_ordenanza', $args );

}
add_action( 'init', 'oda_Tema_ordenanza', 0 );

add_action('admin_menu', 'oda_temas_menu_item'); 
function oda_temas_menu_item() { 
    add_submenu_page(
        'edit.php?post_type=ordenanza', 
        'Temas', 
        'Temas', 
        'manage_options', 
        'edit.php?post_type=tema_ordenanza'
    ); 
}