<?php
if ( ! function_exists( 'oda_tax_tipo_sesion' ) ) {

    // Register Custom Taxonomy
    function oda_tax_tipo_sesion() {
    
        $labels = array(
            'name'                       => _x( 'Tipos de Sesión', 'Taxonomy General Name', 'oda' ),
            'singular_name'              => _x( 'Tipo de Sesión', 'Taxonomy Singular Name', 'oda' ),
            'menu_name'                  => __( 'Tipos de Sesión', 'oda' ),
            'all_items'                  => __( 'Todos los tipos', 'oda' ),
            'parent_item'                => __( 'Tipo padre', 'oda' ),
            'parent_item_colon'          => __( 'Tipo padre:', 'oda' ),
            'new_item_name'              => __( 'Nuevo Tipo', 'oda' ),
            'add_new_item'               => __( 'Agregar nuevo Tipo', 'oda' ),
            'edit_item'                  => __( 'Editar Tipo', 'oda' ),
            'update_item'                => __( 'Actualizar Tipo', 'oda' ),
            'view_item'                  => __( 'Ver Tipo', 'oda' ),
            'separate_items_with_commas' => __( 'Separar items con comas', 'oda' ),
            'add_or_remove_items'        => __( 'Agregar o eliminar Tipo', 'oda' ),
            'choose_from_most_used'      => __( 'Seleccionar de los mas usados', 'oda' ),
            'popular_items'              => __( 'Tipos populares', 'oda' ),
            'search_items'               => __( 'Buscar Tipo', 'oda' ),
            'not_found'                  => __( 'No se encuentra', 'oda' ),
            'no_terms'                   => __( 'Sin Tipos', 'oda' ),
            'items_list'                 => __( 'Lista de Tipo', 'oda' ),
            'items_list_navigation'      => __( 'Navegación de lista de Tipo', 'oda' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => false,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
        );
        register_taxonomy( 'tipo_sesion', array( 'sesion' ), $args );
    
    }
    add_action( 'init', 'oda_tax_tipo_sesion', 0 );
    
}

if ( ! function_exists( 'oda_tax_tipo_votacion' ) ) {

    // Register Custom Taxonomy
    function oda_tax_tipo_votacion() {
    
        $labels = array(
            'name'                       => _x( 'Tipos de Votación', 'Taxonomy General Name', 'oda' ),
            'singular_name'              => _x( 'Tipo de Votacion', 'Taxonomy Singular Name', 'oda' ),
            'menu_name'                  => __( 'Tipos de Votación', 'oda' ),
            'all_items'                  => __( 'Todos los tipos', 'oda' ),
            'parent_item'                => __( 'Tipo padre', 'oda' ),
            'parent_item_colon'          => __( 'Tipo padre:', 'oda' ),
            'new_item_name'              => __( 'Nuevo Tipo', 'oda' ),
            'add_new_item'               => __( 'Agregar nuevo Tipo', 'oda' ),
            'edit_item'                  => __( 'Editar Tipo', 'oda' ),
            'update_item'                => __( 'Actualizar Tipo', 'oda' ),
            'view_item'                  => __( 'Ver Tipo', 'oda' ),
            'separate_items_with_commas' => __( 'Separar items con comas', 'oda' ),
            'add_or_remove_items'        => __( 'Agregar o eliminar Tipo', 'oda' ),
            'choose_from_most_used'      => __( 'Seleccionar de los mas usados', 'oda' ),
            'popular_items'              => __( 'Tipos populares', 'oda' ),
            'search_items'               => __( 'Buscar Tipo', 'oda' ),
            'not_found'                  => __( 'No se encuentra', 'oda' ),
            'no_terms'                   => __( 'Sin Tipos', 'oda' ),
            'items_list'                 => __( 'Lista de Tipo', 'oda' ),
            'items_list_navigation'      => __( 'Navegación de lista de Tipo', 'oda' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => false,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
        );
        register_taxonomy( 'tipo_votacion', array( 'sesion' ), $args );
    
    }
    add_action( 'init', 'oda_tax_tipo_votacion', 0 );
    
}