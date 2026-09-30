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

$text   = get_theme_mod("{$prefix}_heading_text", 'Empowering Enterprise Operations');
$tag    = get_theme_mod("{$prefix}_heading_tag", 'h2');
$tag    = in_array($tag, array('h1', 'h2', 'h3', 'h4'), true) ? $tag : 'h2';
$align  = get_theme_mod("{$prefix}_heading_align", 'left');
$accent = get_theme_mod("{$prefix}_heading_accent", true);

$align_class = ($align === 'center') ? 'text-center' : (($align === 'right') ? 'text-right' : 'text-left');
$bar_align   = ($align === 'center') ? 'center-align' : (($align === 'right') ? 'right-align' : 'left-align');
?>

<div class="builder-component component-heading <?php echo esc_attr($align_class); ?>">
    <<?php echo esc_attr($tag); ?> class="builder-heading-text">
        <?php echo esc_html($text); ?>
    </<?php echo esc_attr($tag); ?>>
    <?php if ($accent) : ?>
        <div class="title-accent-bar <?php echo esc_attr($bar_align); ?>"></div>
    <?php endif; ?>
</div>
