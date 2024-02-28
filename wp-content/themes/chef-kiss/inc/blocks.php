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

add_filter(
	'render_block_core/avatar',
	function( $block_content, $block ) {
		if ( isset( $block['attrs']['useCurrentUser'] ) && true === $block['attrs']['useCurrentUser'] ) {
			return '<div class="avatar-chef-hat"></div>' . $block_content . '';
		}
		return $block_content;
	},
	10,
	2
);

// Fix the CSS specificity issues
add_filter(
	'render_block_core/post-terms',
	function( $block_content ) {
		$links = new \WP_HTML_Tag_Processor( $block_content );
		while ( $links->next_tag( array('tag_name' => 'A') ) ) {
			$links->set_attribute( 'style', 'color:white; text-decoration:none;' );
			$links->remove_attribute( 'href' );
		}
		$block_content = $links->get_updated_html();
		return $block_content;
	},
	10,
	2
);

