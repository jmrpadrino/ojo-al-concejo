<?php

// Register Custom Comisión
function oda_Comision() {

	$labels = array(
		'name'                  => _x( 'Comisiones', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Comisión', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Comisiones', 'oda' ),
		'name_admin_bar'        => __( 'Comisión', 'oda' ),
		'archives'              => __( 'Archivo de Comisiones', 'oda' ),
		'attributes'            => __( 'Atributos de la Comisión', 'oda' ),
		'parent_item_colon'     => __( 'Comisión padre:', 'oda' ),
		'all_items'             => __( 'Todas las Comisiones', 'oda' ),
		'add_new_item'          => __( 'Agregar nueva Comisión', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Comisión', 'oda' ),
		'edit_item'             => __( 'Editar Comisión', 'oda' ),
		'update_item'           => __( 'Actualizar Comisión', 'oda' ),
		'view_item'             => __( 'Ver Comisión', 'oda' ),
		'view_items'            => __( 'Ver Comisiones', 'oda' ),
		'search_items'          => __( 'Buscar Comisión', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Comisión', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Comisión', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Comisión', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Comisión', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Comisión', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Comisión', 'oda' ),
		'items_list'            => __( 'Lista de Comisiones', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Comisiones', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Comisiones', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'comision',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Comisión', 'oda' ),
        'description'           => __( 'Soporte para Comisiones', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 28,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'todas-las-comisiones',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_comision',
        'rewrite'               => $rewrite,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'oda_comisiones',
    );
    register_post_type( 'comision', $args );

}
add_action( 'init', 'oda_Comision', 0 );

$estados_comision = array(
    '1' => 'Permanente',
    '2' => 'Ocasional',
);
define('ODA_ESTADOS_COMISION', $estados_comision);