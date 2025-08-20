<?php
/**
 *    Posts Grid Item --- Initiative Template Type A
 * 
 */
// 

$is_the_post_categories = '';
$categories = get_the_terms( $post->ID, $post->post_type . '-schools' );
if( !empty($categories) && !is_wp_error( ($categories) ) ){

	$is_the_post_categories = '<p class="featured-tags">';
	foreach( $categories as $category ){
		$term_fields = get_fields($category);
		if( !empty($term_fields) ){
			$associated_color = $term_fields['associated_color'];
			$is_the_post_categories .= '<span style="color:'.$associated_color.'">'.$category->name.'</span><br />';
		} else {
			$is_the_post_categories .= '<span>'.$category->name.'</span>';
		}
	}	
	$is_the_post_categories .= '</p>';
}

$guides['grid-item-initiatives'] = '
	<li class="'.$grid_item_conditional_classes.'">
		<a class="contains-clickable-area" href="%1$s"'.$is_the_target_attribute.'%2$s></a>
			%3$s
			<div class="grid-item-content">
				%7$s
				%4$s
				%5$s
				%6$s
			</div>
	</li>
';
// 
// 
$return .= sprintf(
	$guides['grid-item-initiatives'],
	$is_the_href_value,
	$is_the_title_attribute,
	$is_the_cover_image,
	$is_the_post_title,
	// $is_the_post_excerpt,
	get_the_content($post->ID),
	$is_the_icon_element,
	// 
	$is_the_post_categories
);

?>