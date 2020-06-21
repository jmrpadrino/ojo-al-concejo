<?php

// Register Custom Circunscripción
function oda_Circunscripcion() {

	$labels = array(
		'name'                  => _x( 'Circunscripciones', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Circunscripción', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Circunscripciones', 'text_domain' ),
		'name_admin_bar'        => __( 'Circunscripción', 'text_domain' ),
		'archives'              => __( 'Archivo de Circunscripciones', 'text_domain' ),
		'attributes'            => __( 'Atributos de la Circunscripción', 'text_domain' ),
		'parent_item_colon'     => __( 'Circunscripción padre:', 'text_domain' ),
		'all_items'             => __( 'Todas las Circunscripciones', 'text_domain' ),
		'add_new_item'          => __( 'Agregar nueva Circunscripción', 'text_domain' ),
		'add_new'               => __( 'Agregar nueva', 'text_domain' ),
		'new_item'              => __( 'Nueva Circunscripción', 'text_domain' ),
		'edit_item'             => __( 'Editar Circunscripción', 'text_domain' ),
		'update_item'           => __( 'Actualizar Circunscripción', 'text_domain' ),
		'view_item'             => __( 'Ver Circunscripción', 'text_domain' ),
		'view_items'            => __( 'Ver Circunscripciones', 'text_domain' ),
		'search_items'          => __( 'Buscar Circunscripción', 'text_domain' ),
		'not_found'             => __( 'No se encuentra', 'text_domain' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'text_domain' ),
		'featured_image'        => __( 'Logo de la Circunscripción', 'text_domain' ),
		'set_featured_image'    => __( 'Colocar logo de la Circunscripción', 'text_domain' ),
		'remove_featured_image' => __( 'Remover logo de la Circunscripción', 'text_domain' ),
		'use_featured_image'    => __( 'Usar como logo de la Circunscripción', 'text_domain' ),
		'insert_into_item'      => __( 'Insertar en la Circunscripción', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Subir a esta Circunscripción', 'text_domain' ),
		'items_list'            => __( 'Lista de Circunscripciones', 'text_domain' ),
		'items_list_navigation' => __( 'Navegación de lista de Circunscripciones', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de Circunscripciones', 'text_domain' ),
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
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 5,
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