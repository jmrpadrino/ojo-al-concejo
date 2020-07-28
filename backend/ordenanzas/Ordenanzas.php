<?php
    // Register Custom Alcaldía
function oda_Ordenanzas() {

	$labels = array(
		'name'                  => _x( 'Ordenanzas', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Ordenanza', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Ordenanzas', 'text_domain' ),
		'name_admin_bar'        => __( 'Ordenanza', 'text_domain' ),
		'archives'              => __( 'Archivo de Ordenanzas', 'text_domain' ),
		'attributes'            => __( 'Atributos de la Ordenanza', 'text_domain' ),
		'parent_item_colon'     => __( 'Ordenanza padre:', 'text_domain' ),
		'all_items'             => __( 'Todas las Ordenanzas', 'text_domain' ),
		'add_new_item'          => __( 'Agregar nueva Ordenanza', 'text_domain' ),
		'add_new'               => __( 'Agregar nueva', 'text_domain' ),
		'new_item'              => __( 'Nueva Ordenanza', 'text_domain' ),
		'edit_item'             => __( 'Editar Ordenanza', 'text_domain' ),
		'update_item'           => __( 'Actualizar Ordenanza', 'text_domain' ),
		'view_item'             => __( 'Ver Ordenanza', 'text_domain' ),
		'view_items'            => __( 'Ver Ordenanzas', 'text_domain' ),
		'search_items'          => __( 'Buscar Ordenanza', 'text_domain' ),
		'not_found'             => __( 'No se encuentra', 'text_domain' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'text_domain' ),
		'featured_image'        => __( 'Logo de la Ordenanza', 'text_domain' ),
		'set_featured_image'    => __( 'Colocar logo de la Ordenanza', 'text_domain' ),
		'remove_featured_image' => __( 'Remover logo de la Ordenanza', 'text_domain' ),
		'use_featured_image'    => __( 'Usar como logo de la Ordenanza', 'text_domain' ),
		'insert_into_item'      => __( 'Insertar en la Ordenanza', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Subir a esta Ordenanza', 'text_domain' ),
		'items_list'            => __( 'Lista de Ordenanzas', 'text_domain' ),
		'items_list_navigation' => __( 'Navegación de lista de Ordenanzas', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de Ordenanzas', 'text_domain' ),
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
