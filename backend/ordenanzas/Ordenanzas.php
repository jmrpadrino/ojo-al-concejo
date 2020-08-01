<?php
    // Register Custom Alcaldía
function oda_Ordenanzas() {

	$labels = array(
		'name'                  => _x( 'Ordenanzas', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Ordenanza', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Ordenanzas', 'oda' ),
		'name_admin_bar'        => __( 'Ordenanza', 'oda' ),
		'archives'              => __( 'Archivo de Ordenanzas', 'oda' ),
		'attributes'            => __( 'Atributos de la Ordenanza', 'oda' ),
		'parent_item_colon'     => __( 'Ordenanza padre:', 'oda' ),
		'all_items'             => __( 'Todas las Ordenanzas', 'oda' ),
		'add_new_item'          => __( 'Agregar nueva Ordenanza', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Ordenanza', 'oda' ),
		'edit_item'             => __( 'Editar Ordenanza', 'oda' ),
		'update_item'           => __( 'Actualizar Ordenanza', 'oda' ),
		'view_item'             => __( 'Ver Ordenanza', 'oda' ),
		'view_items'            => __( 'Ver Ordenanzas', 'oda' ),
		'search_items'          => __( 'Buscar Ordenanza', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Ordenanza', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Ordenanza', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Ordenanza', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Ordenanza', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Ordenanza', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Ordenanza', 'oda' ),
		'items_list'            => __( 'Lista de Ordenanzas', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Ordenanzas', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Ordenanzas', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'resolucion',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Ordenanza', 'oda' ),
        'description'           => __( 'Soporte para Ordenanzas', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 31,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todas-las-ordenanzas',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'resolucion',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_ordenanzas',
    );
    register_post_type( 'ordenanza', $args );

}
add_action( 'init', 'oda_Ordenanzas', 0 );
