<?php
/**
 * Custom login page modifications
 */

namespace ChefKiss;

/**
 * Enqueue custom login styles
 */
function custom_login_styles() {
	wp_enqueue_style(
		'chef-kiss-login',
		THEME_DIR_URL . '/css/login.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\custom_login_styles' );


/**
 * Add custom HTML to the login page
 */
function custom_login_message() {
	return '<div class="chef-hat"><img src="' . THEME_DIR_URL . '/assets/svg/chef-hat.svg" alt="Chef Hat" /></div>';
}
add_action( 'login_header', __NAMESPACE__ . '\custom_login_message' );
