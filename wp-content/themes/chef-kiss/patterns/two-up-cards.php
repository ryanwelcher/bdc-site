<?php
/**
 * Title: Two Up Recipe Cards
 * Slug: chef-kiss/two-up-cards
 * Description: Displays recipes in a 2 column grid with no voting options.
 * Keywords: query
 * Block Types: core/query
 */

?>

<!-- wp:query {"queryId":3,"query":{"perPage":10,"pages":0,"offset":0,"order":"asc","orderBy":"meta_value_num","author":"","search":"","exclude":[],"sticky":"","inherit":true,"parents":[],"postType":"post","meta_query":{"queries":[{"id":"6b5aa7a0-be82-44e0-8135-5119f5ffc5f6","meta_key":"time","meta_value":"","meta_compare":""}]},"exclude_current":"chef-kiss//page"},"tagName":"main","namespace":"advanced-query-loop","align":"wide","layout":{"type":"default"}} -->
<main class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":2}} -->
<!-- wp:group {"style":{"border":{"radius":{"topLeft":"1rem","topRight":"0rem","bottomLeft":"0rem","bottomRight":"0rem"}},"spacing":{"margin":{"top":"0","bottom":"0"},"blockGap":"0"}},"backgroundColor":"background","className":"recipe-container","layout":{"type":"constrained"}} -->
<div class="wp-block-group recipe-container has-background-background-color has-background" style="border-top-left-radius:1rem;border-top-right-radius:0rem;border-bottom-left-radius:0rem;border-bottom-right-radius:0rem;margin-top:0;margin-bottom:0"><!-- wp:chef-kiss/hat /-->

<!-- wp:post-title {"isLink":true,"style":{"spacing":{"padding":{"top":"1rem","bottom":"0","left":"2rem","right":"2rem"}},"typography":{"lineHeight":"1"}}} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0","padding":{"right":"2rem","left":"2rem"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group" style="padding-right:2rem;padding-left:2rem"><!-- wp:chef-kiss/level /-->

<!-- wp:chef-kiss/cooking-time /--></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"2rem","bottom":"2rem","left":"2rem","right":"2rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:2rem;padding-right:2rem;padding-bottom:2rem;padding-left:2rem"><!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":100,"style":{"typography":{"fontStyle":"normal","fontWeight":"400"}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph {"placeholder":"Add text or blocks that will display when a query returns no results."} -->
<p></p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></main>
<!-- /wp:query -->
