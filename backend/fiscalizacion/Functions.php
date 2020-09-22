<?php
/**
 * Create admin Page para listar las opciones de este modulo
 */
add_action('admin_menu', 'oda_fiscalizacion_admin_menu');

function oda_fiscalizacion_admin_menu() {
    add_menu_page(
        __( 'Solicitud de Información','oda' ),
        __( 'Fiscalización','oda' ),
        'manage_options',
        'modulo-fiscalizacion',
        'edit.php?post_type=solicitud-info',
        ODA_DIR_URL . 'images/FCD-menu-icon.png',
        38
    );

    add_submenu_page(
        'modulo-fiscalizacion',
        __( 'Solicitud de Información', 'oda' ),
        __( 'Solicitud de Información', 'oda' ),
        'manage_options',
        'edit.php?post_type=solicitud-info',
        ''
    );
    add_submenu_page(
        'modulo-fiscalizacion',
        __( 'Solicitud de Comparecencias', 'oda' ),
        __( 'Solicitud de Comparecencias', 'oda' ),
        'manage_options',
        'edit.php?post_type=solicitud-comp',
        ''
    );
    add_submenu_page(
        'modulo-fiscalizacion',
        __( 'Instituciones', 'oda' ),
        __( 'Instituciones', 'oda' ),
        'manage_options',
        'edit.php?post_type=instituciones',
        ''
    );

}

/**
 * Disply callback for the Unsub page.
 */
function oda_fiscalizacion_admin_callback() {
    echo 'Unsubscribe Email List';
}
