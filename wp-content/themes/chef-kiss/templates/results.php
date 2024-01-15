<?php
/**
 * Results page layout.
 */

?>
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'results-page' ); ?>>
<?php wp_body_open(); ?>
<div class="wp-site-blocks">
<header class="wp-block-template-part site-header">
<?php block_header_area(); ?>
</header>
<?php
	echo wp_kses_post( do_blocks( '<!-- wp:template-part {"slug":"results","theme":"chef-kiss"} /-->' ) );
?>
<footer class="wp-block-template-part site-footer">
<?php block_footer_area(); ?>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
