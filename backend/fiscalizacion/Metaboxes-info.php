<?php
/* SOLICITUDS: IF FILE IS CALLED DIRECTLY, ABORT */
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    SOLICITUDS: FILE INCLUDES - SELECT2 CALLBACK
-------------------------------------------------------------- */
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
}

/* --------------------------------------------------------------
    SOLICITUDS: MAIN CMB2 CALLBACK
-------------------------------------------------------------- */
add_action( 'cmb2_admin_init', 'oda_solicitud_info_metabox' );

/* SOLICITUDS: MAIN METABOX CALLBACK HANDLER */
function oda_solicitud_info_metabox() {

    /* SOLICITUDS: OBTENER CIUDAD ASOCIADA A CPT */
    $city = null;
    if (isset($_GET['post'])){
        $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
    }
    if (isset($_POST['post_ID'])){
        $city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);
    }

    /* --------------------------------------------------------------
        SOLICITUDS: METABOX RELACIONES
    -------------------------------------------------------------- */
    $mtb_solicitud_info_rel = new_cmb2_box( array(
        'id'            => 'oda_solicitud_info_relaciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Relaciones', 'oda' ),
        'object_types'  => array( 'solicitud-info' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* SOLICITUDS: CIUDAD [PRE GET POSTS] */
    $args = array(
        'post_type' => 'ciudad',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $alcaldias = new WP_Query($args);


    if ( !$alcaldias->have_posts() ){
        /* SOLICITUDS: Titulo si no hay ninguna ciudad */
        $mtb_solicitud_info_rel->add_field( array(
            'id'   => ODA_PREFIX . 'solicitud_info_ciudad_title',
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'Aun no tiene ciudades agregadas por favor agregue una. Haga clic <a href="'. admin_url('/post-new.php?post_type=ciudad') .'">aqui</a>.', 'oda' ),
            'type' => 'title'
        ) );
    }else{
        $alcaldias_array = array();
        while ( $alcaldias->have_posts() ) : $alcaldias->the_post();
        $alcaldias_array[get_the_ID()] = get_the_title();
        endwhile;
        wp_reset_query();

        /* SOLICITUDS: Ciudades */
        $mtb_solicitud_info_rel->add_field( array(
            'name'       => esc_html__( '¿A qué ciudad pertenece esta solicitud?', 'oda' ),
            'desc'       => esc_html__( 'Este campo es obligatorio', 'oda' ),
            'id'         => ODA_PREFIX . 'ciudad_owner',
            'type'             => 'select',
            'show_option_none' => true,
            'attributes' => array(
                'required' => 'required',
            ),
            'options' => $alcaldias_array
        ) );
    }

    /* --------------------------------------------------------------
        SOLICITUDS: METABOX INFORMACIÓN PRINCIPAL
    -------------------------------------------------------------- */
    $mtb_observacion_data = new_cmb2_box( array(
        'id'            => 'oda_solicitud_info_data_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Información Básica', 'oda' ),
        'object_types'  => array( 'solicitud-info' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* DATA SOLICITUD: Número de Tramite */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_info_nro_tramite',
        'name' => esc_html__( 'Número de Trámite', 'oda' ),
        'desc' => __( 'Agregue el número de trámite asignado a esta Solicitud.', 'oda' ),
        'type' => 'text_small'
    ) );

    /* DATA SOLICITUD: Fecha */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_info_fecha',
        'name' => esc_html__( 'Fecha de Presentación', 'oda' ),
        'desc' => __( 'Agregue la fecha de presentación de la Solicitud.', 'oda' ),
        'type' => 'text_date'
    ) );

    $query_miembros = new WP_Query(array(
        'post_type' => 'miembro',
        'posts_per_page' => -1,
        //'meta_key'=> 'oda_miembro_curul',
        'order' => 'ASC',
        //'order_by' => 'meta_value_num',
        'order_by' => 'id',
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '='
            )
        )
    ));
    $array_concejales = array();
    while ($query_miembros->have_posts()) : $query_miembros->the_post();
        $array_miembros[get_the_ID()] = get_the_title();
        $curul = get_post_meta(get_the_ID(), 'oda_miembro_curul', true);
        if('1' != $curul){
            $array_concejales[get_the_ID()] = get_the_title();
        }
    endwhile;
    wp_reset_query();

    /* DATA SOLICITUD: Iniciativa */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_info_iniciativa',
        'name' => esc_html__( 'Solicitante', 'oda' ),
        'desc' => __( 'Seleccione la Iniciativa de esta Solicitud.', 'oda' ),
        'type' => 'select',
        'show_option_none' => true,
        'default'          => 'alcalde',
        'options'          => array(
            'alcalde'       => __( 'Alcalde', 'oda' ),
            'concejal'      => __( 'Concejal', 'oda' ),
            'comision'    => __( 'Comisión', 'oda' ),
            'ciudadania'    => __( 'Ciudadanía', 'oda' ),
        )
    ) );
    // comisiones
    $args = array(
        'post_type' => 'comision',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '='
            )
        )
    );
    $array_comisiones = array();
    $comisiones = new WP_Query($args);
    while ($comisiones->have_posts()) : $comisiones->the_post();
        $array_comisiones[get_the_ID()] = get_the_title();
    endwhile;
    wp_reset_query();
    $mtb_observacion_data->add_field (array(
        'name' => esc_html__( 'Comisión Solicitante', 'oda' ),
        'desc' => __( 'Seleccione la comisión solicitante.', 'oda' ),
        'id'         => ODA_PREFIX . 'solicitud_info_iniciativa_solicitante_comision',
        'type'          => 'select',
        'classes_cb' => 'oda_select2',
        'options'       => $array_comisiones,
        'attributes'    => array(
            'data-conditional-id'     => ODA_PREFIX . 'solicitud_info_iniciativa',
            'data-conditional-value'  => 'comision',
        ),
    ) );
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_info_iniciativa_solicitante_concejal',
        'name' => esc_html__( 'Concejal Solicitante', 'oda' ),
        'desc' => __( 'Seleccione el concejal solicitante.', 'oda' ),
        'type' => 'select',
        'options'          => $array_concejales,
        'attributes'    => array(
            'data-conditional-id'     => ODA_PREFIX . 'solicitud_info_iniciativa',
            'data-conditional-value'  => 'concejal',
        ),
    ) );
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_info_iniciativa_solicitante_ciudadania',
        'name' => esc_html__( 'Nombre del Solicitante', 'oda' ),
        'desc' => __( 'Indique el nombre del ciudadano solicitante', 'oda' ),
        'type' => 'text',
        'attributes'    => array(
            'data-conditional-id'     => ODA_PREFIX . 'solicitud_info_iniciativa',
            'data-conditional-value'  => 'ciudadania',
        ),
    ) );


    /* DATA SOLICITUD: Miembros [ PRE GET POSTS ] */
    // $query_miembros = new WP_Query(array(
    //     'post_type' => 'miembro',
    //     'posts_per_page' => -1,
    //     'meta_query' => array(
    //         array(
    //             'key' => 'oda_ciudad_owner',
    //             'value' => $city,
    //             'compare' => '='
    //         )
    //     )
    // ));

    if ( !$query_miembros->have_posts() ){
        /* DATA SOLICITUD: Aviso [Si no hay miembros disponibles para la ciudad] */
        $mtb_observacion_data->add_field( array(
            'id'   => ODA_PREFIX . 'solicitud_info_miembros',
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'Aun no tiene miembros asignados a la ciudad, por favor asigne uno. Haga clic <a href="'. admin_url('/post-new.php?post_type=miembro') .'">aqui</a>.', 'oda' ),
            'type' => 'title'
        ) );
    } else {

        /* DATA SOLICITUD: Miembros */
        $mtb_observacion_data->add_field( array(
            'id'         => ODA_PREFIX . 'solicitud_info_miembros',
            'name' => esc_html__( 'Solicitantes del Concejo', 'oda' ),
            'desc' => __( 'Seleccione el/os miembros del concejo para esta Solicitud.', 'oda' ),
            'type' => 'pw_multiselect',
            'classes_cb' => 'oda_select2',
            'options'          => $array_miembros
        ) );
    }

    /* DATA SOLICITUD: Proponente */
    /*
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_info_nombre',
        'name' => esc_html__( 'Nombre de la Solicitud', 'oda' ),
        'desc' => __( 'Agregue el Nombre de la Solicitud.', 'oda' ),
        'type' => 'text_medium'
    ) );
    */

    /* DATA ORDENANZA: Miembros [ PRE GET POSTS ] */
    $query_instituciones = new WP_Query(array(
        'post_type' => 'instituciones',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '='
            )
        )
    ));

    if ( !$query_miembros->have_posts() ){
        /* DATA ORDENANZA: Aviso [Si no hay miembros disponibles para la ciudad] */
        $mtb_observacion_data->add_field( array(
            'id'   => ODA_PREFIX . 'solicitud_instituciones',
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'Aun no tiene miembros asignados a la ciudad, por favor asigne uno. Haga clic <a href="'. admin_url('/post-new.php?post_type=miembro') .'">aqui</a>.', 'oda' ),
            'type' => 'title'
        ) );
    } else {
        /* DATA ORDENANZA: Miembros [ PRE GET POSTS ] */
        while ($query_instituciones->have_posts()) : $query_instituciones->the_post();
        $array_instituciones[get_the_ID()] = get_the_title();
        endwhile;
        wp_reset_query();

        /* DATA ORDENANZA: Miembros */
        $mtb_observacion_data->add_field( array(
            'id'         => ODA_PREFIX . 'solicitud_instituciones',
            'name' => esc_html__( 'Información solicitada a', 'oda' ),
            'desc' => __( 'Seleccione la institución requerida para esta solicitud.', 'oda' ),
            'type' => 'select',
            'classes_cb' => 'oda_select2',
            'options' => $array_instituciones
        ) );
    }

    /* DATA ORDENANZA: Miembros */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_persona_requerida',
        'name' => esc_html__( 'Persona requerida', 'oda' ),
        'desc' => __( 'Seleccione la Persona requerida para esta solicitud.', 'oda' ),
        'type' => 'select',
        'classes_cb' => 'oda_select2',
        'options' => array()
    ) );

    /* DATA SOLICITUD: Estado */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_info_estado',
        'name' => esc_html__( 'Estado', 'oda' ),
        'desc' => __( 'Seleccione el estado de esta Solicitud.', 'oda' ),
        'type' => 'select',
        'show_option_none' => true,
        'default'          => 'alcalde',
        'options'          => array(
            '1'       => __( 'Solicitud presentada', 'oda' ),
            '2'      => __( 'Respuesta', 'oda' ),
        )
    ) );

    /* DATA SOLICITUD: Fecha */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_info_vigencia',
        'name' => esc_html__( 'Fecha de Solicitud', 'oda' ),
        'desc' => __( 'Agregue la fecha de vigencia de la Solicitud.', 'oda' ),
        'type' => 'text_date'
    ) );

    /* DATA SOLICITUD: Link del Registro Oficial */
    /*
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_info_observaciones',
        'name' => esc_html__( 'Observaciones', 'oda' ),
        'desc' => __( 'Agregue las observaciones respectivas', 'oda' ),
        'type' => 'textarea_small'
    ) );
    */

    /* --------------------------------------------------------------
        DATA SOLICITUD: DOCUMENTOS METABOX
    -------------------------------------------------------------- */
    $mtb_solicitud_info_docs = new_cmb2_box( array(
        'id'            => ODA_PREFIX . 'solicitud_info_documentos_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Documento de la Solicitud', 'oda' ),
        'object_types'  => array( 'solicitud-info' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );
    $mtb_solicitud_info_docs->add_field( array(
        'id'   => ODA_PREFIX . 'solicitud_pdf',
        'name'      => esc_html__( 'Documento Solicitud PDF', 'oda' ),
        'desc'      => esc_html__( 'Cargar un Documento PDF para este item', 'oda' ),
        'type'    => 'file',

        'options' => array(
            'url' => true
        ),
        'text'    => array(
            'add_upload_file_text' => esc_html__( 'Cargar PDF', 'oda' ),
        ),
        'query_args' => array(
            'type' => 'application/pdf'
        ),
        'preview_size' => 'medium'
    ) );

    $mtb_solicitud_info_docs->add_field( array(
        'id'   => ODA_PREFIX . 'solicitud_pdf_fecha',
        'name'      => esc_html__( 'Fecha del Documento Solicitud', 'oda' ),
        'desc'      => esc_html__( 'Ingrese la Fecha del Documento', 'oda' ),
        'type' => 'text_date',
    ) );
    $mtb_solicitud_info_docs->add_field( array(
        'id'   => ODA_PREFIX . 'respuesta_pdf',
        'name'      => esc_html__( 'Documento Respuesta PDF', 'oda' ),
        'desc'      => esc_html__( 'Cargar un Documento PDF para este item', 'oda' ),
        'type'    => 'file',

        'options' => array(
            'url' => true
        ),
        'text'    => array(
            'add_upload_file_text' => esc_html__( 'Cargar PDF', 'oda' ),
        ),
        'query_args' => array(
            'type' => 'application/pdf'
        ),
        'preview_size' => 'medium'
    ) );

    $mtb_solicitud_info_docs->add_field( array(
        'id'   => ODA_PREFIX . 'respuesta_pdf_fecha',
        'name'      => esc_html__( 'Fecha del Documento Respuesta', 'oda' ),
        'desc'      => esc_html__( 'Ingrese la Fecha del Documento', 'oda' ),
        'type' => 'text_date',
    ) );
}
