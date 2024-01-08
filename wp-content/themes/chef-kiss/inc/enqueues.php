<?php
/**
 * Enqueues
 */

namespace ChefKiss\Enqueues;

// Enqueue plugins from a theme.
add_action(
	'enqueue_block_editor_assets',
	function () {
		$assets_file = get_stylesheet_directory() . '/build/plugins.asset.php';

		if ( file_exists( $assets_file ) ) {
			$assets = include $assets_file;
			wp_enqueue_script(
				'bdc-plugins',
				get_stylesheet_directory_uri() . '/build/plugins.js',
				$assets['dependencies'],
				$assets['version'],
				true
			);
		}

		$variations_assets_file = get_stylesheet_directory() . '/build/variations.asset.php';

		if ( file_exists( $variations_assets_file ) ) {
			$assets = include $variations_assets_file;
			wp_enqueue_script(
				'bdc-variations',
				get_stylesheet_directory_uri() . '/build/variations.js',
				$assets['dependencies'],
				$assets['version'],
				true
			);
		}
	}
);

/**
 * Enqueue the theme stylesheet
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'style', get_stylesheet_uri() );
	}
);

/**
 * Add the theme bg image as a variable.
 */
add_action(
	'wp_head',
	function () {
		?>
		<style>
			:root {
			--background-image-url: url('<?php echo esc_url( get_parent_theme_file_uri( 'assets/img/circuits.png' ) ); ?>');
			}
		</style>
		<?php
	}
);
