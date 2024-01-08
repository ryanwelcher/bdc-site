<?php
/**
 * Taxonomy definitions
 *
 * @package ChefKiss\Taxonomies
 */

namespace ChefKiss\Taxonomies;

add_action(
	'init',
	function () {
		register_taxonomies();
	}
);

/**
 * Register the custom taxonomies
 */
function register_taxonomies() {

	// Register the votes taxonomy.
	$labels = array(
		'name'              => _x( 'Votes', 'taxonomy general name', 'chef-kiss' ),
		'singular_name'     => _x( 'Vote', 'taxonomy singular name', 'chef-kiss' ),
		'search_items'      => __( 'Search Votes', 'chef-kiss' ),
		'all_items'         => __( 'All Votes', 'chef-kiss' ),
		'parent_item'       => __( 'Parent Vote', 'chef-kiss' ),
		'parent_item_colon' => __( 'Parent Vote:', 'chef-kiss' ),
		'edit_item'         => __( 'Edit Vote', 'chef-kiss' ),
		'update_item'       => __( 'Update Vote', 'chef-kiss' ),
		'add_new_item'      => __( 'Add New Vote', 'chef-kiss' ),
		'new_item_name'     => __( 'New Vote Name', 'chef-kiss' ),
		'menu_name'         => __( 'Vote', 'chef-kiss' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'vote' ),
	);

	register_taxonomy( 'votes', array( 'recipe' ), $args );

	// Register the votes taxonomy.
	$labels = array(
		'name'              => _x( 'Ingredients', 'taxonomy general name', 'chef-kiss' ),
		'singular_name'     => _x( 'Ingredient', 'taxonomy singular name', 'chef-kiss' ),
		'search_items'      => __( 'Search Ingredients', 'chef-kiss' ),
		'all_items'         => __( 'All Ingredients', 'chef-kiss' ),
		'parent_item'       => __( 'Parent Ingredient', 'chef-kiss' ),
		'parent_item_colon' => __( 'Parent Ingredient:', 'chef-kiss' ),
		'edit_item'         => __( 'Edit Ingredient', 'chef-kiss' ),
		'update_item'       => __( 'Update Ingredient', 'chef-kiss' ),
		'add_new_item'      => __( 'Add New Ingredient', 'chef-kiss' ),
		'new_item_name'     => __( 'New Ingredient Name', 'chef-kiss' ),
		'menu_name'         => __( 'Ingredient', 'chef-kiss' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'ingredient' ),
	);

	register_taxonomy( 'ingredients', array( 'recipe' ), $args );
}
