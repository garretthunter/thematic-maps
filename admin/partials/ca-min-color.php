<?php $options = get_option($this->plugin_name.'_maps'); ?>
<input type="text" class="tm-color-picker" name="<?php echo $this->plugin_name; ?>_maps[ca_min_color]" value="<?php echo esc_attr($options['ca_min_color']); ?>" maxlength="7" />
