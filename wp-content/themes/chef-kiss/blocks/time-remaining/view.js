/**
 * WordPress dependencies
 */
import { store } from '@wordpress/interactivity';

const { state } = store( 'chef-kiss', {
	state: {
		get totalDuration() {
			return state.duration;
		},
		get timeAssigned() {
			return state.assigned;
		},
		get userId() {
			return state.uniqueId;
		},
	},
	callbacks: {
		watchTime: () => {
			console.log( state.userId );
			if ( state.assigned >= state.duration ) {
				console.log( 'Time is up!' );
				state.votingOpen = false;
			}
		},
	},
} );
