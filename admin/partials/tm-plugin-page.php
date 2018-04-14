<?php
/**
 * Admin settings page
 *
 * @link       https://github.com/garretthunter
 * @since      1.0.0
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/admin/partials
 */
?>

<div class="wrap">

   <form method="post" action="options.php">
        <?php
        settings_fields( $this->plugin_name.'_plugin' );
        do_settings_sections( $this->plugin_name.'_plugin');
        submit_button();
        ?>
    </form>

</div><!-- /.wrap -->
