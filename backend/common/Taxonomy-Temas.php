<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    TAXONOMY "TEMAS" FOR: ORDENANZAS - RESOLUCIONES
-------------------------------------------------------------- */
function oda_taxonomy_temas() {

    $labels = array(
        'name'                       => _x( 'Temas', 'Taxonomy General Name', 'oda' ),
        'singular_name'              => _x( 'Tema', 'Taxonomy Singular Name', 'oda' ),
        'menu_name'                  => __( 'Temas', 'oda' ),
        'all_items'                  => __( 'Todos los Temas', 'oda' ),
        'parent_item'                => __( 'Tema Padre', 'oda' ),
        'parent_item_colon'          => __( 'Tema Padre:', 'oda' ),
        'new_item_name'              => __( 'Nuevo Tema', 'oda' ),
        'add_new_item'               => __( 'Añadir Tema', 'oda' ),
        'edit_item'                  => __( 'Editar Tema', 'oda' ),
        'update_item'                => __( 'Actualizar Tema', 'oda' ),
        'view_item'                  => __( 'Ver Tema', 'oda' ),
        'separate_items_with_commas' => __( 'Separar temas por comas', 'oda' ),
        'add_or_remove_items'        => __( 'Agregar o Remover Temas', 'oda' ),
        'choose_from_most_used'      => __( 'Escoger de los más usados', 'oda' ),
        'popular_items'              => __( 'Temas Populares', 'oda' ),
        'search_items'               => __( 'Buscar Temas', 'oda' ),
        'not_found'                  => __( 'No hay resultados', 'oda' ),
        'no_terms'                   => __( 'No hay temas', 'oda' ),
        'items_list'                 => __( 'Listado de Temas', 'oda' ),
        'most_used'                  => __( 'Temas Más Usados', 'oda' ),
        'items_list_navigation'      => __( 'Navegación del Listado de Temas', 'oda' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest'               => true,
    );
    //register_taxonomy( 'temas', array( 'ordenanza', 'resolucion' ), $args );

}

add_action( 'init', 'oda_taxonomy_temas', 0 );
