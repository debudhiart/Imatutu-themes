<?php
/**
 * Builder Component: Form (WPForms / Contact Form 7 Shortcode)
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

$shortcode  = get_theme_mod("{$prefix}_form_shortcode", '');
$card_style = get_theme_mod("{$prefix}_form_card_style", true);
$wrap_class = $card_style ? 'builder-form-card' : 'builder-form-clean';
?>

<div class="builder-component component-form">
    <div class="<?php echo esc_attr($wrap_class); ?>">
        <?php if (!empty($shortcode)) : ?>
            <div class="form-render-area">
                <?php echo do_shortcode(wp_kses_post($shortcode)); ?>
            </div>
        <?php else : ?>
            <div class="builder-form-placeholder">
                <div class="placeholder-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <h4 class="placeholder-title"><?php esc_html_e('Contact & Inquiry Form', 'imatutu'); ?></h4>
                <p class="placeholder-text"><?php esc_html_e('Add your WPForms or Contact Form 7 shortcode in Customizer to render here.', 'imatutu'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
