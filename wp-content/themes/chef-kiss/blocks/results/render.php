<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

// Standard old PHP stuff.
$wrapper_attributes = array(
	'id'       => 'results-display',
	'data-cid' => $block->context['postId'],
);

wp_enqueue_script( 'wp-api-fetch' );

$context = array( 'conferenceId' => $block->context['postId'] );
?>
<section <?php echo wp_kses_data( get_block_wrapper_attributes( $wrapper_attributes ) ); ?>
	data-wp-interactive='{ "namespace": "results" }'
	<?php echo data_wp_context( $context ); ?>
	data-wp-init--first-load="callbacks.getVotes"
	data-wp-init--timeout="callbacks.timeout"
>
	<div class="results">
		<ul>
			<template data-wp-each--vote="state.votes" data-wp-each-key="context.vote.id">
				<li class="vote-bar">
					<h3 data-wp-text="context.vote.title"></h3>
					<div class="vote-progress">
						<div
							class="vote-progress-inner"
							data-wp-bind--data-count="context.vote.count"
							data-wp-style--width="actions.determineWidth"
							data-wp-text="context.vote.count"
							></div>
					</div>
				</li>
			</template>
		</ul>
	</div>
</section>
