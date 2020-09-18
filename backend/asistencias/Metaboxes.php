<?php
/**
 * Metabox for asistencias
*/
function asistencia_register_meta_boxes() {
    $show_metabox = false;
    if(
        isset($_GET['parent_sesion']) ||
        isset($_POST['oda_parent_sesion'])
    ){
        $city = get_post_meta($_GET['parent_sesion'], 'oda_ciudad_owner', true);
        $show_metabox = true;
    }else{
        $city = get_post_meta($_POST['parent_sesion'], 'oda_ciudad_owner', true);
        $show_metabox = true;
    }

    if ($show_metabox){
        add_meta_box( 
            'listado_asistencias_mtb', 
            '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . 'Listado de asistencia', 
            'oda_mostrar_listado_asistencia', 
            'asistencia', 
            'normal', 
            'high',
            array(
                'parent_sesion' => $_GET['parent_sesion'],
                'city' => $city,
            )
        );
    }
}
add_action( 'add_meta_boxes', 'asistencia_register_meta_boxes' );

function oda_mostrar_listado_asistencia($post, $args){    
    $query_miembros = get_miembros($args['args']['city']);
    $asistencias = get_post_meta($_GET['post'], 'oda_sesion_asistencia', true); 
	?>
    <div class="custom-field-row <?php echo esc_attr( $classes ); ?>">
    <input type="hidden" name="oda_parent_sesion" value="<?php echo $args['args']['parent_sesion']; ?>">
        <style scoped>
            .oda_row{ 
                width:100%; 
                border-bottom: 1px solid lightgray;
                display: flex;

                align-items: flex-start;
                padding: 5px 0;
            }            
            .oda_col1 { width: 20%;}
            .col-same { width: 15%; text-align: right;}
            .col-same label { display: block; text-align: right;}
            .disabled { color: #a0a5aa; opacity: .7; }
            .preview-suplentes { 
                font-size: 10px; 
                line-height: 1;
                color: gray;
            }
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
            $i = 0;
            while ($query_miembros->have_posts() ){
                $query_miembros->the_post();
                $miembros_suplentes = get_post_meta(get_the_ID(), 'oda_miembro_miembros_suplentes', true);
    ?>
    <input type="hidden" name="oda_sesion_asistencia[<?php echo get_the_ID(); ?>][member_id]" value="<?php echo get_the_ID(); ?>">
    <div class="oda_row">
        <div class="oda_col oda_col1">
            <strong><?php echo get_the_title(); ?></strong>
            <?php if ( $miembros_suplentes ){ ?>
            <ul class="preview-suplentes">
                <?php
                    foreach($miembros_suplentes as $suplente){ 
                        $suplente = get_post($suplente);
                ?>
                <li><?php echo $suplente->post_title; ?></li>
                <?php } ?>
            </ul>
            <?php } ?>
        </div>
        <div class="oda_col col-same oda_col2 text-center">
            <?php
                $checked_ausente = '';
                if (array_key_exists('member_ausente', $asistencias[get_the_ID()])){
                    $checked_ausente = 'checked';
                }
            ?>
            <label for="asiste-<?php echo get_the_ID(); ?>"><input name="oda_sesion_asistencia[<?php echo get_the_ID(); ?>][member_ausente]" class="asiste_miembro" type="checkbox" <?php echo $checked_ausente; ?>></label>
        </div>
        <div class="oda_col col-same oda_col3 text-center">
            <?php 
                if ( $miembros_suplentes ){ 
                    $checked_excusa = '';
                    if (array_key_exists('member_excusa', $asistencias[get_the_ID()])){
                        $checked_excusa = 'checked';
                    }
            ?>
                <label for="excusa-<?php echo get_the_ID(); ?>"><input name="oda_sesion_asistencia[<?php echo get_the_ID(); ?>][member_excusa]" class="excusa_miembro" type="checkbox" data-option="suplente-<?php echo get_the_ID(); ?>" <?php echo $checked_excusa; ?>></label>
            <?php } ?>
        </div>
        <?php if ( $miembros_suplentes ){ ?>
        <div class="oda_col oda_col3">
            <?php
                    if (count($miembros_suplentes) == 1){
                        $suplente = get_post($miembros_suplentes[0]);
            ?>
            <span id="suplente-<?php echo get_the_ID(); ?>" class="disabled"><strong><?php echo $suplente->post_title; ?></strong></span>
            <input type="hidden" name="oda_sesion_asistencia[<?php echo get_the_ID(); ?>][member_suplente]" value="<?php echo $suplente->ID; ?>">
            <?php }else{ ?>
            <select id="suplente-<?php echo get_the_ID(); ?>" name="oda_sesion_asistencia[<?php echo get_the_ID(); ?>][member_suplente]" disabled>
                <option value="">Seleccione un suplente</option>
                <?php 
                    foreach($miembros_suplentes as $suplente){ 
                        $suplente = get_post($suplente);
                        $selected = '';
                        $suplente_seleccionado = '';
                        if (array_key_exists('member_suplente', $asistencias[get_the_ID()])){
                            $suplente_seleccionado = $asistencias[get_the_ID()]['member_suplente'];
                            if($suplente_seleccionado == $suplente->ID){
                                $selected = 'selected';
                            }
                        }
                ?>
                <option value="<?php echo $suplente->ID; ?>" <?php echo $selected; ?>><?php echo $suplente->post_title; ?></option>
                <?php } // END foreach ?>
            </select>
            <?php } ?>    
        </div>
        <?php } ?>
    </div>
    <?php
           $i++; } // END While
        } // END if
        $query_miembros->wp_reset_query();
    ?>
    <div class="oda_row">
        <div id="publishing-action" style="width: 100%;">
            <span class="spinner"></span>
            <input name="original_publish" type="hidden" id="original_publish" value="Publicar">
            <input type="submit" name="publish_and_back" id="publish" class="button button-primary button-large" value="Guardar y volver">
        </div>
    </div>
	</div><!-- END custom-field-row -->
    <?php
}

function oda_save_asistencia_meta( $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( $parent_id = wp_is_post_revision( $post_id ) ) {
        $post_id = $parent_id;
    }
    $fields = [
        'oda_parent_sesion',
        'oda_sesion_asistencia',
        'asistencia_ausentes',
        'asistencia_excusas'
    ];
    foreach ( $fields as $field ) {
        if ( array_key_exists( $field, $_POST ) ) {
            update_post_meta( $post_id, $field, $_POST[$field] );
        }
    }
    if ('asistencia' == get_post_type()){
        if(isset($_POST['oda_parent_sesion'])){
            header('Location:' . admin_url('post.php?post='. $_POST['oda_parent_sesion'] .'&action=edit&asistencia=true'));
            exit();
        }
    }
} // END oda_save_asistencia_meta
add_action( 'save_post', 'oda_save_asistencia_meta' );

function asistencia_show_resumen(){
    if ('asistencia' === get_post_type()){
    $sesion = get_post($_GET['parent_sesion']);
    // echo '<pre>';
    // var_dump(get_post_meta($_GET['post']));
    // echo '</pre>';
?>
<h3>Asistencia para la sesión: <?php echo $sesion->post_title; ?></h3>
<style scope>
    .asistencia_resumem_value { border: 0; background: transparent; }
</style>
<ul>
    <li><strong>Total Miembros:</strong> <span id="total_miembros">0</span></li>
    <li><strong>Total Ausentes:</strong> <input class="asistencia_resumem_value" name="asistencia_ausentes" id="total_ausentes" value="0" readonly></li>
    <li><strong>Total Excusas:</strong> <input class="asistencia_resumem_value" name="asistencia_excusas" id="total_excusas" value="0" readonly></li>
</ul>
<script>
    $(document).ready(function(){
        var total = ausentes = excusas = 0;
        total = $('.asiste_miembro').length;
        $.each($('.asiste_miembro'), function(){
            if ($(this).is(':checked')){
                ausentes++;
            }
        })
        $.each($('.excusa_miembro'), function(){
            if ($(this).is(':checked')){
                excusas++;
            }
        })

        $('#total_miembros').text(total);
        $('#total_ausentes').val(ausentes);
        $('#total_excusas').val(excusas);
    })
</script>
<?php
    } // END
} // END asistencia_show_resumen
add_action('edit_form_after_editor', 'asistencia_show_resumen');