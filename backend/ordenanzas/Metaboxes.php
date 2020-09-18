<?php
/* ORDENANZAS: IF FILE IS CALLED DIRECTLY, ABORT */
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    ORDENANZAS: FILE INCLUDES - SELECT2 CALLBACK
-------------------------------------------------------------- */
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
}

/* --------------------------------------------------------------
    ORDENANZAS: MAIN CMB2 CALLBACK
-------------------------------------------------------------- */
add_action( 'cmb2_admin_init', 'oda_ordenanza_metabox' );
add_action( 'cmb2_admin_init', 'oda_observacion_metabox' );

/* ORDENANZAS: MAIN METABOX CALLBACK HANDLER */
function oda_ordenanza_metabox() {

    /* ORDENANZAS: OBTENER CIUDAD ASOCIADA A CPT */
    $city = null;
    if (isset($_GET['post'])){
        $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
    }
    if (isset($_POST['post_ID'])){
        $city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);        
    }

    /* --------------------------------------------------------------
        ORDENANZAS: METABOX METADATA
    -------------------------------------------------------------- */
    $mtb_metas = new_cmb2_box( array(
        'id'            => 'oda_ordenanza_metas',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Metadatos', 'oda' ),
        'object_types'  => array( 'ordenanza' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );

    /* ORDENANZAS: Etiqueta de Color */
    $mtb_metas->add_field( array(
        'name'    => esc_html__( 'Etiqueta de Color', 'oda' ),
        'desc'    => esc_html__( 'Identificación visual para el sistema', 'oda' ),
        'id'      => ODA_PREFIX . 'ordenanza_color',
        'type'    => 'colorpicker',
        'default' => '#ffffff'
    ) );

    /* --------------------------------------------------------------
        ORDENANZAS: METABOX RELACIONES
    -------------------------------------------------------------- */
    $mtb_ordenanza_rel = new_cmb2_box( array(
        'id'            => 'oda_ordenanza_relaciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Relaciones', 'oda' ),
        'object_types'  => array( 'ordenanza' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* ORDENANZAS: CIUDAD [PRE GET POSTS] */
    $args = array(
        'post_type' => 'ciudad',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $alcaldias = new WP_Query($args);


    if ( !$alcaldias->have_posts() ){
        /* ORDENANZAS: Titulo si no hay ninguna ciudad */
        $mtb_ordenanza_rel->add_field( array(
            'id'   => ODA_PREFIX . 'ordenanza_ciudad_title',
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

        /* ORDENANZAS: Ciudades */
        $mtb_ordenanza_rel->add_field( array(
            'name'       => esc_html__( '¿A qué ciudad pertenece este miembro?', 'oda' ),
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
        ORDENANZAS: METABOX INFORMACIÓN PRINCIPAL
    -------------------------------------------------------------- */
    $mtb_observacion_data = new_cmb2_box( array(
        'id'            => 'oda_ordenanza_data_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Información Básica', 'oda' ),
        'object_types'  => array( 'ordenanza' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* DATA ORDENANZA: Número de Tramite */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_nro_tramite',
        'name' => esc_html__( 'Número de Trámite', 'oda' ),
        'desc' => __( 'Agregue el número de trámite asignado a esta ordenanza.', 'oda' ),
        'type' => 'text_small'
    ) );

    /* DATA ORDENANZA: Fecha */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_fecha',
        'name' => esc_html__( 'Fecha de Presentación', 'oda' ),
        'desc' => __( 'Agregue la fecha de presentación de la Ordenanza.', 'oda' ),
        'type' => 'text_date'
    ) );

    /* DATA ORDENANZA: Iniciativa */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_iniciativa',
        'name' => esc_html__( 'Iniciativa', 'oda' ),
        'desc' => __( 'Seleccione la Iniciativa de esta Ordenanza.', 'oda' ),
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

    /* DATA ORDENANZA: Proponente */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_proponente',
        'name' => esc_html__( 'Proponente de Ordenanza', 'oda' ),
        'desc' => __( 'Agregue el Proponente de esta Ordenanza.', 'oda' ),
        'type' => 'text_medium'
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
        $mtb_observacion_data->add_field( array(
            'id'   => ODA_PREFIX . 'ordenanza_miembros',
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
        $mtb_observacion_data->add_field( array(
            'id'         => ODA_PREFIX . 'ordenanza_miembros',
            'name' => esc_html__( 'Miembros del Consejo', 'oda' ),
            'desc' => __( 'Seleccione el/os miembros del consejo para esta Ordenanza.', 'oda' ),
            'type' => 'pw_multiselect',
            'classes_cb' => 'oda_select2',
            'options'          => $array_miembros
        ) );
    }

    /* DATA ORDENANZA: Estado */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_estado',
        'name' => esc_html__( 'Estado', 'oda' ),
        'desc' => __( 'Seleccione el estado de esta Ordenanza.', 'oda' ),
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

    /* DATA ORDENANZA: Comisión [ PRE GET POSTS ] */
    $query_comision = new WP_Query(array(
        'post_type' => 'comision',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '='
            )
        )
    ));

    if ( !$query_comision->have_posts() ){
        /* DATA ORDENANZA: Aviso [Si no hay comisiones disponibles para la ciudad] */
        $mtb_observacion_data->add_field( array(
            'id'   => ODA_PREFIX . 'ordenanza_comision',
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'Aun no tiene comisiones asignadas a la ciudad, por favor asigne una. Haga clic <a href="'. admin_url('/post-new.php?post_type=comision') .'">aqui</a>.', 'oda' ),
            'type' => 'title'
        ) );
    } else {
        /* DATA ORDENANZA: Comisión [ PRE GET POSTS ] */
        while ($query_comision->have_posts()) : $query_comision->the_post();
        $array_comision[get_the_ID()] = get_the_title();
        endwhile;
        wp_reset_query();

        /* DATA ORDENANZA: Comisión */
        $mtb_observacion_data->add_field( array(
            'id'         => ODA_PREFIX . 'ordenanza_comision',
            'name' => esc_html__( 'Comision de la Ordenanza', 'oda' ),
            'desc' => __( 'Seleccione la comisión para esta Ordenanza.', 'oda' ),
            'type' => 'select',
            'options' => $array_comision
        ) );
    }


    /* DATA ORDENANZA: Fecha */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_vigencia',
        'name' => esc_html__( 'Fecha de Vigencia', 'oda' ),
        'desc' => __( 'Agregue la fecha de vigencia de la Ordenanza.', 'oda' ),
        'type' => 'text_date'
    ) );

    /* DATA ORDENANZA: Link del Registro Oficial */
    $mtb_observacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_oficial_link',
        'name' => esc_html__( 'Link del Registro Oficial', 'oda' ),
        'desc' => __( 'Agregue la URL del Registro Oficial de esta Ordenanza.', 'oda' ),
        'type' => 'text_url'
    ) );

    /* --------------------------------------------------------------
        DATA ORDENANZA: INCIDENCIA METABOX
    -------------------------------------------------------------- */
    $mtb_ordenanza_inc = new_cmb2_box( array(
        'id'            => 'oda_ordenanza_incidencia_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Incidencias', 'oda' ),
        'object_types'  => array( 'ordenanza' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );

    /* DATA INCIDENCIA: Activar [Checkbox] */
    $mtb_ordenanza_inc->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_incidencia_act',
        'name' => esc_html__( '¿Esta ordenanza es una incidencia?', 'oda' ),
        'desc' => __( 'Seleccione si esta ordenanza tiene alguna incidencia.', 'oda' ),
        'type' => 'checkbox'
    ) );

    /* DATA INCIDENCIA: Imágenes de la incidencia */
    $group_field_id = $mtb_ordenanza_inc->add_field( array(
        'id'            => ODA_PREFIX . 'ordenanza_incidencia_group',
        'name'          => esc_html__( 'Incidencias Relacionadas', 'oda' ),
        'description'   => __( 'Incidencias relacionadas de la ordenanza', 'oda' ),
        'type'          => 'group',
        'options'     => array(
            'group_title'       => __( 'Incidencia {#}', 'oda' ),
            'add_button'        => __( 'Agregar Otra Incidencia', 'oda' ),
            'remove_button'     => __( 'Remover Incidencia', 'oda' ),
            'sortable'          => true,
            'closed'         => true,
            'remove_confirm' => esc_html__( '¿Esta seguro de remover esta incidencia?', 'oda' )
        ),
    ) );


    $mtb_ordenanza_inc->add_group_field( $group_field_id, array(
        'id'         => ODA_PREFIX . 'ordenanza_incidencia_img',
        'name' => esc_html__( 'Imágenes de Incidencia', 'oda' ),
        'desc' => __( 'Agregue las imágenes de esta incidencia.', 'oda' ),
        'type' => 'file_list',
        'preview_size' => array( 100, 100 ),
        'query_args' => array( 'type' => 'image' ),
        'text' => array(
            'add_upload_files_text' => __( 'Agregar o Remover imágenes', 'oda' ),
            'remove_image_text' => __( 'Remover Imagen', 'oda' ),
            'file_text' => __( 'Imagen', 'oda' ),
            'file_download_text' => __( 'Descargar', 'oda' ),
            'remove_text' => __( 'Remover', 'oda' )
        )
    ) );

    /* DATA INCIDENCIA: Descripción */
    $mtb_ordenanza_inc->add_group_field( $group_field_id, array(
        'id'         => ODA_PREFIX . 'ordenanza_incidencia_desc',
        'name' => esc_html__( 'Descripción de la incidencia', 'oda' ),
        'desc' => __( 'Describa la incidencia de esta ordenanza.', 'oda' ),
        'type' => 'textarea_small'
    ) );

    /* DATA INCIDENCIA: ID Video YouTube */
    $mtb_ordenanza_inc->add_group_field( $group_field_id, array(
        'id'         => ODA_PREFIX . 'ordenanza_incidencia_videoid',
        'name' => esc_html__( 'ID Video youTube de la Incidencia', 'oda' ),
        'desc' => __( 'Agregue el ID del video de la incidencia. <br/> EG: https://www.youtube.com/watch?v=<b>kXShLPXJSJSH</b>.', 'oda' ),
        'type' => 'text'
    ) );

    /* DATA INCIDENCIA: Urgente [Checkbox] */
    $mtb_ordenanza_inc->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_incidencia_urgente',
        'name' => esc_html__( '¿Esta ordenanza es Urgente?', 'oda' ),
        'desc' => __( 'Seleccione si esta ordenanza es urgente.', 'oda' ),
        'type' => 'checkbox'
    ) );

    /* DATA INCIDENCIA: Análisis y Boletínes */
    $mtb_ordenanza_inc->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_analisis_boletines',
        'name' => esc_html__( 'URL de Análisis y Boletines', 'oda' ),
        'desc' => __( 'Agregue el URL de Análisis y Boletines.', 'oda' ),
        'type' => 'text'
    ) );

    /* DATA INCIDENCIA: Incidencias Relacionadas */
    $mtb_ordenanza_inc->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_incidencia_related',
        'name' => esc_html__( 'Incidencias Relacionadas', 'oda' ),
        'desc' => __( 'Seleccione la/las indicencias relacionadas.', 'oda' ),
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

    /* DATA INCIDENCIA: Temas [Taxonomy Select] */
    $mtb_ordenanza_inc->add_field( array(
        'id'         => ODA_PREFIX . 'ordenanza_incidencia_temas',
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

    /* --------------------------------------------------------------
        DATA ORDENANZA: FASES METABOX
    -------------------------------------------------------------- */
    $mtb_ordenanza_fases = new_cmb2_box( array(
        'id'            => ODA_PREFIX . 'ordenanza_fases_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Fases de la Ordenanza', 'oda' ),
        'object_types'  => array( 'ordenanza' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );

    /* DATA ORDENANZA: FASES [ PRE GET POSTS ] */
    $documentos = get_post_meta($city, ODA_PREFIX . 'items_ordenanza_fases', true);

    if ( !$documentos ){
        /* DATA ORDENANZA: Aviso [Si no hay fases disponibles para la ciudad] */
        $mtb_ordenanza_fases->add_field( array(
            'id'   => ODA_PREFIX . 'ordenanza_fases_title',
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'Aun no tiene fases asignadas a la ciudad, por favor asigne una. Haga clic <a href="'. admin_url('/post-new.php?post_type=ciudad') .'">aqui</a>.', 'oda' ),
            'type' => 'title'
        ) );
    }else{
        $i = 1;
        foreach($documentos as $index => $value){
            if ($i > 1) {
                /* DATA ORDENANZA: Separador */
                $mtb_ordenanza_fases->add_field( array(
                    'id'   => ODA_PREFIX . 'ord_fases_title_' . $index,
                    'name' => esc_html__( ' ' ),
                    'type' => 'title',
                    'classes_cb' => 'oda_spacer',
                ) );
            }
            /* DATA ORDENANZA: Ícono representativo del Item */
            $mtb_ordenanza_fases->add_field( array(
                'id'         => ODA_PREFIX . 'ord_fases_icon_' . $index,
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

            /* DATA ORDENANZA: Documento PDF representativo del Item */
            $mtb_ordenanza_fases->add_field( array(
                'id'         => ODA_PREFIX . 'ord_fases_item_' . $index,
                'name'       => __('Fase: ') . ' ' . $value,
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
            $mtb_ordenanza_fases->add_field( array(
                'id'         => ODA_PREFIX . 'ord_fases_fecha_' . $index,
                'name' => esc_html__( 'Fecha de la Fase', 'oda' ),
                'desc' => __( 'Agregue la fecha de la Fase.', 'oda' ),
                'type' => 'text_date'
            ) );
            $i++; }
    }
}



/* Metabox for Observaciones / Ordenanzas */
function oda_observacion_metabox(){

    $city = null;
    if (isset($_GET['post'])){
        $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
    }
    if (isset($_POST['post_ID'])){
        $city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);        
    }
    /* --------------------------------------------------------------
        OBSERVACIONES: METABOX RELACIONES
    -------------------------------------------------------------- */
    $mtb_observacion_rel = new_cmb2_box( array(
        'id'            => 'oda_observacion_relaciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Relaciones', 'oda' ),
        'object_types'  => array( 'observacion' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* ORDENANZAS: CIUDAD [PRE GET POSTS] */
    $args = array(
        'post_type' => 'ciudad',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $alcaldias = new WP_Query($args);


    if ( !$alcaldias->have_posts() ){
        /* ORDENANZAS: Titulo si no hay ninguna ciudad */
        $mtb_observacion_rel->add_field( array(
            'id'   => ODA_PREFIX . 'ordenanza_ciudad_title',
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

        /* ORDENANZAS: Ciudades */
        $mtb_observacion_rel->add_field( array(
            'name'       => esc_html__( '¿A qué ciudad pertenece esta Observación?', 'oda' ),
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
        ORDENANZAS: METABOX INFORMACIÓN PRINCIPAL
    -------------------------------------------------------------- */
    if($city !== null){
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
        $mtb_observacion_data = new_cmb2_box( array(
            'id'            => 'oda_observacion_data_metabox',
            'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Información Básica', 'oda' ),
            'object_types'  => array( 'observacion' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'show_names' => true
        ) );

        $mtb_observacion_data->add_field( array(
            'id'         => ODA_PREFIX . 'observacion_fecha',
            'name' => esc_html__( 'Fecha de la observación', 'oda' ),            
            'type' => 'text_date',
        ) );

        if ( !$query_miembros->have_posts() ){
            /* DATA ORDENANZA: Aviso [Si no hay miembros disponibles para la ciudad] */
            $mtb_observacion_data->add_field( array(
                'id'   => ODA_PREFIX . 'ordenanza_miembros',
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
            $mtb_observacion_data->add_field( array(
                'id'         => ODA_PREFIX . 'observacion_miembro',
                'name' => esc_html__( 'Miembro del Consejo', 'oda' ),
                'desc' => __( 'Seleccione el/os miembros del consejo para esta Ordenanza.', 'oda' ),
                'type' => 'pw_select',
                'classes_cb' => 'oda_select2',
                'options' => $array_miembros
            ) );
        }

        $query_ordenanzas = new WP_Query(array(
            'post_type' => 'ordenanza',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => 'oda_ciudad_owner',
                    'value' => $city,
                    'compare' => '='
                )
            )
        ));  
        if ( !$query_ordenanzas->have_posts() ){
            /* DATA ORDENANZA: Aviso [Si no hay miembros disponibles para la ciudad] */
            $mtb_observacion_data->add_field( array(
                'id'   => ODA_PREFIX . 'observacion_item',
                'name' => esc_html__( 'Aviso Importante', 'oda' ),
                'desc' => __( 'Aun no tiene miembros asignados a la ciudad, por favor asigne uno. Haga clic <a href="'. admin_url('/post-new.php?post_type=miembro') .'">aqui</a>.', 'oda' ),
                'type' => 'title'
            ) );
        } else {
            /* DATA ORDENANZA: Miembros [ PRE GET POSTS ] */
            $array_ordenanzas = array();
            while ($query_ordenanzas->have_posts()) : $query_ordenanzas->the_post();
            $array_ordenanzas[get_the_ID()] = get_the_title();
            endwhile;
            wp_reset_query();

            /* DATA ORDENANZA: Miembros */
            $mtb_observacion_data->add_field( array(
                'id'         => ODA_PREFIX . 'observacion_ordenanza',
                'name' => esc_html__( 'Miembros del Consejo', 'oda' ),
                'desc' => __( 'Seleccione el/os miembros del consejo para esta Ordenanza.', 'oda' ),
                'type' => 'pw_select',
                'classes_cb' => 'oda_select2',
                'options'          => $array_ordenanzas
            ) );
        }

        /* DATA ORDENANZA: Número de Tramite */
        $mtb_observacion_data->add_field( array(
            'id'         => ODA_PREFIX . 'observacion_documento',
            'name' => esc_html__( 'Documento', 'oda' ),   
            'type' => 'file',
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
    }
}

add_filter('wp_insert_post_data', 'change_name_observacion', 99, 1);
function change_name_observacion( $data ){
    if($data['post_type'] == 'observacion' && isset($_POST['oda_ciudad_owner'])) { // If the actual field name of the rating date is different, you'll have to update this.
        $ciudad = get_post($_POST['oda_ciudad_owner']);
        $ordenanza = get_post($_POST['oda_observacion_ordenanza']);
        $title = 'OBS: '. $ordenanza->post_title .' - ' . $ciudad->post_title;
        $data['post_title'] =  $title ; //Updates the post title to your new title.
    }
    return $data; // Returns the modified data.
}