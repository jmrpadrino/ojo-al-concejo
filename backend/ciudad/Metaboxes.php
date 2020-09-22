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

    /*
     * Información de redes sociales y twitter
     */

    $mtb_sociales = new_cmb2_box( array(
        'id'            => 'oda_ciudad_sociales',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Sociales Ciudad', 'oda' ),
        'object_types'  => array( 'ciudad' ),
        'context'    => 'normal',
        'show_names' => true,
    ) );
    $mtb_sociales->add_field( array(
        'name' => esc_html__( 'Facebook', 'cmb2' ),
        'desc' => __( 'Debe colocar la URL completa.', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_facebook',
        'type' => 'text_url',
    ) );
    $mtb_sociales->add_field( array(
        'name' => esc_html__( 'Twitter', 'cmb2' ),
        'desc' => __( 'Debe colocar la URL completa.', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_twitter',
        'type' => 'text_url',
    ) );
    $mtb_sociales->add_field( array(
        'name' => esc_html__( 'Usuario de Twitter', 'cmb2' ),
        'desc' => __( 'Debe colocar el usuario de Twitter del Concejo. Ejem.: @concejo.', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_twitter_user',
        'type' => 'text',
    ) );
    $mtb_sociales->add_field( array(
        'name' => esc_html__( 'Instagram', 'cmb2' ),
        'desc' => __( 'Debe colocar la URL completa.', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_instagram',
        'type' => 'text_url',
    ) );
    $mtb_sociales->add_field( array(
        'name' => esc_html__( 'Texto del tweet para sección carpetas', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_folders',
        'type' => 'text',
    ) );
    $mtb_sociales->add_field( array(
        'name' => esc_html__( 'Texto del tweet para la cedula del concejal', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_profile',
        'type' => 'text',
    ) );


    /*
         * Textos y elementos de maqueta
         */
    $mtb_textos = new_cmb2_box( array(
        'id'            => 'oda_alta_textos_secciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Textos maqueta Ciudad', 'oda' ),
        'object_types'  => array( 'ciudad' ),
        'context'    => 'normal',
        'show_names' => true,
    ) );
    $mtb_textos->add_field( array(
        'name' => esc_html__( 'Sección Superior', 'cmb2' ),
        'desc' => __( 'Esta sección esta debajo de slider/carrusel', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_texto_top',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ) );
    $mtb_textos->add_field( array(
        'name' => esc_html__( 'Sección Inferior', 'cmb2' ),
        'desc' => __( 'Esta sección esta debajo de Concejo Transparente', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_texto_bottom',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ) );
    $mtb_textos->add_field( array(
        'name' => esc_html__( 'Imagen Popup Info', 'cmb2' ),
        'desc' => __( 'Imagen del Popup al hacer clic en circulo info (esfero)', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_info_popup_image',
        'type' => 'file',
    ) );
    $mtb_textos->add_field( array(
        'name' => esc_html__( 'Intro Concejo Municipal', 'cmb2' ),
        'desc' => __( 'Esta sección al inicio de la pantalla Concejo Municipal', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_intro_concejo',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ) );
    $mtb_textos->add_field( array(
        'name' => esc_html__( '¿Ocultar sección Concejo Transparente?', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad__concejo_transver',
        'type' => 'checkbox',
    ) );
    $mtb_textos->add_field( array(
        'name' => esc_html__( 'Sección Concejo Transparente izquierda', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad__concejo_transizq',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 3,
        ),
    ) );
    $mtb_textos->add_field( array(
        'name' => esc_html__( 'Sección Concejo Transparente derecha', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad__concejo_transder',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 3,
        ),
    ) );

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

    $mtb_metas->add_field( array(
        'name'    => esc_html__( 'Etiqueta de Color', 'cmb2' ),
        'desc'    => esc_html__( 'Identificación visual para el sistema', 'cmb2' ),
        'id'      => ODA_PREFIX . 'ciudad_color',
        'type'    => 'colorpicker',
        'default' => '#ffffff',
    ) );
    $args = array(
        'post_type' => 'oda_slider',
        'posts_per_page' => -1
    );
    $diapo = array();
    $sliders = new WP_Query($args);
    if($sliders->have_posts()){
        $diapo = array();
        while($sliders->have_posts()){ $sliders->the_post();
                                      $diapo[get_the_ID()] = get_the_title();
                                     }
    }

    $mtb_metas->add_field( array(
        'name'             => esc_html__( 'Seleccione un Carrusel', 'cmb2' ),
        'desc'             => esc_html__( 'Este carrusel se muestra en el perfil de la ciudad', 'cmb2' ),
        'id'               => 'oda_ciudad_slider',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => $diapo
    ) );

    /**
	 * Lista documentos concejal transparente
	 */
    $mtb_rel = new_cmb2_box( array(
        'id'            => 'oda_listado_documentos',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Lista de documentos solicitados para Concejo Transparente', 'oda' ),
        'object_types'  => array( 'ciudad' ),
        'context'    => 'normal',
        'priority'   => 'low',
        'show_names' => true,
    ) );

    $mtb_rel->add_field( array(
        'name' => esc_html__( 'Nombre del Documento', 'cmb2' ),
        'desc' => __( 'Este nombre se mostrará en otras partes del sistema', 'cmb2' ),
        'id'   => ODA_PREFIX . 'items_concejo_transparente',
        'type' => 'text',
        'repeatable' => true
    ) );

    /* --------------------------------------------------------------
        DATA ORDENANZA: FASES METABOX
    -------------------------------------------------------------- */

    $mtb_ciudad_ordenanzas_fases = new_cmb2_box( array(
        'id'            => ODA_PREFIX . 'ciudad_ordenanza_fases_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'ORDENANZAS: Lista de Fases Asociadas', 'oda' ),
        'object_types'  => array( 'ciudad' ),
        'context'    => 'normal',
        'priority'   => 'low',
        'show_names' => true
    ) );


    /* DATA ORDENANZA: ITEMS DE FASES */

    $mtb_ciudad_ordenanzas_fases->add_field( array(
        'id'   => ODA_PREFIX . 'items_ordenanza_fases',
        'name' => esc_html__( 'Nombre de la Fase', 'cmb2' ),
        'desc' => __( 'Este nombre se mostrará en otras partes del sistema', 'cmb2' ),
        'type' => 'text',
        'repeatable' => true
    ) );


    /* --------------------------------------------------------------
        DATA RESOLUCIÓN: FASES METABOX
    -------------------------------------------------------------- */

    $mtb_ciudad_resolucion_fases = new_cmb2_box( array(
        'id'            => ODA_PREFIX . 'ciudad_resolucion_fases_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'RESOLUCIONES: Lista de Fases Asociadas', 'oda' ),
        'object_types'  => array( 'ciudad' ),
        'context'    => 'normal',
        'priority'   => 'low',
        'show_names' => true
    ) );


    /* DATA RESOLUCIÓN: ITEMS DE FASES */

    $mtb_ciudad_resolucion_fases->add_field( array(
        'id'   => ODA_PREFIX . 'items_resolucion_fases',
        'name' => esc_html__( 'Nombre de la Fase', 'cmb2' ),
        'desc' => __( 'Este nombre se mostrará en otras partes del sistema', 'cmb2' ),
        'type' => 'text',
        'repeatable' => true
    ) );


    /* Grupos para carpetas inicio ciudad */
    /**
	 * Repeatable Field Groups
	 */
    $cmb_carpeta = new_cmb2_box( array(
        'id'           => 'oda_ciudad_carpetas',
        'title'        => esc_html__( 'Grupo de carpetas en perfil de ciudad', 'cmb2' ),
        'object_types' => array( 'ciudad' ),
        'context'    => 'normal',
        'priority'   => 'low',
    ) );

    // $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
    $group_field_carpetas = $cmb_carpeta->add_field( array(
        'id'          => 'oda_ciudad_carpeta',
        'type'        => 'group',
        'description' => esc_html__( 'Administración de la sección de carpetas en el perfil de Ciudad', 'cmb2' ),
        'options'     => array(
            'group_title'    => esc_html__( '&nbsp;&nbsp;&nbsp;&nbsp;Carpeta {#}', 'cmb2' ), // {#} gets replaced by row number
            'add_button'     => esc_html__( 'Agregar otra Carpeta', 'cmb2' ),
            'remove_button'  => esc_html__( 'Eliminar Carpeta', 'cmb2' ),
            'sortable'       => true,
            'closed'      => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) );

    /**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
    $cmb_carpeta->add_group_field( $group_field_carpetas, array(
        'name'       => esc_html__( 'Texto en Carpeta', 'cmb2' ),
        'id'         => 'oda_carpeta_copy',
        'type'       => 'text',
        // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
    ) );
    $iconos = array();
    foreach(ODA_ICONS as $icon){
        $iconos[$icon] = $icon;
    }
    $cmb_carpeta->add_group_field( $group_field_carpetas, array(
        'name' => esc_html__( 'Icono en Carpeta', 'cmb2' ),
        'id'   => 'oda_carpeta_icon',
        'type' => 'text',
    ) );
    $cmb_carpeta->add_group_field( $group_field_carpetas, array(
        'name'        => esc_html__( 'Texto en la ventana', 'cmb2' ),
        'description' => esc_html__( 'Se muestra cuando el usuario hace clic en la Carpeta', 'cmb2' ),
        'id'          => 'description',
        'type'        => 'wysiwyg',
    ) );

    $cmb_carpeta->add_group_field( $group_field_carpetas, array(
        'name' => esc_html__( 'Imagen en la ventana', 'cmb2' ),
        'id'   => 'image',
        'type' => 'file',
    ) );

}
