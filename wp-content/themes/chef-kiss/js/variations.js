/**
 * WordPress dependencies
 */
import { registerBlockVariation } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { postExcerpt as icon } from '@wordpress/icons';

addFilter(
	'blocks.registerBlockType',
	'chef-kiss/avatar-block',
	( settings, name ) => {
		if ( name !== 'core/avatar' ) {
			return settings;
		}

		return {
			...settings,
			attributes: {
				...settings.attributes,
				useCurrentUser: {
					type: 'boolean',
					default: false,
				},
			},
		};
	}
);

registerBlockVariation( 'core/avatar', {
	name: 'logged-in-user',
	title: __( 'Logged In User', 'chef-kiss' ),
	description: __( 'Display the avatar of the current user.', 'chef-kiss' ),
	isActive: [ 'useCurrentUser' ],
	attributes: {
		useCurrentUser: true,
		size: 100,
		style: { border: { width: '4px', radius: '100px' } },
		borderColor: 'highlight',
	},
	scope: [ 'inserter' ],
} );

// Cooking time
registerBlockVariation( 'core/paragraph', {
	name: 'bdc/cooking-time',
	title: __( 'Cooking Time', 'chef-kiss' ),
	icon: 'media-interactive',
	description: __( 'Display the cooking time with bindings.', 'chef-kiss' ),
	isActive: [ 'className', 'metadata.bindings.content.source' ],
	attributes: {
		className: 'wp-block-chef-kiss-cooking-time',
		metadata: { bindings: { content: { source: 'bdc/cooking-time' } } },
	},
	scope: [ 'inserter' ],
} );

// Skill level
registerBlockVariation( 'core/paragraph', {
	name: 'bdc/skill-level',
	title: __( 'Level', 'chef-kiss' ),
	icon: 'media-interactive',
	description: __( 'Display skill level with bindings.', 'chef-kiss' ),
	isActive: [ 'className', 'metadata.bindings.content.source' ],
	attributes: {
		className: 'wp-block-chef-kiss-level',
		metadata: { bindings: { content: { source: 'bdc/skill-level' } } },
	},
	scope: [ 'inserter' ],
} );

// Skill level
registerBlockVariation( 'core/button', {
	name: 'bdc/view-results',
	title: __( 'View results', 'chef-kiss' ),
	description: __( 'Link to the results page', 'chef-kiss' ),
	isActive: [ 'className' ],
	attributes: {
		className: 'view-result-link',
		metadata: {
			bindings: {
				url: { source: 'bdc/view-results', args: { key: 'url' } },
				text: { source: 'bdc/view-results', args: { key: 'text' } },
				linkTarget: {
					source: 'bdc/view-results',
					args: { key: 'linkTarget' },
				},
				rel: {
					source: 'bdc/view-results',
					args: { key: 'rel' },
				},
			},
		},
	},
	scope: [ 'inserter' ],
} );

/**
 * Register a block variation to make it easier to assign the custom binding.
 */
registerBlockVariation( 'core/paragraph', {
	name: 'chef-kiss/excerpt',
	title: __( 'Bound Excerpt', 'chef-kiss' ),
	icon,
	description: __(
		'Mange the post excerpt directly in a block using a custom binding.',
		'chef-kiss'
	),
	isActive: [ 'metadata.bindings.content.source' ],
	attributes: {
		metadata: {
			bindings: {
				content: { source: 'chef-kiss/excerpt' },
			},
		},
	},
	scope: [ 'inserter' ],
} );
