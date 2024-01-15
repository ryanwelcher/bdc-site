/**
 * WordPress dependencies
 */
import { createRoot, render } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';

const ResultsScreen = () => {
	return <div className="results">RESULTS</div>;
};

// Check if createRoot is available. This addresses if React 18 is available or not as 6.2 shipped with React 18.
domReady( () => {
	if ( createRoot ) {
		createRoot( document.getElementById( 'results-display' ) ).render(
			<ResultsScreen />
		);
	} else {
		render(
			<ResultsScreen />,
			document.getElementById( 'results-display' )
		);
	}
} );
