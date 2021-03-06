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


    /*
         * Textos y elementos de maqueta
         */
    $mtb_textos = new_cmb2_box( array(
        'id'            => 'oda_alta_textos_secciones_1',
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
        'name' => esc_html__( 'Intro Concejo Municipal', 'cmb2' ),
        'desc' => __( 'Esta sección esta al inicio de la pantalla Concejo Municipal', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_intro_concejo',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ) );
    $mtb_textos->add_field( array(
        'name' => esc_html__( 'Intro Concejo Municipal Link VER', 'cmb2' ),
        'desc' => __( 'Esta sección esta al inicio de la pantalla VER Concejo Municipal', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_intro_concejo_ver',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 5,
        ),
    ) );

    $mtb_textos->add_field( array(
        'name' => esc_html__( 'Imagen Derecha (Indicadores) Home', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_info_image_indicadores',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir Imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );

    // oda_doc_post_carpetas
    $mtb_textos->add_field( array(
        'id'         => ODA_PREFIX . 'doc_post_carpetas',
        'name'       => __('Documento adicional (Carpetas)', 'oda'),
        'type'             => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir Archivo'
        ),
        'query_args' => array(
            'type' => array(
                'image/jpeg',
                'image/png',
                'application/pdf'
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );


    
    $mtb_transparente = new_cmb2_box( array(
        'id'            => 'oda_alta_textos_secciones_transparente',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Sección Concejo Transparente (Inicio)', 'oda' ),
        'object_types'  => array( 'ciudad' ),
        'context'    => 'normal',
        'show_names' => true,
    ) );

    $mtb_transparente->add_field( array(
        'name' => esc_html__( 'Texto izquierda', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad__concejo_transizq',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 3,
        ),
    ) );
    $mtb_transparente->add_field( array(
        'name' => esc_html__( 'Texto derecha', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad__concejo_transder',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 3,
        ),
    ) );
    $mtb_transparente->add_field( array(
        'name' => esc_html__( 'Texto del botón', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad__concejo_trans_btntext',
        'type' => 'text',
    ) );
    $mtb_transparente->add_field( array(
        'name' => esc_html__( 'URL del botón', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad__concejo_trans_btnurl',
        'type' => 'text_url',
    ) ); 
    
    
    $mtb_editables_cedula = new_cmb2_box( array(
        'id'            => 'oda_alta_textos_secciones_cedula',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Editables Cedula concejal', 'oda' ),
        'object_types'  => array( 'ciudad' ),
        'context'    => 'normal',
        'show_names' => true,
    ) );
    $mtb_editables_cedula->add_field( array(
        'name' => esc_html__( 'Lateral Superior Perfil', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad__cedula_sidetop',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 2,
        ),
    ) );
    $mtb_editables_cedula->add_field( array(
        'name' => esc_html__( 'Lateral Inferior Perfil', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad__cedula_sidebottom',
        'type' => 'wysiwyg',
        'options' => array(
            'textarea_rows' => 2,
        ),
    ) );


    /*
    * Mascaras y Twitter de maqueta
    */
    $mtb_img_twitter = new_cmb2_box( array(
        'id'            => 'oda_alta_textos_secciones_2',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Imagenes y Twitter maqueta Ciudad', 'oda' ),
        'object_types'  => array( 'ciudad' ),
        'context'    => 'normal',
        'show_names' => true,
    ) );
    $mtb_img_twitter->add_field( array(
		'name' => '<span style="color: #FFC100; font-size: 18px; font-weight: bold;">Elementos del Inicio</span>',
		'id'   => 'title_inicio',
		'type' => 'title',
	) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet para sección carpetas', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_folders',
        'type' => 'text',
    ) );

    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen Popup Info', 'cmb2' ),
        'desc' => __( 'Imagen del Popup al hacer clic en circulo info (esfero)', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_info_popup_image',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
		'name' => '<span style="color: #FFC100; font-size: 18px; font-weight: bold;">Elementos de la Cedula del Concejal</span>',
		'id'   => 'title_cedula',
		'type' => 'title',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen del popup cuando no hay plan de trabajo', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_plandetrabajo',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay plan de trabajo', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_plandetrabajo',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet para solicitud concejal transparente', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_profile',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
		'name' => '<span style="color: #FFC100; font-size: 18px; font-weight: bold;">Elementos para popup en menú "Concejo Municipal"</span>',
		'id'   => 'title_concejo_municipal',
		'type' => 'title',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen del popup cuando no hay ordenanzas', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_menu_ordenanzas',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay ordenanzas', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_menu_ordenanzas',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen del popup cuando no hay resoluciones', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_menu_resoluciones',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay resoluciones', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_menu_resoluciones',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen del popup cuando no hay observaciones', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_menu_observaciones',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay observaciones', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_menu_observaciones',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen del popup cuando no hay solicitudes', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_menu_solicitudes',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay solicitudes', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_menu_solicitudes',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen del popup cuando no hay comparecencias', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_menu_comparecencias',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay comparecencias', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_menu_comparecencias',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
		'name' => '<span style="color: #FFC100; font-size: 18px; font-weight: bold;">Elementos de imagen en Evaluación de Gestión</span>',
		'id'   => 'title_concejo_evaluacion',
		'type' => 'title',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen cuando no hay asistencias, ausencias o suplencias', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_evaluacion_mociones',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay asistencias, ausencias o suplencias', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_evaluacion_mociones',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen cuando no hay ordenanzas', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_evaluacion_ordenanzas',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay ordenanzas', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_evaluacion_ordenanzas',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen cuando no hay resoluciones', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_evaluacion_resoluciones',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay resoluciones', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_evaluacion_resoluciones',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen cuando no hay observaciones', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_evaluacion_observaciones',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay observaciones', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_evaluacion_observaciones',
        'type' => 'text',
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Imagen cuando no hay solicitudes', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_image_evaluacion_solicitudes',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_img_twitter->add_field( array(
        'name' => esc_html__( 'Texto del tweet cuando no hay solicitudes', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_tweet_evaluacion_solicitudes',
        'type' => 'text',
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
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Lista de documentos solicitados para las campañas', 'oda' ),
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

    // $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
    $group_field_fases = $mtb_ciudad_ordenanzas_fases->add_field( array(
        'id'          => 'oda_ciudad_fase',
        'type'        => 'group',
        'description' => esc_html__( 'Administración de las fases para las Ordenanzas de la Ciudad', 'cmb2' ),
        'options'     => array(
            'group_title'    => esc_html__( '&nbsp;&nbsp;&nbsp;&nbsp;Fase {#}', 'cmb2' ), // {#} gets replaced by row number
            'add_button'     => esc_html__( 'Agregar otra Fase', 'cmb2' ),
            'remove_button'  => esc_html__( 'Eliminar Fase', 'cmb2' ),
            'sortable'       => true,
            // 'closed'      => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) );
    $mtb_ciudad_ordenanzas_fases->add_group_field( $group_field_fases, array(
        'id'         => 'ord_fases_icon',
        'name'       => __('Ícono para representar la fase', 'oda'),
        'type'             => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir Ícono'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );


    /* DATA ORDENANZA: ITEMS DE FASES */

    $mtb_ciudad_ordenanzas_fases->add_group_field( $group_field_fases, array(
        'id'   => 'items_ordenanza_fases',
        'name' => esc_html__( 'Nombre de la Fase', 'cmb2' ),
        'desc' => __( 'Este nombre se mostrará en otras partes del sistema', 'cmb2' ),
        'type' => 'text',
    ) );
    $mtb_ciudad_ordenanzas_fases->add_group_field( $group_field_fases, array(
        'id'         => 'ord_fases_front',
        'name' => esc_html__( '¿Es la fase aprobatoria?', 'oda' ),
        'desc' => __( 'Active la casilla para mostrar votaciones en el frontpage.', 'oda' ),
        'type' => 'checkbox'
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

    // $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
    $group_field_fases_res = $mtb_ciudad_resolucion_fases->add_field( array(
        'id'          => 'oda_ciudad_fase_res',
        'type'        => 'group',
        'description' => esc_html__( 'Administración de las fases para las Ordenanzas de la Ciudad', 'cmb2' ),
        'options'     => array(
            'group_title'    => esc_html__( '&nbsp;&nbsp;&nbsp;&nbsp;Fase {#}', 'cmb2' ), // {#} gets replaced by row number
            'add_button'     => esc_html__( 'Agregar otra Fase', 'cmb2' ),
            'remove_button'  => esc_html__( 'Eliminar Fase', 'cmb2' ),
            'sortable'       => true,
            // 'closed'      => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) );


    /* DATA RESOLUCIÓN: ITEMS DE FASES */

    $mtb_ciudad_resolucion_fases->add_group_field( $group_field_fases_res, array(
        'id'         => 'res_fases_icon',
        'name'       => __('Ícono para representar la fase', 'oda'),
        'type'             => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir Ícono'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );

    $mtb_ciudad_resolucion_fases->add_group_field( $group_field_fases_res, array(
        'id'   => ODA_PREFIX . 'items_resolucion_fases',
        'name' => esc_html__( 'Nombre de la Fase', 'cmb2' ),
        'desc' => __( 'Este nombre se mostrará en otras partes del sistema', 'cmb2' ),
        'type' => 'text',
    ) );
    $mtb_ciudad_resolucion_fases->add_group_field( $group_field_fases_res, array(
        'id'         => 'res_fases_front',
        'name' => esc_html__( '¿Es la fase aprobatoria?', 'oda' ),
        'desc' => __( 'Active la casilla para mostrar votaciones en el frontpage.', 'oda' ),
        'type' => 'checkbox'
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

    /**
     * Activar y desactivar modulos para el frontend
     */
    $mtb_activar_modulos = new_cmb2_box( array(
        'id'            => 'oda_activar_modulos',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Activar o desactivar módulos', 'oda' ),
        'object_types'  => array( 'ciudad' ),
        'context'    => 'side',
        'show_names' => true,
    ) );
    $mtb_activar_modulos->add_field( array(
        'name' => esc_html__( '¿Ocultar sección Concejo Transparente?', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad__concejo_transver',
        'type' => 'checkbox',
    ) );
    $mtb_activar_modulos->add_field( array(
        'name' => esc_html__( '¿Ocultar Proyectos de ordenanza en esta ciudad?', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_ocula_ordenanza',
        'type' => 'checkbox',
    ) );
    $mtb_activar_modulos->add_field( array(
        'name' => esc_html__( '¿Ocultar Proyectos de resoluciones en esta ciudad?', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_ocula_resoluciones',
        'type' => 'checkbox',
    ) );
    $mtb_activar_modulos->add_field( array(
        'name' => esc_html__( '¿Ocultar Observaciones a proyectos de ordenanza en esta ciudad?', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_ocula_observaciones',
        'type' => 'checkbox',
    ) );
    $mtb_activar_modulos->add_field( array(
        'name' => esc_html__( '¿Ocultar Solicitudes de información en esta ciudad?', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_ocula_solicitud_info',
        'type' => 'checkbox',
    ) );
    $mtb_activar_modulos->add_field( array(
        'name' => esc_html__( '¿Ocultar Solicitudes de comparecencia en esta ciudad?', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_ocula_solicitud_comp',
        'type' => 'checkbox',
    ) );

    /**
     * Activar y desactivar modulos para el frontend
     */
    $mtb_popupinfo_modulos = new_cmb2_box( array(
        'id'            => 'oda_popupinfo_modulos',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Imágenes para Popup Info', 'oda' ),
        'object_types'  => array( 'ciudad' ),
        'context'    => 'side',
        'show_names' => true,
    ) );
    $mtb_popupinfo_modulos->add_field( array(
        'name' => esc_html__( 'Imagen Popup para módulo Listado de Miembros', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_popupinfo_listado_miembros',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_popupinfo_modulos->add_field( array(
        'name' => esc_html__( 'Imagen Popup para módulo Concejo en Cifras', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_popupinfo_concejo_cifras',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_popupinfo_modulos->add_field( array(
        'name' => esc_html__( 'Imagen Popup para módulo Proyectos de ordenanza', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_popupinfo_ordenanza',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_popupinfo_modulos->add_field( array(
        'name' => esc_html__( 'Imagen Popup para módulo Proyectos de resoluciones', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_popupinfo_resoluciones',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_popupinfo_modulos->add_field( array(
        'name' => esc_html__( 'Imagen Popup para módulo Observaciones a proyectos de ordenanza', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_popupinfo_observaciones',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_popupinfo_modulos->add_field( array(
        'name' => esc_html__( 'Imagen Popup para módulo Solicitudes de información', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_popupinfo_solicitud_info',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );
    $mtb_popupinfo_modulos->add_field( array(
        'name' => esc_html__( 'Imagen Popup para módulo Solicitudes de comparecencia', 'cmb2' ),
        'id'   => ODA_PREFIX . 'ciudad_popupinfo_solicitud_comp',
        'type' => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imagen'
        ),
        'query_args' => array(
            'type' => array(
                'image/gif',
                'image/jpeg',
                'image/png',
            ),
        ),
        'preview_size' => 'thumbnail'
    ) );

}
