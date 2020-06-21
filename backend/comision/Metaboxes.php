<?php
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
}
add_action( 'cmb2_admin_init', 'oda_comision_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'oda_admin_init' or 'oda_init' hook.
 */
function oda_comision_metabox() {
	/**
	 * Metabos for metadata on Comision
	 */
	$mtb_metas = new_cmb2_box( array(
		'id'            => 'oda_comision_meta',
		'title'         => esc_html__( 'Metadatos de la Comisión', 'oda' ),
		'object_types'  => array( 'comision' ), // Post type
		// 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );

	$mtb_metas->add_field( array(
		'name'       => esc_html__( 'Nombre corto', 'oda' ),
		'id'         => ODA_PREFIX . 'comision_short_name',
		'type'       => 'text',
		// 'show_on_cb' => 'yourprefix_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
		// 'column'          => true, // Display field value in the admin post-listing columns
	) );

	/**
	 * Metabos for metadata on Comision
	 */

	$mtb_metas->add_field( array(
		'name'       => esc_html__( 'Tipo', 'oda' ),
		'id'         => ODA_PREFIX . 'comision_type',
		'type'       => 'select',
		'show_option_none' => true,
		'options' 	 => ODA_ESTADOS_COMISION,
		// 'show_on_cb' => 'yourprefix_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
		// 'column'          => true, // Display field value in the admin post-listing columns
	) );

	$mtb_rel = new_cmb2_box( array(
		'id'            => 'oda_comision_relaciones',
		'title'         => esc_html__( 'Relaciones', 'oda' ),
		'object_types'  => array( 'comision' ), // Post type
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
	$ciudad = new WP_Query($args);
	if ( !$ciudad->have_posts() ){
		$mtb_rel->add_field( array(
			'name' => esc_html__( 'Aviso Importante', 'od' ),
			'desc' => __( 'Aun no tiene ciudades agregadas por favor agregue una. Haga clic <a href="'. admin_url('/post-new.php?post_type=ciudad') .'">aqui</a>.', 'od' ),
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
			'name'       => esc_html__( '¿A qué ciudad pertenece esta Comisión?', 'oda' ),
			'desc'       => esc_html__( 'Este campo es obligatorio', 'oda' ),
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