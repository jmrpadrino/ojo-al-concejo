<?php 
// Register Custom Post Type
function oda_sliders() {

	$labels = array(
		'name'                  => _x( 'Carruseles', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Carrusel', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Carruseles', 'oda' ),
		'name_admin_bar'        => __( 'Carrusel', 'oda' ),
		'archives'              => __( 'Archivo Carrusel', 'oda' ),
		'attributes'            => __( 'Atributos del Carrusel', 'oda' ),
		'parent_item_colon'     => __( 'Carrusel Padre:', 'oda' ),
		'all_items'             => __( 'Todos los carruseles', 'oda' ),
		'add_new_item'          => __( 'Agrega nuevo Carrusel', 'oda' ),
		'add_new'               => __( 'Agregar nuevo', 'oda' ),
		'new_item'              => __( 'Nuevo Carrusel', 'oda' ),
		'edit_item'             => __( 'Editar Carrusel', 'oda' ),
		'update_item'           => __( 'Actualizar Carrusel', 'oda' ),
		'view_item'             => __( 'Ver Carrusel', 'oda' ),
		'view_items'            => __( 'Ver Carruseles', 'oda' ),
		'search_items'          => __( 'Buscar Carrusel', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Imagen destacada', 'oda' ),
		'set_featured_image'    => __( 'Colocar imagen destacada', 'oda' ),
		'remove_featured_image' => __( 'Quitar images destacada', 'oda' ),
		'use_featured_image'    => __( 'Colocar como imagen destacada', 'oda' ),
		'insert_into_item'      => __( 'Insertar en el Carrusel', 'oda' ),
		'uploaded_to_this_item' => __( 'Cargado a este Carrusel', 'oda' ),
		'items_list'            => __( 'Lista de Carruseles', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Carrusel', 'oda' ),
		'filter_items_list'     => __( 'Lista de filtros de Carruseles', 'oda' ),
	);
	$args = array(
		'label'                 => __( 'Carrusel', 'oda' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 100,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon-ALT.png',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'oda_slider', $args );

}
add_action( 'init', 'oda_sliders', 0 );