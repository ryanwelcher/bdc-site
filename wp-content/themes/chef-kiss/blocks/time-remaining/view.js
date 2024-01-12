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
		get conferenceId() {
			return state.conference;
		},
	},
	callbacks: {
		watchTime: () => {
			if ( state.assigned >= state.duration ) {
				state.votingOpen = false;
			}
		},
	},
} );
