<?php

/**
 *    Posts Grid Item --- News Item Template Type A
 *
 *    This template will render a single News item into the Posts Grid.
 *
 *    - this is a "clickable area" template
 */
//

$item_metadata = !empty($fields['publication_info']) ? $fields['publication_info'] : '';
$pub_date = !empty($item_metadata['date']) ? '<span class="date">' . DateTime::createFromFormat('Ymd', $item_metadata['date'])->format('M. d, Y') . '</span>' : '';
$pub_author = !empty($item_metadata['author']) ? '<span class="author">' . $item_metadata['author'] . '</span>' : '';
$pub_publisher = !empty($item_metadata['publisher']) ? '<span class="publisher"><em>' . $item_metadata['publisher'] . '</em></span>' : '';

$publication_string = sprintf(
  '<div class="publication-info">%1$s%2$s%3$s</div>',
  !empty($pub_date) ? $pub_date : '',
  !empty($pub_author) ? ' ' . $pub_author : '',
  !empty($pub_publisher) ? ' ' . $pub_publisher : '',
);

// * From class.posts-grid-item.php
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);

// // * Get the custom taxonomy for "tags"
// $news_tags = get_terms( array(
//   'taxonomy' => 'nu_news-tags',
//   'hide_empty' => true,
// ) );

// $news_tag_logos = '';
// $news_tags_array = [];
// if( !empty($news_tags) ){
// 	// * Strip out all whitespace from the tag name
// 	foreach ($news_tags as $news_tag){
// 		$news_tags_array[] = str_replace(' ','',$news_tag->name);
// 	}
// 	// * Place each tag name into its svg equivalent
// 	foreach($news_tags_array as $news_tag_item){
// 		$news_tag_logos .= '<img src="' . get_stylesheet_directory_uri() . '/assets/svg/' . $news_tag_item . '.svg" alt="'. $news_tag_item .' icon" />';
// 	}
// }

$news_tag_logos = [];
$news_tags = get_the_terms($post->ID, 'nu_news-tags');

if( !empty($news_tags) ){
	$news_tag_logos[] = '<img src="' . get_stylesheet_directory_uri() . '/assets/svg/' . $news_tags[0]->slug . '.svg" alt="'. $news_tags[0]->name .' icon" />';
}

$guides['grid-item-news'] = '
  <li class="' . $grid_item_conditional_classes . '">
    <a class="contains-clickable-area" href="%1$s"%2$s%3$s></a>
      %4$s
      <div class="grid-item-content">
        %5$s
        %6$s
        %7$s
        %8$s
        %9$s
      </div>
  </li>
';
//
//
$return .= sprintf(
  $guides['grid-item-news'],
  $is_the_href_value,
  $is_the_title_attribute,
  $is_the_target_attribute,
  $is_the_cover_image,
  !empty($news_tag_logos) ? $news_tag_logos[0]: '', // 5
  $is_the_post_title,
  $is_the_post_excerpt,
  $is_the_icon_element,
  //
  $publication_string
);

