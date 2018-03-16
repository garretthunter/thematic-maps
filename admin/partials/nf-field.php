<?php $options = get_option($this->plugin_name.'_plugin'); ?>
<input type="text" name="<?php echo $this->plugin_name; ?>_plugin[nf_field]" value="<?php echo esc_attr($options['nf_field']); ?>" maxlength="255" />
