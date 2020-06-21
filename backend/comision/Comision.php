<?php

// Register Custom Comisión
function oda_Comision() {

	$labels = array(
		'name'                  => _x( 'Comisiones', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Comisión', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Comisiones', 'text_domain' ),
		'name_admin_bar'        => __( 'Comisión', 'text_domain' ),
		'archives'              => __( 'Archivo de Comisiones', 'text_domain' ),
		'attributes'            => __( 'Atributos de la Comisión', 'text_domain' ),
		'parent_item_colon'     => __( 'Comisión padre:', 'text_domain' ),
		'all_items'             => __( 'Todas las Comisiones', 'text_domain' ),
		'add_new_item'          => __( 'Agregar nueva Comisión', 'text_domain' ),
		'add_new'               => __( 'Agregar nueva', 'text_domain' ),
		'new_item'              => __( 'Nueva Comisión', 'text_domain' ),
		'edit_item'             => __( 'Editar Comisión', 'text_domain' ),
		'update_item'           => __( 'Actualizar Comisión', 'text_domain' ),
		'view_item'             => __( 'Ver Comisión', 'text_domain' ),
		'view_items'            => __( 'Ver Comisiones', 'text_domain' ),
		'search_items'          => __( 'Buscar Comisión', 'text_domain' ),
		'not_found'             => __( 'No se encuentra', 'text_domain' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'text_domain' ),
		'featured_image'        => __( 'Logo de la Comisión', 'text_domain' ),
		'set_featured_image'    => __( 'Colocar logo de la Comisión', 'text_domain' ),
		'remove_featured_image' => __( 'Remover logo de la Comisión', 'text_domain' ),
		'use_featured_image'    => __( 'Usar como logo de la Comisión', 'text_domain' ),
		'insert_into_item'      => __( 'Insertar en la Comisión', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Subir a esta Comisión', 'text_domain' ),
		'items_list'            => __( 'Lista de Comisiones', 'text_domain' ),
		'items_list_navigation' => __( 'Navegación de lista de Comisiones', 'text_domain' ),
		'filter_items_list'     => __( 'Filtrar lista de Comisiones', 'text_domain' ),
	);
	$rewrite = array(
        'slug'                  => '%ciudad_owner%/comision',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Comisión', 'oda' ),
        'description'           => __( 'Soporte para Comisiones', 'oda' ),
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
    '0' => 'No Visible',
    '1' => 'Permanente',
    '2' => 'Ocasional',
);
define('ODA_ESTADOS_COMISION', $estados_comision);