<?php
/**
 * Imatutu Modern Corporate functions and definitions
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('imatutu_setup')) :
    function imatutu_setup() {
        load_theme_textdomain('imatutu', get_template_directory() . '/languages');
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 630, true);

        add_theme_support('custom-logo', array(
            'height'      => 80,
            'width'       => 260,
            'flex-height' => true,
            'flex-width'  => true,
            'unlink-homepage-logo' => false,
        ));

        register_nav_menus(array(
            'primary' => esc_html__('Primary Navigation', 'imatutu'),
            'footer'  => esc_html__('Footer Navigation', 'imatutu'),
        ));

        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('responsive-embeds');
    }
endif;
add_action('after_setup_theme', 'imatutu_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
if (!function_exists('imatutu_content_width')) {
    function imatutu_content_width() {
        $GLOBALS['content_width'] = apply_filters('imatutu_content_width', 1200);
    }
}
add_action('after_setup_theme', 'imatutu_content_width', 0);

/**
 * Enqueue scripts and styles.
 */
if (!function_exists('imatutu_scripts')) {
    function imatutu_scripts() {
        // Google Fonts: Plus Jakarta Sans
        wp_enqueue_style(
            'imatutu-google-fonts',
            'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap',
            array(),
            null
        );

        // Main Theme CSS
        $css_ver = file_exists(get_template_directory() . '/assets/css/main.css') 
            ? filemtime(get_template_directory() . '/assets/css/main.css') 
            : '2.1.0';
        wp_enqueue_style('imatutu-main', get_template_directory_uri() . '/assets/css/main.css', array('imatutu-google-fonts'), $css_ver);
        wp_enqueue_style('imatutu-style', get_stylesheet_uri(), array('imatutu-main'), '2.1.0');

        // Dynamic Customizer Styling (Colors & Typography)
        $custom_css = '';
        if (function_exists('imatutu_get_color_css')) {
            $custom_css .= imatutu_get_color_css();
        }
        if (function_exists('imatutu_get_typography_css')) {
            $custom_css .= imatutu_get_typography_css();
        }
        if (!empty($custom_css)) {
            wp_add_inline_style('imatutu-main', $custom_css);
        }

        // Main Theme JavaScript (Vanilla JS for sticky header & mobile menu)
        $js_ver = file_exists(get_template_directory() . '/assets/js/main.js') 
            ? filemtime(get_template_directory() . '/assets/js/main.js') 
            : '2.1.0';
        wp_enqueue_script('imatutu-script', get_template_directory_uri() . '/assets/js/main.js', array(), $js_ver, true);

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
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
 * Include Customizer
 */
require_once get_template_directory() . '/inc/customizer.php';
