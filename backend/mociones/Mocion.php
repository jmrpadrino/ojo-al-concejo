<?php

// Register Custom Sesion
function oda_Mocion() {

	$labels = array(
		'name'                  => _x( 'Mociones', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Moción', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Mociones', 'oda' ),
		'name_admin_bar'        => __( 'Moción', 'oda' ),
		'archives'              => __( 'Archivo de Mociones', 'oda' ),
		'attributes'            => __( 'Atributos de la Moción', 'oda' ),
		'parent_item_colon'     => __( 'Mociones padre:', 'oda' ),
		'all_items'             => __( 'Todas las Mociones', 'oda' ),
		'add_new_item'          => __( 'Configurar nueva Moción', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Moción', 'oda' ),
		'edit_item'             => __( 'Editar Moción', 'oda' ),
		'update_item'           => __( 'Actualizar Moción', 'oda' ),
		'view_item'             => __( 'Ver Moción', 'oda' ),
		'view_items'            => __( 'Ver Mociones', 'oda' ),
		'search_items'          => __( 'Buscar Moción', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Moción', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Moción', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Moción', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Moción', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Moción', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Moción', 'oda' ),
		'items_list'            => __( 'Lista de Mociones', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Mociones', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Mociones', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'mocion',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Moción', 'oda' ),
        'description'           => __( 'Soporte para Mociones', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 33,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => 'todas-las-mociones',
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_mocion',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_Mociones',
    );
    register_post_type( 'mocion', $args );

}
add_action( 'init', 'oda_Mocion', 0 );