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
add_action( 'cmb2_admin_init', 'oda_solicitud_comp_metabox' );

/* SOLICITUDS: MAIN METABOX CALLBACK HANDLER */
function oda_solicitud_comp_metabox() {

    /* SOLICITUDS: OBTENER CIUDAD ASOCIADA A CPT */
    $city = null;
    if (isset($_GET['post'])){
        $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
    }
    if (isset($_POST['post_ID'])){
        $city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);
    }

    /* --------------------------------------------------------------
        SOLICITUDS: METABOX METADATA
    -------------------------------------------------------------- */
    $mtb_metas = new_cmb2_box( array(
        'id'            => 'oda_solicitud_comp_metas',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Metadatos', 'oda' ),
        'object_types'  => array( 'solicitud-comp' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );

    /* SOLICITUDS: Etiqueta de Color */
    $mtb_metas->add_field( array(
        'name'    => esc_html__( 'Etiqueta de Color', 'oda' ),
        'desc'    => esc_html__( 'Identificación visual para el sistema', 'oda' ),
        'id'      => ODA_PREFIX . 'solicitud_comp_color',
        'type'    => 'colorpicker',
        'default' => '#ffffff'
    ) );

    /* --------------------------------------------------------------
        SOLICITUDS: METABOX RELACIONES
    -------------------------------------------------------------- */
    $mtb_solicitud_comp_rel = new_cmb2_box( array(
        'id'            => 'oda_solicitud_comp_relaciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Relaciones', 'oda' ),
        'object_types'  => array( 'solicitud-comp' ),
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
        $mtb_solicitud_comp_rel->add_field( array(
            'id'   => ODA_PREFIX . 'solicitud_comp_ciudad_title',
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
        $mtb_solicitud_comp_rel->add_field( array(
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
        'id'            => 'oda_solicitud_comp_data_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Información Básica', 'oda' ),
        'object_types'  => array( 'solicitud-comp' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* DATA SOLICITUD: Número de Tramite */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_comp_nro_tramite',
        'name' => esc_html__( 'Número de Trámite', 'oda' ),
        'desc' => __( 'Agregue el número de trámite asignado a esta Solicitud.', 'oda' ),
        'type' => 'text_small'
    ) );

    /* DATA SOLICITUD: Fecha */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_comp_fecha',
        'name' => esc_html__( 'Fecha de Presentación', 'oda' ),
        'desc' => __( 'Agregue la fecha de presentación de la Solicitud.', 'oda' ),
        'type' => 'text_date'
    ) );

    /* DATA SOLICITUD: Iniciativa */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_comp_iniciativa',
        'name' => esc_html__( 'Solicitante', 'oda' ),
        'desc' => __( 'Seleccione la Iniciativa de esta Solicitud.', 'oda' ),
        'type' => 'select',
        'show_option_none' => true,
        'default'          => 'alcalde',
        'options'          => array(
            'alcalde'       => __( 'Alcalde', 'oda' ),
            'concejal'      => __( 'Concejal', 'oda' ),
            'comisiones'    => __( 'Comisiones', 'oda' ),
            'ciudadania'    => __( 'Ciudadanía', 'oda' ),
        )
    ) );



    /* DATA SOLICITUD: Miembros [ PRE GET POSTS ] */
    $query_miembros = new WP_Query(array(
        'post_type' => 'miembro',
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
        /* DATA SOLICITUD: Aviso [Si no hay miembros disponibles para la ciudad] */
        $mtb_observacion_data->add_field( array(
            'id'   => ODA_PREFIX . 'solicitud_comp_miembros',
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'Aun no tiene miembros asignados a la ciudad, por favor asigne uno. Haga clic <a href="'. admin_url('/post-new.php?post_type=miembro') .'">aqui</a>.', 'oda' ),
            'type' => 'title'
        ) );
    } else {
        /* DATA SOLICITUD: Miembros [ PRE GET POSTS ] */
        while ($query_miembros->have_posts()) : $query_miembros->the_post();
        $array_miembros[get_the_ID()] = get_the_title();
        endwhile;
        wp_reset_query();

        /* DATA SOLICITUD: Miembros */
        $mtb_observacion_data->add_field( array(
            'id'         => ODA_PREFIX . 'solicitud_comp_miembros',
            'name' => esc_html__( 'Miembros del Consejo', 'oda' ),
            'desc' => __( 'Seleccione el/os miembros del consejo para esta Solicitud.', 'oda' ),
            'type' => 'pw_multiselect',
            'classes_cb' => 'oda_select2',
            'options'          => $array_miembros
        ) );
    }

    /* DATA SOLICITUD: Proponente */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_comp_nombre',
        'name' => esc_html__( 'Nombre de la Solicitud', 'oda' ),
        'desc' => __( 'Agregue el Nombre de la Solicitud.', 'oda' ),
        'type' => 'text_medium'
    ) );

    /* DATA SOLICITUD: Estado */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_comp_estado',
        'name' => esc_html__( 'Estado', 'oda' ),
        'desc' => __( 'Seleccione el estado de esta Solicitud.', 'oda' ),
        'type' => 'select',
        'show_option_none' => true,
        'default'          => 'alcalde',
        'options'          => array(
            'aprobado'       => __( 'Aprobado', 'oda' ),
            'discusion'      => __( 'En Discusión', 'oda' ),
            'derogado'    => __( 'Derogado', 'oda' ),
            'noaprobado'    => __( 'No Aprobado', 'oda' ),
        )
    ) );

    /* DATA SOLICITUD: Fecha */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_comp_vigencia',
        'name' => esc_html__( 'Fecha de Solicitud', 'oda' ),
        'desc' => __( 'Agregue la fecha de vigencia de la Solicitud.', 'oda' ),
        'type' => 'text_date'
    ) );

    /* DATA SOLICITUD: Link del Registro Oficial */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'solicitud_comp_observaciones',
        'name' => esc_html__( 'Observaciones', 'oda' ),
        'desc' => __( 'Agregue las observaciones respectivas', 'oda' ),
        'type' => 'textarea_small'
    ) );

    /* --------------------------------------------------------------
        DATA SOLICITUD: DOCUMENTOS METABOX
    -------------------------------------------------------------- */
    $mtb_solicitud_comp_docs = new_cmb2_box( array(
        'id'            => ODA_PREFIX . 'solicitud_comp_documentos_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Documento de la Solicitud', 'oda' ),
        'object_types'  => array( 'solicitud-comp' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );

    $group_field_id = $mtb_solicitud_comp_docs->add_field( array(
        'id'          => ODA_PREFIX . 'solicitud_comp_docs_group',
        'type'        => 'group',
        'description' => __( 'Documentos asociados a la solicitud', 'oda' ),
        'options'     => array(
            'group_title'       => __( 'Documento {#}', 'oda' ),
            'add_button'        => __( 'Agregar otro Documento', 'oda' ),
            'remove_button'     => __( 'Remover Documento', 'oda' ),
            'sortable'          => true,
            'closed'         => true,
            'remove_confirm' => esc_html__( '¿Estas seguro de remover este Documento?', 'oda' )
        )
    ) );

    $mtb_solicitud_comp_docs->add_group_field( $group_field_id, array(
        'id'   => 'file',
        'name'      => esc_html__( 'Documento PDF', 'oda' ),
        'desc'      => esc_html__( 'Cargar un Documento PDF para este item', 'oda' ),
        'type'    => 'file',

        'options' => array(
            'url' => false
        ),
        'text'    => array(
            'add_upload_file_text' => esc_html__( 'Cargar Imagen', 'oda' ),
        ),
        'query_args' => array(
            'type' => 'application/pdf', // Make library only display PDFs.
        ),
        'preview_size' => 'medium'
    ) );

    $mtb_solicitud_comp_docs->add_group_field( $group_field_id, array(
        'id'        => 'date',
        'name'      => esc_html__( 'Fecha del Documento', 'oda' ),
        'desc'      => esc_html__( 'Ingrese la Fecha del Documento', 'oda' ),
        'type' => 'text_date',
    ) );

}
