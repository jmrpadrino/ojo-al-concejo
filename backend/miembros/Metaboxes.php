<?php
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
	require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
}

/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object.
 */
function oda_render_icons_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo esc_attr( $classes ); ?>">
		<style scoped>
			.icons-list {
				max-height: 80px;
				width: 90%;
				overflow: auto;
				border: 1px solid #c1c1c1;
				padding:8px;
				padding-right: 16px;
				background-color: #f3f3f3;
				display: flex;
				flex-wrap: wrap;
			}
			.icon-item{
				width: 20px;
				height: 20px;
				margin: 4px;
				border: 1px solid #c1c1c1;
				display: flex!important;
				justify-content: center;
				align-items: center;
				cursor: pointer;
				padding: 0!important;
			}
			.hidden-input {
				display: none!important;
			}
			.icon-item:hover,
			.radio-icon:checked+.icon-item,
			.icon-item.selected{
				background: #FFC100;
				color: white;
			}
		</style>
		<p><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></p>
		<p><input class="hidden-input" id="<?php echo esc_attr( $id ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>" readonly/></p>
		<div class="icons-list">
			<?php foreach ( ODA_ICONS as $index => $icon ){ ?>
				<label for="<?php echo esc_attr( $name ); ?>_icon_<?php echo $index; ?>">
					<input onclick="oda_set_icon(this)" id="<?php echo esc_attr( $name ); ?>_icon_<?php echo $index; ?>" type="radio" name="<?php echo esc_attr( $name ) .'radio'; ?>" class="radio-icon hidden-input" value="<?php echo $icon; ?>" inputtarget="<?php echo esc_attr( $id ); ?>" <?php echo ($value == $icon) ? 'checked': ''; ?>>
					<div class="icon-item">
						<span class="<?php echo $icon; ?>"></span>
					</div>
				</label>
			<?php } ?>
		</div>
		<script>
			function oda_set_icon(e){
				iconInput = document.getElementById(e.attributes.inputtarget.value);
				iconInput.value = e.value;
			}
		</script>
	</div>
	<?php
}
/*
$mtb_rel->add_field( array(
	'name' => esc_html__( 'Icon Selector', 'cmb2' ),
	'id'   => 'oda_icon',
	'type' => 'text',
	'render_row_cb' => 'oda_render_icons_cb',
) );
*/

add_action( 'cmb2_admin_init', 'oda_register_miembro_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function oda_register_miembro_metabox() {
	$city = null;
	$current_post = null;
	if (isset($_GET['post'])){
		$city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
		$current_post = $_GET['post'];
	}
	if (isset($_POST['post_ID'])){
		$city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);
		$current_post = $_POST['post_ID'];
	}


	/**
	 * Metaboxz for Relaciones
	 */
	$mtb_rel = new_cmb2_box( array(
		'id'            => 'oda_miembro_relaciones',
		'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Relaciones', 'oda' ),
		'object_types'  => array( 'miembro' ), // Post type
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
		$mtb_rel->add_field( array(
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
		wp_reset_query();
		//var_dump( $alcaldias_array );
		//die;
		$mtb_rel->add_field( array(
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
	 * Get all post from Circunscripcion
	 */
	if ( !isset ( $_GET['post']) ){
		$mtb_rel->add_field( array(
			'name'       => esc_html__( '¿A qué Circunscripción pertenece este miembro?', 'cmb2' ),
			'desc'       => esc_html__( 'Debe seleccionar una ciudad.', 'oda' ),
			'id'         => ODA_PREFIX . 'circunscripcion_owner',
			'type'             => 'select',
			//'show_option_none' => true,
			'options' => array(),
			'attributes' => array(
				'required' => 'required',
				'disabled' => 'disabled'
			),
		) );
	}else{
		$city_ID = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true); 
		$args = array(
			'post_type' => 'circunscripcion',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'meta_key' => ODA_PREFIX . 'ciudad_owner',
			'orderby'    => 'meta_value_num',
			'order'      => 'ASC',
			'meta_query' => array(
				array(
					'key' => ODA_PREFIX . 'ciudad_owner',
					'value' => $city_ID
				)
			)
		);
		$circunscripcion = new WP_Query($args);
		if ( !$circunscripcion->have_posts() ){
			$mtb_rel->add_field( array(
				'name' => esc_html__( 'Aviso Importante', 'oda' ),
				'desc' => __( 'Aun no tiene circunscripciones agregadas por favor agregue una. Haga clic <a href="'. admin_url('/post-new.php?post_type=circunscripcion') .'">aqui</a>.', 'cmb2' ),
				'id'   => ODA_PREFIX . 'circunscripcion_owner',
				'type' => 'title',
			) );
		}else{
			$circunscripcion_array = array();
			while ( $circunscripcion->have_posts() ) { $circunscripcion->the_post();
				$circunscripcion_array[get_the_ID()] = get_the_title();
			}
			wp_reset_query();
			//var_dump( $alcaldias_array );
			//die;
			$mtb_rel->add_field( array(
				'name'       => esc_html__( '¿A qué Circunscripción pertenece este miembro?', 'cmb2' ),
				'desc'       => esc_html__( 'Este campo es obligatorio', 'oda' ),
				'id'         => ODA_PREFIX . 'circunscripcion_owner',
				'type'             => 'select',
				'show_option_none' => true,
				'options' => $circunscripcion_array,
				'attributes' => array(
					'required' => 'required',
				),
			) );	
		}
	}

	/**
	 * Get all post from Partido Politico
	 */
	$args = array(
		'post_type' => 'partido',
		'posts_per_page' => -1,
		'post_status' => 'publish'
	);
	$partido = new WP_Query($args);
	if ( !$partido->have_posts() ){
		$mtb_rel->add_field( array(
			'name' => esc_html__( 'Aviso Importante', 'oda' ),
			'desc' => __( 'Aun no tiene Partidos politicos agregados por favor agregue una. Haga clic <a href="'. admin_url('/post-new.php?post_type=circunscripcion') .'">aqui</a>.', 'cmb2' ),
			'id'   => 'yourprefix_demo_title',
			'type' => 'title',
		) );
	}else{
		$partido_array = array();
		while ( $partido->have_posts() ) { $partido->the_post();
			$partido_array[get_the_ID()] = get_the_title();
		}
		$partido->wp_reset_query();
		//var_dump( $alcaldias_array );
		//die;
		$mtb_rel->add_field( array(
			'name'       => esc_html__( '¿A qué partido político pertenece este miembro?', 'cmb2' ),
			'desc'       => esc_html__( 'Este campo es obligatorio', 'cmb2' ),
			'id'         => ODA_PREFIX . 'partido_owner',
			'type'             => 'select',
			'show_option_none' => true,
			'options' => $partido_array,
			'attributes' => array(
				'required' => 'required',
			),
		) );
	}

	/**
	 * Metabox para metadatos
	 */
	$suplente = get_post_meta($current_post, ODA_PREFIX . 'miembro_es_supente', true);
	if ( !'on' == $suplente ){
		$mtb_rel = new_cmb2_box( array(
			'id'            => 'oda_miembros_suplentes_metadatos',
			'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Miembros Suplentes', 'oda' ),
			'object_types'  => array( 'miembro' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			'classes'    => 'oda-metabox'
		) );

		// get suplentes of same city
		$suplente = get_post_meta($current_post, ODA_PREFIX . 'comision_composicion_miembros', false);		
		$excluir_suplentes = array();
		$args = array(
			'post_type' => 'miembro',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'post__not_in' => $excluir_suplentes,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => ODA_PREFIX . 'ciudad_owner',
					'value' => $city,
					'compare' => '='
				),
				array(
					'key' => ODA_PREFIX . 'miembro_es_supente',
					'value' => 'on',
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
		$mtb_rel->add_field( array(
			'name'       => esc_html__( 'Miembro Suplente', 'oda' ),
			'id'         => ODA_PREFIX . 'miembro_miembros_suplentes',
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

	}



	/**
	 * Metabox para metadatos
	 */
	$mtb_rel = new_cmb2_box( array(
		'id'            => 'oda_miembro_metadatos',
		'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Metadatos para el Miembro del Concejo', 'oda' ),
		'object_types'  => array( 'miembro' ), // Post type
		// 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'classes'    => 'oda-metabox'
	) );
	
	/**
	 * Get the Full first name
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( '¿Es miembro suplente?', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_es_supente',
		'type' => 'checkbox',
	) );

	/**
	 * Get the Full first name
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( '¿Participa en el Concejo?', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_participa',
		'type' => 'checkbox',
	) );

	/**
	 * Get the Full first name
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( '¿Participa como Concejal Rural?', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_rural',
		'type' => 'checkbox',
	) );
		
	/**
	 * Get the Full first name
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Nombres Completos', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_nombres',
		'type'       => 'text',
	) );

	/**
	 * Get the Full last name
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Apellidos Completos', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_apellidos',
		'type'       => 'text',
	) );

	/**
	 * Get the job
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Cargo', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_cargo',
		'type'             => 'select',
		'show_option_none' => true,
		'show_option_none' => 'Seleccione uno',
		'options'          => array(
			'1' 	=> esc_html__( 'Alcalde', 'oda' ),
			'2'   	=> esc_html__( 'concejal rural', 'oda' ),
			'3'     => esc_html__( 'concejal urbano', 'oda' ),
		),
	) );

	/**
	 * Get the gender
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Genero', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_gerero',
		'type'             => 'select',
		'show_option_none' => true,
		'show_option_none' => 'Seleccione uno',
		'options'          => array(
			'1' 	=> esc_html__( 'Msculino', 'oda' ),
			'2'   	=> esc_html__( 'Femenino', 'oda' ),
			'3'     => esc_html__( 'Sin especificar', 'oda' ),
		),
	) );

	/**
	 * Get the curul
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Curul', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_curul',
		'type'             => 'text',
		'attributes' => array(
			'type' => 'number',
			'min' => '0',
		),

	) );
	
	/**
	 * Get the Profesion
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Profesión', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_profesion',
		'type'             => 'text'
	) );

	/**
	 * Get the email
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Correo Electrónico', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_email',
		'type'             => 'text_email'
	) );

	/**
	 * Get the telefono
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Teléfono', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_phone',
		'type'             => 'text',
		'attributes' => array(
			'type' => 'tel',
		),
	) );

	/**
	 * Get the blog
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Blog', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_web',
		'type'             => 'text_url',
	) );

	/**
	 * Get the twitter
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Usuario Twitter', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_twitter',
		'type'             => 'text',
	) );

	/**
	 * Get the radiografia politica url
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Radiografía Política URL', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_rpurl',
		'type'             => 'text_url',
	) );

	/**
	 * Get the asesor comunicacion
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Asesor de Comunicación', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_asesor_comunicacion',
		'type'             => 'text',
	) );

	/**
	 * Get the asesor legal
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Asesor Legal', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_asesor_legal',
		'type'             => 'text',
	) );

	/**
	 * Get the asesor administrativo
	 */
	$mtb_rel->add_field( array(
		'name'       => esc_html__( 'Asesor Administrativo', 'oda' ),
		//'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => ODA_PREFIX . 'miembro_asesor_admin',
		'type'             => 'text',
		'repeatable' => true
	) );


	/**
	 * Metabox para documentos
	 */
	$mtb_rel = new_cmb2_box( array(
		'id'            => 'oda_miembro_documentos',
		'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Documentos', 'oda' ),
		'object_types'  => array( 'miembro' ), // Post type
		// 'show_on_cb' => 'oda_show_if_front_page', // function should return a bool value
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'classes'    => 'oda-metabox'
	) );

	/**
	 * Get the CV
	 */
	$mtb_rel->add_field( array(
		'name'    => 'Cirruculum Vitae',
		'desc'    => 'Suba un archivo o agregue una URL',
		'id'      => ODA_PREFIX . 'miembro_pdf_cv',
		'type'    => 'file',
		// Optional:
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

	/**
	 * Get the Plan
	 */
	$mtb_rel->add_field( array(
		'name'    => 'Plan de Trabajo',
		'desc'    => 'Suba un archivo o agregue una URL',
		'id'      => ODA_PREFIX . 'miembro_pdf_plan',
		'type'    => 'file',
		// Optional:
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

	/**
	 * Get the Labor notmativa
	 */
	$mtb_rel->add_field( array(
		'name'    => 'Labor Normativa',
		'desc'    => 'Suba un archivo o agregue una URL',
		'id'      => ODA_PREFIX . 'miembro_pdf_labor',
		'type'    => 'file',
		// Optional:
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


	/**
	 * Get all items from Concejal Transparente
	 */
	$mtb_transparente = new_cmb2_box( array(
		'id'            => 'oda_miembros_concejal_transparente',
		'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( 'Documentos para Concejo Transparente', 'oda' ),
		'object_types'  => array( 'miembro' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'classes'    => 'oda-metabox'
	) );
	$documentos = get_post_meta($city, ODA_PREFIX . 'items_concejo_transparente', true);
	
	if ( !$documentos ){
		$mtb_transparente->add_field( array(
			'name' => esc_html__( 'Aviso Importante', 'oda' ),
			'desc' => __( 'Aun no items que solicitar para Concejo Transoparente.', 'cmb2' ),
			'id'   => 'con_transparente',
			'type' => 'title',
		) );
	}else{
		$mtb_transparente->add_field( array(
			'name' => esc_html__( '¿Es parte del Concejo Transparente?', 'oda' ),
			'id'   => ODA_PREFIX . 'miembro_parte_concejo_transparente',
			'type' => 'checkbox',
		) );
		foreach($documentos as $index => $value){
			$mtb_transparente->add_field( array(
				'name'       => $value,
				'id'         => ODA_PREFIX . 'con_transp_item_' . $index,
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
	


}