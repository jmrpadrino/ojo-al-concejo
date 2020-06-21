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
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$mtb_rel = new_cmb2_box( array(
		'id'            => 'oda_miembro_relaciones',
		'title'         => esc_html__( 'Relaciones', 'cmb2' ),
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
			'name' => esc_html__( 'Aviso Importante', 'cmb2' ),
			'desc' => __( 'Aun no tiene alcaldias agregadas por favor agregue una. Haga clic <a href="'. admin_url('/post-new.php?post_type=alcaldia') .'">aqui</a>.', 'cmb2' ),
			'id'   => 'yourprefix_demo_title',
			'type' => 'title',
		) );
	}else{
		$alcaldias_array = array();
		while ( $alcaldias->have_posts() ) { $alcaldias->the_post();
			$alcaldias_array[get_the_ID()] = get_the_title();
		}
		//var_dump( $alcaldias_array );
		//die;
		$mtb_rel->add_field( array(
			'name'       => esc_html__( '¿A qué ciudad pertenece este miembro?', 'cmb2' ),
			'desc'       => esc_html__( 'Este campo es obligatorio', 'cmb2' ),
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
	$args = array(
		'post_type' => 'circunscripcion',
		'posts_per_page' => -1,
		'post_status' => 'publish'
	);
	$circunscripcion = new WP_Query($args);
	if ( !$circunscripcion->have_posts() ){
		$mtb_rel->add_field( array(
			'name' => esc_html__( 'Aviso Importante', 'cmb2' ),
			'desc' => __( 'Aun no tiene circunscripciones agregadas por favor agregue una. Haga clic <a href="'. admin_url('/post-new.php?post_type=circunscripcion') .'">aqui</a>.', 'cmb2' ),
			'id'   => 'yourprefix_demo_title',
			'type' => 'title',
		) );
	}else{
		$circunscripcion_array = array();
		while ( $circunscripcion->have_posts() ) { $circunscripcion->the_post();
			$circunscripcion_array[get_the_ID()] = get_the_title();
		}
		//var_dump( $alcaldias_array );
		//die;
		$mtb_rel->add_field( array(
			'name'       => esc_html__( '¿A qué Circunscripción pertenece esta miembro?', 'cmb2' ),
			'desc'       => esc_html__( 'Este campo es obligatorio', 'cmb2' ),
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