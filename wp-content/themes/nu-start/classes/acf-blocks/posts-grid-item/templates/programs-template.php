<?php
// 
// 
// 
$checkTerms = get_the_terms($post, 'nu_programs-categories');
$category = !empty($checkTerms) ? '<div class="program-category"><span>' . $checkTerms[0]->name . '</span></div>' : '';

// * From class.posts-grid-item.php
$pim_id = !empty($fields['pim_id']) ? $fields['pim_id'] : '';
$p_location = !empty($fields['program_location']) ? $fields['program_location'] : '';
$p_duration = !empty($fields['program_duration']) ? $fields['program_duration'] : '';
$p_study_options = !empty($fields['program_study_options']) ? $fields['program_study_options'] : '';

//
$basic_program_info = '';
if (!empty($p_location) || !empty($p_duration)) {
  $study_options = '';
  if (!empty($p_study_options)) {
    foreach ($p_study_options as $option) {
      $study_options .= '<span>' . $option['study_option'] . '</span>';
    }
  }
  $basic_program_info = sprintf(
    '<div class="basic-program-info">
      %1$s
      %2$s
      %3$s
    </div>',
    !empty($p_location) ? '<div class="location">' . $p_location . '</div>' : '',
    !empty($p_duration) ? '<div class="duration">' . $p_duration . '</div>' : '',
    !empty($p_study_options) ? '<div class="studyoptions"><div>' . $study_options . '</div></div>' : ''
  );
}


// * From class.posts-grid-item.php
$grid_item_conditional_classes = implode(' ', $grid_item_conditional_class_array);


$guides['grid-item-program'] = '
  <li class="' . $grid_item_conditional_classes . '">
    <a class="contains-clickable-area" href="%1$s"' . $is_the_target_attribute . '%2$s></a>
      %3$s
      <div class="grid-item-content">
        %7$s
        %4$s
        %5$s
        %6$s
        %8$s
      </div>
  </li>
';
// 
$return .= sprintf(
  $guides['grid-item-program'],
  $is_the_href_value,
  $is_the_title_attribute,
  $is_the_cover_image,
  $is_the_post_title,
  $is_the_post_excerpt,
  $is_the_icon_element,
  // 
  $category,
  $basic_program_info
);
