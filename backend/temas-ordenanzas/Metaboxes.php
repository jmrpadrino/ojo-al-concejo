<?php
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
}

add_action( 'cmb2_admin_init', 'oda_register_tema_ordenanza_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function oda_register_tema_ordenanza_metabox() {
    $city = null;
	$current_post = null;
	if (isset($_GET['post'])){
		$city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
		$current_post = $_GET['post'];
	}
	if (isset($_POST['post_ID'])){
		$city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);
		$current_post = $_POST['post_ID'];
	}


	/**
	 * Metaboxz for Relaciones
	 */
	$mtb_rel = new_cmb2_box( array(
		'id'            => 'oda_temas_ord_relaciones',
		'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Relaciones', 'oda' ),
		'object_types'  => array( 'tema_ordenanza' ), // Post type
		// 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
		'context'    => 'side',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );

	/**
	 * Get all post from Ciudad
	 */
	$args = array(
		'post_type' => 'ciudad',
		'posts_per_page' => -1,
		'post_status' => 'publish'
	);
	$alcaldias = new WP_Query($args);
	if ( !$alcaldias->have_posts() ){
		$mtb_rel->add_field( array(
			'name' => esc_html__( 'Aviso Importante', 'oda' ),
			'desc' => __( 'Aun no tiene alcaldias agregadas por favor agregue una. Haga clic <a href="'. admin_url('/post-new.php?post_type=alcaldia') .'">aqui</a>.', 'cmb2' ),
			'id'   => 'yourprefix_demo_title',
			'type' => 'title',
		) );
	}else{
		$alcaldias_array = array();
		while ( $alcaldias->have_posts() ) { $alcaldias->the_post();
			$alcaldias_array[get_the_ID()] = get_the_title();
		}
		wp_reset_query();
		//var_dump( $alcaldias_array );
		//die;
		$mtb_rel->add_field( array(
			'name'       => esc_html__( '¿A qué ciudad pertenece este tema?', 'cmb2' ),
			'desc'       => esc_html__( 'Este campo es obligatorio', 'oda' ),
			'id'         => ODA_PREFIX . 'ciudad_owner',
			'type'             => 'select',
			'show_option_none' => true,
			'options' => $alcaldias_array,
			'attributes' => array(
				'required' => 'required',
			),
		) );
	}
}