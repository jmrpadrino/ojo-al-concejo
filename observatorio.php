<?php
/**
 * @package Observatorio
 */
/*
Plugin Name: Observatorio de Alcaldias
Plugin URI: http://urbadigital.com/wordpress-plugins/
Description: Aqui viene una descripción pronto...
Version: 0.0.1
Author: Urba Digital
Author URI: http://urbadigital.com/
License: GPLv2 or later
Text Domain: oda
*/

/**
 * Direct access denied
 */

if ( ! defined( 'ABSPATH' ) ) {
    echo 'quesfff!!';
    //include('./directly-access-message.php');
}

/**
 * Declarations
 */
$oda_objects = [
    'ciudad',
    'circunscripcion',
    'comision',
    'miembro',
    'partido',
    'ordenanza',
    'resolucion',
    'publicacion'
];

define('ODA_VERISON', '0.0.1' );
define('ODA_PREFIX', 'oda_' );
define('ODA_DIR_PATH', plugin_dir_path( __FILE__ ) );
define('ODA_DIR_URL', plugin_dir_url( __FILE__ ) );
define('ODA_OBJECTS', $oda_objects );

// ----------------------------------------------------------------
// Backend files
// ----------------------------------------------------------------
require_once( ODA_DIR_PATH . 'backend/config.php' );

/**
 * Support for CTP Ciudad
 */
require_once( ODA_DIR_PATH . 'backend/ciudad/Ciudad.php' );
require_once( ODA_DIR_PATH . 'backend/ciudad/Metaboxes.php' );

/**
 * Support for CTP Circunscripcion
 */
require_once( ODA_DIR_PATH . 'backend/circunscripcion/Circunscripcion.php' );
require_once( ODA_DIR_PATH . 'backend/circunscripcion/Metaboxes.php' );
require_once( ODA_DIR_PATH . 'backend/circunscripcion/Admin-columns.php' );

/**
 * Support for CTP Comision
 */
require_once( ODA_DIR_PATH . 'backend/comision/Comision.php' );
require_once( ODA_DIR_PATH . 'backend/comision/Metaboxes.php' );
require_once( ODA_DIR_PATH . 'backend/comision/Admin-columns.php' );

/**
 * Support for CTP Miembros
 */
require_once( ODA_DIR_PATH . 'backend/miembros/Miembros.php' );
require_once( ODA_DIR_PATH . 'backend/miembros/Metaboxes.php' );
require_once( ODA_DIR_PATH . 'backend/miembros/Admin-columns.php' );
require_once( ODA_DIR_PATH . 'backend/miembros/Tools.php' );
require_once( ODA_DIR_PATH . 'backend/miembros/ajax-support.php' );

/**
 * Support for CTP Partido Político
 */
require_once( ODA_DIR_PATH . 'backend/partidos-politicos/Partidospoliticos.php' );
require_once( ODA_DIR_PATH . 'backend/partidos-politicos/Metaboxes.php' );
require_once( ODA_DIR_PATH . 'backend/partidos-politicos/Admin-columns.php' );

/**
 * Support for CTP Ordenanzas
 */
require_once( ODA_DIR_PATH . 'backend/ordenanzas/Ordenanzas.php' );
require_once( ODA_DIR_PATH . 'backend/ordenanzas/Metaboxes.php' );
require_once( ODA_DIR_PATH . 'backend/ordenanzas/Admin-columns.php' );

/**
 * Support for CTP Resoluciones
 */
require_once( ODA_DIR_PATH . 'backend/resoluciones/Resoluciones.php' );
require_once( ODA_DIR_PATH . 'backend/resoluciones/Metaboxes.php' );
require_once( ODA_DIR_PATH . 'backend/resoluciones/Admin-columns.php' );

/**
 * Support for CTP Publicaciones
 */
require_once( ODA_DIR_PATH . 'backend/publicaciones/Publicaciones.php' );
require_once( ODA_DIR_PATH . 'backend/publicaciones/Metaboxes.php' );
require_once( ODA_DIR_PATH . 'backend/publicaciones/Admin-columns.php' );

/**
 * Support for Tax Temas
 */
require_once( ODA_DIR_PATH . 'backend/common/Taxonomy-Temas.php' );
require_once( ODA_DIR_PATH . 'backend/common/Filters-Thickbox.php' );

//-----------------------------------------------------------------
// Frontend Files
//-----------------------------------------------------------------

// Just for development
flush_rewrite_rules();

if ( !is_admin() ){
    //add_action('parse_request', 'debug_func');
    //add_action('the_posting', 'query_func');
}
function debug_func($query){
    global $wp_rewrite;
    echo '<pre>';
    print_r($query);
    echo '</pre>';
}
function query_func(){
    global $wp_query;
    echo $wp_query->request;
}
