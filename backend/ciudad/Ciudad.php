<?php

// Register Custom Ciudad
function oda_Ciudad() {

	$labels = array(
		'name'                  => _x( 'Ciudades', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Ciudad', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Ciudades', 'text_domain' ),
		'name_admin_bar'        => __( 'Ciudad', 'text_domain' ),
		'archives'              => __( 'Archivo de Ciudades', 'text_domain' ),
		'attributes'            => __( 'Atributos de la Ciudad', 'text_domain' ),
		'parent_item_colon'     => __( 'Ciudades padre:', 'text_domain' ),
		'all_items'             => __( 'Todas las Ciudades', 'text_domain' ),
		'add_new_item'          => __( 'Agregar nueva Ciudad', 'text_domain' ),
		'add_new'               => __( 'Agregar nueva', 'text_domain' ),
		'new_item'              => __( 'Nueva Ciudad', 'text_domain' ),
		'edit_item'             => __( 'Editar Ciudad', 'text_domain' ),
		'update_item'           => __( 'Actualizar Ciudad', 'text_domain' ),
		'view_item'             => __( 'Ver Ciudad', 'text_domain' ),
		'view_items'            => __( 'Ver Ciudades', 'text_domain' ),
		'search_items'          => __( 'Buscar Ciudad', 'text_domain' ),
		'not_found'             => __( 'No se encuentra', 'text_domain' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'text_domain' ),
		'featured_image'        => __( 'Logo de la Ciudad', 'text_domain' ),
		'set_featured_image'    => __( 'Colocar logo de la Ciudad', 'text_domain' ),
		'remove_featured_image' => __( 'Remover logo de la Ciudad', 'text_domain' ),
		'use_featured_image'    => __( 'Usar como logo de la Ciudad', 'text_domain' ),
		'insert_into_item'      => __( 'Insertar en la Ciudad', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Subir a esta Ciudad', 'text_domain' ),
		'items_list'            => __( 'Lista de Ciudades', 'text_domain' ),
		'items_list_navigation' => __( 'Navegación de lista de Ciudades', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de Ciudades', 'text_domain' ),
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