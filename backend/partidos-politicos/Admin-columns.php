<?php

add_filter( 'manage_posts_columns', 'oda_partido_columns_head' );
add_action( 'manage_posts_custom_column', 'oda_partido_columns_content', 10, 2 );
add_action('admin_head', 'oda_partido_styling_admin_order_list' );
function oda_partido_styling_admin_order_list() {
?>
    <style>
        .label-status{
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
        .no-relation{
            border-color: red;
            color: red;
        }
    </style>
<?php
}

function oda_partido_columns_head($defaults){
    if ( $_GET['post_type'] == 'partido' ){
        unset($defaults['date']);
        $defaults['nombre_corto'] = 'Nombre Corto';
        $defaults['activo'] = '¿Activo?';
        $defaults['date'] = __('Fecha', 'oda');
    }
    return $defaults;
}

function oda_partido_columns_content($column_name, $post_ID){

    if ( $_GET['post_type'] == 'partido' ){

        if ( $column_name == 'nombre_corto'){
            echo get_post_meta( $post_ID, ODA_PREFIX . 'partido_nombrecorto', true);
        }

        if ( $column_name == 'activo'){
            if ('on' === get_post_meta( $post_ID, ODA_PREFIX . 'partido_activo', true) ) {
                echo '<i class="fas fa-check-circle" style="color: green; font-size: 18px;"></i>';
            }else{
                echo '<i class="far fa-times-circle" style="font-size: 18px;"></i>';
            }
        }
    }

}

function oda_partido_add_dashboard_widget() {

	wp_add_dashboard_widget(
		'oda_dahboard_partidos',
		'<img width="20" src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . _x('Partidos Políticos', 'oda'),
		'oda_partido_dashboard_order_label_statues'
	);
}
add_action( 'wp_dashboard_setup', 'oda_partido_add_dashboard_widget' );
function oda_partido_dashboard_order_label_statues() {

    $args = array(
        'post_type' => 'partido',
        'posts_per_page' => 15,
        'post_status' => 'publish'
    );
    $capacitaciones = new WP_Query($args);

	if (!$capacitaciones->have_posts()){
        echo 'No hay partidos políticos agregados aún.';
    }else{
		echo '<table class="oda-dashboard-table" width="100%" border="0" align="center">';
		echo '<thead>';
		echo '<tr>';
		echo '<td><strong>Nombre</strong></td>';
		echo '<td align="center"><strong>¿Esta activo?</strong></td>';
		echo '<td>&nbsp;</td>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>';
		while($capacitaciones->have_posts()){
            $capacitaciones->the_post();
            $status = '';
            if ('on' === get_post_meta( get_the_ID(), ODA_PREFIX . 'partido_activo', true) ) {
                $status = '<i class="fas fa-check-circle" style="color: green; font-size: 18px; display: block; text-align: center;"></i>';
            }else{
                $status = '<i class="far fa-times-circle" style="font-size: 18px; display: block; text-align: center;"></i>';
            }
//			var_dump($order->get_status());
			echo '<tr>';
			echo '<td height="40">'. get_the_title() .'</td>';
            echo '<td aligh="center">'. $status .'</td>';
			echo '<td aligh="center"><a href="'. get_edit_post_link(get_the_ID()).'"><span class="dashicons dashicons-admin-generic"></span></a></td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}
}
