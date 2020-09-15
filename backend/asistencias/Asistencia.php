<?php

// Register Custom Sesion
function oda_Asistencia() {

	$labels = array(
		'name'                  => _x( 'Asistencias', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Asistencia', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Asistencias', 'oda' ),
		'name_admin_bar'        => __( 'Asistencia', 'oda' ),
		'archives'              => __( 'Archivo de Asistencias', 'oda' ),
		'attributes'            => __( 'Atributos de la Asistencia', 'oda' ),
		'parent_item_colon'     => __( 'Asistencias padre:', 'oda' ),
		'all_items'             => __( 'Todas las Asistencias', 'oda' ),
		'add_new_item'          => __( 'Configurar nueva Asistencia', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Asistencia', 'oda' ),
		'edit_item'             => __( 'Editar Asistencia', 'oda' ),
		'update_item'           => __( 'Actualizar Asistencia', 'oda' ),
		'view_item'             => __( 'Ver Asistencia', 'oda' ),
		'view_items'            => __( 'Ver Asistencias', 'oda' ),
		'search_items'          => __( 'Buscar Asistencia', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Asistencia', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Asistencia', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Asistencia', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Asistencia', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Asistencia', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Asistencia', 'oda' ),
		'items_list'            => __( 'Lista de Asistencias', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Asistencias', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Asistencias', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'asistencia',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Asistencia', 'oda' ),
        'description'           => __( 'Soporte para Asistencias', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => false,
		'menu_position'         => 33,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => 'todas-las-asistencias',
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_asistencia',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_Asistencias',
    );
    register_post_type( 'asistencia', $args );

}
add_action( 'init', 'oda_Asistencia', 0 );