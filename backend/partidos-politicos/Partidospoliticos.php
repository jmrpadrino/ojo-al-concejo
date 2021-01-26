<?php

// Register Custom Organización Política
function oda_Partidos() {

	$labels = array(
		'name'                  => _x( 'Organizaciones Políticas', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Organización Política', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Org. Políticas', 'oda' ),
		'name_admin_bar'        => __( 'Organización Política', 'oda' ),
		'archives'              => __( 'Archivo de Organizaciones Políticas', 'oda' ),
		'attributes'            => __( 'Atributos de la Organización Política', 'oda' ),
		'parent_item_colon'     => __( 'Organizaciones Políticas padre:', 'oda' ),
		'all_items'             => __( 'Todas las Organizaciones Políticas', 'oda' ),
		'add_new_item'          => __( 'Agregar nueva Organización Política', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Organización Política', 'oda' ),
		'edit_item'             => __( 'Editar Organización Política', 'oda' ),
		'update_item'           => __( 'Actualizar Organización Política', 'oda' ),
		'view_item'             => __( 'Ver Organización Política', 'oda' ),
		'view_items'            => __( 'Ver Organizaciones Políticas', 'oda' ),
		'search_items'          => __( 'Buscar Organización Política', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Organización Política', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Organización Política', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Organización Política', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Organización Política', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Organización Política', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Organización Política', 'oda' ),
		'items_list'            => __( 'Lista de Organizaciones Políticas', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Organizaciones Políticas', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Organizaciones Políticas', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'partido-politico',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Organización Política', 'oda' ),
        'description'           => __( 'Soporte para Organizaciones Políticas', 'oda' ),
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
        'capability_type'       => array('partido','partidos'),
		'map_meta_cap'    		=> true,
        'show_in_rest'          => true,
        'rest_base'             => 'oda_partidos_politicos',
    );
    register_post_type( 'partido', $args );

}
add_action( 'init', 'oda_Partidos', 0 );