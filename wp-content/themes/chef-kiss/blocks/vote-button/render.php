<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// Enqueue api-fetch manually because the package doesn't support modules yet
wp_enqueue_script( 'wp-api-fetch' );


$state = wp_interactivity_state( 'chef-kiss', array( 'buttonCTA' => __( 'Add Recipe', 'chef-kiss' ) ) );

$context = array(
	'time'          => intval( get_post_meta( $block->context['postId'], 'time', true ) ),
	'disabled'      => false,
	'recipeId'      => $block->context['postId'],
	'addCTA'        => __( 'Add Recipe', 'chef-kiss' ),
	'removeCTA'     => __( 'Remove Recipe', 'chef-kiss' ),
	'savingCTA'     => __( 'Saving...', 'chef-kiss' ),
	'user'          => get_current_user_id(),
	'isVoteLoading' => false,
);
?>

<div
	<?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>
	data-wp-interactive='{ "namespace": "chef-kiss" }'
	data-wp-context='<?php echo wp_json_encode( $context ); ?>'
	data-wp-watch='callbacks.canBeAdded'
	data-wp-init='callbacks.isAdded'
>
<button class="wp-element-button" data-wp-on--click="actions.vote" data-wp-bind--disabled="context.disabled" data-wp-text='state.buttonCTA'></button>
</div>
