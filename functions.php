<?php
/**
 * Imatutu Modern Corporate functions and definitions
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!function_exists('imatutu_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function imatutu_setup() {
        // Make theme available for translation.
        load_theme_textdomain('imatutu', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title.
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 630, true);

        // Custom Logo support
        add_theme_support('custom-logo', array(
            'height'      => 80,
            'width'       => 260,
            'flex-height' => true,
            'flex-width'  => true,
            'unlink-homepage-logo' => false,
        ));

        // Register Navigation Menus
        register_nav_menus(array(
            'primary' => esc_html__('Primary Navigation', 'imatutu'),
            'footer'  => esc_html__('Footer Navigation', 'imatutu'),
        ));

        // Switch default core markup for search form, comment form, etc to HTML5.
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        // Add responsive embeds support.
        add_theme_support('responsive-embeds');
    }
endif;
add_action('after_setup_theme', 'imatutu_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function imatutu_content_width() {
    $GLOBALS['content_width'] = apply_filters('imatutu_content_width', 1200);
}
add_action('after_setup_theme', 'imatutu_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
function imatutu_scripts() {
    // Google Fonts: Plus Jakarta Sans
    wp_enqueue_style(
        'imatutu-google-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap',
        array(),
        null
    );

    // Main Theme CSS
    $css_version = file_exists(get_template_directory() . '/assets/css/main.css') 
        ? filemtime(get_template_directory() . '/assets/css/main.css') 
        : '1.0.0';
    wp_enqueue_style('imatutu-main', get_template_directory_uri() . '/assets/css/main.css', array('imatutu-google-fonts'), $css_version);

    // style.css for metadata and child theme compatibility
    wp_enqueue_style('imatutu-style', get_stylesheet_uri(), array('imatutu-main'), '1.0.0');

    // Dynamic customizer styling
    $primary_color   = get_theme_mod('primary_color', '#1559ED');
    $secondary_color = get_theme_mod('secondary_color', '#0B192C');
    $accent_color    = get_theme_mod('accent_color', '#E21F23');

    $custom_css = "
        :root {
            --color-primary: " . esc_attr($primary_color) . ";
            --color-secondary: " . esc_attr($secondary_color) . ";
            --color-accent: " . esc_attr($accent_color) . ";
        }
    ";
    wp_add_inline_style('imatutu-main', $custom_css);

    // Main Theme JavaScript
    $js_version = file_exists(get_template_directory() . '/assets/js/main.js') 
        ? filemtime(get_template_directory() . '/assets/js/main.js') 
        : '1.0.0';
    wp_enqueue_script('imatutu-script', get_template_directory_uri() . '/assets/js/main.js', array(), $js_version, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'imatutu_scripts');

/**
 * Fallback menu when no WordPress menu is assigned yet
 */
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

/**
 * Fallback menu for footer
 */
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

/**
 * Customizer Additions
 */
require_once get_template_directory() . '/inc/customizer.php';
