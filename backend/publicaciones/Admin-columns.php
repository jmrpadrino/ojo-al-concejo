<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    PUBLICACIONES: HOOKS AND FILTERS
--------------------------------------------------------------- */
add_filter( 'manage_posts_columns', 'oda_publicacion_columns_head' );
add_action( 'manage_posts_custom_column', 'oda_publicacion_columns_content', 10, 2 );
add_action('admin_head', 'oda_publicacion_styling_admin_order_list' );

/* --------------------------------------------------------------
    PUBLICACIONES: STYLE
--------------------------------------------------------------- */
function oda_publicacion_styling_admin_order_list() {
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
    PUBLICACIONES: ADMIN COLUMNS
--------------------------------------------------------------- */
function oda_publicacion_columns_head($defaults){
    if ( $_GET['post_type'] == 'publicacion' ){
        unset($defaults['comments']);
        unset($defaults['date']);
        $defaults['tipo_publicacion'] = 'Tipo de Publicación';
        $defaults['cod_issuu'] = 'Código ISSUU';
        $defaults['date'] = __('Fecha', 'oda');
    }
    return $defaults;
}

/* --------------------------------------------------------------
    PUBLICACIONES: ADMIN COLUMNS CONTENT
--------------------------------------------------------------- */
function oda_publicacion_columns_content($column_name, $post_ID){
    if ( $_GET['post_type'] == 'publicacion' ){
        if ( $column_name == 'cod_issuu'){
            $nro_tramite = get_post_meta( $post_ID, ODA_PREFIX . 'publicacion_issuu', true);
            if ($nro_tramite != '') {
                echo $nro_tramite;
            } else {
                _e('Sin código', 'oda');
            }
        }

        if ( $column_name == 'tipo_publicacion'){
            $iniciativa_value = get_post_meta( $post_ID, ODA_PREFIX . 'tipo_publicacion', true);

            $iniciativa_array = array(
                'anual'       => __( 'Informe Anual', 'oda' ),
                'especial'      => __( 'Informe Especial', 'oda' ),
            );

            if ($iniciativa_value != '') {
                echo $iniciativa_array[$iniciativa_value];
            } else {
                _e('Sin Tipo de Publicación Seleccionada', 'oda');
            }


        }
    }
}

/**
 * Edit List Filters form
 */
/*
add_action('manage_posts_extra_tablenav', 'oda_filter_form_publicaciones');

function oda_filter_form_publicaciones(){
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
        <select for="ciudad" name="oda_publicacion_iniciativa">
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
