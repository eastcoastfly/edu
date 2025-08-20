<?php

/**
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
//


// Create id attribute allowing for custom "anchor" value.
$id = 'featured-ngn-stories-' . $block['id'];

if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

$classes = ['acf-block', 'posts-grid'];
if (!empty($block['className'])) {
	$classes = array_merge($classes, explode(' ', $block['className']));
}
if (!empty($block['align'])) {
	$classes[] = 'align' . $block['align'];
}
if (!empty($block['backgroundColor'])) {
	$classes[] = 'has-background';
	$classes[] = 'has-' . $block['backgroundColor'] . '-background-color';
}
if (!empty($block['textColor'])) {
	$classes[] = 'has-text-color';
	$classes[] = 'has-' . $block['textColor'] . '-color';
}

$classString = esc_attr(join(' ', $classes));
//
//
//		?		above this is just generic block stuff
//		?		below this is the specifics of the latest ngn stories


// 		try to fetch
$fetched = wp_safe_remote_get('https://news.northeastern.edu/wp-json/ngn/featured');
// $fetched = wp_safe_remote_get('https://testnunews.wpengine.com/wp-json/ngn/featured'); // 	!		this is just a test server


// 		if we fetched
if (!is_wp_error($fetched)) {
	// 		deconstruct relevant data
	$body = wp_remote_retrieve_body($fetched);
	// 		decode data into (array) for ease of use
	$json = json_decode($body, true);
}

// 	if we have NGN latest posts
if (!empty($json)) {

	$fields = get_fields();
	if (!empty($fields)) {
		$fields = $fields['featured_news_stories'];
	}

	$grid_item_conditional_classes = 'grid-item nu_news ngn-story has-layout-vertical has-square-cover-image';

	$guides['ngn-story'] = '
		<li class="' . $grid_item_conditional_classes . '">
			<a class="contains-clickable-area" href="%1$s"%2$s></a>
				<figure><img src="%3$s" /></figure>
				<div class="grid-item-content">
					%4$s
					%5$s
					%6$s
					%7$s
				</div>
		</li>
	';

	//	*		starting here we are building an interim view

	$itemTeasers = '';
	foreach ($json['posts'] as $ngn_story) {
		//
		$now = new DateTime($ngn_story['publish_date']);																			// 	convert ISO 8601 into UTC
		$date = $now->format('F d, Y');																												//	format UTC into readable format
		$author = 'by ' . $ngn_story['author_name'];																					// 	complete author string

		$publicationString = sprintf(
			'<div class="publication-info">%1$s%2$s</div>',		//		the original guide string for pubinfo from the news post type
			!empty($fields['show_byline']) ? '<span class="author">' . $author . '</span>' : '',
			!empty($fields['show_date']) ? '<span class="date">' . $date . '</span>' : '',
		);

		//


		$itemTeasers .= sprintf(
			$guides['ngn-story'],
			$ngn_story['post_url'],
			' target="_blank"',
			$ngn_story['post_media']['large'],
			!empty($ngn_story['section_badge']) ? '<img class="ngn-story-badge" src="' . $ngn_story['section_badge'] . '" alt="the ' . $ngn_story['section_title'] . ' badge" />' : '',
			'<div class="headline">' . $ngn_story['headline'] . '</div>',		// these two are switched - our "headline" field is the real "excerpt" etc.
			!empty($fields['show_excerpt']) ? '<div class="excerpt">' . $ngn_story['excerpt'] . '</div>' : '',			// these two are switched - our "headline" field is the real "excerpt" etc.
			!empty($fields['show_date']) || !empty($fields['show_byline']) ? $publicationString : ''
		);
	}


	$return = '<div class="nu-block-featured-ngn-stories nu__grid cols-4"><ul>' . $itemTeasers . '</ul></div>';

	//		this ends our check if we have successfully fetched
}

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classString); ?>">
	<?php echo $return; ?>
</div>
