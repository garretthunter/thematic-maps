<?php $options = get_option($this->plugin_name.'_maps'); ?>
<input type="text" name="<?php echo $this->plugin_name; ?>_maps[nf_field]" value="<?php echo esc_attr($options['nf_field']); ?>" maxlength="255" />
