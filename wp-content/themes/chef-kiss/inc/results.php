<?php
/**
 * Results pages.
 */

namespace ChefKiss\Results;

add_action(
	'init',
	function () {
		add_rewrite_endpoint( 'results', EP_PERMALINK );
	}
);

add_action(
	'template_redirect',
	function () {
		global $wp_query;
		if ( ! is_singular( 'conference' ) || ! isset( $wp_query->query_vars['results'] ) ) {
			return;
		}
		include get_parent_theme_file_path() . '/templates/results.php';
		die;
	}
);
