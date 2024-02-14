/**
 * WordPress dependencies
 */
import { store, getContext } from '@wordpress/interactivity';

const { state } = store( 'chef-kiss', {
	callbacks: {
		isSelected: () => {
			const context = getContext();
			context.isSelected = state.selectedRecipes.includes(
				context.recipeId
			);
		},
	},
} );
