<?php 
/**
 * Plugin Name:       Project Portal
 * Plugin URI:        https://github.com/Mohib04/project-portal.git
 * Description:       By Project Portal You can add your company's project & Portfolio.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Mohibbulla Munshi
 * Author URI:        https://in.linkedin.com/in/mohib5g
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pp
 * Domain Path:       /languages
 */
?>

<?php

class Project {
    
        public function __construct() {
            add_action("init", array($this, "pp_custom_post_type"));
            add_action("add_meta_boxes", array($this, "pp_custom_meta_box"));
            add_action("save_post", array($this, "pp_save_meta_box"));
            add_shortcode("project", array($this, "pp_project_shortcode"));
        }
        

        //Start Custom Post Type
        public function pp_custom_post_type(){
            register_post_type("pp_project", array(
                "labels" => array(
                    "name"              => __("Projects", "pp"),
                    "singular_name"     => __("Project", "pp"),
                ),
                "public"        => true,
                "has_archive"   => true,
                "menu_icon"     => "dashicons-admin-multisite",
                "rewrite"       => array("slug" => "projects"),
                "supports"      => array("title", "editor", "thumbnail"),
            ));
        }
        //End Custom Post Type

        //Custom Meta Box
        public function pp_custom_meta_box($post_type){
            $post_types = array("pp_project");
            if(in_array($post_type, $post_types)){
                add_meta_box(
                    'some_meta_box_name',
                    __('Project Details', 'pp'),
                    array($this, 'render_meta_box_content'),
                    $post_type,
                    'normal',
                    'default'
                );
            }
        }

        //Render Metabox Content
       public function render_meta_box_content() {
?>

<table class="form-table" role="presentation">
    <tbody>

        <tr class="form-field">
            <th scope="row"><label for="company">Company Name:</label></th>
            <td><input name="company" type="text" id="company" class="code"
                    value="<?php global $post; echo esc_html(get_post_meta($post->ID, 'company', true )) ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row"><label for="racking">Racking Area:</label></th>
            <td><input name="racking" type="text" id="racking" class="code"
                    value="<?php global $post; echo esc_html(get_post_meta($post->ID, 'racking', true )) ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row"><label for="manufacturer">Manufacturer Name:</label></th>
            <td><input name="manufacturer" type="text" id="manufacturer" class="code"
                    value="<?php global $post; echo esc_html(get_post_meta($post->ID, 'manufacturer', true )) ?>"></td>
        </tr>
        <tr class="form-field">
        <tr class="form-field">
            <th scope="row"><label for="origin">Origin Name:</label></th>
            <td><input name="origin" type="text" id="origin" class="code"
                    value="<?php global $post; echo esc_html(get_post_meta($post->ID, 'origin', true )) ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row"><label for="url">Embed URL:</label></th>
            <td><input name="url" type="text" id="url" class="code"
                    value="<?php global $post; echo esc_html(get_post_meta($post->ID, 'url', true )) ?>"></td>
        </tr>

    </tbody>
</table>

<?php

    }
     
    
    //Update Metabox
    public function pp_save_meta_box(){
        global $post;
        if(isset($_POST["company"])):
            update_post_meta($post->ID, "company", sanitize_text_field($_POST["company"]) );
        endif;
        if(isset($_POST["racking"])):
            update_post_meta($post->ID, "racking", sanitize_text_field($_POST["racking"]) );
        endif;
        if(isset($_POST["manufacturer"])):
            update_post_meta($post->ID, "manufacturer", sanitize_text_field($_POST["manufacturer"]) );
        endif;
        if(isset($_POST["origin"])):
            update_post_meta($post->ID, "origin", sanitize_text_field($_POST["origin"]) );
        endif;
        if(isset($_POST["url"])):
            update_post_meta($post->ID, "url", sanitize_text_field($_POST["url"]) );
        endif;
    }
    
    //Short Code registration
    public function pp_project_shortcode(){
        ob_start();

        $get_project = New WP_Query(array(
            'post_type'     => 'pp_project',
        ));?>
<div class="card">
    <?php
    while ($get_project->have_posts()): $get_project->the_post(); ?>
    <div class="card-header">
        <iframe width="560" height="315" src="<?php echo esc_html(get_post_meta(get_the_id(), 'url', true)); ?>"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
    </div>
    <div class="card-body">
        <h2>Project: <?php the_title(); ?></h2>
        <h5 class="card-title">Company Name: <?php echo esc_html(get_post_meta(get_the_id(), 'company', true)); ?></h5>
        <h5 class="card-title">Manufacturer: <?php echo esc_html(get_post_meta(get_the_id(), 'manufacturer', true)); ?>
        </h5>
        <h5 class="card-title">Origin: <?php echo esc_html(get_post_meta(get_the_id(), 'origin', true)); ?></h5>
        <p class="card-text"><?php the_content(); ?></p>
        <a href="#" class="btn btn-primary">Lear More</a>
    </div>

    <?php endwhile; ?>
</div>

<?php

return ob_get_clean();
}



}

$project = New Project;

?>