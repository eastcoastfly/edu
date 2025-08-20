<?php

/**
 * 	Default Page Template
 *
 *
 * 	notes:
 * 		- this is super bare bones on purpose
 * 		- we should make some named templates for experimenting
 *
 */
//

// * the pattern is the pattern
$guides = [];
$return = '';

get_header(); // ?	open <main>


echo '<div class="blocks--wrapper">';
the_content();
$reuse_block = get_post( 358 ); // Pre Footer
$reuse_block_content = apply_filters( 'the_content', $reuse_block->post_content);
echo $reuse_block_content;
echo '</div>';


get_footer(); // ?	close </main>


