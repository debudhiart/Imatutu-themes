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
?>

<div class="builder-component component-image">
    <?php if (!empty($image_url)) : ?>
        <div class="builder-image-frame">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($alt_text); ?>" class="builder-img" loading="lazy" />
        </div>
    <?php else : ?>
        <div class="builder-image-placeholder">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            <span><?php esc_html_e('Upload image in Customizer', 'imatutu'); ?></span>
        </div>
    <?php endif; ?>
</div>
