<?php
/**
 * Post type definitions
 *
 * @package ChefKiss\PostTypes;
 */

namespace ChefKiss\PostTypes;

add_action(
	'init',
	function () {
		register_recipes();
	}
);

/**
 * Register the recipes CPT
 */
function register_recipes() {
	$args = array(
		'labels'             => array(
			'name'          => __( 'Recipes', 'chef-kiss' ),
			'singular_name' => __( 'Recipe', 'chef-kiss' ),
			'add_new'       => __( 'Add New Recipe', 'chef-kiss' ),
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'recipes' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ),
		'show_in_rest'       => true,
	);

	register_post_type(
		'recipe',
		$args
	);

	// Register the cooking time meta fields.
	register_post_meta(
		'recipe',
		'time',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'number',
			'default'      => 10,
		)
	);

	// Register the experience level.
	register_post_meta(
		'recipe',
		'level',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'number',
			'default'      => 1,
		)
	);

	// Register the conference CPT
	$args = array(
		'labels'             => array(
			'name'          => __( 'Conferences', 'chef-kiss' ),
			'singular_name' => __( 'Conference', 'chef-kiss' ),
			'add_new'       => __( 'Add New Conference', 'chef-kiss' ),
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'conferences' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt' ),
		'show_in_rest'       => true,
	);

	register_post_type(
		'conference',
		$args
	);

	register_post_meta(
		'conference',
		'duration',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'number',
			'default'      => 90,
		)
	);
	register_post_meta(
		'conference',
		'voting_open',
		array(
			'show_in_rest' => true,
			'single'       => true,
			'type'         => 'boolean',
			'default'      => false,
		)
	);
}

add_filter(
	'template_include',
	function ( $template ) {
		global $post;

		// If this isn't a conference, show it.
		if ( ! is_singular( 'conference' ) ) {
			return $template;
		}

		// If the voting is closed, show the results.
		if ( ! get_post_meta( $post->ID, 'voting_open', true ) ) {
			return \locate_block_template( 'results', 'results', [ 'results' ] );
		}

		// If the conference doesn't need a password show it.
		if ( ! post_password_required( $post->ID ) ) {
			return $template;
		}

		// Show the conference page and deal with the password logic.
		// $user_id        = get_current_user_id();
		// $transient_name = md5( "user_{$user_id}_conference_{$post->ID}_correct_password" );

		// if ( false === get_transient( $transient_name ) ) {
		// 	// Check the password
		// 	$pass = isset( $_POST['p'] ) ? sanitize_text_field( wp_unslash( $_POST['p'] ) ) : false;
		// 	if ( $pass && $pass === $post->post_password ) {
		// 		set_transient( $transient_name, true, 120 * MINUTE_IN_SECONDS );
		// 		return $template;
		// 	}

		// 	return \locate_block_template( 'conference-password', 'conference-password', array( 'conference-password' ) );
		// }

		return $template;
	}
);

add_filter(
	'protected_title_format',
	fn() => '%s',
);
