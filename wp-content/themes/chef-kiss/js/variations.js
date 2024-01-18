/**
 * WordPress dependencies
 */
import { registerBlockVariation } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';

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
