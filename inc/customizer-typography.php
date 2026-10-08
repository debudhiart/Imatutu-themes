<?php
/**
 * Typography Engine & Curated Google Fonts Loader
 *
 * @package Imatutu
 * @version 2.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('imatutu_get_curated_fonts')) {
    function imatutu_get_curated_fonts() {
        return array(
            'Plus Jakarta Sans' => 'Plus Jakarta Sans (Modern Corporate - Default)',
            'Inter'             => 'Inter (Clean & Highly Readable)',
            'Outfit'            => 'Outfit (Modern Tech & Geometry)',
            'Poppins'           => 'Poppins (Friendly & Solid)',
            'Roboto'            => 'Roboto (Standard Enterprise)',
            'Montserrat'        => 'Montserrat (Classic Corporate)',
            'System'            => 'System Default (Zero HTTP Request - Fast)',
        );
    }
}

if (!function_exists('imatutu_enqueue_dynamic_fonts')) {
    function imatutu_enqueue_dynamic_fonts() {
        $body_font    = get_theme_mod('typo_body_font', 'Plus Jakarta Sans');
        $heading_font = get_theme_mod('typo_heading_font', 'Plus Jakarta Sans');

        $fonts_to_load = array_unique(array($body_font, $heading_font));
        $query_chunks  = array();

        foreach ($fonts_to_load as $font) {
            if ($font === 'System') {
                continue;
            }
            $formatted = str_replace(' ', '+', trim($font));
            $query_chunks[] = 'family=' . $formatted . ':ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600';
        }

        if (!empty($query_chunks)) {
            $font_url = 'https://fonts.googleapis.com/css2?' . implode('&', $query_chunks) . '&display=swap';
            wp_enqueue_style('imatutu-google-fonts', $font_url, array(), null);
        }
    }
}
add_action('wp_enqueue_scripts', 'imatutu_enqueue_dynamic_fonts', 2);
add_action('enqueue_block_editor_assets', 'imatutu_enqueue_dynamic_fonts', 2);

if (!function_exists('imatutu_get_typography_css')) {
    function imatutu_get_typography_css() {
        $body_font    = get_theme_mod('typo_body_font', 'Plus Jakarta Sans');
        $heading_font = get_theme_mod('typo_heading_font', 'Plus Jakarta Sans');
        $base_size    = get_theme_mod('typo_base_size', '16');

        $body_stack    = ($body_font === 'System') ? 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : "'{$body_font}', sans-serif";
        $heading_stack = ($heading_font === 'System') ? 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif' : "'{$heading_font}', sans-serif";

        return "
            :root {
                --font-main: {$body_stack};
                --font-heading: {$heading_stack};
                --body-size: {$base_size}px;
            }
            body {
                font-family: var(--font-main);
                font-size: var(--body-size);
            }
            h1, h2, h3, h4, h5, h6, .brand-text, .section-title, .hero-title, .bento-card-title {
                font-family: var(--font-heading);
            }
        ";
    }
}
