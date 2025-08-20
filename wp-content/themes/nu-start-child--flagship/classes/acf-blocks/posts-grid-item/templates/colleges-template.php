<?php

/**
 *    Posts Grid Item --- Colleges and Schools
 *
 *    This template will render a single College/School item into the Posts Grid.
 *    - this is a "clickable area"
 */
//

$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);


// * Display the icon style if this option is checked in the Posts Grid CMS
//
if( ($gridOptions['display_fontawesome_icon']) && ($gridOptions['display_fontawesome_icon'] == true) ){
  
  $fontawesome_icon = !empty($fields['fontawesome_icon']) ? $fields['fontawesome_icon'] : '';
  
  $is_the_href_value = !empty($fields['custom_permalink_redirect']) ? $fields['custom_permalink_redirect'] : '';
  
  // * From class.posts-grid-item.php
  $grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);
  
  $guides['grid-item-college'] = '
    <li class="' . $grid_item_conditional_classes . ' fa-icon-style">
      <a class="contains-clickable-area" href="%1$s"%2$s%3$s></a>
        
        <div class="grid-item-content">
          %4$s
          %5$s
          %6$s
        </div>
    </li>
  ';
  //
  //
  $return .= sprintf(
    $guides['grid-item-college'],
    $is_the_href_value,
    $is_the_title_attribute,
    $is_the_target_attribute,
    $fontawesome_icon,
    $is_the_post_title,
    $is_the_post_excerpt
  );

} // end if($gridOptions['display_fontawesome_icon'] == true)

//
// * Otherwise display the standard view
//
else {

      
    // * Taken from original switch in class.posts-grid-item.php
    //
    $is_the_post_categories = '';
    $categories = get_the_terms($post->ID, 'category');
    if (!empty($categories) && !is_wp_error(($categories))) {
      $is_the_post_categories = '<p class="featured-tags">';
      foreach ($categories as $category) {
        $is_the_post_categories .= '<span>' . $category->name . '</span>';
      }
      $is_the_post_categories .= '</p>';
    }

    //
    $guides['grid-item-default'] = '
      <li class="' . $grid_item_conditional_classes . '">
        <a class="contains-clickable-area" href="%1$s"' . $is_the_target_attribute . '%2$s></a>
          %3$s
          <div class="grid-item-content">
            %7$s
            %4$s
          </div>
      </li>
    ';

    //
    $return .= sprintf(
      $guides['grid-item-default'],
      $is_the_href_value,
      $is_the_title_attribute,
      $is_the_cover_image,
      $is_the_post_title,
      $is_the_post_excerpt,
      $is_the_icon_element,
      //
      $is_the_post_categories
    );
}
