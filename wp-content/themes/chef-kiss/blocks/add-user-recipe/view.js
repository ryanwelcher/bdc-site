/**
 * WordPress dependencies
 */

import { store, getContext } from '@wordpress/interactivity';
const apiFetch = wp.apiFetch;

const { state } = store( 'user-recipes', {
	state: {
		get buttonCTA() {
			const { addCTA, removeCTA, isSavingStatus, savingCTA } =
				getContext();
			if ( isSavingStatus ) {
				return savingCTA;
			}
			return state.isSelected ? removeCTA : addCTA;
		},
		get isSelected() {
			const { recipeId } = getContext();
			return state.userRecipes.includes( recipeId );
		},

		get isDisabled() {
			const { isSavingStatus } = getContext();
			return isSavingStatus;
		},
	},
	actions: {
		changeSavedStatus: async () => {
			const context = getContext();
			const { recipeId, user } = context;
			context.isSavingStatus = true;
			if ( ! state.isSelected ) {
				state.userRecipes.push( recipeId );
			} else {
				state.userRecipes = state.userRecipes.filter(
					( id ) => id !== recipeId
				);
			}
			// Hit the endpoint to save the user meta
			try {
				const request = await apiFetch( {
					path: `/wp/v2/users/${ user }`,
					method: 'POST',
					data: {
						meta: {
							recipes: state.userRecipes,
						},
					},
				} );
				if ( 'success' === request.status ) {
					// context.added = ! context.added;
				}
			} catch ( error ) {
				console.log( error );
			}
			context.isSavingStatus = false;
		},
	},
	callbacks: {},
} );

/**
 * Helper function to unwrap the proxies and display the underlying data.
 * @param {*} data
 * @return
 */
const debugLog = ( data ) =>
	console.log( JSON.parse( JSON.stringify( data ) ) );
