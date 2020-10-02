<?php

/**
 * Metabox for asistencias
 */
function mocion_register_meta_boxes()
{
    $show_metabox = false;
    if (
        isset($_GET['parent_sesion']) ||
        isset($_POST['oda_parent_sesion'])
    ) {
        $city = get_post_meta($_GET['parent_sesion'], 'oda_ciudad_owner', true);
        $show_metabox = true;
    } else {
        $city = get_post_meta($_POST['oda_parent_sesion'], 'oda_ciudad_owner', true);
        $show_metabox = true;
    }
    if ($show_metabox) {
        add_meta_box(
            'listado_mocion_mtb_0',
            '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . 'Configuración',
            'oda_mostrar_configuracion_mocion',
            'mocion',
            'side',
            'low'
        );

        add_meta_box(
            'listado_mocion_mtb_1',
            '<img src="' . ODA_DIR_URL . 'images/FCD-menu-icon.png"> ' . 'Listado de Votación en Moción',
            'oda_mostrar_listado_mocion',
            'mocion',
            'normal',
            'high',
            array(
                'parent_sesion' => $_GET['parent_sesion'],
                'city' => $city,
                'item' => $_GET['item'],
                'position' => $_GET['position'],
            )
        );
    }
}
add_action('add_meta_boxes', 'mocion_register_meta_boxes');

function oda_mostrar_listado_mocion($post, $args)
{
    $query_miembros = get_miembros($args['args']['city']);
    $votos = get_post_meta($_GET['post'], 'oda_sesion_mocion', true);
?>
    <script>
        $(document).ready(function(){
            $('#title').attr('required', true);
        })
    </script>
    <div class="custom-field-row">
        <input type="hidden" name="oda_parent_sesion" value="<?php echo $args['args']['parent_sesion']; ?>">
        <input type="hidden" name="oda_sesion_item" value="<?php echo $args['args']['item']; ?>">
        <input type="hidden" name="oda_mocion_nombre" value="<?php echo $args['args']['item']; ?>">
        <!--
    <input type="hidden" name="oda_mocion_position" value="<?php echo $args['args']['position']; ?>">
    -->
        <input type="hidden" name="oda_mocion_ausentes" value="0">
        <input type="hidden" name="oda_mocion_excusas" value="0">
        <input type="hidden" name="oda_mocion_voto_1" value="0">
        <input type="hidden" name="oda_mocion_voto_2" value="0">
        <input type="hidden" name="oda_mocion_voto_3" value="0">
        <input type="hidden" name="oda_mocion_voto_4" value="0">
        <style scoped>
            .oda_row {
                width: 100%;
                border-bottom: 1px solid lightgray;
                display: flex;

                align-items: flex-start;
                padding: 5px 0;
            }

            .oda_col1 {
                width: 20%;
            }

            .oda_col4 {
                min-width: 25%;
            }

            .oda_col5 {
                min-width: 25%;
            }

            .oda_col5 ul {
                margin: 0;
                display: flex;
                justify-content: space-around;
                align-items: flex-start;
            }

            .col-same {
                width: 15%;
                text-align: right;
            }

            .col-same label {
                display: block;
                text-align: right;
            }

            .disabled {
                color: #a0a5aa;
                opacity: .7;
            }

            .preview-suplentes {
                font-size: 10px;
                line-height: 1;
                color: gray;
            }
        </style>
        <label for="<?php echo esc_attr($id); ?>"><strong><?php echo esc_html($label); ?></strong></label>
        <p class="description"><strong>Instrucciones: </strong><?php echo esc_html($description); ?></p>
        <!--
		<p><input id="<?php echo esc_attr($id); ?>" type="text" name="<?php echo esc_attr($name); ?>" value="<?php echo $value; ?>"/></p>
        -->
        <?php
        if ($query_miembros->have_posts()) {
        ?>
            <div class="oda_row">
                <div class="oda_col oda_col1"></div>
                <div class="oda_col col-same oda_col2">
                    ¿Se ausenta?
                    <!--<input title="Marcar Todos" class="asiste_miembro_all" type="checkbox">-->
                </div>
                <div class="oda_col col-same oda_col3">
                    ¿Se excusa?
                    <!--<input title="Marcar Todos" class="excusa_miembro_all" type="checkbox">-->
                </div>
                <div class="oda_col oda_col4"></div>
                <div class="oda_col oda_col5 oda_col_voto">
                    <ul>
                        <li><strong title="Vota Si">SI</strong></li>
                        <li><strong title="Vota No">NO</strong></li>
                        <li><strong title="Se abstiene">AB</strong></li>
                        <li><strong title="Vota Blanco">BL</strong></li>
                    </ul>
                </div>
            </div>
            <?php
            $i = 0;
            while ($query_miembros->have_posts()) {
                $query_miembros->the_post();
                $miembros_suplentes = get_post_meta(get_the_ID(), 'oda_miembro_miembros_suplentes', true);
            ?>
                <input type="hidden" name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][member_id]" value="<?php echo get_the_ID(); ?>">
                <div class="oda_row member-item">
                    <div class="oda_col oda_col1">
                        <strong><?php echo get_the_title(); ?></strong>
                        <?php if ($miembros_suplentes) { ?>
                            <ul class="preview-suplentes">
                                <?php
                                foreach ($miembros_suplentes as $suplente) {
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
                        if (array_key_exists('member_ausente', $votos[get_the_ID()])) {
                            $checked_ausente = 'checked';
                        }
                        ?>
                        <label for="asiste-<?php echo get_the_ID(); ?>">
                            <input id="asiste-<?php echo get_the_ID(); ?>" data-rowid="<?php echo get_the_ID(); ?>" name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][member_ausente]" class="asiste_miembro" type="checkbox" <?php echo $checked_ausente; ?>>
                        </label>
                    </div>
                    <div class="oda_col col-same oda_col3 text-center">
                        <?php
                        if ($miembros_suplentes) {
                            $checked_excusa = '';
                            if (array_key_exists('member_excusa', $votos[get_the_ID()])) {
                                $checked_excusa = 'checked';
                            }
                        ?>
                            <label for="excusa-<?php echo get_the_ID(); ?>">
                                <input id="excusa-<?php echo get_the_ID(); ?>" data-rowid="<?php echo get_the_ID(); ?>" name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][member_excusa]" class="excusa_miembro" type="checkbox" data-option="suplente-<?php echo get_the_ID(); ?>" <?php echo $checked_excusa; ?>>
                            </label>
                        <?php } ?>
                    </div>
                    <div class="oda_col oda_col4">
                        <?php if ($miembros_suplentes) { ?>
                            <?php
                            if (count($miembros_suplentes) == 1) {
                                $suplente = get_post($miembros_suplentes[0]);
                            ?>
                                <span id="suplente-<?php echo get_the_ID(); ?>" class="disabled"><strong><?php echo $suplente->post_title; ?></strong></span>
                                <input type="hidden" name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][member_suplente]" value="<?php echo $suplente->ID; ?>">
                            <?php } else { ?>
                                <select id="suplente-<?php echo get_the_ID(); ?>" name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][member_suplente]" disabled>
                                    <option value="">Seleccione un suplente</option>
                                    <?php
                                    foreach ($miembros_suplentes as $suplente) {
                                        $suplente = get_post($suplente);
                                        $selected = '';
                                        $suplente_seleccionado = '';
                                        if (array_key_exists('member_suplente', $votos[get_the_ID()])) {
                                            $suplente_seleccionado = $votos[get_the_ID()]['member_suplente'];
                                            if ($suplente_seleccionado == $suplente->ID) {
                                                $selected = 'selected';
                                            }
                                        }
                                    ?>
                                        <option value="<?php echo $suplente->ID; ?>" <?php echo $selected; ?>><?php echo $suplente->post_title; ?></option>
                                    <?php } // END foreach 
                                    ?>
                                </select>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <div class="oda_col oda_col5 oda_col_voto">
                        <?php
                        $voto = '';
                        if (array_key_exists('mocion_voto', $votos[get_the_ID()])) {
                            $voto = $votos[get_the_ID()]['mocion_voto'];
                        }
                        ?>
                        <ul id="row-voto-<?php echo get_the_ID(); ?>">
                            <li>
                                <input class="voto_miembro" type="radio" name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][mocion_voto]" value="1" <?php echo ($voto == 1) ? 'checked' : ''; ?>>
                            </li>
                            <li>
                                <input class="voto_miembro" type="radio" name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][mocion_voto]" value="2" <?php echo ($voto == 2) ? 'checked' : ''; ?>>
                            </li>
                            <li>
                                <input class="voto_miembro" type="radio" name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][mocion_voto]" value="3" <?php echo ($voto == 3) ? 'checked' : ''; ?>>
                            </li>
                            <li>
                                <input class="voto_miembro" type="radio" name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][mocion_voto]" value="4" <?php echo ($voto == 4) ? 'checked' : ''; ?>>
                            </li>
                        </ul>
                    </div>
                </div>
        <?php
                $i++;
            } // END While
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
        <script>
            $(document).ready(function(){                
                $('.asiste_miembro').change(function(){
                    var siblingId = $(this).data('rowid');
                    //console.log($(this).data('rowid'));
                    if($(this).is(':checked')){
                        if($('#excusa-'+ siblingId ).is(':checked')){
                            $('#excusa-'+ siblingId ).click().attr('disabled', true);
                        }else{
                            $('#excusa-'+ siblingId ).attr('disabled', true);
                        }
                        console.log($('#row-voto-'+ siblingId + ' .voto_miembro' )) //.prop('checked', false).attr('disabled', true);
                        $('#row-voto-'+ siblingId + ' .voto_miembro' ).prop('checked', false).attr('disabled', true);
                    }else{
                        $('#excusa-'+ siblingId ).removeAttr('disabled');
                        $('#row-voto-'+ siblingId + ' .voto_miembro' ).removeAttr('disabled');
                    }
                })

            })
        </script>
    </div><!-- END custom-field-row -->
<?php
}

function oda_mostrar_configuracion_mocion()
{

    $city = get_post_meta($_GET['parent_sesion'], 'oda_ciudad_owner', true);

    $args = array(
        'post_type' => 'miembro',
        'posts_per_page' => -1,
        'meta_key' => 'oda_ciudad_owner',
        'orderby' => 'post_id',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '=',
            )
        )
    );
    $miembros = new WP_Query($args);

    $tipos_votaciones = get_terms(
        array(
            'taxonomy' => 'tipo_votacion',
            'hide_empty' => false,
            'parent'   => 0,
            'orderby' => 'id',
            'order' => 'ASC',
        )
    );
    $preside_seleccionado = get_post_meta($_GET['post'], 'mocion_preside', true);
?>
    <input type="hidden" name="oda_ciudad_owner" value="<?php echo $city; ?>">
    <div class="custom-field-row">
        <label><strong>Preside la moción</strong><br/>
            <select id="mocion_preside" name="mocion_preside">
                <option value="">Seleccione un miembro</option>
                <?php while($miembros->have_posts()){ $miembros->the_post(); ?>
                <option value="<?php echo get_the_ID(); ?>" <?php echo ($preside_seleccionado == get_the_ID()) ? 'selected': ''; ?>><?php echo get_the_title(); ?></option>
                <?php } ?>
            </select>
        </label>
        <br />
        <label><strong>Fecha</strong><br/>
            <input type="date" name="mocion_fecha" value="<?php echo get_post_meta($_GET['post'],'mocion_fecha', true); ?>">
        </label>
        <br/>
        <label><strong>Hora</strong><br/>
            <input type="time" name="mocion_hora" value="<?php echo get_post_meta($_GET['post'],'mocion_hora', true); ?>">
        </label>
        <br/>
        <label><strong>Orden/Posicion</strong><br/>
            <input type="number" min="0" name="mocion_orden" value="<?php echo get_post_meta($_GET['post'],'mocion_orden', true); ?>">
        </label>
    </div>
    <hr />
    <div class="custom-field-row">
        <ul>
            <?php foreach ($tipos_votaciones as $tipo) {
                $tipo_seleccionado = ''; ?>
                <li>
                    <label for="tipo_general">
                        <strong><?php echo $tipo->name; ?></strong><br />
                        <?php $tipo_seleccionado = get_post_meta($_GET['post'], 'tipo_votacion_' . $tipo->slug, true); ?>
                        <select id="tipo_<?php echo $tipo->slug; ?>" name="tipo_votacion_<?php echo $tipo->slug; ?>">
                            <option value="">Seleccione</option>
                            <?php
                            $subtipos_votaciones = get_terms(
                                array(
                                    'taxonomy' => 'tipo_votacion',
                                    'hide_empty' => false,
                                    'parent'   => $tipo->term_id,
                                    'orderby' => 'id',
                                    'order' => 'ASC',
                                )
                            );
                            foreach ($subtipos_votaciones as $subtipo) {
                            ?>
                                <option value="<?php echo $subtipo->term_id; ?>" <?php echo ($tipo_seleccionado == $subtipo->term_id) ? 'selected' : ''; ?>><?php echo $subtipo->name; ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </li>
            <?php } // END Foreach 
            ?>
        </ul>
    </div>
    <hr />
    <?php 
        $se_mociona = 0;
        $se_mociona_meta = get_post_meta($_GET['post'], 'se_mociona', true);
        if ($se_mociona_meta == 1){ $se_mociona = 1; }
        if ($se_mociona_meta == 2){ $se_mociona = 2; }
    ?>
    <div class="custom-field-row">
        <p style="font-size: 13px; text-transform: italic; color: gray;">Use este elemento solo si esta moción es para una Ordenanza o una Resolución</p>
        <span for="para_ordenanza"><strong>¿Se mociona documento?</span><br/>
        <label for="no_doc"><input id="no_doc" type="radio" name="se_mociona" value="0" <?php echo (0 == $se_mociona) ? 'checked' : '';?>> No</label><br />
        <label for="si_ord"><input id="si_ord" type="radio" name="se_mociona" value="1" <?php echo (1 == $se_mociona) ? 'checked' : '';?>> Si, Ordenanza</label><br />
        <label for="si_res"><input id="si_res" type="radio" name="se_mociona" value="2" <?php echo (2 == $se_mociona) ? 'checked' : '';?>> Si, Resolución</label><br />
        <br />
    </div>
    <div class="custom-field-row row-documento disabled">
        <label id="label_ordenanza" for="documento">
            <strong>Seleccione Documento</strong>
            <br />
            <select id="documento" name="mocion_documento" title="Seleccione un elemento de la lista de documentos" disabled required>
                <option value="">Seleccione Documento</option>                
            </select>
        </label>
        <br />
        <label id="label_ordenanza" for="fase">
            <strong>Seleccione Fase</strong>
            <br />
            <select id="fase" name="mocion_fase" title="Seleccione un elemento de la lista de fases" disabled required>
                <option value="">Seleccione Fase</option>                
            </select>
        </label>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#mocion_preside').select2();
            $('#tipo_especifica').select2();
            var mocionaDocumento = $('[name="se_mociona"]:checked');
            var mocionDocumentoInput = $('[name="se_mociona"]');
            if( mocionaDocumento.val() > 0 ){
                loadDocumentos(mocionaDocumento.val());
                loadFases(mocionaDocumento.val());
                $('.row-documento').removeClass('disabled');
            };
            mocionDocumentoInput.change(function(){
                if ($(this).val() == 0){
                    $('.row-documento').addClass('disabled');
                    $('#documento').attr('disabled', true);
                    $('#fase').attr('disabled', true);
                    $('#documento').val('').trigger('change');
                    $('#fase').val('').trigger('change');
                }else{
                    $('.row-documento').removeClass('disabled');
                    $('#documento').removeAttr('disabled');
                    $('#fase').removeAttr('disabled');
                    loadDocumentos($(this).val());
                    loadFases($(this).val());
                }
            })
        });
        function loadDocumentos(index){
            var selectvalues = '';
            var html = '';
            if (1 == index){ selectvalues = oda_documentos_object.ordenanzas; }
            if (2 == index){ selectvalues = oda_documentos_object.resoluciones; }
            html += '<option value="">Seleccione documento</option>';
            $.each(selectvalues, function(index, value){
                var selected = '';
                if (oda_documentos_object.documento_id == value.documento_id) { selected = 'selected'; }
                html += '<option value="'+value.documento_id+'" '+selected+'>'+value.documento_title+'</option>';
            })
            $('#documento').html('');
            $('#documento').append(html);
            $('#documento').select2();
            $('#documento').removeAttr('disabled');
        }
        function loadFases(index){
            var selectvalues = '';
            var html = '';
            if (1 == index){ selectvalues = oda_documentos_object.fases_ordenanzas; }
            if (2 == index){ selectvalues = oda_documentos_object.fases_resoluciones; }
            html += '<option value="">Seleccione fase</option>';
            $.each(selectvalues, function(index, value){
                var selected = '';
                if (oda_documentos_object.fase_pos == value.index) { selected = 'selected'; }
                html += '<option value="'+value.index+'" '+selected+'>'+value.title+'</option>';
            })
            $('#fase').html('');
            $('#fase').append(html);
            $('#fase').select2();
            $('#fase').removeAttr('disabled');
        }
    </script>
    <?php
    echo '<pre>';
    //var_dump($ordenanzas_ciudad);
    echo '</pre>';
}

function oda_save_mocion_meta($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if ($parent_id = wp_is_post_revision($post_id)) {
        $post_id = $parent_id;
    }
    $fields = [
        'oda_ciudad_owner',
        'oda_parent_sesion',
        'oda_sesion_item',
        'oda_sesion_mocion',
        'oda_mocion_position',
        'tipo_votacion_general',
        'tipo_votacion_media',
        'tipo_votacion_especifica',
        'mocion_fecha',
        'mocion_hora',
        'mocion_preside',
        'mocion_orden',
        // Para guardar datos si es ordenanza o resolucion
        'se_mociona',
        'mocion_documento',
        'mocion_fase'
    ];
    foreach ($fields as $field) {
        if (array_key_exists($field, $_POST)) {
            update_post_meta($post_id, $field, $_POST[$field]);
        }
    }
    if (!isset($_POST['ordenanza_fase'])){
        update_post_meta($post_id, 'para_ordenanza', 'off');
    }
    if (!isset($_POST['resolucion_fase'])){
        update_post_meta($post_id, 'para_resolucion', 'off');
    }
    // echo '<pre>';
    // var_dump($_POST);
    // echo '</pre>';
    
    if ('mocion' == get_post_type()) {
        if (isset($_POST['oda_parent_sesion'])) {
            header('Location:' . admin_url('post.php?post=' . $_POST['oda_parent_sesion'] . '&action=edit&asistencia=true'));
            exit();
        }
    }

}
add_action('save_post', 'oda_save_mocion_meta');

function mocion_show_resume()
{
    if ('mocion' === get_post_type()) {
        $metas = get_post_meta($_GET['parent_sesion'], 'oda_sesion_pats_group', true);
    ?>
        <h3>Votación para la moción: <u><?php echo $metas[$_GET['position']]['sesion_pat_title']; ?></u></h3>
        <style scope>
            .asistencia_resumem_value {
                border: 0;
                background: transparent;
            }

            .data-row {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
            }
        </style>
        <div class="data-row">
            <div class="data-col">
                <ul>
                    <li><strong>Total Miembros:</strong> <span id="total_miembros">0</span></li>
                    <li><strong>Total Ausentes:</strong> <input class="asistencia_resumem_value" name="asistencia_ausentes" id="total_ausentes" value="0" readonly></li>
                    <li><strong>Total Excusas:</strong> <input class="asistencia_resumem_value" name="asistencia_excusas" id="total_excusas" value="0" readonly></li>
                </ul>
            </div>
            <div class="data-col">
                <ul>
                    <li><strong>Total SI:</strong> <input class="asistencia_resumem_value" name="votos_si" id="total_1" value="0" readonly></li>
                    <li><strong>Total NO:</strong> <input class="asistencia_resumem_value" name="votos_no" id="total_2" value="0" readonly></li>
                    <li><strong>Total Abstenciones:</strong> <input class="asistencia_resumem_value" name="votos_ab" id="total_3" value="0" readonly></li>
                    <li><strong>Total Blancos:</strong> <input class="asistencia_resumem_value" name="votos_bl" id="total_4" value="0" readonly></li>
                </ul>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var total = ausentes = excusas = votoSi = votoNo = votoAb = votoBl = 0;
                total = $('.asiste_miembro').length;
                $.each($('.asiste_miembro'), function() {
                    if ($(this).is(':checked')) {
                        ausentes++;
                    }
                })
                $.each($('.excusa_miembro'), function() {
                    if ($(this).is(':checked')) {
                        excusas++;
                    }
                })

                $.each($('.voto_miembro'), function() {
                    if ($(this).is(':checked')) {
                        if ($(this).val() == 1) {
                            votoSi++;
                        }
                        if ($(this).val() == 2) {
                            votoNo++;
                        }
                        if ($(this).val() == 3) {
                            votoAb++;
                        }
                        if ($(this).val() == 4) {
                            votoBl++;
                        }
                    }
                })

                $('#total_miembros').text(total);
                $('#total_ausentes').val(ausentes);
                $('#total_excusas').val(excusas);
                $('#total_1').val(votoSi);
                $('#total_2').val(votoNo);
                $('#total_3').val(votoAb);
                $('#total_4').val(votoBl);
            })
        </script>
<?php
    } // END
} // END asistencia_show_resumen
add_action('edit_form_after_editor', 'mocion_show_resume');
