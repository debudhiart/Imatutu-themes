<?php
/**
 * Builder Component: Heading
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

$prefix = get_query_var('component_prefix', '');
if (empty($prefix)) {
    return;
}

$text = get_theme_mod("{$prefix}_heading_text", 'Empowering Enterprise Operations');
$tag  = get_theme_mod("{$prefix}_heading_tag", 'h2');
$tag  = in_array($tag, array('h1', 'h2', 'h3', 'h4'), true) ? $tag : 'h2';
?>

<div class="builder-component component-heading">
    <<?php echo esc_attr($tag); ?> class="builder-heading-text">
        <?php echo esc_html($text); ?>
    </<?php echo esc_attr($tag); ?>>
    <div class="title-accent-bar left-align"></div>
</div>
