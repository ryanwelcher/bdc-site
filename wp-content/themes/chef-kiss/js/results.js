/**
 * WordPress dependencies
 */
import { createRoot, render } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import {
	useEntityProp,
	store as coreStore,
	useEntityRecords,
} from '@wordpress/core-data';

const ResultsScreen = ( { conference } ) => {
	const { records, isResolving } = useEntityRecords( 'taxonomy', 'votes' );
	if ( isResolving ) {
		return 'Loading...';
	}

	const votes = records.filter( ( vote ) => {} );
	return <div className="results">RESULTS</div>;
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
