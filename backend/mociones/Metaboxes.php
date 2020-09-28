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
            'high'
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
                <div class="oda_row">
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
                            <input name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][member_ausente]" class="asiste_miembro" type="checkbox" <?php echo $checked_ausente; ?>>
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
                            <label for="excusa-<?php echo get_the_ID(); ?>"><input name="oda_sesion_mocion[<?php echo get_the_ID(); ?>][member_excusa]" class="excusa_miembro" type="checkbox" data-option="suplente-<?php echo get_the_ID(); ?>" <?php echo $checked_excusa; ?>></label>
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
                        <ul>
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
    </div><!-- END custom-field-row -->
<?php
}

function oda_mostrar_configuracion_mocion()
{

    $city = get_post_meta($_GET['parent_sesion'], 'oda_ciudad_owner', true);

    $args = array(
        'post_type' => 'ordenanza',
        'posts_per_page' => -1,
        'meta_key' => 'oda_ciudad_owner',
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $city,
                'compare' => '=',
            )
        )
    );
    $ordenanzas_ciudad = new WP_Query($args);

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
                        <select id="tipo_general" name="tipo_votacion_<?php echo $tipo->slug; ?>">
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
    if ($ordenanzas_ciudad->have_posts()) {
        $para_ordenanza = get_post_meta($_GET['post'], 'para_ordenanza', true); 
        $ordenanza_seleccionada = get_post_meta($_GET['post'], 'mocion_ordenanza', true); 
        $ordenanza_fase_seleccionada = get_post_meta($_GET['post'], 'ordenanza_fase', true); 
    ?>
        <input id="fase_seleccionada" type="hidden" value="<?php echo $ordenanza_fase_seleccionada; ?>">
        <div class="custom-field-row">
            <p style="font-size: 13px; text-transform: italic; color: gray;">Use este elemento solo si esta moción es para  una ordenanza o fase de una ordenanza</p>
            <label for="para_ordenanza"><strong>¿Moción para ordenanza?</strong><br/>
                <input type="checkbox" name="para_ordenanza" id="para_ordenanza" <?php echo ($para_ordenanza == 'on') ? 'checked': ''; ?>>
            </label>
            <br />
            <label id="label_ordenanza" for="ordenanza">
                <strong>Seleccione Ordenanza</strong>
                <br />
                <select id="ordenanza" name="mocion_ordenanza" class="select-mocion-ordenanza" title="Seleccione un elemento de la lista de ordenanzas" <?php echo (!empty($ordenanza_seleccionada)) ? '' : 'disabled required'; ?>>
                    <option value="">Seleccione</option>
                    <?php while ($ordenanzas_ciudad->have_posts()) {
                        $ordenanzas_ciudad->the_post(); ?>
                        <option value="<?php echo get_the_ID(); ?>" <?php echo ($ordenanza_seleccionada == get_the_ID()) ? 'selected="selected"' : ''; ?>><?php echo get_the_title(); ?></option>
                    <?php } //end while 
                    ?>
                </select>
            </label>
            <div id="fase_ordenanza_container"></div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                var selectMocion = $('.select-mocion-ordenanza');
                $('#mocion_preside').select2();
                selectMocion
                    .select2()
                    .change(function(e){
                        var ordenanzaID = $(this).val();
                        if(ordenanzaID > 0){
                            $.ajax({
                                url: ajaxurl,
                                data: {
                                    action: 'get_fases_ordenanzas',
                                    id: ordenanzaID,
                                },
                                beforeSend: function(){
                                    $('#fase_ordenanza_container').html('<p>Cargando...</p>');
                                },
                                success: function(data){
                                    data = JSON.parse(data);
                                    console.log(data.length);
                                    if(data.length > 0){
                                        var html = '<label><strong>Seleccione una fase</strong><br />' + 
                                            '<select name="ordenanza_fase" required>' +
                                            '<option value="">Seleccione una fase</option>';
                                        var faseSeleccionada = $('#fase_seleccionada').val();
                                        $.each(data, function(index, value){
                                            if (faseSeleccionada == index){
                                                html += '<option value="'+index+'" selected>' + value + '</option>';
                                            }else{
                                                html += '<option value="'+index+'">' + value + '</option>';
                                            }
                                        });
                                        html += '</select></label>';
                                        $('#fase_ordenanza_container').html('');
                                        $('#fase_ordenanza_container').html(html);
                                    }else{
                                        $('#fase_ordenanza_container').html('<p style="color: red; font-weight: bold;">No hay fases configuradas en la ciudad, revise por favor.</p>');
                                    }
                                }
                            })
                        }
                    })
                $('#para_ordenanza').change(function(){
                    if($(this).is(':checked')){
                        $('#ordenanza').removeAttr('disabled');
                    }else{
                        $('#ordenanza').val('').trigger('change');
                        $('#ordenanza').attr('disabled', 'disabled');
                        $('#fase_ordenanza_container').html('');
                    }
                })
            });
        </script>
    <?php
    } // END if have posts
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
        'oda_parent_sesion',
        'oda_sesion_item',
        'oda_sesion_mocion',
        'oda_mocion_position',
        'tipo_votacion_general',
        'tipo_votacion_media',
        'tipo_votacion_especifica',
        'mocion_ordenanza',
        'ordenanza_fase',
        'para_ordenanza',
        'mocion_fecha',
        'mocion_hora',
        'mocion_preside',
        'mocion_orden',
    ];
    foreach ($fields as $field) {
        if (array_key_exists($field, $_POST)) {
            update_post_meta($post_id, $field, $_POST[$field]);
        }
    }
    if (!isset($_POST['ordenanza_fase'])){
        update_post_meta($post_id, 'para_ordenanza', 'off');
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
