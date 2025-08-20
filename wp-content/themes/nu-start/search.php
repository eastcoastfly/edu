<?php
/**
 * 	Search Results Template
 */

// * the pattern is the pattern
$guides = [];
$return = '';

$guides['search-page'] = '
<div class="main-heading-search">
	<h1>Search</h1>
</div>

<div class="blocks--wrapper">

	<div class="search-results-info">
		%1$s
		%2$s
	</div>
';

$page = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$ppp = get_query_var('posts_per_page');
$end = $ppp * $page;
$start = $end - $ppp + 1;
$total = $wp_query->found_posts;

get_header(); // ?	open <main>

// * If the user hasn't entered anything in the search box
if( empty( get_search_query() ) ){
	$result_summary = '<p class="search-error">Oops! Please enter a search term above.</p>';
}

else if ($total > 0 ){
	$result_summary = '<p class="returned-results">Your search for "'.get_search_query().'" returned '.$total.' results.</p>
	<p class="results-range">Displaying results '.$start.' to '.$end.'</p>'; 
}

// * Else zero results
else {
	$result_summary = '<p class="returned-results">Sorry, that search term did not return any results.</p><p class="results-range">Please try a different keyword.</p>';
}

echo sprintf(
	$guides['search-page'],
	get_search_form( ['echo' => false] ),
	$result_summary
);

echo nu__get_search_results();

echo '</div>';


get_footer(); // ?	close </main>


// 
?>