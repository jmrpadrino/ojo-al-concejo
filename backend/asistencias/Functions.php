<?php
add_filter('wp_insert_post_data', 'change_name_listado', 99, 1);
function change_name_listado( $data ){
    if($data['post_type'] == 'asistencia' && isset($_POST['oda_parent_sesion'])) { // If the actual field name of the rating date is different, you'll have to update this.
        $title = 'Asistencia principal para la sesión ' . $_POST['oda_parent_sesion'];
        $data['post_title'] =  $title ; //Updates the post title to your new title.
    }
    return $data; // Returns the modified data.
}
add_action('post_submitbox_start', 'oda_cancel_buton_asistencias');
function oda_cancel_buton_asistencias(){
    if ('asistencia' == get_post_type() ) {
    ?>
        <div id="cancel-action" style="text-align: right; width: 100%; margin-bottom: 18px;">
            <a style="color: #a00;" href="<?php echo admin_url('post.php?post='.$_GET['parent_sesion'].'&action=edit'); ?>">Cancelar y volver a sesión</a>
        </div>
    <?php
    }
}

add_action('admin_head', 'oda_css_asistencia');
function oda_css_asistencia(){
    if ('asistencia' === get_post_type()){
?>
<style>
    #minor-publishing, 
    #delete-action { display: none !important; }
</style>
<?php
    } // END IF
}