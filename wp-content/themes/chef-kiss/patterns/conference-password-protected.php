<?php
/**
 * Title: Conference password
 * Slug: chef-kiss/protected-conference
 * Description: Shows the form for protected conferences
 * Block Types: core/group
 * Categories: chef-kiss/conference-voting
 */
if ( post_password_required() ) : ?>
	<!-- wp:group {"style":{"position":{"type":"sticky","top":"0px"},"border":{"radius":{"topLeft":"2rem"}},"spacing":{"blockGap":"0","margin":{"bottom":"var:preset|spacing|60"}},"dimensions":{"minHeight":"0px"}},"className":"conference-header","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
	<div class="wp-block-group conference-header has-highlight-background-color has-text-color has-link-color" style="border-top-left-radius:2rem;min-height:0px;margin-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group"><!-- wp:avatar {"size":100,"style":{"border":{"width":"4px","radius":"100px"}},"borderColor":"highlight","useCurrentUser":true} /-->

		<!-- wp:post-title {"style":{"elements":{"link":{"color":{"text":"var:preset|color|background"}}}},"textColor":"background"} /--></div>
		<!-- /wp:group -->

		<!-- wp:heading -->
		<h2 class="wp-block-heading has-text-color has-background-color">Password Needed</h2>
		<!-- /wp:heading -->
	</div>
		<!-- /wp:group -->

		<!-- wp:group {"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
		<div class="wp-block-group">

		<!-- wp:html -->
		<form class="chef-kiss-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass' ) ); ?>" method="POST"><input type="text" name="post_password" class="password-field" /><input type="submit" class="submit-button"/></form>
		<!-- /wp:html --></div>
	<!-- /wp:group -->
<?php else : ?>
	<!-- wp:template-part {"slug":"conference-voting","theme":"chef-kiss","tagName":"conference-voting"} /-->
	<?php
endif;
