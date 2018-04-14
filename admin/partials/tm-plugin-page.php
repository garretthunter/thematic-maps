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

    <div id="icon-themes" class="icon32"></div>
    <h2>Thematic Maps</h2>
	<?php settings_errors(); ?>

	<?php
	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'settings';
	?>

    <h2 class="nav-tab-wrapper">
        <a href="?page=thematic_maps_plugin&tab=settings" class="nav-tab <?php echo $active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
        <a href="?page=thematic_maps_plugin&tab=maps" class="nav-tab <?php echo $active_tab == 'maps' ? 'nav-tab-active' : ''; ?>">Maps</a>
    </h2>

   <form method="post" action="options.php">
        <?php

        if ( 'settings' == $active_tab ) {
	        settings_fields( $this->plugin_name.'_plugin' );
	        do_settings_sections( $this->plugin_name.'_plugin');
	        submit_button();
        } else { ?>
            <h2>Maps</h2>
       <?php
        }

        ?>
    </form>

</div><!-- /.wrap -->
