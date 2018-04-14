<?php
/**
 * Lists all maps and provides ability to create new maps
 *
 * @link       https://github.com/garretthunter
 * @since      1.1.0
 *
 * @package    Thematic_Maps
 * @subpackage Thematic_Maps/admin/partials
 */
?>
<div class="wrap">

    <div id="icon-themes"></div>
    <h2>Thematic Maps</h2>
	<?php settings_errors();

	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'maps';
	?>

    <h2 class="nav-tab-wrapper">
        <a href="?page=thematic_maps_maps&tab=maps" class="nav-tab <?php echo $active_tab == 'maps' ? 'nav-tab-active' : ''; ?>">Available Maps</a>
        <a href="?page=thematic_maps_maps&tab=new_map" class="nav-tab <?php echo $active_tab == 'new_map' ? 'nav-tab-active' : ''; ?>">New Map</a>
    </h2>

    <?php if( 'new_map' == $active_tab) { ?>

        <form method="post" action="options.php">
		<?php
		settings_errors();
		settings_fields( $this->plugin_name.'_new_map' );
		do_settings_sections( $this->plugin_name.'_new_map');
		submit_button();
		?>
    </form>

    <?php
    } else { ?>
        <table class="wp-list-table widefat fixed striped ">
            <thead>
                <tr>
                    <th id="title" class="manage-column column-title column-primary sortable desc" scope="col">
                        <span>Shortcode ID</span>
                    </th>
                    <th id="form" class="manage-column column-form sortable desc" scope="col">
                        <span>Ninja Form</span>
                    </th>
                    <th id="field" class="manage-column column-field sortable desc" scope="col">
                        <span>Ninja Form Field</span>
                    </th>
                    <th id="min-color" class="manage-column column-min-color sortable desc" scope="col">
                        <span>Min Color</span>
                    </th>
                    <th id="max-color" class="manage-column column-max-color sortable desc" scope="col">
                        <span>Max Color</span>
                    </th>
                </tr>
            </thead>
            <tbody id="the-list">
            <?php foreach ( $available_maps as $map ) { ?>
                <tr>
                    <th id="title" class="manage-column column-title column-primary sortable desc" scope="col">
                        <span><?php echo $map['thematic_maps_id'] ?></span>
                    </th>
                    <th id="form" class="manage-column column-form sortable desc" scope="col">
                        <span><?php echo $map['nf_form_id'] ?></span>
                    </th>
                    <th id="field" class="manage-column column-field sortable desc" scope="col">
                        <span><?php echo $map['nf_field'] ?></span>
                    </th>
                    <th id="min-color" class="manage-column column-min-color sortable desc" scope="col" bgcolor="<?php echo $map['ca_min_color'] ?>">
                        <span> </span>
                    </th>
                    <th id="max-color" class="manage-column column-max-color sortable desc" scope="col" bgcolor="<?php echo $map['ca_max_color'] ?>">
                        <span> </span>
                    </th>
                </tr>
            <?php } ?>
            </tbody>
            <tfoot>
                <tr>

                </tr>
            </tfoot>
        </table>
    <?php

        submit_button( 'Add New' );

    } ?>

</div><!-- /.wrap -->
