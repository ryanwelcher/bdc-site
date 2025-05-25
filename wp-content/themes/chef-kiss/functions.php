<?php
/**
 * Theme functions
 */

namespace ChefKiss;

// Define some constants.
define( 'THEME_DIR_PATH', get_stylesheet_directory() );
define( 'THEME_INC_PATH', THEME_DIR_PATH . '/inc/' );
define( 'THEME_DIR_URL', get_stylesheet_directory_uri() );
define( 'THEME_BLOCK_PATH', THEME_DIR_PATH . '/blocks/' );
define( 'THEME_BLOCK_URL', THEME_DIR_URL . '/blocks/' );
define( 'THEME_BUILD_DIR_PATH', THEME_DIR_PATH . '/build' );

// Require files.
require_once THEME_INC_PATH . 'post-types.php';
require_once THEME_INC_PATH . 'taxonomies.php';
require_once THEME_INC_PATH . 'enqueues.php';
require_once THEME_INC_PATH . 'blocks.php';
require_once THEME_INC_PATH . 'rest-api.php';
require_once THEME_INC_PATH . 'results.php';
require_once THEME_INC_PATH . 'binding-sources.php';
require_once THEME_INC_PATH . 'login.php';


add_filter( 'default_wp_template_part_areas', __NAMESPACE__ . '\template_part_areas' );

function template_part_areas( array $areas ) {
	$areas[] = array(
		'area'        => 'conference-voting',
		'area_tag'    => 'section',
		'label'       => __( 'Conference voting', 'chef-kiss' ),
		'description' => __( 'Template parts relate to voting', 'chef-kiss' ),
		'icon'        => 'layout',
	);

	return $areas;
}

add_action( 'init', __NAMESPACE__ . '\register_pattern_categories' );

function register_pattern_categories() {
	register_block_pattern_category(
		'chef-kiss/conference-voting',
		array(
			'label'       => __( 'Block Developer Cookbook', 'chef-kiss' ),
			'description' => __( 'Custom patterns for Chef Kiss theme', 'chef-kiss' ),
		)
	);
}

add_action( 'init', function() {
		register_meta(
			'user',
			'recipes',
			[
				'show_in_rest' => true,
				'single'       => true,
				'type'         => 'array',
			]
	);
});
