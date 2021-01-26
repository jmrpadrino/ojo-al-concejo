<?php
    // Register Custom Alcaldía
function oda_Resoluciones() {

	$labels = array(
		'name'                  => _x( 'Resoluciones', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Resolución', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Resoluciones', 'oda' ),
		'name_admin_bar'        => __( 'Resolución', 'oda' ),
		'archives'              => __( 'Archivo de Resoluciones', 'oda' ),
		'attributes'            => __( 'Atributos de la Resolución', 'oda' ),
		'parent_item_colon'     => __( 'Resolución padre:', 'oda' ),
		'all_items'             => __( 'Todas las Resoluciones', 'oda' ),
		'add_new_item'          => __( 'Agregar nueva Resolución', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Resolución', 'oda' ),
		'edit_item'             => __( 'Editar Resolución', 'oda' ),
		'update_item'           => __( 'Actualizar Resolución', 'oda' ),
		'view_item'             => __( 'Ver Resolución', 'oda' ),
		'view_items'            => __( 'Ver Resoluciones', 'oda' ),
		'search_items'          => __( 'Buscar Resolución', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Resolución', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Resolución', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Resolución', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Resolución', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Resolución', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Resolución', 'oda' ),
		'items_list'            => __( 'Lista de Resoluciones', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Resoluciones', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Resoluciones', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'resolucion',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Resolución', 'oda' ),
        'description'           => __( 'Soporte para Resoluciones', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 32,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todas-las-resoluciones',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'resolucion',
        'rewrite'               => $rewrite,
        'capability_type'       => array('resolucion','resoluciones'),
		'map_meta_cap'    		=> true,
        'show_in_rest'          => true,
        'rest_base'             => 'oda_resoluciones',
    );
    register_post_type( 'resolucion', $args );

}
add_action( 'init', 'oda_Resoluciones', 0 );
