/**
 * WordPress dependencies
 */

import { store, getContext } from '@wordpress/interactivity';
const apiFetch = wp.apiFetch;

const { state } = store( 'chef-kiss', {
	state: {
		get buttonCTA() {
			const { addCTA, removeCTA } = getContext();
			return state.isSelected ? removeCTA : addCTA;
		},

		get isSelected() {
			const { recipeId } = getContext();
			return state.selectedRecipes.includes( recipeId );
		},
	},
	actions: {
		vote: async () => {
			const context = getContext();
			const { time, recipeId, added, user } = context;
			if ( ! added ) {
				state.assigned += Number( time );
				state.allowedValue -= Number( time );
				state.selectedRecipes.push( recipeId );
			} else {
				state.assigned -= Number( time );
				state.allowedValue += Number( time );
				state.selectedRecipes = state.selectedRecipes.filter(
					( id ) => id !== recipeId
				);
			}
			try {
				const request = await apiFetch( {
					path: '/bdc/v1/vote',
					method: 'POST',
					data: {
						user_id: user,
						conference_id: state.conferenceId,
						recipe_id: recipeId,
						action: added ? 'remove' : 'add',
					},
				} );
				if ( 'success' === request.status ) {
					context.added = ! context.added;
				}
			} catch ( error ) {
				console.log( error );
			}
		},
	},
	callbacks: {
		canBeAdded: () => {
			const context = getContext();
			if ( state.selectedRecipes.includes( context.recipeId ) ) {
				context.disabled = false;
			} else {
				context.disabled = context.time > state.allowedValue;
			}
		},
		isAdded: () => {
			const context = getContext();
			context.added = state.isSelected;
		},
	},
} );
