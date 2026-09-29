<?php
/**
 * Typography Engine & Google Fonts Loader
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue selected Google Fonts dynamically
 */
function imatutu_enqueue_dynamic_fonts() {
    $body_font    = get_theme_mod('typo_primary_font', 'Plus Jakarta Sans');
    $heading_font = get_theme_mod('typo_heading_font', 'Plus Jakarta Sans');

    $fonts_to_load = array_unique(array($body_font, $heading_font));
    $google_fonts  = array();

    foreach ($fonts_to_load as $font) {
        if ($font === 'System') {
            continue;
        }
        $formatted = str_replace(' ', '+', trim($font));
        $google_fonts[] = 'family=' . $formatted . ':ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600';
    }

    if (!empty($google_fonts)) {
        $font_query = implode('&', $google_fonts) . '&display=swap';
        wp_enqueue_style('imatutu-dynamic-google-fonts', 'https://fonts.googleapis.com/css2?' . $font_query, array(), null);
    }
}
add_action('wp_enqueue_scripts', 'imatutu_enqueue_dynamic_fonts', 5);

/**
 * Generate CSS rules for typography
 */
function imatutu_get_typography_css() {
    $body_font    = get_theme_mod('typo_primary_font', 'Plus Jakarta Sans');
    $heading_font = get_theme_mod('typo_heading_font', 'Plus Jakarta Sans');
    $h1_size      = get_theme_mod('typo_h1_size', 48);
    $h2_size      = get_theme_mod('typo_h2_size', 36);
    $h3_size      = get_theme_mod('typo_h3_size', 24);
    $body_size    = get_theme_mod('typo_body_size', 16);
    $line_height  = get_theme_mod('typo_body_line_height', 1.6);

    $body_fallback    = ($body_font === 'System') ? 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : "'{$body_font}', sans-serif";
    $heading_fallback = ($heading_font === 'System') ? 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : "'{$heading_font}', sans-serif";

    return "
        :root {
            --font-main: {$body_fallback};
            --font-heading: {$heading_fallback};
            --h1-size: {$h1_size}px;
            --h2-size: {$h2_size}px;
            --h3-size: {$h3_size}px;
            --body-size: {$body_size}px;
            --body-line-height: {$line_height};
        }
        body {
            font-family: var(--font-main);
            font-size: var(--body-size);
            line-height: var(--body-line-height);
        }
        h1, h2, h3, h4, h5, h6, .brand-text, .section-title, .hero-title {
            font-family: var(--font-heading);
        }
        .hero-title {
            font-size: var(--h1-size);
        }
        .section-title {
            font-size: var(--h2-size);
        }
        .service-title {
            font-size: var(--h3-size);
        }
    ";
}
