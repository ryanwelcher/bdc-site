/**
 * WordPress dependencies
 */

import { store, getContext } from '@wordpress/interactivity';
const apiFetch = wp.apiFetch;

const { state } = store( 'chef-kiss', {
	state: {
		get buttonCTA() {
			const { addCTA, removeCTA, isVoteLoading, savingCTA } =
				getContext();
			if ( isVoteLoading ) {
				return savingCTA;
			}
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

			if ( context.isVoteLoading ) {
				return;
			}

			const { time, recipeId, added } = context;

			// Snapshot shared state so we can roll back if the request fails.
			const prevAssigned = state.assigned;
			const prevSelectedRecipes = [ ...state.selectedRecipes ];

			context.isVoteLoading = true;

			if ( ! added ) {
				state.assigned += Number( time );
				state.selectedRecipes.push( recipeId );
			} else {
				state.assigned -= Number( time );
				state.selectedRecipes = state.selectedRecipes.filter(
					( id ) => id !== recipeId
				);
			}

			try {
				const request = await apiFetch( {
					path: '/bdc/v1/vote',
					method: 'POST',
					data: {
						conference_id: state.conference,
						recipe_id: recipeId,
						action: added ? 'remove' : 'add',
					},
				} );
				if ( 'success' === request.status ) {
					context.added = ! context.added;
				}
			} catch ( error ) {
				state.assigned = prevAssigned;
				state.selectedRecipes = prevSelectedRecipes;
			} finally {
				context.isVoteLoading = false;
			}
		},
	},
	callbacks: {
		canBeAdded: () => {
			const context = getContext();
			if ( context.isVoteLoading ) {
				return ( context.disabled = true );
			}
			if ( state.selectedRecipes.includes( context.recipeId ) ) {
				context.disabled = false;
			} else {
				// If there is not enough time to add the recipe, disable the button.
				context.disabled =
					context.time > state.allowedValue - state.assigned;
			}
		},
		isAdded: () => {
			const context = getContext();
			context.added = state.isSelected;
		},
	},
} );

