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
        <a href="?page=thematic_maps_maps&tab=maps" class="nav-tab <?php echo $active_tab == 'maps' ? 'nav-tab-active' : ''; ?>">Maps</a>
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

    <?php } else { ?>
        <h2>Available Maps</h2>
        <table class="wp-list-table widefat fixed striped ">
            <thead>
                <tr>
                    <td class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <th id="title" class="manage-column column-title column-primary sortable desc" scope="col">
                        <span>Title</span>
                    </th>
                    <th id="form" class="manage-column column-form sortable desc" scope="col">
                        <span>Form</span>
                    </th>
                    <th id="field" class="manage-column column-field sortable desc" scope="col">
                        <span>Field</span>
                    </th>
                    <th id="min-color" class="manage-column column-min-color sortable desc" scope="col">
                        <span>Min Color</span>
                    </th>
                    <th id="max-color" class="manage-column column-max-color sortable desc" scope="col">
                        <span>Max Color</span>
                    </th>
                </tr>
            </thead>
        </table>
    <?php } ?>

</div><!-- /.wrap -->
