<?php

// Register Custom Sesion
function oda_Mocion() {

	$labels = array(
		'name'                  => _x( 'Mociones', 'Post Type General Name', 'oda' ),
		'singular_name'         => _x( 'Moción', 'Post Type Singular Name', 'oda' ),
		'menu_name'             => __( 'Mociones', 'oda' ),
		'name_admin_bar'        => __( 'Moción', 'oda' ),
		'archives'              => __( 'Archivo de Mociones', 'oda' ),
		'attributes'            => __( 'Atributos de la Moción', 'oda' ),
		'parent_item_colon'     => __( 'Mociones padre:', 'oda' ),
		'all_items'             => __( 'Todas las Mociones', 'oda' ),
		'add_new_item'          => __( 'Configurar nueva Moción', 'oda' ),
		'add_new'               => __( 'Agregar nueva', 'oda' ),
		'new_item'              => __( 'Nueva Moción', 'oda' ),
		'edit_item'             => __( 'Editar Moción', 'oda' ),
		'update_item'           => __( 'Actualizar Moción', 'oda' ),
		'view_item'             => __( 'Ver Moción', 'oda' ),
		'view_items'            => __( 'Ver Mociones', 'oda' ),
		'search_items'          => __( 'Buscar Moción', 'oda' ),
		'not_found'             => __( 'No se encuentra', 'oda' ),
		'not_found_in_trash'    => __( 'No se encuentra en papelera', 'oda' ),
		'featured_image'        => __( 'Logo de la Moción', 'oda' ),
		'set_featured_image'    => __( 'Colocar logo de la Moción', 'oda' ),
		'remove_featured_image' => __( 'Remover logo de la Moción', 'oda' ),
		'use_featured_image'    => __( 'Usar como logo de la Moción', 'oda' ),
		'insert_into_item'      => __( 'Insertar en la Moción', 'oda' ),
		'uploaded_to_this_item' => __( 'Subir a esta Moción', 'oda' ),
		'items_list'            => __( 'Lista de Mociones', 'oda' ),
		'items_list_navigation' => __( 'Navegación de lista de Mociones', 'oda' ),
		'filter_items_list'     => __( 'Filtrar lista de Mociones', 'oda' ),
	);
	$rewrite = array(
        'slug'                  => 'mocion',
        'with_front'            => false,
        'pages'                 => true,
        'feeds'                 => true,
    );
    $args = array(
        'label'                 => __( 'Moción', 'oda' ),
        'description'           => __( 'Soporte para Mociones', 'oda' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'revisions' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
		'menu_position'         => 33,
		'menu_icon'             => ODA_DIR_URL . 'images/FCD-menu-icon.png',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => 'todas-las-mociones',
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'query_var'             => 'qv_mocion',
        'rewrite'               => $rewrite,
        'show_in_rest'          => true,
        'rest_base'             => 'oda_Mociones',
        'capability_type'       => array('mocion','mociones'),
		'map_meta_cap'    		=> true,
    );
    register_post_type( 'mocion', $args );

}
add_action( 'init', 'oda_Mocion', 0 );


add_filter( 'manage_posts_columns', 'oda_mocion_columns_head' );
add_action( 'manage_posts_custom_column', 'oda_mocion_columns_content', 10, 2 );
add_action('admin_head', 'oda_mocion_styling_admin_order_list' );
function oda_mocion_styling_admin_order_list() {
?>
<style>
    .label-status {
        display: block;
        border-radius: 4px;
        background-color: #ececec;
        padding: 7px 7px;
        text-align: center;
        width: 120px;
        min-width: 80px;
        border-left: 5px solid;
        font-weight: bold;
    }

    .no-relation {
        border-color: red;
        color: red;
    }

</style>
<?php
	if ( $_GET['post_type'] == 'mocion' ){
?> 
<script>
	jQuery(document).ready(function(){
		jQuery('.row-actions .edit').remove();
		jQuery('.row-actions .view').remove();
		jQuery('.row-actions .editinline').remove();
		jQuery('.row-actions .inline').remove();
		jQuery('.page-title-action').remove();
		jQuery.each( jQuery('.row-title'), function(index, value){
            jQuery(this).parents('.iedit');
            var itemHref = jQuery(this).attr('href');
            var parentRowID = jQuery(this).parents('.iedit').attr('id');
			//console.log(jQuery(this).attr('href'));
            //console.log(jQuery('.sesion-'+parentRowID).data('mocion'));
            itemHref += '&parent_sesion='+ jQuery('.sesion-'+parentRowID).data('mocion')
            itemHref += '&item='+ jQuery('.hash-'+parentRowID).data('mocion')
            jQuery(this).attr('href',itemHref);
            console.log(jQuery(this).attr('href'));
		});
	})
</script>
<?php
	}
}

function oda_mocion_columns_head($defaults){
    if ( $_GET['post_type'] == 'mocion' ){
        unset($defaults['date']);
        $defaults['ciudad'] = 'Ciudad';
        $defaults['sesion'] = 'Nombre de la Sesión';
        $defaults['sesionid'] = 'Sesión ID';
        $defaults['itemhash'] = 'Item HASH';
    }
    return $defaults;
}

function oda_mocion_columns_content($column_name, $post_ID){

    if ( $_GET['post_type'] == 'mocion' ){

		if ( $column_name == 'ciudad'){
			$post_padre = get_post_meta($post_ID, 'oda_parent_sesion', true);
			$ciudad_ID = get_post_meta( $post_padre, ODA_PREFIX . 'ciudad_owner', true);
            $ciudad_color = get_post_meta( $ciudad_ID, ODA_PREFIX . 'ciudad_color', true);
            if ( empty( $ciudad_ID ) ){
                echo '<span class="label-status no-relation">Sin ciudad</span>';
            }else{
                echo '<span class="label-status" style="border-color:'. $ciudad_color .';">' . get_the_title($ciudad_ID) . '</span>';
            }
        }

        if ( $column_name == 'sesion'){
			$post_padre = get_post_meta($post_ID, 'oda_parent_sesion', true);
			$sesion_padre = get_the_title($post_padre);
			if ($sesion_padre){
				echo $sesion_padre;
			}else{
				echo 'No pertenece a ninguna sesion.';
			}
        }

        if ( $column_name == 'sesionid'){
			$itemhash = get_post_meta($post_ID, 'oda_parent_sesion', true);
			echo '<span class="sesion-post-'.$post_ID.'" data-mocion="'.$itemhash.'">'.$itemhash.'</span>';
        }

        if ( $column_name == 'itemhash'){
			$itemhash = get_post_meta($post_ID, 'oda_sesion_item', true);
			echo '<span class="hash-post-'.$post_ID.'" data-mocion="'.$itemhash.'">'.$itemhash.'</span>';
        }

    }

}
function mocion_menu_page_removing() {
    remove_submenu_page('edit.php?post_type=mocion','post-new.php?post_type=mocion');
}
add_action( 'admin_menu', 'mocion_menu_page_removing' );