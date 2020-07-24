<?php
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
}
add_action( 'cmb2_admin_init', 'oda_ciudad_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function oda_ciudad_metabox() {
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$mtb_metas = new_cmb2_box( array(
		'id'            => 'oda_ciudad_metas',
		'title'         => esc_html__( 'Metadatos', 'cmb2' ),
		'object_types'  => array( 'ciudad' ), // Post type
		// 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
		'context'    => 'side',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'oda_add_some_classes', // Add classes through a callback.

		/*
		 * The following parameter is any additional arguments passed as $callback_args
		 * to add_meta_box, if/when applicable.
		 *
		 * CMB2 does not use these arguments in the add_meta_box callback, however, these args
		 * are parsed for certain special properties, like determining Gutenberg/block-editor
		 * compatibility.
		 *
		 * Examples:
		 *
		 * - Make sure default editor is used as metabox is not compatible with block editor
		 *      [ '__block_editor_compatible_meta_box' => false/true ]
		 *
		 * - Or declare this box exists for backwards compatibility
		 *      [ '__back_compat_meta_box' => false ]
		 *
		 * More: https://wordpress.org/gutenberg/handbook/extensibility/meta-box/
		 */
		// 'mb_callback_args' => array( '__block_editor_compatible_meta_box' => false ),
	) );

	/**
	 * Get all post from Alcaldia
	 */
	$mtb_metas->add_field( array(
		'name'    => esc_html__( 'Etiqueta de Color', 'cmb2' ),
		'desc'    => esc_html__( 'Identificación visual para el sistema', 'cmb2' ),
		'id'      => ODA_PREFIX . 'ciudad_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

	/**
	 * Lista documentos concejal transparente
	 */
	$mtb_rel = new_cmb2_box( array(
		'id'            => 'oda_listado_documentos',
		'title'         => esc_html__( 'Lista de documentos solicitados para Concejo Transparente', 'cmb2' ),
		'object_types'  => array( 'ciudad' ), // Post type
		// 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
		'context'    => 'normal',
		'priority'   => 'low',
		'show_names' => true, // Show field names on the left
	) );
	$mtb_rel->add_field( array(
		'name' => esc_html__( 'Nombre del Documento', 'cmb2' ),
		'desc' => __( 'Este nombre se mostrará en otras partes del sistema', 'cmb2' ),
		'id'   => ODA_PREFIX . 'items_concejo_transparente',
		'type' => 'text',
		'repeatable' => true
	) );

}