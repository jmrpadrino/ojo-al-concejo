<?php
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
}

/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */

add_action( 'cmb2_admin_init', 'oda_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function oda_register_demo_metabox() {
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$mtb_rel = new_cmb2_box( array(
		'id'            => 'oda_circunscripcion_relaciones',
		'title'         => esc_html__( 'Relaciones', 'cmb2' ),
		'object_types'  => array( 'circunscripcion' ), // Post type
		// 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
		'context'    => 'side',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );

	/**
	 * Get all post from Alcaldia
	 */
	$args = array(
		'post_type' => 'ciudad',
		'posts_per_page' => -1,
		'post_status' => 'publish'
	);
	$ciudad = new WP_Query($args);
	if ( !$ciudad->have_posts() ){
		$mtb_rel->add_field( array(
			'name' => esc_html__( 'Aviso Importante', 'cmb2' ),
			'desc' => __( 'Aun no tiene ciudades agregadas por favor agregue una. Haga clic <a href="'. admin_url('/post-new.php?post_type=ciudad') .'">aqui</a>.', 'cmb2' ),
			'id'   => 'yourprefix_demo_title',
			'type' => 'title',
		) );
	}else{
		$ciudad_array = array();
		while ( $ciudad->have_posts() ) { $ciudad->the_post();
			$ciudad_array[get_the_ID()] = get_the_title();
		}
		//var_dump( $alcaldias_array );
		//die;
		$mtb_rel->add_field( array(
			'name'       => esc_html__( '¿A qué ciudad pertenece esta circunscripción?', 'cmb2' ),
			'desc'       => esc_html__( 'Este campo es obligatorio', 'cmb2' ),
			'id'         => ODA_PREFIX . 'ciudad_owner',
			'type'             => 'select',
			'show_option_none' => true,
			'options' => $ciudad_array,
			'attributes' => array(
				'required' => 'required',
			),
			'after_field'    => '<strong>¿No esta la ciudad?</strong>, haga clic <a href="'. admin_url('/post-new.php?post_type=ciudad') .'">aqui</a> para agregar una nueva.',
		) );

		
	}

}