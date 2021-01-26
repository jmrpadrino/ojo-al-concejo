<?php

// Register Custom Sesion
function oda_solicitud_comp() {

	$labels = array(
		'name'                  => _x( 'Solicitud de Comparecencia', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Solicitud', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Solicitud de Comparecencia', 'oda' ),
		'name_admin_bar'        => __( 'Solicitud', 'oda' ),
		'archives'              => __( 'Archivo de Solicitudes de Comparecencia', 'oda' ),
		'attributes'            => __( 'Atributos de la Solicitud', 'oda' ),
		'parent_item_colon'     => __( 'Solicitud de Comparecencia padre:', 'oda' ),
		'all_items'             => __( 'Todas las Solicitudes de Comparecencia', 'oda' ),
		'add_new_item'          => __( 'Configurar nueva Solicitud', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Solicitud', 'oda' ),
		'edit_item'             => __( 'Editar Solicitud', 'oda' ),
		'update_item'           => __( 'Actualizar Solicitud', 'oda' ),
		'view_item'             => __( 'Ver Solicitud', 'oda' ),
		'view_items'            => __( 'Ver Solicitudes de Comparecencia', 'oda' ),
		'search_items'          => __( 'Buscar Solicitud', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Solicitud', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Solicitud', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Solicitud', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Solicitud', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Solicitud', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Solicitud', 'oda' ),
		'items_list'            => __( 'Lista de Solicitudes de Comparecencia', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Solicitudes de Comparecencia', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Solicitudes de Comparecencia', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'solicitud-comp',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Solicitud', 'oda' ),
        'description'           => __( 'Soporte para Solicitudes de Comparecencia', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => false,
		'menu_position'         => 38,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => 'todas-las-solicitudes-comp',
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_solicitud_comp',
        'rewrite'               => $rewrite,
        'capability_type'       => array('comparescencia','comparescencias'),
		'map_meta_cap'    		=> true,
        'show_in_rest'          => true,
        'rest_base'             => 'oda_solicitudes_comp',
    );
    register_post_type( 'solicitud-comp', $args );

}
add_action( 'init', 'oda_solicitud_comp', 0 );
