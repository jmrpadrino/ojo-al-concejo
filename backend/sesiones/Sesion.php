<?php

// Register Custom Sesion
function oda_Sesion() {

	$labels = array(
		'name'                  => _x( 'Sesiones', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Sesión', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Sesiones', 'oda' ),
		'name_admin_bar'        => __( 'Sesión', 'oda' ),
		'archives'              => __( 'Archivo de Sesiones', 'oda' ),
		'attributes'            => __( 'Atributos de la Sesión', 'oda' ),
		'parent_item_colon'     => __( 'Sesiones padre:', 'oda' ),
		'all_items'             => __( 'Todas las Sesiones', 'oda' ),
		'add_new_item'          => __( 'Agregar nueva Sesión', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Sesión', 'oda' ),
		'edit_item'             => __( 'Editar Sesión', 'oda' ),
		'update_item'           => __( 'Actualizar Sesión', 'oda' ),
		'view_item'             => __( 'Ver Sesión', 'oda' ),
		'view_items'            => __( 'Ver Sesiones', 'oda' ),
		'search_items'          => __( 'Buscar Sesión', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Sesión', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Sesión', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Sesión', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Sesión', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Sesión', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Sesión', 'oda' ),
		'items_list'            => __( 'Lista de Sesiones', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Sesiones', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Sesiones', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'sesion',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Sesión', 'oda' ),
        'description'           => __( 'Soporte para Sesiones', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 33,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todas-las-sesiones',
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_sesion',
        'rewrite'               => $rewrite,
        'capability_type'       => array('sesion','sesiones'),
		'map_meta_cap'    		=> true,
        'show_in_rest'          => true,
        'rest_base'             => 'oda_Sesiones',
    );
    register_post_type( 'sesion', $args );

}
add_action( 'init', 'oda_Sesion', 0 );