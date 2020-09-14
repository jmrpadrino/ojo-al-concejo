<?php
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
}
add_action( 'cmb2_admin_init', 'oda_comision_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'oda_admin_init' or 'oda_init' hook.
 */
function oda_comision_metabox() {

	/**
	 * Metabos for metadata on Comision Composicion
	 */
	$mtb_metas = new_cmb2_box( array(
		'id'            => 'oda_comision_composicion',
		'title'         => esc_html__( 'Composición de la Comisión', 'oda' ),
		'object_types'  => array( 'comision' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );

	$args = array(
		'post_type' => 'miembro',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'meta_key'   => ODA_PREFIX . 'miembro_es_supente',
		'meta_query' => array(
			//'relation' => 'AND',
			array(
				'key' => ODA_PREFIX . 'miembro_es_supente',
				'value' => 'on',
				'compare' => '='
			)
		)
	);
	
	$miembros_suplentes = new WP_Query($args);
	$excluir_suplentes = array();
	while ( $miembros_suplentes->have_posts() ){
		$miembros_suplentes->the_post();
		$excluir_suplentes[] = get_the_ID();
	}
	wp_reset_query();

	// get city meta for comision to filter members
	//$city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
	$city = null;
	if (isset($_GET['post'])){
		$city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
	}
	if (isset($_POST['post_ID'])){
		$city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);
	}

	
	$args = array(
		'post_type' => 'miembro',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'post__not_in' => $excluir_suplentes,
		'meta_query' => array(
			array(
				'key' => ODA_PREFIX . 'ciudad_owner',
				'value' => $city,
				'compare' => '='
			)
		)
	);
	$miembros = new WP_Query($args);

	$miembros_array = array();
	if ( $miembros->have_posts() ){
		while ( $miembros->have_posts() ) { $miembros->the_post();
			$miembros_array[get_the_ID()] = get_the_title();
		}
		wp_reset_query();
	}

	$mtb_metas->add_field( array(
		'name'       => esc_html__( 'Presidente', 'oda' ),
		'id'         => ODA_PREFIX . 'comision_composicion_presidente',
		'type'             => 'select',
		'show_option_none' => true,
		'options' => $miembros_array,
		/*
		'attributes' => array(
			'required' => 'required',
		),
		*/
	) );

	$mtb_metas->add_field( array(
		'name'       => esc_html__( 'Vicepresidente', 'oda' ),
		'id'         => ODA_PREFIX . 'comision_composicion_vicepresidente',
		'type'             => 'select',
		'show_option_none' => true,
		'options' => $miembros_array,
		/*
		'attributes' => array(
			'required' => 'required',
		),
		*/
	) );

	$mtb_metas->add_field( array(
		'name'       => esc_html__( 'Demás Miembros', 'oda' ),
		'id'         => ODA_PREFIX . 'comision_composicion_miembros',
		'type'             => 'select',
		'show_option_none' => true,
		'options' => $miembros_array,
		/*
		'attributes' => array(
			'required' => 'required',
		),
		*/
		'repeatable' => true
	) );

	/**
	 * Metabos for metadata on Comision
	 */
	$mtb_metas = new_cmb2_box( array(
		'id'            => 'oda_comision_meta',
		'title'         => esc_html__( 'Metadatos de la Comisión', 'oda' ),
		'object_types'  => array( 'comision' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
	) );

	$mtb_metas->add_field( array(
		'name'       => esc_html__( '¿Desactivar?', 'oda' ),
		'id'         => ODA_PREFIX . 'comision_activa',
		'type'       => 'checkbox',
	) );

	$mtb_metas->add_field( array(
		'name'       => esc_html__( 'Fecha de creación', 'oda' ),
		'id'         => ODA_PREFIX . 'comision_created',
		'type'       => 'text_date',
	) );

	$mtb_metas->add_field( array(
		'name'       => esc_html__( 'Fecha de terminación', 'oda' ),
		'id'         => ODA_PREFIX . 'comision_ends',
		'type'       => 'text_date',
	) );

	$mtb_metas->add_field( array(
		'name'       => esc_html__( 'Nombre corto', 'oda' ),
		'id'         => ODA_PREFIX . 'comision_short_name',
		'type'       => 'text',
	) );

	$mtb_metas->add_field( array(
		'name'       => esc_html__( 'Tipo', 'oda' ),
		'id'         => ODA_PREFIX . 'comision_type',
		'type'       => 'select',
		'show_option_none' => true,
		'options' 	 => ODA_ESTADOS_COMISION,
	) );


	$mtb_rel = new_cmb2_box( array(
		'id'            => 'oda_comision_relaciones',
		'title'         => esc_html__( 'Relaciones', 'oda' ),
		'object_types'  => array( 'comision' ), // Post type
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
	$ciudad = new WP_Query($args);
	if ( !$ciudad->have_posts() ){
		$mtb_rel->add_field( array(
			'name' => esc_html__( 'Aviso Importante', 'od' ),
			'desc' => __( 'Aun no tiene ciudades agregadas por favor agregue una. Haga clic <a href="'. admin_url('/post-new.php?post_type=ciudad') .'">aqui</a>.', 'od' ),
			'id'   => 'yourprefix_demo_title',
			'type' => 'title',
		) );
	}else{
		$ciudad_array = array();
		while ( $ciudad->have_posts() ) { $ciudad->the_post();
			$ciudad_array[get_the_ID()] = get_the_title();
		}
		wp_reset_query();
		//var_dump( $alcaldias_array );
		//die;
		$mtb_rel->add_field( array(
			'name'       => esc_html__( '¿A qué ciudad pertenece esta Comisión?', 'oda' ),
			'desc'       => esc_html__( 'Este campo es obligatorio', 'oda' ),
			'id'         => ODA_PREFIX . 'ciudad_owner',
			'type'             => 'select',
			'show_option_none' => true,
			'options' => $ciudad_array,
			'attributes' => array(
				'required' => 'required',
			),
			'after_field'    => '<strong>¿No esta la ciudad?</strong>, haga clic <a href="'. admin_url('/post-new.php?post_type=ciudad') .'">aqui</a> para agregar una nueva.',
		) );
	}

}