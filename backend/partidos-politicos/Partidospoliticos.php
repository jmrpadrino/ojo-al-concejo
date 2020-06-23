<?php

// Register Custom Partido Político
function oda_Partidos() {

	$labels = array(
		'name'                  => _x( 'Partidos Políticos', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Partido Político', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Partidos Políticos', 'text_domain' ),
		'name_admin_bar'        => __( 'Partido Político', 'text_domain' ),
		'archives'              => __( 'Archivo de Partidos Políticos', 'text_domain' ),
		'attributes'            => __( 'Atributos de la Partido Político', 'text_domain' ),
		'parent_item_colon'     => __( 'Partidos Políticos padre:', 'text_domain' ),
		'all_items'             => __( 'Todas las Partidos Políticos', 'text_domain' ),
		'add_new_item'          => __( 'Agregar nueva Partido Político', 'text_domain' ),
		'add_new'               => __( 'Agregar nueva', 'text_domain' ),
		'new_item'              => __( 'Nueva Partido Político', 'text_domain' ),
		'edit_item'             => __( 'Editar Partido Político', 'text_domain' ),
		'update_item'           => __( 'Actualizar Partido Político', 'text_domain' ),
		'view_item'             => __( 'Ver Partido Político', 'text_domain' ),
		'view_items'            => __( 'Ver Partidos Políticos', 'text_domain' ),
		'search_items'          => __( 'Buscar Partido Político', 'text_domain' ),
		'not_found'             => __( 'No se encuentra', 'text_domain' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'text_domain' ),
		'featured_image'        => __( 'Logo de la Partido Político', 'text_domain' ),
		'set_featured_image'    => __( 'Colocar logo de la Partido Político', 'text_domain' ),
		'remove_featured_image' => __( 'Remover logo de la Partido Político', 'text_domain' ),
		'use_featured_image'    => __( 'Usar como logo de la Partido Político', 'text_domain' ),
		'insert_into_item'      => __( 'Insertar en la Partido Político', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Subir a esta Partido Político', 'text_domain' ),
		'items_list'            => __( 'Lista de Partidos Políticos', 'text_domain' ),
		'items_list_navigation' => __( 'Navegación de lista de Partidos Políticos', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de Partidos Políticos', 'text_domain' ),
	);
	$rewrite = array(
        'slug'                  => 'partido-politico',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Partido Político', 'oda' ),
        'description'           => __( 'Soporte para Partidos Políticos', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 29,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todas-los-partidos',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_partido',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_partidos_politicos',
    );
    register_post_type( 'partido', $args );

}
add_action( 'init', 'oda_Partidos', 0 );