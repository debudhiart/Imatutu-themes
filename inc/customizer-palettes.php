<?php
/**
 * Color Presets & Dynamic CSS Engine
 *
 * @package Imatutu
 * @version 2.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('imatutu_get_color_palettes')) {
    function imatutu_get_color_palettes() {
        return array(
            'pertamina_blue' => array(
                'name'      => esc_html__('Pertamina Blue (Default Corporate)', 'imatutu'),
                'primary'   => '#1559ED',
                'secondary' => '#0B192C',
                'accent'    => '#E21F23',
                'surface'   => '#F8FAFC',
                'text'      => '#1E293B',
            ),
            'executive_navy' => array(
                'name'      => esc_html__('Executive Midnight Navy', 'imatutu'),
                'primary'   => '#2563EB',
                'secondary' => '#030712',
                'accent'    => '#F59E0B',
                'surface'   => '#F1F5F9',
                'text'      => '#0F172A',
            ),
            'emerald_eco' => array(
                'name'      => esc_html__('Emerald Eco Enterprise', 'imatutu'),
                'primary'   => '#059669',
                'secondary' => '#064E3B',
                'accent'    => '#10B981',
                'surface'   => '#F0FDF4',
                'text'      => '#0F172A',
            ),
            'minimal_slate' => array(
                'name'      => esc_html__('Minimalist Modern Slate', 'imatutu'),
                'primary'   => '#0F172A',
                'secondary' => '#334155',
                'accent'    => '#64748B',
                'surface'   => '#F8FAFC',
                'text'      => '#1E293B',
            ),
        );
    }
}

if (!function_exists('imatutu_get_color_css')) {
    function imatutu_get_color_css() {
        $preset_key = get_theme_mod('color_preset', 'pertamina_blue');
        $palettes   = imatutu_get_color_palettes();
        $defaults   = isset($palettes[$preset_key]) ? $palettes[$preset_key] : $palettes['pertamina_blue'];

        $primary    = get_theme_mod('primary_color', $defaults['primary']);
        $secondary  = get_theme_mod('secondary_color', $defaults['secondary']);
        $accent     = get_theme_mod('accent_color', $defaults['accent']);
        $surface    = get_theme_mod('surface_color', isset($defaults['surface']) ? $defaults['surface'] : '#FFFFFF');
        $text       = get_theme_mod('text_color', isset($defaults['text']) ? $defaults['text'] : '#1E293B');

        // Helper: Convert HEX to comma-separated RGB values for rgba() fallbacks
        $hex_to_rgb = function($hex, $default = '21, 89, 237') {
            $hex = ltrim($hex, '#');
            if (strlen($hex) === 3) {
                $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
                return "{$r}, {$g}, {$b}";
            } elseif (strlen($hex) === 6) {
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                return "{$r}, {$g}, {$b}";
            }
            return $default;
        };

        $primary_rgb   = $hex_to_rgb($primary, '21, 89, 237');
        $secondary_rgb = $hex_to_rgb($secondary, '11, 25, 44');
        $accent_rgb    = $hex_to_rgb($accent, '226, 31, 35');

        return "
            :root,
            .editor-styles-wrapper {
                /* Core Theme Custom Properties */
                --color-primary: {$primary};
                --color-primary-rgb: {$primary_rgb};
                --color-primary-dark: color-mix(in srgb, var(--color-primary) 80%, #000000);
                --color-primary-light: color-mix(in srgb, var(--color-primary) 12%, #FFFFFF);
                
                --color-secondary: {$secondary};
                --color-secondary-rgb: {$secondary_rgb};
                --color-secondary-light: color-mix(in srgb, var(--color-secondary) 85%, #FFFFFF);
                
                --color-accent: {$accent};
                --color-accent-rgb: {$accent_rgb};
                
                --color-surface: {$surface};
                --color-bg-surface: {$surface};
                --color-text: {$text};

                --shadow-primary: 0 10px 25px -3px rgba({$primary_rgb}, 0.35);

                /* WordPress Core Gutenberg Block Presets */
                --wp--preset--color--primary: {$primary};
                --wp--preset--color--secondary: {$secondary};
                --wp--preset--color--accent: {$accent};
                --wp--preset--color--surface: {$surface};
                --wp--preset--color--text: {$text};
            }

            /* Legacy Fallbacks without color-mix */
            @supports not (color: color-mix(in srgb, red, blue)) {
                :root, .editor-styles-wrapper {
                    --color-primary-dark: rgba({$primary_rgb}, 0.88);
                    --color-primary-light: rgba({$primary_rgb}, 0.08);
                    --color-secondary-light: rgba({$secondary_rgb}, 0.85);
                }
            }

            /* Synchronize Gutenberg Core Block Utility Classes */
            .has-primary-color { color: var(--color-primary) !important; }
            .has-primary-background-color { background-color: var(--color-primary) !important; }
            .has-secondary-color { color: var(--color-secondary) !important; }
            .has-secondary-background-color { background-color: var(--color-secondary) !important; }
            .has-accent-color { color: var(--color-accent) !important; }
            .has-accent-background-color { background-color: var(--color-accent) !important; }

            /* Direct Pattern Bindings for Universal Parity */
            .hero-section,
            .bento-card-large {
                background: linear-gradient(135deg, var(--color-secondary) 0%, var(--color-primary) 100%) !important;
            }
            .bento-glass-card {
                background: linear-gradient(135deg, rgba({$secondary_rgb}, 0.95), rgba({$primary_rgb}, 0.9)) !important;
            }
            .cta-glow-box {
                background-color: var(--color-secondary) !important;
            }
            .cta-glow-backdrop {
                background: radial-gradient(circle, rgba({$primary_rgb}, 0.45) 0%, rgba({$secondary_rgb}, 0) 70%) !important;
            }
            .bento-icon-wrap,
            .career-dept {
                background-color: var(--color-primary-light) !important;
                color: var(--color-primary) !important;
            }
            .badge-glow {
                background-color: var(--color-accent) !important;
                box-shadow: 0 0 10px var(--color-accent) !important;
            }
            .title-accent-bar {
                background: var(--color-primary) !important;
            }
            .hero-split-title,
            .bento-card-title,
            .service-title {
                color: var(--color-secondary) !important;
            }
            .service-tag,
            .bento-number,
            .service-link {
                color: var(--color-primary) !important;
            }
            .service-card:hover .service-icon-box {
                background: var(--color-primary) !important;
            }
            .service-card:hover {
                border-color: rgba({$primary_rgb}, 0.35) !important;
            }
        ";
    }
}
