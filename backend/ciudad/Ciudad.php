<?php

// Register Custom Ciudad
function oda_Ciudad() {

	$labels = array(
		'name'                  => _x( 'Ciudades', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Ciudad', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Ciudades', 'oda' ),
		'name_admin_bar'        => __( 'Ciudad', 'oda' ),
		'archives'              => __( 'Archivo de Ciudades', 'oda' ),
		'attributes'            => __( 'Atributos de la Ciudad', 'oda' ),
		'parent_item_colon'     => __( 'Ciudades padre:', 'oda' ),
		'all_items'             => __( 'Todas las Ciudades', 'oda' ),
		'add_new_item'          => __( 'Agregar nueva Ciudad', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Ciudad', 'oda' ),
		'edit_item'             => __( 'Editar Ciudad', 'oda' ),
		'update_item'           => __( 'Actualizar Ciudad', 'oda' ),
		'view_item'             => __( 'Ver Ciudad', 'oda' ),
		'view_items'            => __( 'Ver Ciudades', 'oda' ),
		'search_items'          => __( 'Buscar Ciudad', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Ciudad', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Ciudad', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Ciudad', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Ciudad', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Ciudad', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Ciudad', 'oda' ),
		'items_list'            => __( 'Lista de Ciudades', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Ciudades', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Ciudades', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'ciudad',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Ciudad', 'oda' ),
        'description'           => __( 'Soporte para Ciudades', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 26,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todas-las-ciudades',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_ciudad',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_ciudades',
    );
    register_post_type( 'ciudad', $args );

}
add_action( 'init', 'oda_Ciudad', 0 );