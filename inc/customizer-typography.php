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
            :root,
            .editor-styles-wrapper {
                --font-main: {$body_stack};
                --font-heading: {$heading_stack};
                --body-size: {$base_size}px;
            }
            body,
            .editor-styles-wrapper {
                font-family: var(--font-main);
                font-size: var(--body-size);
            }
            h1, h2, h3, h4, h5, h6,
            .brand-text,
            .section-title,
            .hero-title,
            .bento-card-title,
            .editor-styles-wrapper h1,
            .editor-styles-wrapper h2,
            .editor-styles-wrapper h3 {
                font-family: var(--font-heading);
            }

            /* ==============================================================
             * WPForms & Third-Party Forms Typography & Styling Harmonization
             * Safely integrates global fonts and colors without breaking layouts
             * ============================================================== */
            div.wpforms-container-full,
            div.wpforms-container,
            .wpforms-form {
                font-family: var(--font-main);
            }

            .wpforms-title {
                font-family: var(--font-heading) !important;
                color: var(--color-secondary, #0B192C) !important;
                font-weight: 700;
            }

            .wpforms-description {
                font-family: var(--font-main);
                font-size: calc(var(--body-size, 16px) * 0.9375);
                color: var(--color-text-muted, #64748B);
            }

            .wpforms-form .wpforms-field-label {
                font-family: var(--font-main) !important;
                font-size: calc(var(--body-size, 16px) * 0.9375);
                font-weight: 600;
                color: var(--color-secondary, #0B192C);
                margin-bottom: 6px;
            }

            .wpforms-form .wpforms-field-sublabel,
            .wpforms-form .wpforms-field-description {
                font-family: var(--font-main);
                font-size: calc(var(--body-size, 16px) * 0.8125);
                color: var(--color-text-muted, #64748B);
            }

            .wpforms-form input[type=text],
            .wpforms-form input[type=email],
            .wpforms-form input[type=tel],
            .wpforms-form input[type=url],
            .wpforms-form input[type=password],
            .wpforms-form input[type=number],
            .wpforms-form textarea,
            .wpforms-form select {
                font-family: var(--font-main) !important;
                font-size: var(--body-size, 16px) !important;
                line-height: 1.5;
                color: var(--color-text, #1E293B);
                border: 1px solid var(--color-border, #E2E8F0);
                border-radius: var(--radius-sm, 8px);
                transition: var(--transition, all 0.25s ease);
            }

            .wpforms-form input:focus,
            .wpforms-form textarea:focus,
            .wpforms-form select:focus {
                border-color: var(--color-primary) !important;
                outline: none;
                box-shadow: 0 0 0 3px color-mix(in srgb, var(--color-primary) 18%, transparent) !important;
            }

            div.wpforms-container-full .wpforms-form button[type=submit],
            .wpforms-container .wpforms-submit {
                font-family: var(--font-main) !important;
                font-size: var(--body-size, 16px) !important;
                font-weight: 700 !important;
                background-color: var(--color-primary) !important;
                color: #FFFFFF !important;
                border: 1px solid transparent !important;
                border-radius: var(--radius-full, 9999px) !important;
                padding: 0.75rem 2rem !important;
                cursor: pointer;
                transition: var(--transition, all 0.25s ease);
                box-shadow: var(--shadow-primary);
            }

            div.wpforms-container-full .wpforms-form button[type=submit]:hover,
            .wpforms-container .wpforms-submit:hover {
                background-color: var(--color-primary-dark) !important;
                color: #FFFFFF !important;
                transform: translateY(-2px);
                box-shadow: 0 12px 28px -3px color-mix(in srgb, var(--color-primary) 40%, transparent) !important;
            }

            /* Preserve WPForms internal structure & error indicators */
            .wpforms-form .wpforms-field-label-inline {
                font-family: var(--font-main);
                font-weight: 400;
                font-size: calc(var(--body-size, 16px) * 0.9375);
            }
            label.wpforms-error {
                font-size: calc(var(--body-size, 16px) * 0.8125) !important;
                color: #DC2626 !important;
            }
        ";
    }
}
