<?php

add_action('admin_enqueue_scripts', 'oda_insert_scripts_miembros');
function oda_insert_scripts_miembros(){
    if (!is_admin()) return;
    
    if ( 'miembro' == get_current_screen()->post_type ) {
        wp_enqueue_script('oda_admin_script_jqui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery'), '1', true );
        wp_enqueue_script('oda_admin_script_miembros', ODA_DIR_URL . 'backend/miembros/js/admin-script-miembros.js', array('jquery'), '1', true );
    }
}

add_action('wp_ajax_oda_miembros_carga_circunscripcion','oda_miembros_carga_circunscripcion');
function oda_miembros_carga_circunscripcion()
{
    $args = array(
        'post_type' => 'circunscripcion',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_key' => ODA_PREFIX . 'ciudad_owner',
        'orderby'    => 'meta_value_num',
        'order'      => 'ASC',
        'meta_query' => array(
            array(
                'key' => ODA_PREFIX . 'ciudad_owner',
                'value' => $_GET['id_post'],
            )
        )
    );
    $circunscripcion = new WP_Query($args);

    if ( !$circunscripcion->have_posts() ){
        wp_die();
    }else{
        $data = array();
        while( $circunscripcion->have_posts() ){
            $circunscripcion->the_post();
            $data[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title()
            );
        }
        echo json_encode($data);
    }
	wp_die();
}