<?php
/* sesionES: IF FILE IS CALLED DIRECTLY, ABORT */
if ( ! defined( 'WPINC' ) ) {
    die;
}

/* --------------------------------------------------------------
    sesionES: FILE INCLUDES - SELECT2 CALLBACK
-------------------------------------------------------------- */
if ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
} elseif ( file_exists( ODA_DIR_PATH . 'backend/metaboxes/init.php' ) ) {
    require_once ODA_DIR_PATH . 'backend/metaboxes/init.php';
    require_once ODA_DIR_PATH . 'backend/metaboxes/cmb-field-select2.php';
}

/* --------------------------------------------------------------
    sesionES: MAIN CMB2 CALLBACK
-------------------------------------------------------------- */
add_action( 'cmb2_admin_init', 'oda_sesion_metabox' );

/* sesionES: MAIN METABOX CALLBACK HANDLER */
function oda_sesion_metabox() {

    /* sesionES: OBTENER CIUDAD ASOCIADA A CPT */
    if (isset($_GET['post'])){
		$city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
	}else{
		$city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);
    }
    
    global $post;
    var_dump(get_post_type());

    /* DATA ORDENANZA: Miembros [ PRE GET POSTS ] */
    $query_miembros = new WP_Query(array(
        'post_type' => 'miembro',
        'order' => 'ASC',
        'order_by' => 'meta_value_num',
        'meta_key' => 'oda_miembro_curul',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '='
            )
        )
    ));
    $query_miembros->wp_reset_query();
    

    /* --------------------------------------------------------------
        sesionES: METABOX RELACIONES
    -------------------------------------------------------------- */
    $mtb_sesion_rel = new_cmb2_box( array(
        'id'            => 'oda_sesion_relaciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( '1. Configuración de la sesión', 'oda' ),
        'object_types'  => array( 'sesion' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true
    ) );

    /* sesionES: CIUDAD [PRE GET POSTS] */
    $args = array(
        'post_type' => 'ciudad',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    );
    $alcaldias = new WP_Query($args);


    if ( !$alcaldias->have_posts() ){
        /* sesionES: Titulo si no hay ninguna ciudad */
        $mtb_sesion_rel->add_field( array(
            'id'   => ODA_PREFIX . 'sesion_ciudad_title',
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

        /* sesionES: Ciudades */
        $mtb_sesion_rel->add_field( array(
            'id'         => ODA_PREFIX . 'ciudad_owner',
            'name'       => esc_html__( '¿A qué Concejo Municipal pertenece esta sesión?', 'oda' ),
            'desc'       => esc_html__( 'Este campo es Necesario', 'oda' ),
            'type'             => 'select',
            'show_option_none' => true,
            'attributes' => array(
                'required' => 'required',
            ),
            'options' => $alcaldias_array
        ) );
    }
    /* DATA RESOLUCIÓN: Fecha */
    $mtb_sesion_rel->add_field( array(
        'id'         => ODA_PREFIX . 'sesion_fecha',
        'name' => esc_html__( 'Fecha', 'oda' ),
        'type' => 'text_date'
    ) );
    $mtb_sesion_rel->add_field( array(
		'id'         => ODA_PREFIX . 'sesion_tipo',
		'name' => esc_html__( 'Tipo de sesión', 'oda' ),
		'type'     => 'taxonomy_select', // Or `taxonomy_select_hierarchical`
		'taxonomy' => 'tipo_sesion', // Taxonomy Slug
    ) );
    $mtb_sesion_rel->add_field( array(
		'id'         => ODA_PREFIX . 'sesion_tipo',
		'name' => esc_html__( 'Tipo de sesión', 'oda' ),
		'type'     => 'taxonomy_select', // Or `taxonomy_select_hierarchical`
        'taxonomy' => 'tipo_sesion', // Taxonomy Slug
        
    ) );

    $args = array(
        'post_type' => 'sesion',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'post__not_in' => array($_GET['post']),
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '='
            )
        )
    );
    $alcaldias = new WP_Query($args);
    $sesiones_ciudad = array();
    while ( $alcaldias->have_posts() ) : $alcaldias->the_post();
    $sesiones_ciudad[get_the_ID()] = get_the_title();
    endwhile;
    wp_reset_query();
    $mtb_sesion_rel->add_field( array(
        'name'       => 'Seleccione sesión continuada',
        'id'         => 'oda_sesion_continuada_id',
        'type'       => 'select',
        'options'    => $sesiones_ciudad,
        'attributes' => array(
            'data-conditional-id'    => ODA_PREFIX . 'sesion_tipo',
            'data-conditional-value' => 'continuacion',
        ),
    ) );
    $mtb_sesion_rel->add_field( array(
        'id'         => ODA_PREFIX . 'sesion_estado',
        'name' => esc_html__( 'Estado de sesión', 'oda' ),
        'type' => 'select',
        'options' => array(
            '1' => 'Iniciada',
            '2' => 'Pausada',
            '3' => 'Cerrada',
        )
    ) );

    /**
     * Participantes MTB
     */

    $mtb_sesion_asistentes = new_cmb2_box( array(
        'id'            => 'oda_sesion_data_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( '2. Participantes', 'oda' ),
        'object_types'  => array( 'sesion' ),
        'context'    => 'normal',
        'priority'   => 'high',
        'closed'     => true,
        'show_names' => true
    ) );
    if (!empty($city)){
        /* --------------------------------------------------------------
            sesionES: METABOX INFORMACIÓN PRINCIPAL
        -------------------------------------------------------------- */
        /* DATA ORDENANZA: Miembros [ PRE GET POSTS ] */
        while ($query_miembros->have_posts()) : $query_miembros->the_post();
        $array_miembros[get_the_ID()] = get_the_title();
        endwhile;
        $query_miembros->wp_reset_query();
        /* DATA RESOLUCIÓN: Número de Tramite */
        $mtb_sesion_asistentes->add_field( array(
            'id'         => ODA_PREFIX . 'sesion_nro_tramite',
            'name' => esc_html__( '¿Quién preside la sesión?', 'oda' ),
            'type' => 'select',
            'options' => $array_miembros
        ) );


        /* Se muestra la lista de miembros */

        $mtb_sesion_asistentes->add_field( array(
            'name' => esc_html__( 'Listado de Asistentes', 'cmb2' ),
            'desc' => esc_html__( 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti dolorem sequi consectetur, perferendis neque, hic ullam veniam impedit vero aliquam corrupti labore perspiciatis molestias consequatur sit inventore? Error, consequuntur nesciunt.', 'cmb2' ),
            'id'   => 'oda_sesion_member__asistant_list',
            'type' => 'text',
            'render_row_cb' => 'oda_show_sesion_members_list',
        ) );
    }else{
        $mtb_sesion_asistentes->add_field( array(
            'id'   => ODA_PREFIX . 'sesion_fases_title',
            'name' => esc_html__( 'Aviso Importante', 'oda' ),
            'desc' => __( 'La sesión aun no tiene asignada la ciudad, por favor asigne una.', 'oda' ),
            'type' => 'title'
        ) );

    }

    /**
     * Puntos a tratar MTB
     */
    /**
	 * Repeatable Field Groups
	 */
	$cmb_pat = new_cmb2_box( array(
		'id'           => 'oda_sesion_pats',
		'title'        => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( '3. Puntos a tratar de esta sesión', 'cmb2' ),
        'object_types' => array( 'sesion' ),
        'context'    => 'normal',
        'priority'   => 'low',
	) );

	// $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
	$group_field_pat = $cmb_pat->add_field( array(
		'id'          => 'oda_sesion_pats_group',
		'type'        => 'group',
		'description' => esc_html__( 'Se establecen los Puntos a Tratar de esta sesión', 'cmb2' ),
		'options'     => array(
			'group_title'    => esc_html__( '&nbsp;&nbsp;&nbsp;&nbsp;Punto a tratar {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'     => esc_html__( 'Agregar', 'cmb2' ),
			'remove_button'  => esc_html__( 'Eliminar', 'cmb2' ),
			'sortable'       => false,
			'closed'      => false, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_pat->add_group_field( $group_field_pat, array(
		'name'       => esc_html__( 'Denominación', 'cmb2' ),
		'id'         => 'pat_title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );






    /*

    $mtb_sesion_mociones = new_cmb2_box( array(
        'id'            => 'oda_sesion_mociones_metabox',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( '3. Puntos a tratar', 'oda' ),
        'object_types'  => array( 'sesion' ),
        'context'    => 'normal',
        'priority'   => 'high',
        //'closed'     => true,
        'show_names' => true
    ) );
    $group_sesion_mocion = $mtb_sesion_mociones->add_field( array(
        'id'          => 'oda_group_mocion_conf',
        'type'        => 'group',            
        'options'     => array(
            'group_title'    => '&nbsp;&nbsp;&nbsp;' . esc_html__( 'Punto a tratar {#}', 'cmb2' ), // {#} gets replaced by row number
            'add_button'     => esc_html__( 'Agregar nuevo', 'cmb2' ),
            'remove_button'  => esc_html__( 'Remover', 'cmb2' ),
            'sortable'       => false,
            // 'closed'      => true, // true to have the groups closed by default
            // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
        ),
    ) );
    $mtb_sesion_mociones->add_group_field( $group_sesion_mocion, array(
        'name'       => esc_html__( 'Título', 'cmb2' ),
        'id'         => ODA_PREFIX . 'sesion_pat_nombre',
        'type'       => 'text',
    ) );
    $mtb_sesion_mociones->add_group_field( $group_sesion_mocion, array(
        'name' => esc_html__( '¿Hay mociones?', 'cmb2' ),
        'desc' => esc_html__( 'Marque para habilitar las mociones y sus procesos de votación', 'cmb2' ),
        'id'   => ODA_PREFIX . 'sesion_pat_semociona',
        'type' => 'checkbox',
    ) );
    */



        /*




        $mtb_sesion_mociones->add_group_field( $group_sesion_mocion, array(
            'id'         => ODA_PREFIX . 'sesion_pat_tipo',
            'name' => esc_html__( 'Tipo', 'oda' ),
            'type' => 'select',
            'options' => array(
                '1' => 'Otro',
                '2' => 'Ordenanza',
                '3' => 'Resolución'
            ),
            'attributes' => array(                
                'data-conditional-id'    => ODA_PREFIX . 'sesion_pat_semociona',
                //'data-conditional-value' => 'continuacion',
            ),
        ) );
        $mtb_sesion_mociones->add_group_field( $group_sesion_mocion, array(
            'id'         => ODA_PREFIX . 'sesion_mocion_nombre',
            'name' => esc_html__( 'Nombre de la Moción', 'oda' ),
            'type' => 'text',
            'attributes' => array(                
                'data-conditional-id'    => ODA_PREFIX . 'sesion_pat_semociona',
                //'data-conditional-value' => 'continuacion',
            ),
        ) );

        /* Obtener los tipos de votacion padre */
        /*
        $args = array( 
            'taxonomy' => 'tipo_votacion', 
            'parent' => 0,
            'hide_empty' => false,
            'orderby' => 'term_id',
            'order' => 'ASC',
        );
        $tipo_votacion_padre = get_terms( $args );
        foreach ($tipo_votacion_padre as $votacion_padre) :
        $votacion_padre_lista[$votacion_padre->term_id] = $votacion_padre->name;
        endforeach;
        $mtb_sesion_mociones->add_group_field( $group_sesion_mocion, array(
            'id'         => ODA_PREFIX . 'sesion_votacion_tipo',
            'name' => esc_html__( 'Categoria de Votación', 'oda' ),
            'type' => 'select',
            'show_option_none' => true,
            'options' => $votacion_padre_lista,
            'attributes' => array(                
                'data-conditional-id'    => ODA_PREFIX . 'sesion_pat_semociona',
                //'data-conditional-value' => 'continuacion',
            ),
        ) );
        foreach ($tipo_votacion_padre as $votacion_padre) {
            $args = array( 
                'taxonomy' => 'tipo_votacion', 
                'parent' => $votacion_padre->term_id,
                'hide_empty' => false,
                'orderby' => 'term_id',
                'order' => 'ASC',
            );
            $tipo_votacion_hijos = get_terms( $args );
            //var_dump($tipo_votacion_hijos);
            foreach ($tipo_votacion_hijos as $votacion_hijo) :
            $votacion_hijos_lista[$votacion_hijo->term_id] = $votacion_hijo->name;
            endforeach;

            $mtb_sesion_mociones->add_group_field( $group_sesion_mocion, array(
                'id'         => ODA_PREFIX . 'sesion_mocion_subtipo_' . $votacion_padre->term_id,
                'name' => esc_html__( 'Tipo de Votación', 'oda' ),
                'type' => 'select',
                'options' => $votacion_hijos_lista,
                'attributes' => array(                
                    'data-conditional-id'    => ODA_PREFIX . 'sesion_votacion_tipo',
                    'data-conditional-value' => $votacion_padre->term_id,
                ),
            ) );
        }
        $mtb_sesion_mociones->add_group_field( $group_sesion_mocion, array(
            'name' => esc_html__( 'Proceso de Votación', 'cmb2' ),
            'desc' => esc_html__( 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti dolorem sequi consectetur, perferendis neque, hic ullam veniam impedit vero aliquam corrupti labore perspiciatis molestias consequatur sit inventore? Error, consequuntur nesciunt.', 'cmb2' ),
            'id'   => 'oda_sesion_proceso_votacion',
            'type' => 'text',
            'render_row_cb' => 'oda_show_proceso_votacion',
            'mb_callback_args' => array(
                'grupo_callback' => $group_sesion_mocion->object_id,
            ),
            'attributes' => array(                
                'data-conditional-id'    => ODA_PREFIX . 'sesion_pat_semociona',
                //'data-conditional-value' => 'continuacion',
            ),
        ) );

        */
}
function oda_show_sesion_members_list( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
    $description = $field->args( 'description' );

    /* sesionES: OBTENER CIUDAD ASOCIADA A CPT */
    $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);

    /* DATA ORDENANZA: Miembros [ PRE GET POSTS ] */
    $query_miembros = new WP_Query(array(
        'post_type' => 'miembro',
        'order' => 'ASC',
        'order_by' => 'meta_value_num',
        'meta_key' => 'oda_miembro_curul',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '='
            )
        )
    ));

	?>
    <div class="custom-field-row <?php echo esc_attr( $classes ); ?>">
        <style scoped>
            .oda_row{ 
                width:100%; 
                border-bottom: 1px solid lightgray;
                display: flex;
                align-items: center;
                padding: 5px 0;
            }            
            .oda_col1 { width: 20%;}
            .col-same { width: 15%; text-align: right;}
            .col-same label { display: block; text-align: right;}
            .disabled { color: #a0a5aa; opacity: .7; }
        </style>
		<label for="<?php echo esc_attr( $id ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label>
		<p class="description"><strong>Instrucciones: </strong><?php echo esc_html( $description ); ?></p>
        <!--
		<p><input id="<?php echo esc_attr( $id ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>"/></p>
        -->
    <?php
        if($query_miembros->have_posts()){
    ?>
    <div class="oda_row">
        <div class="oda_col oda_col1"></div>
        <div class="oda_col col-same oda_col2">
            ¿Se ausenta? <!--<input title="Marcar Todos" class="asiste_miembro_all" type="checkbox">-->
        </div>
        <div class="oda_col col-same oda_col3">
            ¿Se excusa? <!--<input title="Marcar Todos" class="excusa_miembro_all" type="checkbox">-->
        </div>
        <div class="oda_col oda_col4"></div>
    </div>
    <?php
            while ($query_miembros->have_posts() ){
                $query_miembros->the_post();
                $miembros_suplentes = get_post_meta(get_the_ID(), 'oda_miembro_miembros_suplentes', true);
    ?>
    <div class="oda_row">
        <div class="oda_col oda_col1">
            <strong><?php echo get_the_title(); ?></strong>
        </div>
        <div class="oda_col col-same oda_col2 text-center">
            <label for="asiste-<?php echo get_the_ID(); ?>"><input class="asiste_miembro" type="checkbox"></label>
        </div>
        <div class="oda_col col-same oda_col3 text-center">
            <?php if ( $miembros_suplentes ){ ?>
                <label for="excusa-<?php echo get_the_ID(); ?>"><input class="excusa_miembro" type="checkbox" data-option="suplente-<?php echo get_the_ID(); ?>"></label>
            <?php } ?>
        </div>
        <?php if ( $miembros_suplentes ){ ?>
        <div class="oda_col oda_col3">
            <?php
                    if (count($miembros_suplentes) == 1){
                        $suplente = get_post($miembros_suplentes[0]);
            ?>
            <span id="suplente-<?php echo get_the_ID(); ?>" class="disabled"><strong><?php echo $suplente->post_title; ?></strong></span>
            <input type="hidden" name="suplente-<?php echo get_the_ID(); ?>" value="<?php echo $miembros_suplentes; ?>">
            <?php }else{ ?>
            <select id="suplente-<?php echo get_the_ID(); ?>" name="suplente-<?php echo get_the_ID(); ?>" disabled>
                <option value="">Seleccione un suplente</option>
                <?php 
                    foreach($miembros_suplentes as $suplente){ 
                        $suplente = get_post($suplente);
                ?>
                <option value="<?php echo $suplente->ID; ?>"><?php echo $suplente->post_title; ?></option>
                <?php } // END foreach ?>
            </select>
            <?php } ?>    
        </div>
        <?php } ?>
    </div>
    
    <?php
            } // END While
        } // END if
    ?>
	</div><!-- END custom-field-row -->
    <?php
    $query_miembros->wp_reset_query();
}

function oda_show_proceso_votacion( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
    $description = $field->args( 'description' );    

    /* sesionES: OBTENER CIUDAD ASOCIADA A CPT */
    $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);

    /* DATA ORDENANZA: Miembros [ PRE GET POSTS ] */
    $query_miembros = new WP_Query(array(
        'post_type' => 'miembro',
        'order' => 'ASC',
        'order_by' => 'meta_value_num',
        'meta_key' => 'oda_miembro_curul',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '='
            )
        )
    ));

	?>
    <div class="cmb-row custom-field-row <?php echo esc_attr( $classes ); ?>" data-conditional-id="<?php echo $field->args('attributes')['data-conditional-id'] ?>">
        <style scoped>
            .oda_row{ 
                width:100%; 
                border-bottom: 1px solid lightgray;
                display: flex;
                align-items: center;
                padding: 5px 0;
            }            
            .oda_col1 { width: 25%;}
            .disabled { color: #a0a5aa; opacity: .7; }
        </style>
		<label for="<?php echo esc_attr( $id ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label>
		<p class="description"><strong>Instrucciones: </strong><?php echo esc_html( $description ); ?></p>
        <!--
		<p><input id="<?php echo esc_attr( $id ); ?>" type="text" name="<?php echo esc_attr( $name ); ?>" value="<?php echo $value; ?>"/></p>
        -->
    <?php
        if($query_miembros->have_posts()){
            while ($query_miembros->have_posts() ){
                $query_miembros->the_post();
                $miembros_suplentes = get_post_meta(get_the_ID(), 'oda_miembro_miembros_suplentes', true);
    ?>
    <div class="oda_row">
        <div class="oda_col oda_col1">
            <strong><?php echo get_the_title(); ?></strong>
        </div>
        <?php if ( $miembros_suplentes ){ ?>
        <div class="oda_col oda_col2">
            <label for="excusa-<?php echo get_the_ID(); ?>">¿Excusa? <input class="excusa_miembro" type="checkbox" data-option="suplente-<?php echo get_the_ID(); ?>"></label>
        </div>
        <div class="oda_col oda_col3">
            <?php
                    if (count($miembros_suplentes) == 1){
                        $suplente = get_post($miembros_suplentes[0]);
            ?>
            <span id="suplente-<?php echo get_the_ID(); ?>" class="disabled"><strong><?php echo $suplente->post_title; ?></strong></span>
            <input type="hidden" name="suplente-<?php echo get_the_ID(); ?>" value="<?php echo $miembros_suplentes; ?>">
            <?php }else{ ?>
            <select id="suplente-<?php echo get_the_ID(); ?>" name="suplente-<?php echo get_the_ID(); ?>" disabled>
                <option value="">Seleccione un suplente</option>
                <?php 
                    foreach($miembros_suplentes as $suplente){ 
                        $suplente = get_post($suplente);
                ?>
                <option value="<?php echo $suplente->ID; ?>"><?php echo $suplente->post_title; ?></option>
                <?php } // END foreach ?>
            </select>
            <?php } ?>    
        </div>
        <?php } ?>
        <div class="oda_col oda_col4">
            <ul class="d-flex" style="display: flex; justify-content:space-between;">
                <li><label>Si <input type="radio" name="voto" value="si"></label></li>
                <li><label>No <input type="radio" name="voto" value="no"></label></li>
                <li><label>Abstencion <input type="radio" name="voto" value="abs"></label></li>
                <li><label>Blanco <input type="radio" name="voto" value="nulo"></label></li>
            </ul>
        </div>
    </div>
    
    <?php
            } // END While
        } // END if
    ?>
	</div><!-- END custom-field-row -->
    <?php
    $query_miembros->wp_reset_query();
}

add_action('admin_menu', 'oda_remove_boxes_sesion', 20);
function oda_remove_boxes_sesion() {
    remove_meta_box('tagsdiv-tipo_sesion', 'sesion', 'side');
    remove_meta_box('tipo_votaciondiv', 'sesion', 'side');
}