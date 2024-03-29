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

global $post;

$duration             = intval( get_post_meta( $post->ID, 'duration', true ) );
$unique_id            = wp_unique_id();
$conference_term_name = 'user_' . get_current_user_id() . '_conference_' . $post->ID . '_';

$votes = get_terms(
	[
		'taxonomy'   => 'votes',
		'name__like' => $conference_term_name,
		'fields'     => 'ids',
	]
);

$selected_recipes = new \WP_Query(
	array(
		'post_type' => 'recipe',
		'fields'    => 'ids',
		'tax_query' => array(
			array(
				'taxonomy' => 'votes',
				'terms'    => $votes,
			),
		),
	)
);

$assigned = 0;
if ( $selected_recipes->have_posts() ) {
	foreach ( $selected_recipes->posts as $recipe ) {
		$assigned += intval( get_post_meta( $recipe, 'time', true ) );
	}
}

wp_interactivity_state(
	'chef-kiss',
	array(
		'duration'        => $duration,
		'assigned'        => $assigned,
		'allowedValue'    => $duration,
		'votingOpen'      => true,
		'selectedRecipes' => $selected_recipes->have_posts() ? $selected_recipes->posts : array(),
		'totalDuration'   => $duration,
		'timeAssigned'    => 0,
		'conference'      => $post->ID,
		'term'            => $conference_term_name,
	)
);
?>

<div
	<?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>
	data-wp-interactive='{ "namespace": "chef-kiss" }'
	data-wp-watch='callbacks.watchTime'
>
Time Allotted: <span data-wp-text="state.timeAssigned"></span>/<span data-wp-text="state.totalDuration"></span>
</div>
