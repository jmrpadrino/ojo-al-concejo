<?php
add_action('admin_menu', 'wpdocs_register_my_custom_submenu_page');
function wpdocs_register_my_custom_submenu_page() {
    add_submenu_page( 
        'edit.php?post_type=miembro', 
        'Herramientas', 
        'Herramientas', 
        'manage_options', 
        'miembros-tools', 
        'miembros_tools'
    );
};
function miembros_tools(){
// check user capabilities
if ( ! current_user_can( 'manage_options' ) ) {
    return;
  }

  //Get the active tab from the $_GET param
  $default_tab = null;
  $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;

  ?>
<div class="wrap">
    <style scoped>
        .city-selector {
            margin: 18px 0;
        }
        .sortable {
            display: flex;
            flex-wrap: wrap;
        }
        .sortable li { 
            margin: 5px; 
            padding: 5px 18px; 
            font-size: 1.2em; 
            border: 1px solid lightgray;
            width: 150px;
            height: 150px;
            cursor: grab;
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }
        .sortable li:hover {
            background: #FFC100;
            border: 1px solid #FFC100;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.3);
            transform: translateY(-8px);
            transition: transform ease-in .1s;
            color: white;
        }
        .sortable li:first-child{
            background: #e0e0e0;
        }
        .curul-position {
            font-size: 48px;
        }
        .curul-name {
            font-size: 18px;
        }
        .sortable li:hover .curul-position,
        .sortable li:hover .curul-name{
            font-weight: bold;
            color: white;
        }
        @-webkit-keyframes rotating /* Safari and Chrome */ {
            from {
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            to {
                -webkit-transform: rotate(-360deg);
                -o-transform: rotate(-360deg);
                transform: rotate(-360deg);
            }
            }
        @keyframes rotating {
            from {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            to {
                -ms-transform: rotate(-360deg);
                -moz-transform: rotate(-360deg);
                -webkit-transform: rotate(-360deg);
                -o-transform: rotate(-360deg);
                transform: rotate(-360deg);
            }
            }
        .rotating {
            display: inline-block;
            margin-top: 8px;
            margin-left: 5px;
            -webkit-animation: rotating 1s linear infinite;
            -moz-animation: rotating 1s linear infinite;
            -ms-animation: rotating 1s linear infinite;
            -o-animation: rotating 1s linear infinite;
            animation: rotating 1s linear infinite;
        }
        .rotating.hide {
            display: none;
        }
    </style>
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <nav class="nav-tab-wrapper">
        <a href="?post_type=miembro&page=miembros-tools" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Ordenar Curules</a>
        <a href="?post_type=miembro&page=miembros-tools&tab=one" class="nav-tab <?php if($tab==='settings'):?>nav-tab-active<?php endif; ?>">Otro</a>
        <a href="?post_type=miembro&page=miembros-tools&tab=two" class="nav-tab <?php if($tab==='tools'):?>nav-tab-active<?php endif; ?>">Otro</a>
    </nav>

    <div class="tab-content">
    <?php switch($tab) :
      case 'one':
        echo 'Otro 1';
        break;
      case 'two':
        echo 'Otro 2';
        break;
      default:
        oda_mostrar_ordenar_curules();
        break;
    endswitch; ?>
    </div>
</div>
  <?php
}

function oda_mostrar_ordenar_curules(){
    $ciudades = oda_get_cities();
    if ( $ciudades->have_posts() ) {
?>
    <form class="city-selector" action="" role="form">
        <input type="hidden" name="post_type" value="miembro">
        <input type="hidden" name="page" value="miembros-tools">
        <input type="hidden" name="action" value="ordenar-curules">
        <label for="cities">Ciudades</label>
        <select id="cities" name="ciudad">
            <option>Seleccione</option>
<?php
        $nombre_ciudad = '';
        $id_ciudad = '';
        while ( $ciudades->have_posts() ) {
            $ciudades->the_post();
            $seleccionada = '';
            if ( isset ( $_GET['ciudad'] ) ){
                if ( get_the_ID() == $_GET['ciudad']) {
                    $seleccionada = 'selected';
                    $nombre_ciudad = get_the_title();
                    $id_ciudad = get_the_ID();
                }
            }
            echo '<option value="' . get_the_ID() . '" ' . $seleccionada . '>' . get_the_title() . '</option>';
            $seleccionada = '';
        }
?>
        </select>
        <button type="submit" class="button">Selecionar</button>
    </form>
    <hr />
    <?php echo ( !empty( $nombre_ciudad ) ) ? '<h1>Ordenar Listado de Miembros de ' . $nombre_ciudad . '<span class="dashicons dashicons-image-rotate rotating hide"></span></h1>' : ''; ?>
    <?php 
        if ( !empty( $id_ciudad) ) {
            $args = array(
                'post_type' => 'miembro',
                'posts_per_page' => -1,
                'meta_key' => ODA_PREFIX . 'miembro_curul',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => ODA_PREFIX . 'miembro_curul',
                        'value' => 0,
                        'compare' => '>',
                    ),
                    array(
                        'key' => ODA_PREFIX . 'ciudad_owner',
                        'value' => $id_ciudad,
                        'compare' => '=',
                    )
                )
            );
            $miembros = new WP_Query($args);
            if ($miembros->have_posts()){
                echo '<ul class="sortable">';
                while($miembros->have_posts()){
                    $miembros->the_post();
                    echo '<li id="' . get_the_ID() . '"><span class="curul-position"><strong>' . get_post_meta(get_the_id(), ODA_PREFIX . 'miembro_curul', true) . '</strong></span><span class="curul-name">' . get_the_title() . '</span></li>';
                }
                echo '</ul>';
            }
        }
    ?>
<?php

    }
}

add_action('wp_ajax_oda_reordenar_curules','oda_reordenar_curules');
function oda_reordenar_curules()
{
    //echo json_encode($_GET['data']);
    foreach ( $_GET['data'] as $item ){
        update_post_meta($item['id'], ODA_PREFIX . 'miembro_curul', $item['order']);
    }
    wp_die();
}
