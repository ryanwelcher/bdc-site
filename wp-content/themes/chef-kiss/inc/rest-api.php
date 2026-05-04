<?php
/**
 * REST API Endpoints
 *
 * @package ChefKiss\Endpoints
 */

namespace ChefKiss\Endpoints;

use WP_REST_Controller;

if ( ! function_exists( 'add_action' ) ) {
	return;
}

/**
 * Class to handle all of the requests from the front end.
 */
class BDC_REST_API extends WP_REST_Controller {

	const NAMESPACE = 'bdc/v1';

	/**
	 * Register the routes/
	 */
	public function register_routes() {
		register_rest_route(
			self::NAMESPACE,
			'/vote',
			array(
				array(
					'methods'             => \WP_REST_Server::CREATABLE,
					'callback'            => array( $this, 'register_vote' ),
					'permission_callback' => 'is_user_logged_in',
				),
			)
		);
		register_rest_route(
			self::NAMESPACE,
			'/results',
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'get_vote_results' ),
					'permission_callback' => '__return_true',
				),
			)
		);
	}


	/**
	 * Get the voting results for a given conference
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function get_vote_results( $request ) {
		$conference_id = $request['cid'];
		$rtn           = array(
			'totalVotes' => 0,
			'votes'      => array(),
		);

		// Fetch all vote terms in one query instead of one per recipe.
		$all_terms = get_terms(
			array(
				'taxonomy'   => 'votes',
				'hide_empty' => true,
				'number'     => 0,
			)
		);

		if ( is_wp_error( $all_terms ) || empty( $all_terms ) ) {
			return new \WP_REST_Response( array( 'status' => 'success', 'data' => $rtn ) );
		}

		// Filter to the requested conference when a cid is provided.
		if ( isset( $conference_id ) ) {
			$all_terms = array_filter(
				$all_terms,
				function ( $term ) use ( $conference_id ) {
					return str_contains( $term->name, "conference_{$conference_id}_" );
				}
			);
		}

		if ( empty( $all_terms ) ) {
			return new \WP_REST_Response( array( 'status' => 'success', 'data' => $rtn ) );
		}

		// Parse recipe IDs from term names (format: user_{uid}_conference_{cid}_recipe_{rid}).
		$votes_by_recipe = array();
		foreach ( $all_terms as $term ) {
			if ( preg_match( '/_recipe_(\d+)$/', $term->name, $matches ) ) {
				$recipe_id                      = (int) $matches[1];
				$votes_by_recipe[ $recipe_id ] = ( $votes_by_recipe[ $recipe_id ] ?? 0 ) + 1;
			}
		}

		if ( empty( $votes_by_recipe ) ) {
			return new \WP_REST_Response( array( 'status' => 'success', 'data' => $rtn ) );
		}

		// Fetch all recipe titles in a single query.
		$recipes = get_posts(
			array(
				'post_type'      => 'recipe',
				'post__in'       => array_keys( $votes_by_recipe ),
				'posts_per_page' => -1,
				'post_status'    => 'publish',
			)
		);

		$rtn['totalVotes'] = array_sum( $votes_by_recipe );

		foreach ( $recipes as $recipe ) {
			$rtn['votes'][] = array(
				'id'    => $recipe->ID,
				'title' => $recipe->post_title,
				'votes' => $votes_by_recipe[ $recipe->ID ],
			);
		}

		return new \WP_REST_Response(
			array(
				'status' => 'success',
				'data'   => $rtn,
			)
		);
	}

	/**
	 * Generate a vote for a recipe
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Response
	 */
	public function register_vote( $request ) {
		$user_id       = get_current_user_id();
		$conference_id = $request['conference_id'];
		$recipe_id     = $request['recipe_id'];
		$action        = $request['action'] ?? 'add';

		$rtn = false;

		// Return an error if ids are missing.
		if ( ! $conference_id || ! $recipe_id ) {
			return new \WP_Error( 'Missing Params', 'Requires: conference_id and recipe_id' );
		}

		// Generate the term name - we want to be able query for a count of terms for each recipe.
		$term_name = "user_{$user_id}_conference_{$conference_id}_recipe_{$recipe_id}";

		// Check the action and act accordingly.
		switch ( $action ) {
			case 'add':
				$rtn = $this->add_vote( $term_name, $recipe_id );
				break;
			case 'remove':
				$rtn = $this->remove_vote( $term_name, $recipe_id );
				break;
			default:
				return new \WP_Error( 'Unknown action', 'Must be either  "add" or "remove"' );
		}

		if ( ! is_wp_error( $rtn ) ) {
			return new \WP_REST_Response(
				array(
					'status' => 'success',
					'data'   => $rtn,
				)
			);
		} else {
			// Pass WP_Errors through.
			return $rtn;
		}
	}

	/**
	 * Add a vote for a recipe.
	 *
	 * @param {string}  $term_name The unique vote term name.
	 * @param {integer} $recipe_id The post ID of the recipe.
	 */
	private function add_vote( $term_name, $recipe_id ) {
		// Return early if the vote already exists — concurrent requests land here safely.
		$existing = get_term_by( 'name', $term_name, 'votes' );
		if ( $existing ) {
			return array( $existing->term_id );
		}
		return wp_set_object_terms( $recipe_id, $term_name, 'votes', true );
	}

	/**
	 * Remove a vote for a recipe.
	 *
	 * @param {string}  $term_name The unique vote term name.
	 * @param {integer} $recipe_id The post ID of the recipe.
	 */
	private function remove_vote( $term_name, $recipe_id ) {
		$term = get_term_by( 'name', $term_name, 'votes' );
		if ( ! $term ) {
			// Already removed — treat as success so concurrent removes don't error.
			return true;
		}
		return wp_delete_term( $term->term_id, 'votes' );
	}
}

// Register the endpoints.
add_action(
	'rest_api_init',
	function () {
		$controller = new BDC_REST_API();
		$controller->register_routes();
	}
);
