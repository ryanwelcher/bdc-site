/**
 * Internal dependencies
 */
import { __, _n, sprintf } from '@wordpress/i18n';
import { registerBlockBindingsSource } from '@wordpress/blocks';
import { store as coreDataStore } from '@wordpress/core-data';

registerBlockBindingsSource( {
	label: __( 'Cooking Time' ),
	name: 'bdc/cooking-time',
	getValues( { select, context } ) {
		if ( context.postId ) {
			const { meta } = select( coreDataStore ).getEntityRecord(
				'postType',
				context.postType,
				context.postId
			);
			const time = sprintf(
				_n( '%s minute', '%s minutes', meta?.time, 'chef-kiss' ),
				meta?.time
			);
			// failure point when showing the template.
			return {
				content: `⏲️ <span class="number-value">${ time }</span>`,
			};
		} else {
			return {
				content: '⏲️ 10 minutes',
			};
		}
	},

	setValues( { select, dispatch, context, bindings } ) {},

	canUserEditValue( { select, context } ) {
		return true;
	},
} );

registerBlockBindingsSource( {
	label: __( 'Skill Level' ),
	name: 'bdc/skill-level',
	getValues( { select, context } ) {
		if ( context.postId ) {
			const { meta } = select( coreDataStore ).getEntityRecord(
				'postType',
				context.postType,
				context.postId
			);

			return {
				content: `${ __(
					'Skill Level:',
					'chef-kiss'
				) }<span class="number-value level-${ meta?.level }"></span>`,
			};
		} else {
			return {
				content: `${ __(
					'Skill Level:',
					'chef-kiss'
				) }<span class="number-value level-2"></span>`,
			};
		}
	},

	setValues( { select, dispatch, context, bindings } ) {},

	canUserEditValue( { select, context } ) {
		return true;
	},
} );

/**
 * Register the custom bindings so it can be edited in the block editor.
 */
registerBlockBindingsSource( {
	label: __( 'Excerpt' ),
	name: 'chef-kiss/excerpt',
	getValues( { select } ) {
		return {
			content:
				select( 'core/editor' ).getEditedPostAttribute( 'excerpt' ),
		};
	},

	setValues( { dispatch, bindings } ) {
		dispatch( 'core/editor' ).editPost( {
			excerpt: bindings?.content?.newValue,
		} );
	},

	canUserEditValue( { select, context } ) {
		return true;
	},
} );
