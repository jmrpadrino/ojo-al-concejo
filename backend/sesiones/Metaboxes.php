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

add_action('admin_menu', 'oda_remove_boxes_sesion', 20);
function oda_remove_boxes_sesion() {
    remove_meta_box('tagsdiv-tipo_sesion', 'sesion', 'side');
    remove_meta_box('tipo_votaciondiv', 'sesion', 'side');
}

/**
 * Pasa pasar la asistencia
 */

function oda_sesion_add_asistencia(){
    $current_sesion = $_GET['post'];
    // Obtener listado de asistencias en Asistencia
    $asistencia = new WP_Query(
        array(
            'post_type' => 'asistencia',
            'posts_per_page' => -1,
            'meta_key' => 'oda_parent_sesion',
            'meta_query' => array(
                array(
                    'key' => 'oda_parent_sesion',
                    'value' => $current_sesion,
                    'compare' => '='
                )
            )
        )
    );
    ?>
    <div class="cmb-row" style="margin-top: 10px;">
        <div class="cmb-th">
            <label for="oda_sesion_preside">Anotar asistencia principal</label>
        </div>
        <div class="cmb-td">
            <?php if (count($asistencia->posts) > 0){ ?>
                <a href="<?php echo admin_url('post.php?post='. $asistencia->posts[0]->ID .'&action=edit&parent_sesion=') . $current_sesion; ?>" class="button">Ver</a>    
            <?php }else{ ?>
            <a href="<?php echo admin_url('post-new.php?post_type=asistencia&parent_sesion=') . $current_sesion; ?>" class="button">Empezar</a>
            <?php } ?>
        </div>
    </div>
    <?php
}

/**
 * Para el proceso de votación
 */

function oda_sesion_proceso_mocion(  $field_args, $field ){ 
    $classes     = $field->row_classes();
    $current_sesion = $_GET['post'];
    // Obtener listado de asistencias en Asistencia
    $asistencia = new WP_Query(
        array(
            'post_type' => 'asistencia',
            'posts_per_page' => -1,
            'meta_key' => 'oda_parent_sesion',
            'meta_query' => array(
                array(
                    'key' => 'oda_parent_sesion',
                    'value' => $current_sesion,
                    'compare' => '='
                )
            )
        )
    );
    ?>
    <div class="cmb-row <?php echo esc_attr( $classes ); ?>" style="margin-top: 10px;">
        <div class="cmb-th">
            <label for="oda_sesion_preside">Proceso de Votación</label>
        </div>
        <div class="cmb-td">
            <?php if (count($mociones->posts) > 0){ ?>
                <a href="<?php echo admin_url('post.php?post='. $asistencia->posts[0]->ID .'&action=edit&parent_sesion=') . $current_sesion; ?>" class="button">Ver</a>    
            <?php }else{ ?>
            <a href="<?php echo admin_url('post-new.php?post_type=asistencia&parent_sesion=') . $current_sesion; ?>" class="button">Empezar</a>
            <?php } ?>
        </div>
    </div>
    <?php
}
/* --------------------------------------------------------------
    sesionES: MAIN CMB2 CALLBACK
-------------------------------------------------------------- */
add_action( 'cmb2_admin_init', 'oda_sesion_metabox' );

/* sesionES: MAIN METABOX CALLBACK HANDLER */
function oda_sesion_metabox() {
    
    $city = null;
    $disabled = true;
    $current_sesion = null;
    if (isset($_GET['post'])){
        $city = get_post_meta($_GET['post'], ODA_PREFIX . 'ciudad_owner', true);
        $disabled = false;
        $current_sesion = $_GET['post'];
        // echo '<pre>';
        // var_dump(get_post_meta($_GET['post']));
        // echo '</pre>';
    }
    if (isset($_POST['post_ID'])){
        $city = get_post_meta($_POST['post_ID'], ODA_PREFIX . 'ciudad_owner', true);
        $disabled = false;        
        $current_sesion = $_POST['post_ID'];
    }

    /**
     * PASO 1
     * Metabox configuracion
     */

    $mtb_sesion_rel = new_cmb2_box( array(
        'id'            => 'oda_sesion_relaciones',
        'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( '1. Configuración de la sesión', 'oda' ),
        'object_types'  => array( 'sesion' ),
        'context'    => 'side',
        'priority'   => 'high',
        'show_names' => true
    ) );
    $ciudades = get_object_ciudades();
    $alcaldias_array = array();
    if ($ciudades->have_posts()){
        while($ciudades->have_posts()){
            $ciudades->the_post();
            $alcaldias_array[get_the_ID()] = get_the_title();
        }
    }
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
    /* DATA RESOLUCIÓN: Fecha */
    $mtb_sesion_rel->add_field( array(
        'id'         => ODA_PREFIX . 'sesion_fecha',
        'name' => esc_html__( 'Fecha', 'oda' ),
        'type' => 'text_date',
        'attributes' => array(
            'disabled' => $disabled,
        ),
    ) );
    $mtb_sesion_rel->add_field( array(
		'id'         => ODA_PREFIX . 'sesion_tipo',
		'name' => esc_html__( 'Tipo de sesión', 'oda' ),
		'type'     => 'taxonomy_select', // Or `taxonomy_select_hierarchical`
        'taxonomy' => 'tipo_sesion', // Taxonomy Slug
        'attributes' => array(
            'disabled' => $disabled,
        ),
    ) );

    $sesiones_ciudad = array();
    $sesiones_alcaldia = get_sesion_object($city, $current_sesion);
    while ( $sesiones_alcaldia->have_posts() ) : $sesiones_alcaldia->the_post();
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
            'disabled' => $disabled,
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
        ),
        'attributes' => array(
            'disabled' => $disabled,
        ),
    ) );

    /**
     * PASO 2
     * Metabox Asistencia principal a la sesion
     */
    if (null != $city){
        $mtb_sesion_asistentes = new_cmb2_box( array(
            'id'            => 'oda_sesion_data_metabox_0',
            'title'         => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( '2. Participantes ', 'oda' ),
            'object_types'  => array( 'sesion' ),
            'context'    => 'normal',
            'priority'   => 'high',
            'closed'     => false,
            'show_names' => true
        ) );
        $asistentes = get_miembros($city);
        while ( $asistentes->have_posts() ) : $asistentes->the_post();
        $asistentes_ciudad[get_the_ID()] = get_the_title();
        endwhile;
        $asistentes->wp_reset_query();
        $mtb_sesion_asistentes->add_field( array(
            'id'         => ODA_PREFIX . 'sesion_preside',
            'name' => esc_html__( '¿Quién preside la sesión?', 'oda' ),
            'type' => 'select',
            'options' => $asistentes_ciudad
        ) );
        $mtb_sesion_asistentes->add_field( array(
            'name' => esc_html__( 'Anotar aistencia principal', 'cmb2' ),
            'id'   => ODA_PREFIX . 'sesion_member_asistant_list',
            'type' => 'text',
            'render_row_cb' => 'oda_sesion_add_asistencia',
        ) );
    }

    /**
     * PASO 3
     * Metabox Agregar puntos a tratar
     */
    if (null != $city){
        $mtb_sesion_puntos = new_cmb2_box( array(
            'id'           => 'oda_sesion_data_metabox_1',
            'title'        => '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . esc_html__( '3. Puntos a tratar de esta sesión', 'cmb2' ),
            'object_types' => array( 'sesion' ),
            'context'    => 'normal',
            'priority'   => 'high',
        ) );

        // $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
        $group_field_pat = $mtb_sesion_puntos->add_field( array(
            'id'          => 'oda_sesion_pats_group',
            'type'        => 'group',
            'description' => esc_html__( 'Se establecen los Puntos a Tratar de esta sesión', 'cmb2' ),
            'options'     => array(
                'group_title'    => esc_html__( '&nbsp;&nbsp;&nbsp;&nbsp;Punto a tratar {#}', 'cmb2' ), // {#} gets replaced by row number
                'add_button'     => esc_html__( 'Agregar', 'cmb2' ),
                'remove_button'  => esc_html__( 'Eliminar', 'cmb2' ),
                'sortable'       => false,
                //'closed'      => true, // true to have the groups closed by default
                // 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
            ),
        ) );
        $mtb_sesion_puntos->add_group_field( $group_field_pat, array(
            'name'       => esc_html__( 'Titulo', 'cmb2' ),
            'id'         => 'sesion_pat_title',
            'type'       => 'text',
            // 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
        ) );
        $mtb_sesion_puntos->add_group_field( $group_field_pat, array(
            'name' => esc_html__( '¿Hay mociones?', 'cmb2' ),
            'desc' => esc_html__( 'Marque para habilitar las mociones y sus procesos de votación', 'cmb2' ),
            'id'   => 'sesion_pat_semociona',
            'type' => 'checkbox',
            'classes' => 'mocion-parent'
        ) );
        $mtb_sesion_puntos->add_group_field( $group_field_pat, array(
            'name' => esc_html__( 'Aplicar votación a moción', 'cmb2' ),
            'id'   => ODA_PREFIX . 'mocion_votacion',
            'type' => 'text',
            'render_row_cb' => 'oda_sesion_proceso_mocion',
            'classes' => 'mocion-child mocion-hidden'
        ) );
    }
    
}

add_action('admin_head', 'oda_scripts_sesion');
function oda_scripts_sesion(){
    if ('sesion' === get_post_type()){
?>
<style>    
    .mocion-hidden { display: none; }
</style>
<script>
    $(document).ready(function(){
        $('.cmb2-option').change(function(e){
            if($(this).is(':checked')){
                $.each($(this).parents('.mocion-parent').siblings('.mocion-child'), function(){
                    $(this).removeClass('mocion-hidden');
                })
                console.log('encender', $(this).parents('.mocion-parent').siblings('.mocion-child'))
            }else{
                $.each($(this).parents('.mocion-parent').siblings('.mocion-child'), function(){
                    $(this).addClass('mocion-hidden');
                })
                console.log('apagar', $(this).parents('.mocion-parent').siblings('.mocion-child'))
            }
        })
    })
    function oda_refresh_mocion_links(){

    }
</script>   
<?php
    } // END IF
}