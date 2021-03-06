<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    ORDENANZAS: HOOKS AND FILTERS
--------------------------------------------------------------- */
add_filter( 'manage_posts_columns', 'oda_sesion_columns_head' );
add_action( 'manage_posts_custom_column', 'oda_sesion_columns_content', 10, 2 );
add_action('admin_head', 'oda_sesion_styling_admin_order_list' );

/* --------------------------------------------------------------
    ORDENANZAS: STYLE
--------------------------------------------------------------- */
function oda_sesion_styling_admin_order_list() {
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
function oda_sesion_columns_head($defaults){
    if ( $_GET['post_type'] == 'sesion' ){
        unset($defaults['comments']);
        unset($defaults['taxonomy-temas']);
        unset($defaults['date']);
        $defaults['ciudad'] = 'Ciudad';
        $defaults['sesion_date'] = __('Fecha Sesion', 'oda');
        $defaults['mociones'] = __('Mociones', 'oda');
    }
    return $defaults;
}

/* --------------------------------------------------------------
    ORDENANZAS: ADMIN COLUMNS CONTENT
--------------------------------------------------------------- */
function oda_sesion_columns_content($column_name, $post_ID){

    if ( $_GET['post_type'] == 'sesion' ){

        if ( $column_name == 'ciudad'){
            $ciudad_ID = get_post_meta( $post_ID, ODA_PREFIX . 'ciudad_owner', true);
            $ciudad_color = get_post_meta( $ciudad_ID, ODA_PREFIX . 'ciudad_color', true);
            if ( empty( $ciudad_ID ) ){
                echo '<span class="label-status no-relation">Sin ciudad</span>';
            }else{
                echo '<span class="label-status" style="border-color:'. $ciudad_color .';">' . get_the_title($ciudad_ID) . '</span>';
            }
        }
        if ( $column_name == 'sesion_date'){ 
            $date = get_post_meta( $post_ID, ODA_PREFIX . 'sesion_fecha', true);
            if($date){
                echo date('d/m/Y', strtotime( $date ));
            }
        }
        if ( $column_name == 'mociones'){ 
            echo get_post_meta( $post_ID, ODA_PREFIX . 'sesion_fecha', true);
        }
    }

}

/**
 * Edit List Filters form
 */
/*
add_action('manage_posts_extra_tablenav', 'oda_filter_form_ordenanzas');

function oda_filter_form_ordenanzas(){
    add_thickbox();
?>
<a class="thickbox button" href="#TB_inline?&width=600&height=550&inlineId=more_filters">Mas filtros</a>
<div id="more_filters" style="display:none;">
    <?php
    echo 'algo '.get_current_screen()->parent_file;
    $args = array(
        'post_type' => 'ciudad',
        'posts_per_page' => -1
    );
    $ciudades = new WP_Query($args);
    if($ciudades->have_posts()){
    ?>
    <label for="ciudad">Filtrar por Inicativa
        <select for="ciudad" name="oda_ordenanza_iniciativa">
            <option>Seleccione una ciudad</option>
            <?php while($ciudades->have_posts()){ $ciudades->the_post(); ?>
            <option value="<?php echo get_the_ID(); ?>"><?php echo get_the_title(); ?></option>
            <?php } //end while ?>
        </select>
    </label>
    <?php } // End if ?>
    <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filtrar">
</div>
<?php
}
*/
