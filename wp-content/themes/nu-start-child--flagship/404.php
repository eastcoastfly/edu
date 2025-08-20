<?php
/**
 *
 */
//

// * the pattern is the pattern
$guides = [];
$return = '';
$guides['404-section'] = '
	<div class="is-the-404-section">
		%1$s
		%2$s
		%3$s
	</div>
';

$current_url = $_SERVER['REQUEST_URI'];

$error_message = '<p class="is-style-large">The page you\'re looking for has moved or no longer exists.</p>';
$suggested_message = '<p class="has-14-20-font-size">Try searching the site to find related information.</p>';
$search_form = get_search_form( ['echo' => false] );

$return = sprintf(
	$guides['404-section'],
	$error_message,
	$suggested_message,
	$search_form
);


get_header(); // ?	open <main>



echo '<div class="blocks--wrapper">';
echo $return;
$reuse_block = get_post( 358 ); // Pre Footer
$reuse_block_content = apply_filters( 'the_content', $reuse_block->post_content);
echo $reuse_block_content;
echo '</div>';



get_footer(); // ?	close </main>


//
?>
