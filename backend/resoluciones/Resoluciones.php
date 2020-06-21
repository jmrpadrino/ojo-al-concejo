<?php
    // Register Custom Alcaldía
function oda_Resoluciones() {

	$labels = array(
		'name'                  => _x( 'Resoluciones', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Resolución', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Resoluciones', 'text_domain' ),
		'name_admin_bar'        => __( 'Resolución', 'text_domain' ),
		'archives'              => __( 'Archivo de Resoluciones', 'text_domain' ),
		'attributes'            => __( 'Atributos de la Resolución', 'text_domain' ),
		'parent_item_colon'     => __( 'Resolución padre:', 'text_domain' ),
		'all_items'             => __( 'Todas las Resoluciones', 'text_domain' ),
		'add_new_item'          => __( 'Agregar nueva Resolución', 'text_domain' ),
		'add_new'               => __( 'Agregar nueva', 'text_domain' ),
		'new_item'              => __( 'Nueva Resolución', 'text_domain' ),
		'edit_item'             => __( 'Editar Resolución', 'text_domain' ),
		'update_item'           => __( 'Actualizar Resolución', 'text_domain' ),
		'view_item'             => __( 'Ver Resolución', 'text_domain' ),
		'view_items'            => __( 'Ver Resoluciones', 'text_domain' ),
		'search_items'          => __( 'Buscar Resolución', 'text_domain' ),
		'not_found'             => __( 'No se encuentra', 'text_domain' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'text_domain' ),
		'featured_image'        => __( 'Logo de la Resolución', 'text_domain' ),
		'set_featured_image'    => __( 'Colocar logo de la Resolución', 'text_domain' ),
		'remove_featured_image' => __( 'Remover logo de la Resolución', 'text_domain' ),
		'use_featured_image'    => __( 'Usar como logo de la Resolución', 'text_domain' ),
		'insert_into_item'      => __( 'Insertar en la Resolución', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Subir a esta Resolución', 'text_domain' ),
		'items_list'            => __( 'Lista de Resoluciones', 'text_domain' ),
		'items_list_navigation' => __( 'Navegación de lista de Resoluciones', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de Resoluciones', 'text_domain' ),
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
		'menu_position'         => 5,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todas-las-resoluciones',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'resolucion',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_resoluciones',
    );
    register_post_type( 'resolucion', $args );

}
add_action( 'init', 'oda_Resoluciones', 0 );