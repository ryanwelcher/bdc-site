/**
 * WordPress dependencies
 */
import { createRoot, render } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import apiFetch from '@wordpress/api-fetch';
import { useEffect, useState } from '@wordpress/element';

const ResultsScreen = ( { conference } ) => {
	const [ votes, setVotes ] = useState( [] );
	const [ totalVotes, setTotalVotes ] = useState( 0 );

	const getVotes = () => {
		console.log( 'fetching' );
		apiFetch( {
			path: '/bdc/v1/results',
		} ).then( ( { status, data } ) => {
			// console.log( { status, data } );
			const { totalVotes, votes } = data;
			const sorted = votes.sort(
				( a, b ) => parseFloat( b.votes ) - parseFloat( a.votes )
			);
			setTotalVotes( totalVotes );
			setVotes( sorted );
		} );
	};
	useEffect( () => {
		const interval = setInterval( () => {
			getVotes();
		}, 3000 );
		getVotes();
		return () => clearInterval( interval );
	}, [] );

	const determineWidth = ( votes, totalVotes ) =>
		( votes / totalVotes ) * 100;
	return (
		<div className="results">
			<ul>
				{ votes.map( ( { id, title, votes } ) => (
					<li className="vote-bar" key={ id }>
						<h3>{ title }</h3>
						<div className="vote-progress">
							<div
								className="vote-progress-inner"
								style={ {
									width: `${ determineWidth(
										votes,
										totalVotes
									) }%`,
								} }
							>
								{ `${ votes } Votes` }
							</div>
						</div>
					</li>
				) ) }
			</ul>
		</div>
	);
};

// Check if createRoot is available. This addresses if React 18 is available or not as 6.2 shipped with React 18.
domReady( () => {
	const rootEl = document.getElementById( 'results-display' );
	if ( createRoot ) {
		createRoot( document.getElementById( 'results-display' ) ).render(
			<ResultsScreen conference={ rootEl.dataset?.conference } />
		);
	} else {
		render(
			<ResultsScreen conference={ rootEl.dataset?.conference } />,
			document.getElementById( 'results-display' )
		);
	}
} );
