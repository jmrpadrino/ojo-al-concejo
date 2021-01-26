<?php
/* RESOLUCIONES: IF FILE IS CALLED DIRECTLY, ABORT */
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    RESOLUCIONES: FILE INCLUDES - SELECT2 CALLBACK
-------------------------------------------------------------- */
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
}

/* --------------------------------------------------------------
    RESOLUCIONES: MAIN CMB2 CALLBACK
-------------------------------------------------------------- */
add_action( 'cmb2_admin_init', 'oda_resolucion_metabox' );

/* RESOLUCIONES: MAIN METABOX CALLBACK HANDLER */
function oda_resolucion_metabox() {

    /* RESOLUCIONES: OBTENER CIUDAD ASOCIADA A CPT */
    $city = null;
    if (isset($_GET['post'])){
        $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
    }
    if (isset($_POST['post_ID'])){
        $city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);        
    }

    /* --------------------------------------------------------------
        RESOLUCIONES: METABOX METADATA
    -------------------------------------------------------------- */
    $mtb_metas = new_cmb2_box( array(
        'id'            => ODA_PREFIX . 'resolucion_metas',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Metadatos', 'oda' ),
        'object_types'  => array( 'resolucion' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );

    /* RESOLUCIONES: Etiqueta de Color */
    $mtb_metas->add_field( array(
        'id'      => ODA_PREFIX . 'resolucion_color',
        'name'    => esc_html__( 'Etiqueta de Color', 'oda' ),
        'desc'    => esc_html__( 'Identificación visual para el sistema', 'oda' ),
        'type'    => 'colorpicker',
        'default' => '#ffffff'
    ) );

    /* --------------------------------------------------------------
        RESOLUCIONES: METABOX RELACIONES
    -------------------------------------------------------------- */
    $mtb_resolucion_rel = new_cmb2_box( array(
        'id'            => 'oda_resolucion_relaciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Relaciones', 'oda' ),
        'object_types'  => array( 'resolucion' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* RESOLUCIONES: CIUDAD [PRE GET POSTS] */
    $args = array(
        'post_type' => 'ciudad',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $alcaldias = new WP_Query($args);


    if ( !$alcaldias->have_posts() ){
        /* RESOLUCIONES: Titulo si no hay ninguna ciudad */
        $mtb_resolucion_rel->add_field( array(
            'id'   => ODA_PREFIX . 'resolucion_ciudad_title',
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

        /* RESOLUCIONES: Ciudades */
        $mtb_resolucion_rel->add_field( array(
            'id'         => ODA_PREFIX . 'ciudad_owner',
            'name'       => esc_html__( '¿A qué ciudad pertenece esta resolución?', 'oda' ),
            'desc'       => esc_html__( 'Este campo es obligatorio', 'oda' ),
            'type'             => 'select',
            'show_option_none' => true,
            'attributes' => array(
                'required' => 'required',
            ),
            'options' => $alcaldias_array
        ) );
    }

    /* --------------------------------------------------------------
        RESOLUCIONES: METABOX INFORMACIÓN PRINCIPAL
    -------------------------------------------------------------- */
    $mtb_resolucion_data = new_cmb2_box( array(
        'id'            => 'oda_resolucion_data_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Información Básica', 'oda' ),
        'object_types'  => array( 'resolucion' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* DATA RESOLUCIÓN: Número de Tramite */
    $mtb_resolucion_data->add_field( array(
        'id'         => ODA_PREFIX . 'resolucion_nro_tramite',
        'name' => esc_html__( 'Número de Trámite', 'oda' ),
        'desc' => __( 'Agregue el número de trámite asignado a esta resolucion.', 'oda' ),
        'type' => 'text_small'
    ) );

    /* DATA RESOLUCIÓN: Fecha */
    $mtb_resolucion_data->add_field( array(
        'id'         => ODA_PREFIX . 'resolucion_fecha',
        'name' => esc_html__( 'Fecha de Presentación', 'oda' ),
        'desc' => __( 'Agregue la fecha de presentación de la resolucion.', 'oda' ),
        'type' => 'text_date'
    ) );

    /* DATA RESOLUCIÓN: Iniciativa */
    $mtb_resolucion_data->add_field( array(
        'id'         => ODA_PREFIX . 'resolucion_iniciativa',
        'name' => esc_html__( 'Iniciativa', 'oda' ),
        'desc' => __( 'Seleccione la Iniciativa de esta resolucion.', 'oda' ),
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
    $mtb_resolucion_data->add_field (array(
        'name' => esc_html__( 'Comisión Solicitante', 'oda' ),
        'desc' => __( 'Seleccione la comisión iniciativa.', 'oda' ),
        'id'         => ODA_PREFIX . 'ordenanza_comision',
        'type'          => 'select',
        'classes_cb' => 'oda_select2',
        'options'       => $array_comisiones,
        'attributes'    => array(
            'data-conditional-id'     => ODA_PREFIX . 'resolucion_iniciativa',
            'data-conditional-value'  => 'comisiones',
        ),
    ) );

    /* DATA ORDENANZA: Proponente */
    $mtb_resolucion_data->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_ciudadania',
        'name' => esc_html__( 'Proponente ciudadano', 'oda' ),
        'desc' => __( 'Agregue el Proponente de esta Ordenanza.', 'oda' ),
        'type' => 'text_medium',
        'attributes'    => array(
            'data-conditional-id'     => ODA_PREFIX . 'resolucion_iniciativa',
            'data-conditional-value'  => 'ciudadania',
        ),
    ) );

    /* DATA ORDENANZA: Miembros [ PRE GET POSTS ] */
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
        /* DATA ORDENANZA: Aviso [Si no hay miembros disponibles para la ciudad] */
        $mtb_resolucion_data->add_field( array(
            'id'   => ODA_PREFIX . 'resolucion_miembros',
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'Aun no tiene miembros asignados a la ciudad, por favor asigne uno. Haga clic <a href="'. admin_url('/post-new.php?post_type=miembro') .'">aqui</a>.', 'oda' ),
            'type' => 'title'
        ) );
    } else {
        /* DATA ORDENANZA: Miembros [ PRE GET POSTS ] */
        while ($query_miembros->have_posts()) : $query_miembros->the_post();
        $array_miembros[get_the_ID()] = get_the_title();
        endwhile;
        wp_reset_query();

        /* DATA ORDENANZA: Miembros */
        $mtb_resolucion_data->add_field( array(
            'id'         => ODA_PREFIX . 'resolucion_miembros',
            'name' => esc_html__( 'Proponente del Concejo', 'oda' ),
            'desc' => __( 'Seleccione el/os miembros del concejo para esta Resolución.', 'oda' ),
            'type' => 'pw_multiselect',
            'classes_cb' => 'oda_select2',
            'options'          => $array_miembros,
            'attributes'    => array(
                'data-conditional-id'     => ODA_PREFIX . 'resolucion_iniciativa',
                'data-conditional-value'  => 'concejal',
            ),
        ) );
    }
    /*
    $mtb_resolucion_data->add_field( array(
        'id'         => ODA_PREFIX . 'resolucion_iniciativa_ciudadana',
        'name' => esc_html__( 'Iniciativa Ciudadana', 'oda' ),        
        'type' => 'text'
    ) );
    */
    /* DATA ORDENANZA: Estado */
    $mtb_resolucion_data->add_field( array(
        'id'         => ODA_PREFIX . 'resolucion_estado',
        'name' => esc_html__( 'Estado', 'oda' ),
        'desc' => __( 'Seleccione el estado de esta Resolución.', 'oda' ),
        'type' => 'select',
        'show_option_none' => true,
        'default'          => 'alcalde',
        'options'          => RESOLUCION_STATUS
    ) );

    /* DATA INCIDENCIA: Temas [Taxonomy Select] */
    /*
    $mtb_resolucion_data->add_field( array(
        'id'         => ODA_PREFIX . 'resolucion_incidencia_temas',
        'name' => esc_html__( 'Temas de Ordenanza', 'oda' ),
        'desc' => __( 'Seleccione el / los temas de esta incidencia.', 'oda' ),
        'taxonomy'       => 'temas',
        'type'           => 'taxonomy_select',
        'remove_default' => 'true',
        'query_args' => array(
            'orderby' => 'slug',
            'hide_empty' => false
        )
    ) );
    */

    // colocar los temas CPT
    $query_temas = new WP_Query(array(
        'post_type' => 'tema_resolucion',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '='
            )
        )
    ));
    $array_temas = array();
    while ($query_temas->have_posts()) : $query_temas->the_post();
        $array_temas[get_the_ID()] = get_the_title();
    endwhile;
    $mtb_resolucion_data->add_field( array(
        'id'         => ODA_PREFIX . 'resolucion_incidencia_temas',
        'name' => esc_html__( 'Temas de Resolución', 'oda' ),
        'desc' => __( 'Seleccione el tema de esta incidencia.', 'oda' ),
        'type' => 'select',
        'show_option_none' => 'Seleccionar',
        'classes_cb' => 'oda_select2',
        'options' => $array_temas
    ) );

    /* --------------------------------------------------------------
        DATA ORDENANZA: FASES METABOX
    -------------------------------------------------------------- */
    $mtb_resolucion_fases = new_cmb2_box( array(
        'id'            => ODA_PREFIX . 'resolucion_fases_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Fases de la Resolución', 'oda' ),
        'object_types'  => array( 'resolucion' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );

    /* DATA ORDENANZA: FASES [ PRE GET POSTS ] */
    $documentos = get_post_meta($city, ODA_PREFIX . 'ciudad_fase_res', true);

    if ( !$documentos ){
        /* DATA ORDENANZA: Aviso [Si no hay fases disponibles para la ciudad] */
        $mtb_resolucion_fases->add_field( array(
            'id'   => ODA_PREFIX . 'resolucion_fases_title',
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'Aun no tiene fases asignadas a la ciudad, por favor asigne una. Haga clic <a href="'. admin_url('/post-new.php?post_type=ciudad') .'">aqui</a>.', 'oda' ),
            'type' => 'title'
        ) );
    }else{
        $i = 1;
        foreach($documentos as $index => $value){
            if ($i > 1) {
                /* DATA ORDENANZA: Separador */
                $mtb_resolucion_fases->add_field( array(
                    'id'   => ODA_PREFIX . 'res_fases_title_' . $index,
                    'name' => esc_html__( ' ' ),
                    'type' => 'title',
                    'classes_cb' => 'oda_spacer',
                ) );
            }

            /* DATA ORDENANZA: Documento PDF representativo del Item */
            $mtb_resolucion_fases->add_field( array(
                'id'         => ODA_PREFIX . 'res_fases_item_' . $index,
                'name'       => __('Documento Fase: ') . ' <strong>' . $value['oda_items_resolucion_fases'] . '</strong>',
                'type'             => 'file',
                'options' => array(
                    'url' => true,
                ),
                'text'    => array(
                    'add_upload_file_text' => 'Añadir PDF'
                ),
                'query_args' => array(
                    'type' => 'application/pdf',
                ),
                'preview_size' => 'large'
            ) );

            /* DATA ORDENANZA: Fecha del Item */
            $mtb_resolucion_fases->add_field( array(
                'id'         => ODA_PREFIX . 'res_fases_fecha_' . $index,
                'name' => esc_html__( 'Fecha de la Fase', 'oda' ),
                'desc' => __( 'Agregue la fecha de la Fase.', 'oda' ),
                'type' => 'text_date'
            ) );
            $i++;
        }
    }
}
