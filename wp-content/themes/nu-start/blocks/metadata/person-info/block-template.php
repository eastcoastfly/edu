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
$classes[] = 'person-info';

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
if ($blockFields['example-field'] == 'value') {
	// 
	// ... create or alter the $blockContentString
	// 
}


// 
// 
// 
$person = $postFields['person_metadata'];
$guides['person_info_section'] = '
	<div class="about">
		%1$s
		%2$s
	</div>
	<div class="contact">
		%3$s
		%4$s
	</div>
';
// 
// 
if ($blockFields['block_renders'] == 'contact' || $blockFields['block_renders'] == 'all') {
	$email = !empty($person['email']) ? '<p class="email"><a href="mailto:' . $person['email'] . '">' . $person['email'] . '</a></p>' : '';
	$phone = !empty($person['phone_number']) ? '<p class="phone-number"><a href="tel:' . $person['phone_number'] . '">' . $person['phone_number'] . '</a></p>' : '';
}
if ($blockFields['block_renders'] == 'titles' || $blockFields['block_renders'] == 'all') {
	$name = !empty($person['full_name']) ? '<h2 class="full-name">' . $person['full_name'] . '</h2>' : '';
	$title = !empty($person['primary_title']) ? '<p class="primary-title is-style-large">' . $person['primary_title'] . '</p>' : '';
}
// 
// ... create or alter the $blockContentString
// 
$blockContentString = sprintf(
	$guides['person_info_section'],
	$name,
	$title,
	$email,
	$phone
);




// 
?>

<div <?php echo $anchor; ?>class="<?php echo $classString; ?>">
	<?= $blockContentString; ?>
</div>