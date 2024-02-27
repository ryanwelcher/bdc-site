/**
 * WordPress dependencies
 */
import { store, getContext, getElement } from '@wordpress/interactivity';
// import apiFetch from '@wordpress/api-fetch'; // Won't work.

const apiFetch = wp.apiFetch;
const { state, callbacks } = store( 'results', {
	state: {
		votes: [],
		totalVotes: 0,
	},
	actions: {
		determineWidth( votes ) {
			const {
				attributes: { 'data-count': count },
			} = getElement();
			return `${ ( count / state.totalVotes ) * 100 }%`;
		},
	},
	callbacks: {
		getVotes( overrideContext = null ) {
			const context = overrideContext ?? getContext();

			apiFetch( {
				path: '/bdc/v1/results',
				method: 'POST',
				data: { cid: context.conferenceId },
			} ).then( ( { status, data } ) => {
				const { totalVotes, votes } = data;
				const sorted = votes.sort(
					( a, b ) => parseFloat( b.count ) - parseFloat( a.count )
				);
				state.totalVotes = totalVotes;
				state.votes = sorted;
			} );
		},
		timeout() {
			const context = getContext();
			window.requestAnimationFrame( ( time ) => {
				if ( time > 2000 ) {
					console.log( 'getting that data	' );
					callbacks.getVotes( context );
				}
				window.requestAnimationFrame( callbacks.timeout );
			} );
			// const context = getContext();
			// window.requestAnimationFrame( () => {
			// 	callbacks.getVotes( context );
			// 	window.requestAnimationFrame( callbacks.getVotes( context ) );
			// } );
			// setInterval( () => {
			// 	callbacks.getVotes( context );
			// }, 3000 );
		},
	},
} );

const debugData = ( data ) => {
	console.log( JSON.parse( JSON.stringify( data ) ) );
};
