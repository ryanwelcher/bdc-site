/**
 * WordPress dependencies
 */
import { createRoot, render, useEffect, useState } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import apiFetch from '@wordpress/api-fetch';
import { _n } from '@wordpress/i18n';

const ResultsScreen = ( { conference } ) => {
	const [ votes, setVotes ] = useState( [] );
	const [ totalVotes, setTotalVotes ] = useState( 0 );

	const getVotes = ( conference ) => {
		apiFetch( {
			path: `/bdc/v1/results${ conference ? `?cid=${ conference }` : '' }`,
		} ).then( ( { status, data } ) => {
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
			getVotes( conference );
		}, 3000 );
		getVotes( conference );
		return () => clearInterval( interval );
	}, [] );

	const determineWidth = ( votes, totalVotes ) =>
		( votes / totalVotes ) * 100;
	return (
		<div className="results">
			<ul className="vote-container">
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
								<span className="vote-count-text">
									{ _n(
										`${ votes } vote`,
										`${ votes } votes`,
										votes
									) }
								</span>
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
	createRoot( document.getElementById( 'results-display' ) ).render(
		<ResultsScreen conference={ rootEl.dataset?.cid } />
	);
} );
