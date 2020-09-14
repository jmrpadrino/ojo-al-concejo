<?php

// Register Custom Circunscripción
function oda_Circunscripcion() {

	$labels = array(
		'name'                  => _x( 'Circunscripciones', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Circunscripción', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Circunscripciones', 'oda' ),
		'name_admin_bar'        => __( 'Circunscripción', 'oda' ),
		'archives'              => __( 'Archivo de Circunscripciones', 'oda' ),
		'attributes'            => __( 'Atributos de la Circunscripción', 'oda' ),
		'parent_item_colon'     => __( 'Circunscripción padre:', 'oda' ),
		'all_items'             => __( 'Todas las Circunscripciones', 'oda' ),
		'add_new_item'          => __( 'Agregar nueva Circunscripción', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Circunscripción', 'oda' ),
		'edit_item'             => __( 'Editar Circunscripción', 'oda' ),
		'update_item'           => __( 'Actualizar Circunscripción', 'oda' ),
		'view_item'             => __( 'Ver Circunscripción', 'oda' ),
		'view_items'            => __( 'Ver Circunscripciones', 'oda' ),
		'search_items'          => __( 'Buscar Circunscripción', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Circunscripción', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Circunscripción', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Circunscripción', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Circunscripción', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Circunscripción', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Circunscripción', 'oda' ),
		'items_list'            => __( 'Lista de Circunscripciones', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Circunscripciones', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Circunscripciones', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'circunscripcion',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Circunscripción', 'oda' ),
        'description'           => __( 'Soporte para Circunscripciones', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 27,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todas-las-circunscripciones',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_circunscripcion',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_circunscripciones',
    );
    register_post_type( 'circunscripcion', $args );

}
add_action( 'init', 'oda_Circunscripcion', 0 );