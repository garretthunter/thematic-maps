<?php $options = get_option($this->plugin_name.'_plugin'); ?>
<input type="text" name="<?php echo $this->plugin_name; ?>_plugin[maps_apikey]" value="<?php echo esc_attr($options['maps_apikey']); ?>" />
<?php echo __('Get your API key at', 'thematic_maps_plugin'); ?> <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">Google</a>
