<?php
$options = get_option($this->plugin_name.'_plugin');
$ninja_forms = (new Thematic_Maps_Ninja_Form())->get_forms();
if( empty( $ninja_forms ) ) {
	echo __('You must install the <a href="https://wordpress.org/plugins/ninja-forms/" target="_blank">Ninja Forms</a> plugin and create a form before using this plugin.', $this->plugin_name);
} else { ?>
    <select name="<?php echo $this->plugin_name; ?>_plugin[nf_form_id]">
        <option value=""></option> <?php
		foreach( $ninja_forms as $form ) { ?>
            <option value="<?php echo $form->id; ?>"<?php if ( $form->id === $options['nf_form_id'] ) :?> SELECTED <?php endif ?>><?php echo esc_attr($form->title); ?></option> <?php
		} ?>
    </select> <?php
}
