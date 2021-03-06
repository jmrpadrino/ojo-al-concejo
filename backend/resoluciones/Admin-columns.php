<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    RESOLUCIONES: HOOKS AND FILTERS
--------------------------------------------------------------- */
add_filter( 'manage_posts_columns', 'oda_resolucion_columns_head' );
add_action( 'manage_posts_custom_column', 'oda_resolucion_columns_content', 10, 2 );
add_action('admin_head', 'oda_resolucion_styling_admin_order_list' );

/* --------------------------------------------------------------
    RESOLUCIONES: STYLE
--------------------------------------------------------------- */
function oda_resolucion_styling_admin_order_list() {
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
}

/* --------------------------------------------------------------
    RESOLUCIONES: ADMIN COLUMNS
--------------------------------------------------------------- */
function oda_resolucion_columns_head($defaults){
    if ( $_GET['post_type'] == 'resolucion' ){
        unset($defaults['comments']);
        unset($defaults['taxonomy-temas']);
        unset($defaults['date']);
        $defaults['ciudad'] = 'Ciudad';
        $defaults['tramite'] = 'Número de Trámite';
        $defaults['presentacion'] = 'Fecha de Presentación';
        $defaults['iniciativa'] = 'Iniciativa';
        $defaults['date'] = __('Fecha', 'oda');
    }
    return $defaults;
}

/* --------------------------------------------------------------
    RESOLUCIONES: ADMIN COLUMNS CONTENT
--------------------------------------------------------------- */
function oda_resolucion_columns_content($column_name, $post_ID){

    if ( $_GET['post_type'] == 'resolucion' ){

        if ( $column_name == 'ciudad'){
            $ciudad_ID = get_post_meta( $post_ID, ODA_PREFIX . 'ciudad_owner', true);
            $ciudad_color = get_post_meta( $ciudad_ID, ODA_PREFIX . 'ciudad_color', true);
            if ( empty( $ciudad_ID ) ){
                echo '<span class="label-status no-relation">Sin ciudad</span>';
            }else{
                echo '<span class="label-status" style="border-color:'. $ciudad_color .';">' . get_the_title($ciudad_ID) . '</span>';
            }
        }

        if ( $column_name == 'tramite'){
            $nro_tramite = get_post_meta( $post_ID, ODA_PREFIX . 'resolucion_nro_tramite', true);
            if ($nro_tramite != '') {
                echo $nro_tramite;
            } else {
                _e('Sin número', 'oda');
            }
        }

        if ( $column_name == 'presentacion'){
            $fecha_presentacion =  get_post_meta( $post_ID, ODA_PREFIX . 'resolucion_fecha', true);
            if ($fecha_presentacion != '') {
                echo $fecha_presentacion;
            } else {
                _e('Sin Fecha', 'oda');
            }
        }

        if ( $column_name == 'iniciativa'){
            $iniciativa_value = get_post_meta( $post_ID, ODA_PREFIX . 'resolucion_iniciativa', true);

            $iniciativa_array = array(
                'alcalde'       => __( 'Alcalde', 'oda' ),
                'concejal'      => __( 'Concejal', 'oda' ),
                'comisiones'    => __( 'Comisiones', 'oda' ),
                'ciudadania'    => __( 'Ciudadanía', 'oda' ),
            );

            $ciudad_color = get_post_meta( $ciudad_ID, ODA_PREFIX . 'ciudad_color', true);
            if ( empty( $iniciativa_value ) ){
                echo '<span class="label-status no-relation">Sin Iniciativa</span>';
            }else{
                echo '<span class="label-status" style="border-color:'. $ciudad_color .';">' . $iniciativa_array[$iniciativa_value] . '</span>';
            }
        }
    }
}
