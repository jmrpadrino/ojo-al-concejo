<?php

/**
 * Edit List Filters form
 */

//defining the filter that will be used to select posts by 'post formats'
function add_post_formats_filter_to_post_administration(){

    //execute only on the 'post' content type
    global $post_type;

    $oda_valid_cpt = [
        'circunscripcion',
        'comision',
        'miembro',
        'ordenanza',
        'resolucion'
    ];

    if ( in_array($post_type, $oda_valid_cpt) ){
        $args = array(
            'post_type' => 'ciudad',
            'posts_per_page' => -1
        );
        $posts_ciudades = new WP_Query($args);
        if ($posts_ciudades->have_posts()) :
        while($posts_ciudades->have_posts()) : $posts_ciudades->the_post();
        $array_ciudades[get_the_ID()] = get_the_title();
        endwhile;
        endif;
        wp_reset_query();



        if( isset( $_GET['ciudad'] ) ) {
            $selected_city = $_GET['ciudad'];
        } else {
            $selected_city = 0;
        }
?>
<select name="ciudad" id="ciudad">
    <option value="0"><?php _e('Todas las Ciudades', 'oda'); ?></option>
    <?php foreach ($array_ciudades as $key => $value) { ?>
    <?php if ($key == $selected_city) { $selected = 'selected'; } else { $selected = ''; } ?>
    <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $value; ?></option>
    <?php } ?>
</select>
<?php
    }
}
add_action('restrict_manage_posts','add_post_formats_filter_to_post_administration');

//restrict the posts by the chosen post format
function add_post_format_filter_to_posts($query){

    global $post_type, $pagenow;

    $oda_valid_cpt = [
        'circunscripcion',
        'comision',
        'miembro',
        'ordenanza',
        'resolucion'
    ];

    //if we are currently on the edit screen of the post type listings
    if($pagenow == 'edit.php' && in_array($post_type, $oda_valid_cpt)){
        if( $query->is_main_query() ):

        if(isset($_GET['ciudad'])){

            //get the desired post format
            $post_format = $_GET['ciudad'];
            //if the post format is not 0 (which means all)
            if($post_format != 0){

                $query->query_vars['meta_query'] = array(
                    array(
                        'key'  => 'oda_ciudad_owner',
                        'value'     => $post_format
                    )
                );

            }
        }

        endif;
    }
}
add_action('parse_query','add_post_format_filter_to_posts');

/*
add_action('manage_posts_extra_tablenav', 'oda_filter_form_resoluciones', 20, 1);

function oda_filter_form_resoluciones( $which ){
add_thickbox();
?>
<a class="thickbox button" href="#TB_inline?&width=600&height=550&inlineId=more_filters">Mas filtros</a>
<div id="more_filters" style="display:none;">
    <?php
        echo 'algo '.get_current_screen()->parent_file;
        $args = array(
            'post_type' => 'ciudad',
            'posts_per_page' => -1
        );
        $ciudades = new WP_Query($args);
        if($ciudades->have_posts()){
?>
    <label for="ciudad">Filtrar por Inicativa
        <select for="ciudad" name="oda_resolucion_iniciativa">
            <option>Seleccione una ciudad</option>
            <?php while($ciudades->have_posts()){ $ciudades->the_post(); ?>
            <option value="<?php echo get_the_ID(); ?>"><?php echo get_the_title(); ?></option>
            <?php } //end while ?>
        </select>
    </label>
    <?php } // End if ?>
    <input type="submit" name="filter_action" id="post-query-submit" class="button" value="Filtrar">
</div>
<?php
    }
    */
