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

add_action( 'cmb2_admin_init', 'oda_register_sliders_meta' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function oda_register_sliders_meta() {
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$mtb_rel = new_cmb2_box( array(
		'id'            => 'oda_slider_metas',
		'title'         => esc_html__( 'Diapositivas', 'cmb2' ),
		'object_types'  => array( 'oda_slider' ), // Post type
		// 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );
	
    // $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
	$group_field_slides = $mtb_rel->add_field( array(
		'id'          => 'oda_slides_metas',
		'type'        => 'group',
		'description' => esc_html__( 'Configuración de la diapositiva', 'cmb2' ),
		'options'     => array(
			'group_title'    => esc_html__( '&nbsp;&nbsp;&nbsp;&nbsp;Diapositiva {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'     => esc_html__( 'Agregar otra Diapositiva', 'cmb2' ),
			'remove_button'  => esc_html__( 'Eliminar Diapositiva', 'cmb2' ),
			'sortable'       => true,
			//'closed'         => true, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
    ) );
    $mtb_rel->add_group_field( $group_field_slides, array(
		'name' => esc_html__( 'Fondo de la diapositiva', 'cmb2' ),
		'id'   => 'oda_slide_bkg_img',
		'type' => 'file',
	) );
    $mtb_rel->add_group_field( $group_field_slides, array(
		'name'       => esc_html__( 'Texto en Diapositiva', 'cmb2' ),
		'id'         => 'oda_slide_content',
        'type'       => 'wysiwyg',
        'options' => array(
			'textarea_rows' => 5,
		),
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );
    $mtb_rel->add_group_field( $group_field_slides, array(
		'name'       => esc_html__( 'Texto del Botón', 'cmb2' ),
		'id'         => 'oda_slide_button_text',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );
    $mtb_rel->add_group_field( $group_field_slides, array(
		'name'       => esc_html__( 'Link del Botón', 'cmb2' ),
		'id'         => 'oda_slide_button_link',
		'type'       => 'text_url',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

}