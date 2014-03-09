<div class="wrap">
	<h2>CF7 Highrise Plugin</h2>

	<form action="options.php" method="post">
		<?php settings_fields('cf7_highrise_options'); ?>
		<?php do_settings_sections(CF7_HIGHRISE_BASENAME); ?>

		<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
	</form>	
</div>