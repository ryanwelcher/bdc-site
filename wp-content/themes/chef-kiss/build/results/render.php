<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$wrapper_attributes = array(
	'id'       => 'results-display',
	'data-cid' => $block->context['postId'],
);
?>
<section <?php echo wp_kses_data( get_block_wrapper_attributes( $wrapper_attributes ) ); ?>>JS needed</section>
