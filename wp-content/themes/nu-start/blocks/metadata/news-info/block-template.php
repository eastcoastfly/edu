<?php

/**
 * 
 */
// 
// 

// prepare the final output string - maybe sub-strings needed if complexity is high
$blockContentString = '';
// grab the posts fields as well, we may need them
$postFields = get_fields($post_id);
// grab the block fields
$blockFields = get_fields();

// get an array of the basic classes we need from common block attributes
$classes = return_acf_block_base_css_classes_array($block);

// 
// add this blocks name as a class
// 
$classes[] = 'news-info';

// Support custom "anchor" values.
$anchor = '';
if (!empty($block['anchor'])) {
	$anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}


// 
// an example custom class attached to a custom field value
// 
if (!empty($blockFields['example-field'])) {
	$classes[] = 'enables-this-custom-class';
}

// 
// join the classes array into a string of classes separated by spaces ( no spaces before or after )
// 
$classString = esc_attr(join(' ', $classes));


// 
// 
// 
// if ($blockFields['example-field'] == 'value') {
	// 
	// ... create or alter the $blockContentString
	// 
// }

// ? if type is selected, the block renders the single-selected term of the "type" taxonomy - borrowed logic markup from the teaser
if ($blockFields['block_renders'] == 'type' ) {
	global $post;
	$checkTerms = get_the_terms($post, 'nu_news-categories');
	$news_item_type = !empty($checkTerms) ? '<div class="news-item-category">' . $checkTerms[0]->name . '</div>' : '';
	$blockContentString = sprintf(
		'%1$s',
		$news_item_type
	);
}

if ($blockFields['block_renders'] == 'pubdate' && !empty($postFields['publication_info']['date'])) {
	$blockContentString = '<p class="pubdate">' . DateTime::createFromFormat('Ymd', $postFields['publication_info']['date'])->format('M. d, Y') . '</p>';
}

if ($blockFields['block_renders'] == 'author' && !empty($postFields['publication_info']['author'])) {
	$blockContentString = '<p class="author">' . $postFields['publication_info']['author'] . '</p>';
}

if ($blockFields['block_renders'] == 'all' ) {
	global $post;
	$checkTerms = get_the_terms($post, 'nu_news-categories');
	$news_item_type = !empty($checkTerms) ? '<div class="news-item-category">' . $checkTerms[0]->name . '</div>' : '';
	$blockContentString .= sprintf(
		'%1$s',
		$news_item_type
	);
	$blockContentString .= '<p class="pubdate">' . DateTime::createFromFormat('Ymd', $postFields['publication_info']['date'])->format('M. d, Y') . '</p>';
	$blockContentString .= '<p class="author">' . $postFields['publication_info']['author'] . '</p>';

}


// 
?>

<div <?php echo $anchor; ?>class="<?php echo $classString; ?>">
	<?= $blockContentString; ?>
</div>