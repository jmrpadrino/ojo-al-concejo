<?php

add_filter( 'manage_posts_columns', 'oda_miembro_columns_head' );
add_action( 'manage_posts_custom_column', 'oda_miembro_columns_content', 10, 2 );
add_action('admin_head', 'oda_miembro_styling_admin_order_list' );
function oda_miembro_styling_admin_order_list() {
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

function oda_miembro_columns_head($defaults){
    if ( $_GET['post_type'] == 'miembro' ){
        unset($defaults['date']);
        $defaults['ciudad'] = 'Ciudad';
        $defaults['curul'] = 'Curul';
        $defaults['participa'] = '<span title="¿Participa en el Concejo?">¿PEC?</span>';
        $defaults['suplente'] = '<span title="¿Es miembro suplente?">¿Suplente?</span>';
        $defaults['date'] = __('Fecha', 'oda');
    }
    return $defaults;
}

function oda_miembro_columns_content($column_name, $post_ID){

    if ( $_GET['post_type'] == 'miembro' ){

        if ( $column_name == 'ciudad'){
            $ciudad_ID = get_post_meta( $post_ID, ODA_PREFIX . 'ciudad_owner', true);
            $ciudad_color = get_post_meta( $ciudad_ID, ODA_PREFIX . 'ciudad_color', true);
            if ( empty( $ciudad_ID ) ){
                echo '<span class="label-status no-relation">Sin ciudad</span>';
            }else{
                echo '<span class="label-status" style="border-color:'. $ciudad_color .';">' . get_the_title($ciudad_ID) . '</span>';
            }
        }

        if ( $column_name == 'curul'){
            echo get_post_meta( $post_ID, ODA_PREFIX . 'miembro_curul', true);
        }

        if ( $column_name == 'participa'){
            if ('on' === get_post_meta( $post_ID, ODA_PREFIX . 'miembro_participa', true) ) {
                echo '<i class="fas fa-check-circle" style="color: green; font-size: 18px;"></i>';
            }else{
                echo '<i class="far fa-times-circle" style="font-size: 18px;"></i>';
            }
        }

        if ( $column_name == 'suplente'){
            if ('on' === get_post_meta( $post_ID, ODA_PREFIX . 'miembro_es_supente', true) ) {
                echo '<i class="fas fa-check-circle" style="color: green; font-size: 18px;"></i>';
            }
        }
    }

}

function oda_miembro_add_dashboard_widget() {

    wp_add_dashboard_widget(
        'gmDir_listado_capacitaciones',
        '<img width="20" src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . _x('Próximas Capacitaciones', 'oda'),
        'oda_miembro_dashboard_order_label_statues'
    );
}
add_action( 'wp_dashboard_setup', 'oda_miembro_add_dashboard_widget' );
function oda_miembro_dashboard_order_label_statues() {

    $args = array(
        'post_type' => 'capacitacion',
        'posts_per_page' => 15,
        'post_status' => 'publish'
    );
    $capacitaciones = new WP_Query($args);

    if (!$capacitaciones->have_posts()){
        echo 'No hay Capacitaciones agregadas aún.';
    }else{
        echo '<table class="lk24-dashboard-table" width="100%" border="0" align="center">';
        echo '<thead>';
        echo '<tr>';
        echo '<td><strong>Nombre</strong></td>';
        echo '<td width="100"><strong>Fecha</strong></td>';
        echo '<td align="center"><strong>Estado</strong></td>';
        echo '<td>&nbsp;</td>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($capacitaciones->have_posts()){
            $capacitaciones->the_post();
            //			var_dump($order->get_status());
            echo '<tr>';
            echo '<td height="40">'. get_the_title() .'</td>';
            echo '<td>'. date('d-m-Y', strtotime(get_post_meta(get_the_ID(),'gmDir_inicio', true)) ) .'</td>';

            $today = date('U');
            $event_date = date('U', strtotime(get_post_meta(get_the_ID(), 'gmDir_inicio', true)));
            $dia1 = date('Ymd',$today);
            if (date('Ymd', $today) == date('Ymd', $event_date)){
                echo '<td><span class="label-status status-2">En Curso</span></td>';
            }else{
                if ($today > $event_date){
                    echo '<td><span class="label-status status-3">Completado</span></td>';
                }else{
                    echo '<td><span class="label-status status-1">Programada</span></td>';
                }
            }

            echo '<td aligh="center"><a href="'. get_edit_post_link(get_the_ID()).'"><span class="dashicons dashicons-admin-generic"></span></a></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '<tfoot>';
        echo '<tr>';
        echo '<td><strong>Nombre</strong></td>';
        echo '<td><strong>Fecha</strong></td>';
        echo '<td align="center"><strong>Estado</strong></td>';
        echo '<td>&nbsp;</td>';
        echo '</tr>';
        echo '</tfoot>';
        echo '</table>';
    }
}

/**
 * Edit List Filters form
 */
/*
add_action('manage_posts_extra_tablenav', 'oda_filter_form_miembros');

function oda_filter_form_miembros(){
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
    <label for="ciudad">Filtrar por ciudad
        <select for="ciudad" name="city">
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
