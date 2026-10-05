<?php
/**
 * Imatutu Theme Functions and Definitions
 * Architecture: Hybrid Theme with Native Gutenberg Block Patterns
 *
 * @package Imatutu
 * @version 2.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('IMATUTU_VERSION', '2.2.0');
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

    // Palet Warna Default untuk Block Editor
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => esc_html__('Corporate Blue', 'imatutu'),
            'slug'  => 'primary',
            'color' => '#1559ED',
        ),
        array(
            'name'  => esc_html__('Deep Navy', 'imatutu'),
            'slug'  => 'secondary',
            'color' => '#0B192C',
        ),
        array(
            'name'  => esc_html__('Corporate Red', 'imatutu'),
            'slug'  => 'accent',
            'color' => '#E21F23',
        ),
        array(
            'name'  => esc_html__('Slate Body', 'imatutu'),
            'slug'  => 'text',
            'color' => '#1E293B',
        ),
        array(
            'name'  => esc_html__('Light Slate', 'imatutu'),
            'slug'  => 'surface',
            'color' => '#F8FAFC',
        ),
    ));
}
add_action('after_setup_theme', 'imatutu_setup');

/**
 * Enqueue Frontend Scripts & Styles
 */
function imatutu_scripts() {
    // Google Fonts: Plus Jakarta Sans
    wp_enqueue_style(
        'imatutu-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap',
        array(),
        null
    );

    // Main Stylesheet
    wp_enqueue_style(
        'imatutu-main',
        IMATUTU_URI . '/assets/css/main.css',
        array(),
        IMATUTU_VERSION
    );

    // Dynamic Color Customizer CSS
    $primary_color   = get_theme_mod('primary_color', '#1559ED');
    $secondary_color = get_theme_mod('secondary_color', '#0B192C');
    $accent_color    = get_theme_mod('accent_color', '#E21F23');

    $custom_css = "
        :root {
            --color-primary: {$primary_color};
            --color-secondary: {$secondary_color};
            --color-accent: {$accent_color};
        }
    ";
    wp_add_inline_style('imatutu-main', $custom_css);

    // Main JavaScript
    wp_enqueue_script(
        'imatutu-main-js',
        IMATUTU_URI . '/assets/js/main.js',
        array(),
        IMATUTU_VERSION,
        true
    );

    // Fastbots AI Chatbot Integration
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
add_action('wp_enqueue_scripts', 'imatutu_scripts');

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
    register_block_pattern_category(
        'imatutu',
        array('label' => esc_html__('Imatutu Corporate Components', 'imatutu'))
    );
}
add_action('init', 'imatutu_register_pattern_categories');

/**
 * Memuat Modul Customizer Ramping (Hanya Pengaturan Global)
 */
require_once IMATUTU_DIR . '/inc/customizer.php';
