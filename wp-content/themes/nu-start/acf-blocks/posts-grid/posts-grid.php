<?php

/**
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
//


// Create id attribute allowing for custom "anchor" value.
$id = 'posts-grid--' . $block['id'];

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


?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classString); ?>">
	<?php $instance = new PostsGrid($block, $content, $is_preview, $post_id); ?>
</div>
