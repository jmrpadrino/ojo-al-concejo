<?php

// Register Custom Sesion
function oda_instituciones() {

	$labels = array(
		'name'                  => _x( 'Instituciones', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Institución', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Instituciones', 'oda' ),
		'name_admin_bar'        => __( 'Institución', 'oda' ),
		'archives'              => __( 'Archivo de Instituciónes', 'oda' ),
		'attributes'            => __( 'Atributos de la Institución', 'oda' ),
		'parent_item_colon'     => __( 'Instituciones padre:', 'oda' ),
		'all_items'             => __( 'Todas las Instituciónes', 'oda' ),
		'add_new_item'          => __( 'Configurar nueva Institución', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Institución', 'oda' ),
		'edit_item'             => __( 'Editar Institución', 'oda' ),
		'update_item'           => __( 'Actualizar Institución', 'oda' ),
		'view_item'             => __( 'Ver Institución', 'oda' ),
		'view_items'            => __( 'Ver Instituciónes', 'oda' ),
		'search_items'          => __( 'Buscar Institución', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Institución', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Institución', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Institución', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Institución', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Institución', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Institución', 'oda' ),
		'items_list'            => __( 'Lista de Instituciónes', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Instituciónes', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Instituciónes', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'instituciones',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Institución', 'oda' ),
        'description'           => __( 'Soporte para Instituciónes', 'oda' ),
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
        'has_archive'           => 'todas-las-instituciones',
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_instituciones',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_solicitudes_info',
    );
    register_post_type( 'instituciones', $args );

}
add_action( 'init', 'oda_instituciones', 0 );
