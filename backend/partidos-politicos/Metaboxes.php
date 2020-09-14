<?php
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
}
add_action( 'cmb2_admin_init', 'oda_partido_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function oda_partido_metabox() {
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$mtb_metas = new_cmb2_box( array(
		'id'            => 'oda_partido_metas',
		'title'         => esc_html__( 'Metadatos', 'oda' ),
		'object_types'  => array( 'partido' ), // Post type
		// 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
		'context'    => 'side',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );

	/**
	 * Get all post from Alcaldia
	 */
	$mtb_metas->add_field( array(
		'name'    => esc_html__( '¿Está activo?', 'oda' ),
		'id'      => ODA_PREFIX . 'partido_activo',
		'type'    => 'checkbox',
	) );

	/**
	 * Get all post from Alcaldia
	 */
	$mtb_metas->add_field( array(
		'name'    => esc_html__( 'Nombre Corto', 'oda' ),
		'id'      => ODA_PREFIX . 'partido_nombrecorto',
		'type'    => 'text',
	) );

	/**
	 * Get all post from Alcaldia
	 */
	$mtb_metas->add_field( array(
		'name'    => esc_html__( 'Color Principal', 'oda' ),
		'desc'    => esc_html__( 'Identificación visual para el sistema', 'oda' ),
		'id'      => ODA_PREFIX . 'partido_color_principal',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );


	$mtb_metas->add_field( array(
		'name'    => esc_html__( 'Color Secundario', 'oda' ),
		'desc'    => esc_html__( 'Identificación visual para el sistema', 'oda' ),
		'id'      => ODA_PREFIX . 'partido_color_secundario',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

	$mtb_metas->add_field( array(
		'name'    => esc_html__( 'Color Alternativo', 'oda' ),
		'desc'    => esc_html__( 'Identificación visual para el sistema', 'oda' ),
		'id'      => ODA_PREFIX . 'partido_color_alternativo',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

}