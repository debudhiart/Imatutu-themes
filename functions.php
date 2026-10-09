<?php
/**
 * Imatutu Theme Functions and Definitions
 * Architecture: Hybrid Theme with Native Gutenberg Block Patterns
 *
 * @package Imatutu
 * @version 2.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('IMATUTU_VERSION', '2.3.0');
define('IMATUTU_DIR', get_template_directory());
define('IMATUTU_URI', get_template_directory_uri());

/**
 * Theme Setup: Registrasi fitur core WordPress
 */
function imatutu_setup() {
    load_theme_textdomain('imatutu', IMATUTU_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Kustomisasi Logo
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 280,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Navigasi Menu
    register_nav_menus(array(
        'primary' => esc_html__('Primary Navigation', 'imatutu'),
        'footer'  => esc_html__('Footer Navigation', 'imatutu'),
    ));

    // Dukungan Gutenberg & Block Styles
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');
    add_editor_style(array('assets/css/main.css', 'assets/css/editor-style.css'));

    // Palet Warna Dinamis untuk Block Editor & Gutenberg
    $current_preset = get_theme_mod('color_preset', 'pertamina_blue');
    $palettes       = function_exists('imatutu_get_color_palettes') ? imatutu_get_color_palettes() : array();
    $defaults       = isset($palettes[$current_preset]) ? $palettes[$current_preset] : array('primary' => '#1559ED', 'secondary' => '#0B192C', 'accent' => '#E21F23', 'surface' => '#FFFFFF', 'text' => '#1E293B');

    $pri = get_theme_mod('primary_color', $defaults['primary']);
    $sec = get_theme_mod('secondary_color', $defaults['secondary']);
    $acc = get_theme_mod('accent_color', $defaults['accent']);
    $txt = get_theme_mod('text_color', isset($defaults['text']) ? $defaults['text'] : '#1E293B');
    $srf = get_theme_mod('surface_color', isset($defaults['surface']) ? $defaults['surface'] : '#FFFFFF');

    add_theme_support('editor-color-palette', array(
        array(
            'name'  => esc_html__('Primary Brand', 'imatutu'),
            'slug'  => 'primary',
            'color' => $pri,
        ),
        array(
            'name'  => esc_html__('Secondary Brand', 'imatutu'),
            'slug'  => 'secondary',
            'color' => $sec,
        ),
        array(
            'name'  => esc_html__('Accent Color', 'imatutu'),
            'slug'  => 'accent',
            'color' => $acc,
        ),
        array(
            'name'  => esc_html__('Body Text', 'imatutu'),
            'slug'  => 'text',
            'color' => $txt,
        ),
        array(
            'name'  => esc_html__('Surface / Background', 'imatutu'),
            'slug'  => 'surface',
            'color' => $srf,
        ),
    ));
}
add_action('after_setup_theme', 'imatutu_setup');

/**
 * Enqueue Frontend Scripts & Styles
 */
function imatutu_scripts() {
    // Main Stylesheet
    wp_enqueue_style(
        'imatutu-main',
        IMATUTU_URI . '/assets/css/main.css',
        array(),
        IMATUTU_VERSION
    );

    // Dynamic Color & Typography Customizer CSS
    $color_css = function_exists('imatutu_get_color_css') ? imatutu_get_color_css() : '';
    $typo_css  = function_exists('imatutu_get_typography_css') ? imatutu_get_typography_css() : '';
    $custom_css = $color_css . $typo_css;
    if (!empty($custom_css)) {
        wp_add_inline_style('imatutu-main', $custom_css);
    }

    // Main JavaScript
    wp_enqueue_script(
        'imatutu-main-js',
        IMATUTU_URI . '/assets/js/main.js',
        array(),
        IMATUTU_VERSION,
        true
    );

    // Fastbots AI Chatbot Integration (Disabled inside Customizer preview to prevent iframe blocking)
    if (!is_customize_preview()) {
        $fastbots_id = get_theme_mod('imatutu_chatbot_id', get_theme_mod('fastbots_bot_id', 'cm8gjb24m11rmrik59ko46vdi'));
        if (!empty($fastbots_id)) {
            wp_enqueue_script(
                'fastbots-chatbot',
                'https://app.fastbots.ai/embed.js',
                array(),
                null,
                array('strategy' => 'defer', 'in_footer' => true)
            );
            wp_script_add_data('fastbots-chatbot', 'data-bot-id', esc_attr($fastbots_id));
        }
    }
}
add_action('wp_enqueue_scripts', 'imatutu_scripts');

/**
 * Enqueue Dynamic Color & Typography Styles into Gutenberg Block Editor
 * Ensures Patterns, Gutenberg blocks, and WPForms previews reflect global settings in real-time
 */
function imatutu_block_editor_assets() {
    $color_css = function_exists('imatutu_get_color_css') ? imatutu_get_color_css() : '';
    $typo_css  = function_exists('imatutu_get_typography_css') ? imatutu_get_typography_css() : '';
    $custom_css = $color_css . $typo_css;

    if (!empty($custom_css)) {
        wp_register_style('imatutu-editor-dynamic', false);
        wp_enqueue_style('imatutu-editor-dynamic');
        wp_add_inline_style('imatutu-editor-dynamic', $custom_css);
    }
}
add_action('enqueue_block_editor_assets', 'imatutu_block_editor_assets', 10);


/**
 * Remove X-Frame-Options in Customizer preview to avoid iframe blocks on strict hosting servers (Plesk/Nginx)
 */
function imatutu_customize_frame_options() {
    if (is_customize_preview()) {
        header_remove('X-Frame-Options');
    }
}
add_action('send_headers', 'imatutu_customize_frame_options');

/**
 * Fallback menu when no WordPress menu is assigned yet
 */
if (!function_exists('imatutu_default_primary_menu')) {
    function imatutu_default_primary_menu() {
        $menu_items = array(
            array('title' => 'Home', 'url' => home_url('/')),
            array('title' => 'About Us', 'url' => home_url('/about-us/')),
            array('title' => 'Careers', 'url' => home_url('/careers/')),
            array('title' => 'Gallery', 'url' => home_url('/gallery/')),
            array('title' => 'Contact Us', 'url' => home_url('/contact-us/')),
        );

        echo '<ul class="nav-menu" id="primary-menu">';
        foreach ($menu_items as $item) {
            $is_active = (is_front_page() && $item['title'] === 'Home') ? ' current-menu-item' : '';
            echo '<li class="menu-item' . esc_attr($is_active) . '">';
            echo '<a href="' . esc_url($item['url']) . '">' . esc_html($item['title']) . '</a>';
            echo '</li>';
        }
        echo '</ul>';
    }
}

/**
 * Fallback menu for footer
 */
if (!function_exists('imatutu_default_footer_menu')) {
    function imatutu_default_footer_menu() {
        $menu_items = array(
            array('title' => 'Home', 'url' => home_url('/')),
            array('title' => 'About Us', 'url' => home_url('/about-us/')),
            array('title' => 'Careers', 'url' => home_url('/careers/')),
            array('title' => 'Gallery', 'url' => home_url('/gallery/')),
            array('title' => 'Contact Us', 'url' => home_url('/contact-us/')),
        );

        echo '<ul class="footer-links-list">';
        foreach ($menu_items as $item) {
            echo '<li><a href="' . esc_url($item['url']) . '">' . esc_html($item['title']) . '</a></li>';
        }
        echo '</ul>';
    }
}

/**
 * Registrasi Kategori Block Pattern Tema
 */
function imatutu_register_pattern_categories() {
    $categories = array(
        'imatutu'              => array('label' => esc_html__('Imatutu Corporate Components', 'imatutu')),
        'imatutu-hero'         => array('label' => esc_html__('Imatutu: Hero & Headers', 'imatutu')),
        'imatutu-features'     => array('label' => esc_html__('Imatutu: Bento Grids & Features', 'imatutu')),
        'imatutu-social-proof' => array('label' => esc_html__('Imatutu: Social Proof & Clients', 'imatutu')),
        'imatutu-content'      => array('label' => esc_html__('Imatutu: Content, FAQ & Careers', 'imatutu')),
        'imatutu-cta'          => array('label' => esc_html__('Imatutu: CTA Banners', 'imatutu')),
        'imatutu-pages'        => array('label' => esc_html__('Imatutu: 1-Click Page Templates', 'imatutu')),
    );

    foreach ($categories as $slug => $args) {
        register_block_pattern_category($slug, $args);
    }
}
add_action('init', 'imatutu_register_pattern_categories');

/**
 * Memuat Modul Customizer Ramping (Hanya Pengaturan Global)
 */
require_once IMATUTU_DIR . '/inc/customizer.php';

/**
 * Memuat Panel Pengaturan Independen di Dashboard WordPress (wp-admin)
 * Solusi 100% stabil & hemat memori tanpa ketergantungan iframe Customizer
 */
require_once IMATUTU_DIR . '/inc/admin-settings.php';

