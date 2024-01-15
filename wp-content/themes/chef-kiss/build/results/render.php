<?php
/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

?>
<section <?php echo get_block_wrapper_attributes(['id' => 'results-display', 'data-cid' =>$block->context['postId'] ]); ?>>
	<?php esc_html_e( 'Results – hello from a dynamic block!', 'results' ); ?>
	<ul>
		<li>Title of the recipe</li>
		<li>Title of the recipe</li>
		<li>Title of the recipe</li>
		<li>Title of the recipe</li>
		<li>Title of the recipe</li>
		<li>Title of the recipe</li>
	</ul>
</section>
