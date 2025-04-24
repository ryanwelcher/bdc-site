<?php
/**
 * Block related code
 *
 * @package ChefKiss\Blocks
 */

namespace ChefKiss\Blocks;

add_action(
	'init',
	function () {
		$blocks = glob( THEME_BUILD_DIR_PATH . '/*', GLOB_ONLYDIR );
		foreach ( $blocks as $block ) {
			register_block_type( $block );
		}

		// Get the block namespace paths.
		$paths = array_map(
			fn( $namespace ) => get_parent_theme_file_path( "build/css/{$namespace}" ),
			array( 'core-blocks' )
		);

		// Enqueue block level CSS
		// Loop through each of the block namespace paths, get their
		// stylesheets, and enqueue them.
		foreach ( $paths as $path ) {
			$files = new \FilesystemIterator( $path );

			foreach ( $files as $file ) {
				if ( ! $file->isDir() && 'css' === $file->getExtension() ) {

					$slug = $file->getBasename( '.css' );

					// Build a relative path and URL string.
					$relative = "build/css/core-blocks/{$slug}";

					// Bail if the asset file doesn't exist.
					if ( ! file_exists( get_parent_theme_file_path( "{$relative}.asset.php" ) ) ) {
						return;
					}

					// Get the asset file.
					$asset = include get_parent_theme_file_path( "{$relative}.asset.php" );

					// Register the block style.
					\wp_enqueue_block_style(
						"core/{$slug}",
						array(
							'handle' => "chef-kiss-core-{$slug}",
							'src'    => get_parent_theme_file_uri( "{$relative}.css"  ),
							'path'   => get_parent_theme_file_path( "{$relative}.css" ),
							'deps'   => array_merge( $asset['dependencies'] ),
							'ver'    => $asset['version'],
						)
					);
				}
			}
		}
	}
);

// Register a custom block category
add_action(
	'block_categories_all',
	function( $block_categories ) {
		array_push(
			$block_categories,
			array(
				'slug'  => 'block-developers-cookbook',
				'title' => __( 'Block Developer\'s Cookbook', 'chef-kiss' ),
			)
		);

		return $block_categories;
	},
	10,
	2
);


add_filter(
	'render_block_data',
	function( $parsed_block ) {
		if (
			'core/avatar' === $parsed_block['blockName'] &&
			isset( $parsed_block['attrs']['useCurrentUser'] ) &&
			true === $parsed_block['attrs']['useCurrentUser']
		) {
			$parsed_block['attrs']['userId'] = get_current_user_id();
		}
		return $parsed_block;
	}
);

/**
 * Filter the core/navigation block to allow our variation
 */
add_filter(
	'block_type_metadata_settings',
	function( $settings, $metadata ) {
		if ( 'core/navigation' === $settings['name'] ) {
			$settings['allowed_blocks'][] = 'core/avatar';
			return $settings;
		}
		return $settings;
	},
	10,
	2
);
