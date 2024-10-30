<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
function cassc_enable_callback() {
	$options = get_option( 'cassb_settings' );
	?>
	<input name="cassb_settings[cassb_enable]" type="checkbox" id="cassb_enable" <?php if ( isset($options['cassb_enable']) && $options['cassb_enable'] == TRUE) echo "checked"; ?>>
	<?php
}

function cassc_height_callback() {
	$options = get_option( 'cassb_settings' );
	?>
	<input name="cassb_settings[cassb_height]" type="number" id="cassb_height" value="<?php if (isset($options['cassb_height'])) echo (int) $options['cassb_height']; ?>">
	<?php
}

function cassc_background_callback() {
	$options = get_option( 'cassb_settings' );
	?>
	<input 
	class="cassb_color_picker" 
	id="cassb_background_color_picker" 
	name="cassb_settings[cassb_background]" 
	type="text" 
	value="<?php if ( isset($options['cassb_background']) ) echo sanitize_hex_color($options['cassb_background']); ?>" 
	data-default-color="#6ECE9E" />
	<?php
}

function cassc_text_color_callback() {
	$options = get_option( 'cassb_settings' );
	?>
	<input 
	class="cassb_color_picker" 
	id="cassb_text_color_picker" 
	name="cassb_settings[cassb_text_color]" 
	type="text" 
	value="<?php if ( isset($options['cassb_text_color']) ) echo sanitize_hex_color($options['cassb_text_color']); ?>" 
	data-default-color="#FFFFFF" />
	<?php
}

function cassc_left_content_callback() {
	?>
	<div class="cassb_tinymce_editor">
		<?php
		$options = get_option( 'cassb_settings' );
		if ( isset($options['cassb_left_content']) )
			wp_editor( html_entity_decode( $options['cassb_left_content'] ) , 'cassb_left_content', $settings = array('textarea_name'=>'cassb_settings[cassb_left_content]', 'textarea_rows' => 1) );
		else
			wp_editor( 'Left side content' , 'cassb_left_content', $settings = array('textarea_name'=>'cassb_settings[cassb_left_content]', 'textarea_rows' => 1) );
		?>
	</div>
	<?php
}

function cassc_right_content_callback() {
	?>
	<div class="cassb_tinymce_editor">
		<?php
		$options = get_option( 'cassb_settings' );
		if ( isset($options['cassb_right_content']) )
			wp_editor( html_entity_decode( $options['cassb_right_content'] ) , 'cassb_right_content', $settings = array('textarea_name'=>'cassb_settings[cassb_right_content]', 'textarea_rows' => 1) );
		else
			wp_editor( 'Right side content' , 'cassb_right_content', $settings = array('textarea_name'=>'cassb_settings[cassb_right_content]', 'textarea_rows' => 1) );
		?>
	</div>
	<?php
}
?>