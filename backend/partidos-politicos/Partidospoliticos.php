<?php

// Register Custom Organización Política
function oda_Partidos() {

	$labels = array(
		'name'                  => _x( 'Organizaciones Políticas', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Organización Política', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Org. Políticas', 'text_domain' ),
		'name_admin_bar'        => __( 'Organización Política', 'text_domain' ),
		'archives'              => __( 'Archivo de Organizaciones Políticas', 'text_domain' ),
		'attributes'            => __( 'Atributos de la Organización Política', 'text_domain' ),
		'parent_item_colon'     => __( 'Organizaciones Políticas padre:', 'text_domain' ),
		'all_items'             => __( 'Todas las Organizaciones Políticas', 'text_domain' ),
		'add_new_item'          => __( 'Agregar nueva Organización Política', 'text_domain' ),
		'add_new'               => __( 'Agregar nueva', 'text_domain' ),
		'new_item'              => __( 'Nueva Organización Política', 'text_domain' ),
		'edit_item'             => __( 'Editar Organización Política', 'text_domain' ),
		'update_item'           => __( 'Actualizar Organización Política', 'text_domain' ),
		'view_item'             => __( 'Ver Organización Política', 'text_domain' ),
		'view_items'            => __( 'Ver Organizaciones Políticas', 'text_domain' ),
		'search_items'          => __( 'Buscar Organización Política', 'text_domain' ),
		'not_found'             => __( 'No se encuentra', 'text_domain' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'text_domain' ),
		'featured_image'        => __( 'Logo de la Organización Política', 'text_domain' ),
		'set_featured_image'    => __( 'Colocar logo de la Organización Política', 'text_domain' ),
		'remove_featured_image' => __( 'Remover logo de la Organización Política', 'text_domain' ),
		'use_featured_image'    => __( 'Usar como logo de la Organización Política', 'text_domain' ),
		'insert_into_item'      => __( 'Insertar en la Organización Política', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Subir a esta Organización Política', 'text_domain' ),
		'items_list'            => __( 'Lista de Organizaciones Políticas', 'text_domain' ),
		'items_list_navigation' => __( 'Navegación de lista de Organizaciones Políticas', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de Organizaciones Políticas', 'text_domain' ),
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
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_partidos_politicos',
    );
    register_post_type( 'partido', $args );

}
add_action( 'init', 'oda_Partidos', 0 );