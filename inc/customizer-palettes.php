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
        $surface    = get_theme_mod('surface_color', $defaults['surface']);
        $text       = get_theme_mod('text_color', $defaults['text']);

        return "
            :root {
                --color-primary: {$primary};
                --color-secondary: {$secondary};
                --color-accent: {$accent};
                --color-surface: {$surface};
                --color-bg-surface: {$surface};
                --color-text: {$text};
            }
        ";
    }
}
