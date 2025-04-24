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

wp_enqueue_script( 'wp-api-fetch' );

$current_user = wp_get_current_user();
$recipes = get_user_meta( $current_user->ID, 'recipes', true );

// Enqueue api-fetch manually because the package doesn't support modules yet
wp_interactivity_state(
	'user-recipes',
	array(
		'buttonCTA'   => __( 'Add to my cookbook', 'chef-kiss' ),
		'userRecipes' => !empty( $recipes ) ? $recipes : []
	)
);

$context = array(
	'recipeId'       => $block->context['postId'],
	'addCTA'         => __( 'Add to my cookbook', 'chef-kiss' ),
	'removeCTA'      => __( 'Remove from my cookbook', 'chef-kiss' ),
	'savingCTA'      => __( 'Saving...', 'chef-kiss' ),
	'user'           => get_current_user_id(),
	'isSavingStatus' => false,
);
?>
<div
	<?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>
	data-wp-interactive='user-recipes'
	data-wp-context='<?php echo wp_json_encode( $context ); ?>'
>
	<button
		class="wp-element-button"
		data-wp-on--click="actions.changeSavedStatus"
		data-wp-text='state.buttonCTA'
		>
	</button>
</div>
