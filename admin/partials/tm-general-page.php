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
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <h2 class="nav-tab-wrapper">
        <span class="nav-tab nav-tab-active">Global</span>
        <a class="nav-tab " href="#" target="">
            New Map
        </a>
    </h2>
    <div id="poststuff">
        <form method="post" action="<?php echo esc_html( admin_url( 'admin-post.php' ) ); ?>">
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row">
                        <label for="">Google API Key</label>
                    </th>
                    <td>
                        <input type="text" name="maps_apikey" value="BOO" />
                    </td>
                </tr>
                </tbody>
            </table>
	        <?php
	        wp_nonce_field( 'acme-settings-save', 'acme-custom-message' );
	        submit_button();
	        ?>
        </form>
    </div>
        <form method="post" action="options.php">
			<?php
			settings_errors();
			settings_fields( $this->plugin_name.'_general' );
			do_settings_sections( $this->plugin_name.'_general');
			submit_button();
			?>
        </form>
</div><!-- /.wrap -->
