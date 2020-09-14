<?php
/* PUBLICACIONES: IF FILE IS CALLED DIRECTLY, ABORT */
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    PUBLICACIONES: FILE INCLUDES - SELECT2 CALLBACK
-------------------------------------------------------------- */
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
}

/* --------------------------------------------------------------
    PUBLICACIONES: MAIN CMB2 CALLBACK
-------------------------------------------------------------- */
add_action( 'cmb2_admin_init', 'oda_publicacion_metabox' );

/* PUBLICACIONES: MAIN METABOX CALLBACK HANDLER */
function oda_publicacion_metabox() {

    /* PUBLICACIONES: OBTENER CIUDAD ASOCIADA A CPT */
    $city = null;
    if (isset($_GET['post'])){
        $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
    }
    if (isset($_POST['post_ID'])){
        $city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);        
    }

    /* --------------------------------------------------------------
        PUBLICACIONES: METABOX METADATA
    -------------------------------------------------------------- */
    $mtb_metas = new_cmb2_box( array(
        'id'            => ODA_PREFIX . 'publicacion_metas',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Metadatos', 'oda' ),
        'object_types'  => array( 'publicacion' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );

    /* PUBLICACIONES: Etiqueta de Color */
    $mtb_metas->add_field( array(
        'id'      => ODA_PREFIX . 'publicacion_color',
        'name'    => esc_html__( 'Etiqueta de Color', 'oda' ),
        'desc'    => esc_html__( 'Identificación visual para el sistema', 'oda' ),
        'type'    => 'colorpicker',
        'default' => '#ffffff'
    ) );

    /* --------------------------------------------------------------
        PUBLICACIONES: METABOX RELACIONES
    -------------------------------------------------------------- */
    $mtb_publicacion_rel = new_cmb2_box( array(
        'id'            => 'oda_publicacion_relaciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Relaciones', 'oda' ),
        'object_types'  => array( 'publicacion' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* PUBLICACIONES: CIUDAD [PRE GET POSTS] */
    $args = array(
        'post_type' => 'ciudad',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $alcaldias = new WP_Query($args);


    if ( !$alcaldias->have_posts() ){
        /* PUBLICACIONES: Titulo si no hay ninguna ciudad */
        $mtb_publicacion_rel->add_field( array(
            'id'   => ODA_PREFIX . 'publicacion_ciudad_title',
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

        /* PUBLICACIONES: Ciudades */
        $mtb_publicacion_rel->add_field( array(
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
        PUBLICACIONES: METABOX INFORMACIÓN PRINCIPAL
    -------------------------------------------------------------- */
    $mtb_publicacion_data = new_cmb2_box( array(
        'id'            => 'oda_publicacion_data_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Información Básica', 'oda' ),
        'object_types'  => array( 'publicacion' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* DATA PUBLICACIÓN: Tipo de Publicación */
    $mtb_publicacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'tipo_publicacion',
        'name' => esc_html__( 'Tipo de Publicación', 'oda' ),
        'desc' => __( 'Seleccione el Tipo de la Publicación.', 'oda' ),
        'type' => 'select',
        'show_option_none' => true,
        'default'          => 'anual',
        'options'          => array(
            'anual'      => __( 'Informe Anual', 'oda' ),
            'especial'    => __( 'Informe Especial', 'oda' ),
        )
    ) );

    /* DATA PUBLICACIÓN: Documento PDF */
    $mtb_publicacion_data->add_field( array(
        'id'            => ODA_PREFIX . 'publicacion_imagen',
        'name'          => esc_html__( 'Imágen de Portada', 'oda' ),
        'type'          => 'file',
        'options' => array(
            'url' => true,
        ),
        'text'    => array(
            'add_upload_file_text' => 'Añadir imágen'
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

    /* DATA PUBLICACIÓN: Fecha */
    $mtb_publicacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'publicacion_fecha',
        'name' => esc_html__( 'Fecha de Presentación', 'oda' ),
        'desc' => __( 'Agregue la fecha de presentación de la publicacion.', 'oda' ),
        'type' => 'text_date'
    ) );

    /* DATA PUBLICACIÓN: Descripción */
    $mtb_publicacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'publicacion_descripcion',
        'name' => esc_html__( 'Descripción', 'oda' ),
        'desc' => __( 'Agregue la Descripción de la Publicación.', 'oda' ),
        'type' => 'textarea_small'
    ) );

    /* DATA PUBLICACIÓN: Documento PDF */
    $mtb_publicacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'publicacion_documento',
        'name'          => esc_html__( 'Documento de la Publicación', 'oda' ),
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

    /* DATA PUBLICACIÓN: Código ISSUU */
    $mtb_publicacion_data->add_field( array(
        'id'         => ODA_PREFIX . 'publicacion_issuu',
        'name' => esc_html__( 'Código ISSUU', 'oda' ),
        'desc' => __( 'Agregue el Código ISSUU asignado a esta publicación.', 'oda' ),
        'type' => 'text_small'
    ) );
}
