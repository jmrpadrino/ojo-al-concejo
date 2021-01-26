<?php
    // Register Custom Alcaldía
function oda_Observacion() {

	$labels = array(
		'name'                  => _x( 'Observaciones', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Observación', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Observaciones', 'oda' ),
		'name_admin_bar'        => __( 'Observación', 'oda' ),
		'archives'              => __( 'Archivo de Observaciones', 'oda' ),
		'attributes'            => __( 'Atributos de la Observación', 'oda' ),
		'parent_item_colon'     => __( 'Observación padre:', 'oda' ),
		'all_items'             => __( 'Todas las Observaciones', 'oda' ),
		'add_new_item'          => __( 'Agregar nueva Observación', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Observación', 'oda' ),
		'edit_item'             => __( 'Editar Observación', 'oda' ),
		'update_item'           => __( 'Actualizar Observación', 'oda' ),
		'view_item'             => __( 'Ver Observación', 'oda' ),
		'view_items'            => __( 'Ver Observaciones', 'oda' ),
		'search_items'          => __( 'Buscar Observación', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Observación', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Observación', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Observación', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Observación', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Observación', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Observación', 'oda' ),
		'items_list'            => __( 'Lista de Observaciones', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Observaciones', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Observaciones', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'observacion',
        'with_front'            => true,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Observación', 'oda' ),
        'description'           => __( 'Soporte para Observaciones', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => false,
		'menu_position'         => 31,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => 'todas-las-observaciones',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'query_var'             => 'observacion',
        'rewrite'               => $rewrite,
        'capability_type'       => array('observacion','observaciones'),
		'map_meta_cap'    		=> true,
        'show_in_rest'          => true,
        'rest_base'             => 'oda_observaciones',
    );
    register_post_type( 'observacion', $args );

}
add_action( 'init', 'oda_Observacion', 0 );

add_action('admin_menu', 'oda_observacion_menu_item'); 
function oda_observacion_menu_item() { 
    add_submenu_page(
        'edit.php?post_type=ordenanza', 
        'Observaciones', 
        'Observaciones', 
        'manage_options', 
        'edit.php?post_type=observacion'
    ); 
}
