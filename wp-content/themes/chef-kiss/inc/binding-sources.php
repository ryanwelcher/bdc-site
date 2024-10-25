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
				'label'              => __( 'Cooking Time', 'custom-bindings' ),
				'get_value_callback' => __NAMESPACE__ . '\retrieve_cooking_time',
				'uses_context'       => array( 'postId', 'postType' ),
			)
		);

		register_block_bindings_source(
			'bdc/skill-level',
			array(
				'label'              => __( 'Skill Level', 'custom-bindings' ),
				'get_value_callback' => __NAMESPACE__ . '\retrieve_skill_level',
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
