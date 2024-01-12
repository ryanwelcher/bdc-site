/**
 * WordPress dependencies
 */
// import apiFetch from '@wordpress/api-fetch';
import { store, getContext } from '@wordpress/interactivity';

const { state } = store( 'chef-kiss', {
	state: {
		get buttonCTA() {
			const { added, addCTA, removeCTA } = getContext();

			return added ? removeCTA : addCTA;
		},
	},
	actions: {
		vote: async () => {
			const context = getContext();
			const { time, recipeId, added, user } = context;
			console.log( context );
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

			console.log( state.conferenceId );

			fetch( 'http://localhost:8888/wp-json/bdc/v1/vote', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json;charset=utf-8',
				},
				body: JSON.stringify( {
					user_id: user,
					conference_id: state.conferenceId,
					recipe_id: recipeId,
					action: added ? 'remove' : 'add',
				} ),
			} ).then( ( res ) => {
				console.log( res );
			} );
			// const request = await apiFetch( {
			// 	path: '/bdc/v1/vote',
			// 	method: 'POST',
			// 	data: {
			// 		user_id: user,
			// 		conference_id: '',
			// 		recipe_id: recipeId,
			// 		action: 'add',
			// 	},
			// } ).then( ( res ) => {
			// 	console.log( res );
			// } );

			context.added = ! context.added;
		},
	},
	callbacks: {
		canBeAdded: () => {
			const context = getContext();
			// console.log( state.selectedRecipes );
			if ( state.selectedRecipes.includes( context.recipeId ) ) {
				context.disabled = false;
			} else {
				context.disabled = context.time > state.allowedValue;
			}
		},
	},
} );
