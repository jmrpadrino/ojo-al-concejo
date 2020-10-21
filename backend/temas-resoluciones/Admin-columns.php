<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    ORDENANZAS: HOOKS AND FILTERS
--------------------------------------------------------------- */
add_filter( 'manage_posts_columns', 'oda_tema_res_columns_head' );
add_action( 'manage_posts_custom_column', 'oda_tema_res_columns_content', 10, 2 );
add_action('admin_head', 'oda_tema_res_styling_admin_order_list' );

/* --------------------------------------------------------------
    ORDENANZAS: STYLE
--------------------------------------------------------------- */
function oda_tema_res_styling_admin_order_list() {
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
    ORDENANZAS: ADMIN COLUMNS
--------------------------------------------------------------- */
function oda_tema_res_columns_head($defaults){
    if ( $_GET['post_type'] == 'tema_resolucion' ){
        unset($defaults['comments']);
        unset($defaults['taxonomy-temas']);
        unset($defaults['date']);
        $defaults['ciudad'] = 'Ciudad';
    }
    return $defaults;
}

/* --------------------------------------------------------------
    ORDENANZAS: ADMIN COLUMNS CONTENT
--------------------------------------------------------------- */
function oda_tema_res_columns_content($column_name, $post_ID){

    if ( $_GET['post_type'] == 'tema_resolucion' ){

        if ( $column_name == 'ciudad'){
            $ciudad_ID = get_post_meta( $post_ID, ODA_PREFIX . 'ciudad_owner', true);
            $ciudad_color = get_post_meta( $ciudad_ID, ODA_PREFIX . 'ciudad_color', true);
            if ( empty( $ciudad_ID ) ){
                echo '<span class="label-status no-relation">Sin ciudad</span>';
            }else{
                echo '<span class="label-status" style="border-color:'. $ciudad_color .';">' . get_the_title($ciudad_ID) . '</span>';
            }
        }

    }

}


