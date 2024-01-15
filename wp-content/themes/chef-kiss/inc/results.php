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

add_filter(
	'template_include',
	fn( $template ) =>
		isset( $GLOBALS['results'] )
		? locate_block_template( 'results', 'results', [ 'results' ] )
		: $template
);

add_filter(
	'default_template_types',
	fn( $types ) => array_merge(
		[
			'results' => [
				'title'       => 'Results',
				'description' => 'The results page for conference voting',
			],
		],
		$types
	)
);
