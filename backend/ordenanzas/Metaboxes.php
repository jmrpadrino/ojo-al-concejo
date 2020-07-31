<?php
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
}
add_action( 'cmb2_admin_init', 'oda_ordenanza_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function oda_ordenanza_metabox() {

    $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);

    /**
	 * Sample metabox to demonstrate each field type included
	 */
    $mtb_metas = new_cmb2_box( array(
        'id'            => 'oda_ordenanza_metas',
        'title'         => esc_html__( 'Metadatos', 'cmb2' ),
        'object_types'  => array( 'ordenanza' ), // Post type
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
        'id'      => ODA_PREFIX . 'ordenanza_color',
        'type'    => 'colorpicker',
        'default' => '#ffffff',
    ) );

    /**
	 * Metaboxz for Relaciones
	 */
    $mtb_ordinance_rel = new_cmb2_box( array(
        'id'            => 'oda_ordenanza_relaciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Relaciones', 'oda' ),
        'object_types'  => array( 'ordenanza' ), // Post type
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
        $mtb_ordinance_rel->add_field( array(
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
        //var_dump( $alcaldias_array );
        //die;
        $mtb_ordinance_rel->add_field( array(
            'name'       => esc_html__( '¿A qué ciudad pertenece este miembro?', 'cmb2' ),
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

    /**
	 * Metabox fecha de Ordenanza
	 */
    $mtb_ordinance_date = new_cmb2_box( array(
        'id'            => 'oda_ordenanza_fecha',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Fecha', 'oda' ),
        'object_types'  => array( 'ordenanza' ), // Post type
        // 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
    ) );


    $mtb_ordinance_date->add_field( array(
        'name' => esc_html__( 'Fecha de la Ordenanza', 'oda' ),
        'desc' => __( 'Adjunte aqui la fecha de la Ordenanza.', 'cmb2' ),
        'id'         => ODA_PREFIX . 'ordenanza_fecha',
        'type' => 'text_date',
    ) );

    /**
	 * Get all items from Ordenanzas Ciudad
	 */
    $mtb_ordenanza_doc_upload = new_cmb2_box( array(
        'id'            => 'oda_ordenanza_documentos_asociados',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Documentos relacionados a la Ordenanza', 'oda' ),
        'object_types'  => array( 'ordenanza' ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'classes'    => 'oda-metabox'
    ) );
    $documentos = get_post_meta($city, ODA_PREFIX . 'items_ordinance_docs', true);
    //die;
    if ( !$documentos ){
        $mtb_ordenanza_doc_upload->add_field( array(
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'Aun no documentos a asociar para la ordenanza.', 'cmb2' ),
            'id'   => 'con_transparente',
            'type' => 'title',
        ) );
    }else{
        foreach($documentos as $index => $value){
            $mtb_ordenanza_doc_upload->add_field( array(
                'name'       => $value,
                'id'         => ODA_PREFIX . 'ord_file_item_' . $index,
                'type'             => 'file',
                'options' => array(
                    'url' => true, // Hide the text input for the url
                ),
                'text'    => array(
                    'add_upload_file_text' => 'Añadir PDF' // Change upload button text. Default: "Add or Upload File"
                ),
                'query_args' => array(
                    'type' => 'application/pdf', // Make library only display PDFs.
                    // Or only allow gif, jpg, or png images
                    // 'type' => array(
                    // 	'image/gif',
                    // 	'image/jpeg',
                    // 	'image/png',
                    // ),
                ),
                'preview_size' => 'large', // Image size to use when previewing in the admin.
            ) );
        }
    }


    /**
	 * Get all status from Ordenanzas Ciudad
	 */

    $mtb_ordenanza_status = new_cmb2_box( array(
        'id'            => 'oda_ordenanza_status_asoc_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Status relacionados a la Ordenanza', 'oda' ),
        'object_types'  => array( 'ordenanza' ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'classes'    => 'oda-metabox'
    ) );
    $documentos = get_post_meta($city, ODA_PREFIX . 'items_ordinance_status', true);
    //die;
    if ( !$documentos ){
        $mtb_ordenanza_status->add_field( array(
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'Aun no status asociados para la ordenanza.', 'cmb2' ),
            'id'   => 'con_transparente',
            'type' => 'title',
        ) );
    }else{
        foreach($documentos as $index => $value){
            $mtb_ordenanza_status->add_field( array(
                'name'       => $value,
                'id'         => ODA_PREFIX . 'ord_status_item_' . $index,
                'type'             => 'file',
                'options' => array(
                    'url' => true, // Hide the text input for the url
                ),
                'text'    => array(
                    'add_upload_file_text' => 'Añadir PDF' // Change upload button text. Default: "Add or Upload File"
                ),
                'query_args' => array(
                    'type' => 'application/pdf', // Make library only display PDFs.
                    // Or only allow gif, jpg, or png images
                    // 'type' => array(
                    // 	'image/gif',
                    // 	'image/jpeg',
                    // 	'image/png',
                    // ),
                ),
                'preview_size' => 'large', // Image size to use when previewing in the admin.
            ) );
        }
    }

    /**
	 * Lista documentos concejal transparente
	 */
    //	$mtb_proc_ord = new_cmb2_box( array(
    //		'id'            => 'oda_estado_proceso',
    //		'title'         => esc_html__( 'Lista de documentos asociados a la ordenanza', 'cmb2' ),
    //		'object_types'  => array( 'ordenanza' ), // Post type
    //		// 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
    //		'context'    => 'normal',
    //		'priority'   => 'low',
    //		'show_names' => true, // Show field names on the left
    //	) );
    //
    //	$mtb_proc_ord->add_field( array(
    //		'name' => esc_html__( 'Nombre del Documento', 'cmb2' ),
    //		'desc' => __( 'Este nombre se mostrará en otras partes del sistema', 'cmb2' ),
    //		'id'   => ODA_PREFIX . 'items_concejo_transparente',
    //		'type' => 'text',
    //		'repeatable' => true
    //	) );
}
