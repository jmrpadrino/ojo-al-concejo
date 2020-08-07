<?php 

/**
 * Edit List Filters form
 */

add_action('manage_posts_extra_tablenav', 'oda_filter_form_resoluciones');

function oda_filter_form_resoluciones(){
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
