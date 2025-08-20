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
echo '</div>';


get_footer(); // ?	close </main>


// 
