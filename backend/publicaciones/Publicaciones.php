<?php
    // Register Custom Alcaldía
function oda_Publicaciones() {

	$labels = array(
		'name'                  => _x( 'Publicaciones', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Publicación', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Publicaciones', 'oda' ),
		'name_admin_bar'        => __( 'Publicación', 'oda' ),
		'archives'              => __( 'Archivo de Publicaciones', 'oda' ),
		'attributes'            => __( 'Atributos de la Publicación', 'oda' ),
		'parent_item_colon'     => __( 'Publicación padre:', 'oda' ),
		'all_items'             => __( 'Todas las Publicaciones', 'oda' ),
		'add_new_item'          => __( 'Agregar nueva Publicación', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Publicación', 'oda' ),
		'edit_item'             => __( 'Editar Publicación', 'oda' ),
		'update_item'           => __( 'Actualizar Publicación', 'oda' ),
		'view_item'             => __( 'Ver Publicación', 'oda' ),
		'view_items'            => __( 'Ver Publicaciones', 'oda' ),
		'search_items'          => __( 'Buscar Publicación', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Publicación', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Publicación', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Publicación', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Publicación', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Publicación', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Publicación', 'oda' ),
		'items_list'            => __( 'Lista de Publicaciones', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Publicaciones', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Publicaciones', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'publicacion',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Publicación', 'oda' ),
        'description'           => __( 'Soporte para Publicaciones', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 99,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon-ALT.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todas-las-publicaciones',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'publicacion',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_publicaciones',
    );
    register_post_type( 'publicacion', $args );

}
add_action( 'init', 'oda_publicaciones', 0 );
