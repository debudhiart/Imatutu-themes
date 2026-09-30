<?php
/**
 * Builder Component: Image
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

$image_url = get_theme_mod("{$prefix}_image_url", '');
$alt_text  = get_theme_mod("{$prefix}_image_alt", 'Imatutu Corporate Visual');
$ratio     = get_theme_mod("{$prefix}_image_ratio", 'auto');
$radius    = get_theme_mod("{$prefix}_image_radius", 'rounded-xl');
$link      = get_theme_mod("{$prefix}_image_link", '');
$lightbox  = get_theme_mod("{$prefix}_image_lightbox", true);

$frame_classes = array(
    'builder-image-frame',
    "ratio-{$ratio}",
    "radius-{$radius}",
);
?>

<div class="builder-component component-image">
    <?php if (!empty($image_url)) : ?>
        <div class="<?php echo esc_attr(implode(' ', $frame_classes)); ?>">
            <?php if (!empty($link)) : ?>
                <a href="<?php echo esc_url($link); ?>" class="builder-image-link" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text); ?>" class="builder-img" loading="lazy" />
                </a>
            <?php elseif ($lightbox) : ?>
                <a href="<?php echo esc_url($image_url); ?>" class="builder-lightbox-trigger" data-caption="<?php echo esc_attr($alt_text); ?>" title="<?php esc_attr_e('Click to view larger', 'imatutu'); ?>">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text); ?>" class="builder-img" loading="lazy" />
                    <span class="lightbox-zoom-icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                    </span>
                </a>
            <?php else : ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text); ?>" class="builder-img" loading="lazy" />
            <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="builder-image-placeholder">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            <span><?php esc_html_e('Upload image in Customizer', 'imatutu'); ?></span>
        </div>
    <?php endif; ?>
</div>
