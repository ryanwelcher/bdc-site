<?php
/**
 * Binding sources
 */

namespace ChefKiss\Bindings;

add_action(
	'init',
	function() {
		register_block_bindings_source(
			'bdc/cooking-time',
			array(
				'label'              => __( 'Cooking Time', 'chef-kiss' ),
				'get_value_callback' => __NAMESPACE__ . '\retrieve_cooking_time',
				'uses_context'       => array( 'postId', 'postType' ),
			)
		);

		register_block_bindings_source(
			'bdc/skill-level',
			array(
				'label'              => __( 'Skill Level', 'chef-kiss' ),
				'get_value_callback' => __NAMESPACE__ . '\retrieve_skill_level',
				'uses_context'       => array( 'postId', 'postType' ),
			)
		);

		register_block_bindings_source(
			'bdc/view-results',
			array(
				'label'              => __( 'Voting results', 'chef-kiss' ),
				'get_value_callback' => __NAMESPACE__ . '\retrieve_voting_results_url',
				'uses_context'       => array( 'postId', 'postType' ),
			)
		);

		register_block_bindings_source(
			'chef-kiss/excerpt',
			array(
				'label'              => __( 'Post Excerpt', 'chef-kiss' ),
				'get_value_callback' => __NAMESPACE__ . '\retrieve_excerpt_binding',
				'uses_context'       => array( 'postId', 'postType' ),
			)
		);
	}
);

function retrieve_cooking_time( $source_args, $block_instance ) {
	$post_id      = $block_instance->context['postId'];
	$cooking_time = get_post_meta( $post_id, 'time', true );

	return '⏲️ <span class="number-value">' . esc_html( sprintf( _n( '%s minute', '%s minutes', $cooking_time, 'chef-kiss' ), $cooking_time ) ) . '</span>';
}

function retrieve_skill_level( $source_args, $block_instance ) {
	$post_id = $block_instance->context['postId'];
	$level   = get_post_meta( $post_id, 'level', true );

	return esc_html__( 'Skill Level:', 'chef-kiss' ) . '<span class="number-value level-' . esc_attr( $level ) . '"></span>';
}

function retrieve_voting_results_url( $source_args, $block_instance ) {
	$post_id = $block_instance->context['postId'];
	$url     = trailingslashit( get_permalink( $post_id ) ) . 'results';

	switch ( $source_args['key'] ) {
		case 'url':
			return esc_url( $url );
		case 'text':
			return esc_html__( 'View results', 'chef-kiss' );
		case 'linkTarget':
			return '_blank';
		case 'rel':
			return 'noopener noreferrer';
	}
}

/**
 * The callback to return the excerpt for the binding
 */
function retrieve_excerpt_binding( $source_args, $block_instance ) {
	$post_id      = $block_instance->context['postId'];
	$post_type    = $block_instance->context['postType'];
	$current_post = get_post( $post_id );
	return $current_post->post_excerpt;
}
