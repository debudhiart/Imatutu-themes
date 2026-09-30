<?php
/**
 * Builder Component: CTA Button
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

$btn_text   = get_theme_mod("{$prefix}_btn_text", 'Get Started Today');
$btn_url    = get_theme_mod("{$prefix}_btn_url", 'https://imatutu.com/contact-us/');
$btn_style  = get_theme_mod("{$prefix}_btn_style", 'primary');
$btn_size   = get_theme_mod("{$prefix}_btn_size", 'md');
$btn_target = get_theme_mod("{$prefix}_btn_target", false);

$btn_classes = array(
    'btn',
    "btn-{$btn_style}",
    "btn-size-{$btn_size}",
    'builder-btn',
);

$target_attr = $btn_target ? ' target="_blank" rel="noopener noreferrer"' : '';
?>

<div class="builder-component component-button">
    <a href="<?php echo esc_url($btn_url); ?>" class="<?php echo esc_attr(implode(' ', $btn_classes)); ?>"<?php echo $target_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
        <span class="btn-text-label"><?php echo esc_html($btn_text); ?></span>
        <svg class="btn-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
    </a>
</div>
