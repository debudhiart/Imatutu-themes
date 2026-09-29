<?php
/**
 * Theme Color Palettes & Preset Definitions
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Returns available pre-defined color palettes
 */
function imatutu_get_color_palettes() {
    return array(
        'pertamina_blue' => array(
            'name'   => esc_html__('Pertamina Blue (Corporate)', 'imatutu'),
            'colors' => array('#1559ED', '#0B192C', '#E21F23', '#F8FAFC'),
            'values' => array(
                'primary'    => '#1559ED',
                'primary_h'  => '#0D45C2',
                'primary_l'  => '#EBF2FE',
                'secondary'  => '#0B192C',
                'accent'     => '#E21F23',
                'bg_main'    => '#FFFFFF',
                'bg_surface' => '#F8FAFC',
                'text_main'  => '#1E293B',
                'text_muted' => '#64748B',
                'border'     => '#E2E8F0',
            ),
        ),
        'executive_navy' => array(
            'name'   => esc_html__('Executive Midnight Navy', 'imatutu'),
            'colors' => array('#2563EB', '#030712', '#F59E0B', '#1E293B'),
            'values' => array(
                'primary'    => '#2563EB',
                'primary_h'  => '#1D4ED8',
                'primary_l'  => '#EFF6FF',
                'secondary'  => '#030712',
                'accent'     => '#F59E0B',
                'bg_main'    => '#FFFFFF',
                'bg_surface' => '#F1F5F9',
                'text_main'  => '#0F172A',
                'text_muted' => '#64748B',
                'border'     => '#CBD5E1',
            ),
        ),
        'emerald_enterprise' => array(
            'name'   => esc_html__('Emerald Eco Enterprise', 'imatutu'),
            'colors' => array('#059669', '#064E3B', '#10B981', '#F0FDF4'),
            'values' => array(
                'primary'    => '#059669',
                'primary_h'  => '#047857',
                'primary_l'  => '#ECFDF5',
                'secondary'  => '#064E3B',
                'accent'     => '#10B981',
                'bg_main'    => '#FFFFFF',
                'bg_surface' => '#F0FDF4',
                'text_main'  => '#0F172A',
                'text_muted' => '#475569',
                'border'     => '#DCFCE7',
            ),
        ),
        'minimal_slate' => array(
            'name'   => esc_html__('Modern Minimalist Slate', 'imatutu'),
            'colors' => array('#0F172A', '#334155', '#64748B', '#F8FAFC'),
            'values' => array(
                'primary'    => '#0F172A',
                'primary_h'  => '#1E293B',
                'primary_l'  => '#F1F5F9',
                'secondary'  => '#334155',
                'accent'     => '#64748B',
                'bg_main'    => '#FFFFFF',
                'bg_surface' => '#F8FAFC',
                'text_main'  => '#1E293B',
                'text_muted' => '#64748B',
                'border'     => '#E2E8F0',
            ),
        ),
    );
}

/**
 * Output dynamic CSS variables for theme colors
 */
function imatutu_get_color_css() {
    $preset_id = get_theme_mod('color_preset_active', 'pertamina_blue');
    $palettes  = imatutu_get_color_palettes();
    $defaults  = isset($palettes[$preset_id]) ? $palettes[$preset_id]['values'] : $palettes['pertamina_blue']['values'];

    $primary    = get_theme_mod('primary_color', $defaults['primary']);
    $primary_h  = get_theme_mod('color_primary_hover', $defaults['primary_h']);
    $primary_l  = isset($defaults['primary_l']) ? $defaults['primary_l'] : '#EBF2FE';
    $secondary  = get_theme_mod('secondary_color', $defaults['secondary']);
    $accent     = get_theme_mod('accent_color', $defaults['accent']);
    $bg_main    = get_theme_mod('color_bg_main', $defaults['bg_main']);
    $bg_surface = get_theme_mod('color_bg_surface', $defaults['bg_surface']);
    $text_main  = get_theme_mod('color_text_main', $defaults['text_main']);
    $text_muted = get_theme_mod('color_text_muted', $defaults['text_muted']);
    $border     = get_theme_mod('color_border', $defaults['border']);

    return "
        :root {
            --color-primary: " . esc_attr($primary) . ";
            --color-primary-dark: " . esc_attr($primary_h) . ";
            --color-primary-light: " . esc_attr($primary_l) . ";
            --color-secondary: " . esc_attr($secondary) . ";
            --color-accent: " . esc_attr($accent) . ";
            --color-bg: " . esc_attr($bg_main) . ";
            --color-bg-secondary: " . esc_attr($bg_surface) . ";
            --color-text: " . esc_attr($text_main) . ";
            --color-text-muted: " . esc_attr($text_muted) . ";
            --color-border: " . esc_attr($border) . ";
        }
    ";
}
