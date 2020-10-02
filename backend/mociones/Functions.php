<?php
add_action('post_submitbox_start', 'oda_cancel_buton_mociones');
function oda_cancel_buton_mociones()
{
    if ('mocion' == get_post_type()) {
?>
        <div id="cancel-action" style="text-align: right; width: 100%; margin-bottom: 18px;">
            <a style="color: #a00;" href="<?php echo admin_url('post.php?post=' . $_GET['parent_sesion'] . '&action=edit'); ?>">Cancelar y volver a sesión</a>
        </div>
    <?php
    }
}

add_action('admin_head', 'oda_css_mocion');
function oda_css_mocion()
{
    if ('mocion' === get_post_type()) {
    ?>
        <style>
            #minor-publishing,
            #delete-action {
                display: none !important;
            }
        </style>
    <?php
    } // END IF
}

/* PROVICIONAL - PARA TESTING */
add_action('admin_menu', 'mostrar_test');
function mostrar_test()
{
    add_submenu_page(
        'edit.php?post_type=sesion',
        'Test Votos',
        '<span style="color:yellow;">SIMULACRO</span>',
        'manage_options',
        'votos',
        'mostrar_votos',
        5
    );
}
function mostrar_votos()
/*
02 Oct 2020
Principal: Todos los datos provienen de las mociones.
- Si se ausenta, no se cuentan votos.(se le suma ausencia)
- Si se ausenta, no se permite excusa.(no se le suma excusa, solo ausencia)
- Si se excusa, no se cuenta asistencia y tampoco ausencia, ni votos para el miembro principal.
- Si se excusa, el suplente se le cuenta asistencia o ausencia y posible conteo de votos.

Suplente:
- Se cuentan o no votos.
- Si no vota, se suma ausencia a suplente.

Adicional:
- Se deben contar solo si el participante(miembro, suplente o nuevo) esta en la mocion.
*/

{
    ?>
    <div class="wrap">
        <style scoped>
            .box-container {
                width: 100%;
                display: flex;
            }

            .box-content {
                *width: 50%;
                padding: 20px;
            }
            .box-container .left-box{ width:30%;}
            .box-container .right-box{ width:70%;}
        </style>
        <span style="font-size: 24px; line-height: 1.3; display: block; margin-bottom: 36px;">En este test se motrarán solo el conteo de votos para la ciudad de Quito, es ademas para validar que solo se cuente esta ciudas y no otra. <strong style="color: red;">ESTO ES UNA HERRAMIENTA PROVISIONAL QUE ESTA EN DESARROLLO</strong></span>
        <?php
            //var_dump(get_sesiones_ciudad(9)); 
            //var_dump(get_mociones_ciudad(9)); 
            $sesiones = get_sesiones_ciudad(9);
            $mociones = get_mociones_ciudad(9);
            $miembros = get_miembro_ciudad(9);
        ?>
        <h2>Sesiones en Quito (<?php echo $sesiones->post_count; ?>)</h2>
        <ul>
            <?php foreach ($sesiones->posts as $sesion) { ?>
            <li><strong><?php echo $sesion->post_title; ?></strong></li>
            <?php } ?>
        </ul>
        <div class="box-container">
            <div class="box-content left-box">
                <p>Este conteno se obtiene contando todas la mociones de la ciudad, de las cuales se obtienen la asistencia, ausencia, delegado al suplente, votos</p>
                <table width="100%" cellspacing="0" border="1">
                    <tr>
                        <td><strong>MIEMBRO</strong></td>
                        <td align="center"><strong>AS</strong></td>
                        <td align="center"><strong>AU</strong></td>
                        <td align="center"><strong>EX</strong></td>
                        <td align="center"><strong>DE</strong></td>
                        <td align="center"><strong>SI</strong></td>
                        <td align="center"><strong>NO</strong></td>
                        <td align="center"><strong>AB</strong></td>
                        <td align="center"><strong>BL</strong></td>
                    </tr>
                    <?php
                        $personas = $miembros->posts;
                        foreach ($personas as $persona) {
                            $as = $au = $ex = $de = $si = $no = $ab = $bl = 0;
                            echo '<tr>';
                            echo '<td><strong>'.$persona->post_title.'</strong><br/></td>';
                            foreach($mociones->posts as $mocion){
                                $metas = get_post_meta($mocion->ID, 'oda_sesion_mocion',true);
                                if(isset($metas[$persona->ID]['member_excusa'])){
                                    // se excusó
                                    $ex++;
                                    if(isset($metas[$persona->ID]['member_suplente'])){
                                        $de++;
                                    }
                                }else{
                                    // no se excusó, asistíó o no
                                    if (isset($metas[$persona->ID]['member_ausente'])){
                                        // No asistió y se excusó se cuentan votos para suplente
                                        $au++;
                                    }else{
                                        // Asistió se cuentan votos a miembro principal
                                        switch ($metas[$persona->ID]['mocion_voto']) {
                                            case '1':
                                                $si++; $as++;
                                                break;
                                            case '2':
                                                $no++; $as++;
                                                break;
                                            case '3':
                                                $ab++; $as++;
                                                break;
                                            case '4':
                                                $bl++; $as++;
                                                break;
                                        }
                                    }
                                }
                            }
                            echo '<td align="center">' . $as . '</td>';
                            echo '<td align="center">' . $au . '</td>';
                            echo '<td align="center">' . $ex . '</td>';
                            echo '<td align="center">' . $de . '</td>';
                            echo '<td align="center">' . $si . '</td>';
                            echo '<td align="center">' . $no . '</td>';
                            echo '<td align="center">' . $ab . '</td>';
                            echo '<td align="center">' . $bl . '</td>';
                            echo '</tr>';
                        }
                    ?>

                    <tr>
                        <td><strong>MIEMBRO</strong></td>
                        <td align="center"><strong>AS</strong></td>
                        <td align="center"><strong>AU</strong></td>
                        <td align="center"><strong>EX</strong></td>
                        <td align="center"><strong>DE</strong></td>
                        <td align="center"><strong>SI</strong></td>
                        <td align="center"><strong>NO</strong></td>
                        <td align="center"><strong>AB</strong></td>
                        <td align="center"><strong>BL</strong></td>
                    </tr>
                </table>
            </div>
            <div class="box-content right-box">
                <h2>Mociones en Quito (<?php echo $mociones->post_count; ?>)</h2>
                <ul>
                    <?php
                    foreach ($mociones->posts as $mociones) {
                        $metas = '';
                        $metas = get_post_meta($mociones->ID);
                        $votacion = get_post_meta($mociones->ID, 'oda_sesion_mocion', true);
                        /* echo '<pre>';
                        var_dump($metas);
                        echo '</pre>'; */
                        /**
                         * Tipos de votos
                         * 1. si            => $si
                         * 2. no            => $no
                         * 3. abstencion    => $ab
                         * 4. blanco        => $bl
                         */

                        $si = $no = $ab = $bl = 0;
                        foreach ($votacion as $voto) {
                            echo '<pre>';
                            //var_dump($voto);
                            echo '</pre>';
                            switch ($voto['mocion_voto']) {
                                case '1':
                                    $si++;
                                    break;
                                case '2':
                                    $no++;
                                    break;
                                case '3':
                                    $ab++;
                                    break;
                                case '4':
                                    $bl++;
                                    break;
                            }
                        }


                    ?>
                        <li><strong style="font-size: 18px;">- <?php echo $mociones->post_title; ?></strong>
                            <ul style="margin-left: 18px; list-style-type: circle; padding-left: 20px;">
                                <li><strong>Excusas:</strong> <?php echo $metas['asistencia_excusas'][0]; ?></li>
                                <li><strong>Ausencias:</strong> <?php echo $metas['asistencia_ausentes'][0]; ?></li>
                                <li><strong>Asistencia:</strong> <?php echo count($votacion) - $metas['asistencia_ausentes'][0]; ?></li>
                            </ul>
                        </li>
                        <table width="50%" cellspacing="0" border="1">
                            <tr align="center">
                                <td>SI</td>
                                <td>NO</td>
                                <td>AB</td>
                                <td>BL</td>
                            </tr>
                            <tr align="center">
                                <td><strong><?php echo $si; ?></strong></td>
                                <td><strong><?php echo $no; ?></strong></td>
                                <td><strong><?php echo $ab; ?></strong></td>
                                <td><strong><?php echo $bl; ?></strong></td>
                            </tr>
                        </table>
                        <br />
                        <hr />
                        <br />
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

<?php
}
// funciones HELPERS
function get_sesiones_ciudad($id_ciudad)
{
    $args = array(
        'post_type' => 'sesion',
        'posts_per_page' => -1,
        'meta_key' => 'oda_ciudad_owner',
        'order_by' => 'post_date',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $id_ciudad,
                'compare' => '=',
            )
        )
    );
    $sesiones = new WP_Query($args);
    return $sesiones;
}
function get_mociones_ciudad($id_ciudad)
{
    $args = array(
        'post_type' => 'mocion',
        'posts_per_page' => -1,
        'meta_key' => 'oda_ciudad_owner',
        'order_by' => 'post_date',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $id_ciudad,
                'compare' => '=',
            )
        )
    );
    $mociones = new WP_Query($args);
    return $mociones;
}
function get_miembro_ciudad($id_ciudad)
{
    $args = array(
        'post_type' => 'miembro',
        'posts_per_page' => -1,
        'meta_key' => 'oda_miembro_curul',
        'order_by' => 'post_date',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'oda_ciudad_owner',
                'value' => $id_ciudad,
                'compare' => '=',
            )
        )
    );
    $miembro = new WP_Query($args);
    return $miembro;
}
