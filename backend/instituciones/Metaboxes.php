<?php
/* INSTITUCIONES: IF FILE IS CALLED DIRECTLY, ABORT */
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    INSTITUCIONES: FILE INCLUDES - SELECT2 CALLBACK
-------------------------------------------------------------- */
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
}

/* --------------------------------------------------------------
    INSTITUCIONES: MAIN CMB2 CALLBACK
-------------------------------------------------------------- */
add_action( 'cmb2_admin_init', 'oda_instituciones_metabox');

/* INSTITUCIONES: MAIN METABOX CALLBACK HANDLER */
function oda_instituciones_metabox() {

    /* INSTITUCIONES: OBTENER CIUDAD ASOCIADA A CPT */
    $city = null;
    if (isset($_GET['post'])){
        $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
    }
    if (isset($_POST['post_ID'])){
        $city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);
    }

    /* --------------------------------------------------------------
        INSTITUCIONES: METABOX METADATA
    -------------------------------------------------------------- */
    $mtb_metas = new_cmb2_box( array(
        'id'            => 'oda_instituciones_metas',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Metadatos', 'oda' ),
        'object_types'  => array( 'instituciones' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );

    /* INSTITUCIONES: Etiqueta de Color */
    $mtb_metas->add_field( array(
        'name'    => esc_html__( 'Etiqueta de Color', 'oda' ),
        'desc'    => esc_html__( 'Identificación visual para el sistema', 'oda' ),
        'id'      => ODA_PREFIX . 'ordenanza_color',
        'type'    => 'colorpicker',
        'default' => '#ffffff'
    ) );

    /* --------------------------------------------------------------
        INSTITUCIONES: METABOX RELACIONES
    -------------------------------------------------------------- */
    $mtb_ordenanza_rel = new_cmb2_box( array(
        'id'            => 'oda_instituciones_relaciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Relaciones', 'oda' ),
        'object_types'  => array( 'instituciones' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* INSTITUCIONES: CIUDAD [PRE GET POSTS] */
    $args = array(
        'post_type' => 'ciudad',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $alcaldias = new WP_Query($args);


    if ( !$alcaldias->have_posts() ){
        /* INSTITUCIONES: Titulo si no hay ninguna ciudad */
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

        /* INSTITUCIONES: Ciudades */
        $mtb_ordenanza_rel->add_field( array(
            'name'       => esc_html__( '¿A qué ciudad pertenece esta institucion?', 'oda' ),
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
        INSTITUCIONES: METABOX INFORMACIÓN PRINCIPAL
    -------------------------------------------------------------- */
    $mtb_instituciones_data = new_cmb2_box( array(
        'id'            => ODA_PREFIX . 'instituciones_data_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Información Básica', 'oda' ),
        'object_types'  => array( 'instituciones' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true,
        'classes'    => 'oda-metabox'
    ) );

    $group_field_id = $mtb_instituciones_data->add_field( array(
        'id'          => ODA_PREFIX . 'instituciones_cargos_group',
        'type'        => 'group',
        'description' => __( 'Cargos asociados a la institucion', 'oda' ),
        'options'     => array(
            'group_title'       => __( 'Cargo {#}', 'oda' ),
            'add_button'        => __( 'Agregar otro Cargo', 'oda' ),
            'remove_button'     => __( 'Remover Cargo', 'oda' ),
            'sortable'          => true,
            'closed'         => true,
            'remove_confirm' => esc_html__( '¿Estas seguro de remover este Cargo?', 'oda' )
        )
    ) );

    $mtb_instituciones_data->add_group_field( $group_field_id, array(
        'id'        => 'nombre',
        'name'      => esc_html__( 'Nombre', 'oda' ),
        'type' => 'text',
    ) );

    $mtb_instituciones_data->add_group_field( $group_field_id, array(
        'id'        => 'posicion',
        'name'      => esc_html__( 'Posición', 'oda' ),
        'type' => 'text',
    ) );

}
