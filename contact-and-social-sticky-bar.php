<?php
/*
Plugin Name:  Contact and social sticky bar
Description:  This plugin will display a responsive, sticky bar at the top of your website with the information you provided.
Version:      1.0.0
Author:       Mateusz Styrna
Author URI:   https://mateusz-styrna.pl/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

add_action( 'wp_enqueue_scripts', 'cassb_load_assets' );
add_action( 'wp_head', 'cassb_custom_style' );
add_action( 'wp_body_open', 'cassb_display' );
add_action( 'admin_menu', 'cassb_menu' );
add_action( 'admin_init', 'cassb_register_settings' );

function cassb_load_assets() {
	wp_enqueue_style( 'cassb_css', plugins_url('/css/front.css', __FILE__), '', '1.0.0', false );
}

function cassb_custom_style() {
	$options = get_option( 'cassb_settings' );
	if ( isset($options['cassb_enable']) && $options['cassb_enable'] == TRUE) {
		?>
		<style type="text/css">
			.cassb-bar {
				background: <?php if (isset($options['cassb_background'])) echo wp_kses($options['cassb_background'], array('div' => array('style' => array()))); ?>;
				height: <?php if (isset($options['cassb_height'])) echo (int) $options['cassb_height'].'px'; else echo "auto"; ?>;
				color: <?php if (isset($options['cassb_text_color'])) echo wp_kses($options['cassb_text_color'], array('div' => array('style' => array()))); ?>;
			}

			.cassb-bar a {
				color: <?php if (isset($options['cassb_text_color'])) echo wp_kses($options['cassb_text_color'], array('a' => array('style' => array()))); ?>;
			}
		</style>
		<?php
	}
}

function cassb_display() {
	$options = get_option( 'cassb_settings' );
	if ( isset($options['cassb_enable']) && $options['cassb_enable'] == TRUE) {
		?>
		<div class="cassb-bar">
			<div class="cassb-bar__left">
				<?php if ( isset($options['cassb_left_content']) ) echo wp_kses_post($options['cassb_left_content']); ?>
			</div>
			<div class="cassb-bar__right">
				<?php if ( isset($options['cassb_right_content']) ) echo wp_kses_post($options['cassb_right_content']); ?>
			</div>
		</div>
		<?php 
	}
}

function cassb_register_settings() {
	register_setting(
        'cassb',
        'cassb_settings',
        'cassb_sanitize'
    );

    add_settings_section(
        'cassb_main_settings',
        'Visual settings',
        'cassb_main_settings_info' ,
        'cassb'
    );  

    add_settings_field(
        'cassb_enable',
        'Enable',
        'cassc_enable_callback',
        'cassb',
        'cassb_main_settings'         
    );

    add_settings_field(
        'cassb_background',
        'Background Color',
        'cassc_background_callback',
        'cassb',
        'cassb_main_settings'         
    );

    add_settings_field(
        'cassb_text_color',
        'Text Color',
        'cassc_text_color_callback',
        'cassb',
        'cassb_main_settings'         
    );

    add_settings_field(
        'cassb_height',
        'Bar height (in pixels, blank for auto)',
        'cassc_height_callback',
        'cassb',
        'cassb_main_settings'         
    );

    add_settings_field(
        'cassb_left_content',
        'Left side content',
        'cassc_left_content_callback',
        'cassb',
        'cassb_main_settings'         
    );

    add_settings_field(
        'cassb_right_content',
        'Right side content',
        'cassc_right_content_callback',
        'cassb',
        'cassb_main_settings'         
    );
}

function cassb_main_settings_info() {
	echo __('Enter your settings below: ', 'wordpress');
}

include 'callbacks.php';

function cassb_sanitize( $input ) {
	$validated_options = array();

	foreach( $input as $key => $value ) {
        if( isset( $input[$key] ) ) {
			switch ($key) {
				case 'cassb_enable':
					if ( wp_validate_boolean( $input[$key] ) ) {
						$validated_options[$key] = $input[$key];
					}
				break;
				case 'cassb_background':
						$validated_options[$key] = sanitize_hex_color( $input[$key] );
				break;
				case 'cassb_text_color':
						$validated_options[$key] = sanitize_hex_color( $input[$key] );
				break;
				case 'cassb_height':
					if ( intval($input[$key]) ) {
						$validated_options[$key] = $input[$key];
					}
				break;
				case 'cassb_left_content':
						$validated_options[$key] = wp_kses_post( $input[$key] );
				break;
				case 'cassb_right_content':
						$validated_options[$key] = wp_kses_post( $input[$key] );
				break;
			}
        }   
    }

    return $validated_options;
}

function cassb_menu() {
	add_menu_page('Contact and social sticky bar', 'Sticky bar', 'administrator', 'contact_and_social_sticky_bar', 'cassb_admin_page', 'dashicons-minus', 81);
}

function cassb_admin_page() {
	wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'cassb_admin_js', plugins_url('/js/admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    wp_enqueue_style( 'cassb_admin_css', plugins_url('/css/admin.css', __FILE__ ), '', '1.0.0', false );
    $options = get_option( 'cassb_settings' );
	?>
	<div class="wrap">
		<h1>Contact & social sticky bar</h1>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php 
				settings_fields( 'cassb' );
		   		do_settings_sections( 'cassb' );
		    	submit_button(); 
		    ?>
		</form>
		<h2>Preview:</h2>
		<div id="cassb-bar--preview" class="cassb-bar--preview" style="height: <?php echo (int) $options['cassb_height'] ?>px; background: <?php echo sanitize_hex_color($options['cassb_background']); ?>; color: <?php echo sanitize_hex_color($options['cassb_text_color']); ?>">
			<div id="cassb-bar__left--preview">
				<?php if ( isset($options['cassb_left_content']) ) echo wp_kses_post( $options['cassb_left_content'] ); ?>
			</div>
			<div id="cassb-bar__right--preview">
				<?php if ( isset($options['cassb_right_content']) ) echo wp_kses_post( $options['cassb_right_content'] ); ?>
			</div>
		</div>
	</div>
	<?php
}
?>