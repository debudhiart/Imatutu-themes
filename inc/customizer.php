<?php
/**
 * Imatutu Theme Customizer (inc/customizer.php)
 *
 * Implements full WP_Customize_Manager configuration for all editable elements
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Require Custom Controls & Modular Customizer Engines
require_once get_template_directory() . '/inc/custom-controls/class-control-range-slider.php';
require_once get_template_directory() . '/inc/custom-controls/class-control-palette-picker.php';
require_once get_template_directory() . '/inc/custom-controls/class-control-typography.php';
require_once get_template_directory() . '/inc/customizer-palettes.php';
require_once get_template_directory() . '/inc/customizer-typography.php';
require_once get_template_directory() . '/inc/customizer-layout-engine.php';

function imatutu_customize_register($wp_customize) {
    // -------------------------------------------------------------
    // Main Customizer Panel
    // -------------------------------------------------------------
    $wp_customize->add_panel('panel_imatutu', array(
        'title'       => esc_html__('Imatutu Theme Settings', 'imatutu'),
        'description' => esc_html__('Configure visual styles, content, partners, contacts, and chatbot integration.', 'imatutu'),
        'priority'    => 25,
    ));

    // =============================================================
    // SECTION 1: Colors & Brand Identity
    // =============================================================
    $wp_customize->add_section('sec_imatutu_colors', array(
        'title'    => esc_html__('1. Colors & Brand Identity', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 10,
    ));

    // 1-Click Color Preset Picker
    $wp_customize->add_setting('color_preset_active', array(
        'default'           => 'pertamina_blue',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'refresh',
    ));
    if (class_exists('Imatutu_Palette_Picker_Control')) {
        $wp_customize->add_control(new Imatutu_Palette_Picker_Control($wp_customize, 'color_preset_active', array(
            'label'       => esc_html__('1-Click Color Palette Preset', 'imatutu'),
            'description' => esc_html__('Select a curated corporate color scheme.', 'imatutu'),
            'section'     => 'sec_imatutu_colors',
            'palettes'    => imatutu_get_color_palettes(),
        )));
    }

    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#1559ED',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'    => esc_html__('Primary Corporate Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
        'settings' => 'primary_color',
    )));

    // Primary Hover Color
    $wp_customize->add_setting('color_primary_hover', array(
        'default'           => '#0D45C2',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_primary_hover', array(
        'label'    => esc_html__('Primary Hover Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
        'settings' => 'color_primary_hover',
    )));

    // Secondary Color (Navy/Dark)
    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#0B192C',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'    => esc_html__('Secondary Navy Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
        'settings' => 'secondary_color',
    )));

    // Accent Color (Red Accent)
    $wp_customize->add_setting('accent_color', array(
        'default'           => '#E21F23',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'    => esc_html__('Accent Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
        'settings' => 'accent_color',
    )));

    // Background Main
    $wp_customize->add_setting('color_bg_main', array(
        'default'           => '#FFFFFF',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_bg_main', array(
        'label'    => esc_html__('Website Background', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
        'settings' => 'color_bg_main',
    )));

    // Background Surface / Card
    $wp_customize->add_setting('color_bg_surface', array(
        'default'           => '#F8FAFC',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_bg_surface', array(
        'label'    => esc_html__('Card & Section Surface Background', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
        'settings' => 'color_bg_surface',
    )));

    // Text Main
    $wp_customize->add_setting('color_text_main', array(
        'default'           => '#1E293B',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_text_main', array(
        'label'    => esc_html__('Main Text Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
        'settings' => 'color_text_main',
    )));

    // Text Muted
    $wp_customize->add_setting('color_text_muted', array(
        'default'           => '#64748B',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_text_muted', array(
        'label'    => esc_html__('Muted / Subtitle Text Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
        'settings' => 'color_text_muted',
    )));

    // Border Color
    $wp_customize->add_setting('color_border', array(
        'default'           => '#E2E8F0',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'color_border', array(
        'label'    => esc_html__('Border & Divider Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
        'settings' => 'color_border',
    )));

    // =============================================================
    // SECTION 1B: Typography Engine
    // =============================================================
    $wp_customize->add_section('sec_imatutu_typography', array(
        'title'    => esc_html__('1B. Typography & Fonts', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 15,
    ));

    // Primary Body Font
    $wp_customize->add_setting('typo_primary_font', array(
        'default'           => 'Plus Jakarta Sans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    if (class_exists('Imatutu_Typography_Control')) {
        $wp_customize->add_control(new Imatutu_Typography_Control($wp_customize, 'typo_primary_font', array(
            'label'       => esc_html__('Primary Body Font Family', 'imatutu'),
            'description' => esc_html__('Used for paragraphs, buttons, and navigation.', 'imatutu'),
            'section'     => 'sec_imatutu_typography',
        )));
    }

    // Heading Font
    $wp_customize->add_setting('typo_heading_font', array(
        'default'           => 'Plus Jakarta Sans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    if (class_exists('Imatutu_Typography_Control')) {
        $wp_customize->add_control(new Imatutu_Typography_Control($wp_customize, 'typo_heading_font', array(
            'label'       => esc_html__('Heading Font Family', 'imatutu'),
            'description' => esc_html__('Used for all titles (H1-H6) and brand logo.', 'imatutu'),
            'section'     => 'sec_imatutu_typography',
        )));
    }

    // H1 Size Slider
    $wp_customize->add_setting('typo_h1_size', array(
        'default'           => 48,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    if (class_exists('Imatutu_Range_Slider_Control')) {
        $wp_customize->add_control(new Imatutu_Range_Slider_Control($wp_customize, 'typo_h1_size', array(
            'label'   => esc_html__('Heading 1 Size (Desktop)', 'imatutu'),
            'section' => 'sec_imatutu_typography',
            'min'     => 32,
            'max'     => 72,
            'step'    => 2,
            'unit'    => 'px',
        )));
    }

    // H2 Size Slider
    $wp_customize->add_setting('typo_h2_size', array(
        'default'           => 36,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    if (class_exists('Imatutu_Range_Slider_Control')) {
        $wp_customize->add_control(new Imatutu_Range_Slider_Control($wp_customize, 'typo_h2_size', array(
            'label'   => esc_html__('Heading 2 Size (Desktop)', 'imatutu'),
            'section' => 'sec_imatutu_typography',
            'min'     => 24,
            'max'     => 54,
            'step'    => 2,
            'unit'    => 'px',
        )));
    }

    // Body Font Size Slider
    $wp_customize->add_setting('typo_body_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    if (class_exists('Imatutu_Range_Slider_Control')) {
        $wp_customize->add_control(new Imatutu_Range_Slider_Control($wp_customize, 'typo_body_size', array(
            'label'   => esc_html__('Body Font Size', 'imatutu'),
            'section' => 'sec_imatutu_typography',
            'min'     => 14,
            'max'     => 22,
            'step'    => 1,
            'unit'    => 'px',
        )));
    }


    // =============================================================
    // SECTION 2: Header Settings
    // =============================================================
    $wp_customize->add_section('sec_imatutu_header', array(
        'title'    => esc_html__('2. Header & Top Bar', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 20,
    ));

    // Brand Text (Fallback if no custom logo uploaded)
    $wp_customize->add_setting('header_brand_text', array(
        'default'           => 'IMATUTU',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('header_brand_text', array(
        'label'       => esc_html__('Brand Logo Text (Fallback)', 'imatutu'),
        'description' => esc_html__('Used when no custom logo image is uploaded under Site Identity.', 'imatutu'),
        'section'     => 'sec_imatutu_header',
        'type'        => 'text',
    ));

    // Header Subtitle (Corporate entity note)
    $wp_customize->add_setting('header_subtitle', array(
        'default'           => 'by PT Karya Antara Negeri | PT Karya Antara Benua',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('header_subtitle', array(
        'label'   => esc_html__('Header Entity Subtitle', 'imatutu'),
        'section' => 'sec_imatutu_header',
        'type'    => 'text',
    ));

    // Header CTA Button Text
    $wp_customize->add_setting('header_cta_text', array(
        'default'           => 'Contact',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('header_cta_text', array(
        'label'   => esc_html__('Header CTA Button Text', 'imatutu'),
        'section' => 'sec_imatutu_header',
        'type'    => 'text',
    ));

    // Header CTA Button Link
    $wp_customize->add_setting('header_cta_link', array(
        'default'           => 'https://imatutu.com/contact-us/',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('header_cta_link', array(
        'label'   => esc_html__('Header CTA Button Link', 'imatutu'),
        'section' => 'sec_imatutu_header',
        'type'    => 'url',
    ));

    // =============================================================
    // SECTION 3: Hero Section
    // =============================================================
    $wp_customize->add_section('sec_imatutu_hero', array(
        'title'    => esc_html__('3. Hero Section', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 30,
    ));

    // Hero Heading 1 (Single H1)
    $wp_customize->add_setting('hero_heading_1', array(
        'default'           => 'The Trusted Choice For Your Business Support Requirements',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('hero_heading_1', array(
        'label'       => esc_html__('Hero Main Heading (H1)', 'imatutu'),
        'description' => esc_html__('The primary SEO H1 heading of the website.', 'imatutu'),
        'section'     => 'sec_imatutu_hero',
        'type'        => 'text',
    ));

    // Hero Heading 2 (Subtitle)
    $wp_customize->add_setting('hero_heading_2', array(
        'default'           => 'Integrated Solutions for All Your Business Needs',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('hero_heading_2', array(
        'label'   => esc_html__('Hero Subheading / Tagline', 'imatutu'),
        'section' => 'sec_imatutu_hero',
        'type'    => 'textarea',
    ));

    // Hero Background Image
    $wp_customize->add_setting('hero_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_bg_image', array(
        'label'       => esc_html__('Hero Background Image', 'imatutu'),
        'description' => esc_html__('Optional corporate high-res background image overlay.', 'imatutu'),
        'section'     => 'sec_imatutu_hero',
    )));

    // Hero Primary CTA Text
    $wp_customize->add_setting('hero_cta_primary_text', array(
        'default'           => 'Contact Us',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_cta_primary_text', array(
        'label'   => esc_html__('Primary Button Text', 'imatutu'),
        'section' => 'sec_imatutu_hero',
        'type'    => 'text',
    ));

    // Hero Primary CTA Link
    $wp_customize->add_setting('hero_cta_primary_link', array(
        'default'           => 'https://imatutu.com/contact-us/',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_cta_primary_link', array(
        'label'   => esc_html__('Primary Button Link', 'imatutu'),
        'section' => 'sec_imatutu_hero',
        'type'    => 'url',
    ));

    // Hero Secondary CTA Text
    $wp_customize->add_setting('hero_cta_secondary_text', array(
        'default'           => 'Our Services',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_cta_secondary_text', array(
        'label'   => esc_html__('Secondary Button Text', 'imatutu'),
        'section' => 'sec_imatutu_hero',
        'type'    => 'text',
    ));

    // Hero Secondary CTA Link
    $wp_customize->add_setting('hero_cta_secondary_link', array(
        'default'           => '#services',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_cta_secondary_link', array(
        'label'   => esc_html__('Secondary Button Link', 'imatutu'),
        'section' => 'sec_imatutu_hero',
        'type'    => 'text',
    ));

    // =============================================================
    // SECTION 4: Services Section
    // =============================================================
    $wp_customize->add_section('sec_imatutu_services', array(
        'title'    => esc_html__('4. Services Section', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 40,
    ));

    // Section Subtitle
    $wp_customize->add_setting('services_subtitle', array(
        'default'           => 'What We OFFER',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('services_subtitle', array(
        'label'   => esc_html__('Services Pill Subtitle', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'text',
    ));

    // Section Title
    $wp_customize->add_setting('services_title', array(
        'default'           => 'Taylor Made Solutions for Your Business',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('services_title', array(
        'label'   => esc_html__('Services Section Title (H2)', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'text',
    ));

    // Service 1: Customer Service Support
    $wp_customize->add_setting('service_1_title', array(
        'default'           => 'Customer Service Support',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('service_1_title', array(
        'label'   => esc_html__('Service 1: Title', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('service_1_desc', array(
        'default'           => 'We provide 24/7 contact center services tailored to suit your industry needs from, handling inquiries, transport bookings, handling customer feedback and resolving issues promptly to ensure customer satisfaction. Our team is trained to deliver exceptional service in every interaction.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('service_1_desc', array(
        'label'   => esc_html__('Service 1: Description', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('service_1_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'service_1_image', array(
        'label'   => esc_html__('Service 1: Card Image', 'imatutu'),
        'section' => 'sec_imatutu_services',
    )));

    // Service 2: Full Technical Support
    $wp_customize->add_setting('service_2_title', array(
        'default'           => 'Full Technical Support',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('service_2_title', array(
        'label'   => esc_html__('Service 2: Title', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('service_2_desc', array(
        'default'           => 'Our experts offer reliable troubleshooting and technical assistance, for multiple systems helping clients resolve technical problems efficiently. We focus on quick solutions to minimize downtime.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('service_2_desc', array(
        'label'   => esc_html__('Service 2: Description', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('service_2_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'service_2_image', array(
        'label'   => esc_html__('Service 2: Card Image', 'imatutu'),
        'section' => 'sec_imatutu_services',
    )));

    // Service 3: Administration Support
    $wp_customize->add_setting('service_3_title', array(
        'default'           => 'Administration Support',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('service_3_title', array(
        'label'   => esc_html__('Service 3: Title', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('service_3_desc', array(
        'default'           => 'Full accounting services available, teamed up with data processing, general administration and customer service support',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('service_3_desc', array(
        'label'   => esc_html__('Service 3: Description', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('service_3_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'service_3_image', array(
        'label'   => esc_html__('Service 3: Card Image', 'imatutu'),
        'section' => 'sec_imatutu_services',
    )));

    // =============================================================
    // SECTION 5: Global Reach & Stats
    // =============================================================
    $wp_customize->add_section('sec_imatutu_stats', array(
        'title'    => esc_html__('5. Global Reach & Stats', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 50,
    ));

    $wp_customize->add_setting('stats_title', array(
        'default'           => 'Our Global Reach',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('stats_title', array(
        'label'   => esc_html__('Section Title', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('stats_desc', array(
        'default'           => 'With numerous clients, successful projects and a wide reach, Imatutu is making a mark as the preferred outsourcing partner. We support our global clients, delivering excellence in every project. Our services span across multiple countries and multiple industries, helping businesses achieve their goals globally.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('stats_desc', array(
        'label'   => esc_html__('Section Description', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('stats_side_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'stats_side_image', array(
        'label'   => esc_html__('Showcase Graphic / Image', 'imatutu'),
        'section' => 'sec_imatutu_stats',
    )));

    // Stat 1
    $wp_customize->add_setting('stat_1_number', array(
        'default'           => '150+',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('stat_1_number', array(
        'label'   => esc_html__('Metric 1: Number', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('stat_1_label', array(
        'default'           => 'Client',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('stat_1_label', array(
        'label'   => esc_html__('Metric 1: Label', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));

    // Stat 2
    $wp_customize->add_setting('stat_2_number', array(
        'default'           => '150+',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('stat_2_number', array(
        'label'   => esc_html__('Metric 2: Number', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('stat_2_label', array(
        'default'           => 'Project',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('stat_2_label', array(
        'label'   => esc_html__('Metric 2: Label', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));

    // Stat 3
    $wp_customize->add_setting('stat_3_number', array(
        'default'           => '3',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('stat_3_number', array(
        'label'   => esc_html__('Metric 3: Number', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('stat_3_label', array(
        'default'           => 'Country',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('stat_3_label', array(
        'label'   => esc_html__('Metric 3: Label', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));

    // =============================================================
    // SECTION 6: Partner & Client Logos
    // =============================================================
    $wp_customize->add_section('sec_imatutu_clients', array(
        'title'    => esc_html__('6. Partners & Client Logos', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 60,
    ));

    $wp_customize->add_setting('clients_section_title', array(
        'default'           => 'Our Trusted Partners',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('clients_section_title', array(
        'label'   => esc_html__('Partners Section Title', 'imatutu'),
        'section' => 'sec_imatutu_clients',
        'type'    => 'text',
    ));

    $default_clients = array(
        1 => array('name' => 'Alert Taxis', 'url' => 'http://www.alerttaxis.co.nz'),
        2 => array('name' => 'Canberra Elite', 'url' => 'http://www.canberraelite.com.au'),
        3 => array('name' => 'NZTC', 'url' => 'http://www.nztc.net.nz'),
        4 => array('name' => 'Aerial Capital Group', 'url' => 'http://www.aerialcapitalgroup.com.au'),
        5 => array('name' => 'First Direct', 'url' => 'http://www.firstdirect.net.nz'),
        6 => array('name' => 'PN Taxis', 'url' => 'http://www.pntaxis.co.nz'),
        7 => array('name' => 'BusMe', 'url' => 'http://www.busme.com.au'),
        8 => array('name' => 'Silver Service Canberra', 'url' => 'http://www.silverservicecanberra.com.au'),
        9 => array('name' => 'QE Taxis', 'url' => 'http://www.qetaxis.com.au'),
    );

    foreach ($default_clients as $i => $client) {
        // Name
        $wp_customize->add_setting("client_{$i}_name", array(
            'default'           => $client['name'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("client_{$i}_name", array(
            'label'   => sprintf(esc_html__('Partner %d: Name', 'imatutu'), $i),
            'section' => 'sec_imatutu_clients',
            'type'    => 'text',
        ));

        // URL
        $wp_customize->add_setting("client_{$i}_url", array(
            'default'           => $client['url'],
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("client_{$i}_url", array(
            'label'   => sprintf(esc_html__('Partner %d: Website URL', 'imatutu'), $i),
            'section' => 'sec_imatutu_clients',
            'type'    => 'url',
        ));

        // Logo
        $wp_customize->add_setting("client_{$i}_logo", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "client_{$i}_logo", array(
            'label'   => sprintf(esc_html__('Partner %d: Logo Image', 'imatutu'), $i),
            'section' => 'sec_imatutu_clients',
        )));
    }

    // =============================================================
    // SECTION 7: Footer & Contact Info
    // =============================================================
    $wp_customize->add_section('sec_imatutu_footer', array(
        'title'    => esc_html__('7. Footer & Contact Info', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 70,
    ));

    $wp_customize->add_setting('footer_tagline', array(
        'default'           => 'Integrated Solutions for All Your Business Needs',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_tagline', array(
        'label'   => esc_html__('Footer Tagline', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('footer_address_1', array(
        'default'           => 'Jl. Gatot Subroto Barat No.283, Pemecutan Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80111',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('footer_address_1', array(
        'label'   => esc_html__('Office Address 1 (Gatot Subroto Barat)', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('footer_address_2', array(
        'default'           => 'Jl. Gatot Subroto Tengah No.45F, Dauh Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80239',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('footer_address_2', array(
        'label'   => esc_html__('Office Address 2 (Gatot Subroto Tengah)', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('footer_phone', array(
        'default'           => '+62 851 6893 2460',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_phone', array(
        'label'   => esc_html__('Phone Number', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('footer_email', array(
        'default'           => 'office@imatutu.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    $wp_customize->add_control('footer_email', array(
        'label'   => esc_html__('Email Address', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'email',
    ));

    $wp_customize->add_setting('fastbots_bot_id', array(
        'default'           => 'cm8gjb24m11rmrik59ko46vdi',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('fastbots_bot_id', array(
        'label'       => esc_html__('Fastbots AI Chatbot ID', 'imatutu'),
        'description' => esc_html__('Embeds floating Fastbots AI assistant on website.', 'imatutu'),
        'section'     => 'sec_imatutu_footer',
        'type'        => 'text',
    ));

    $wp_customize->add_setting('footer_copyright', array(
        'default'           => '© Copyright Imatutu. All Rights Reserved.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_copyright', array(
        'label'   => esc_html__('Copyright Notice', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'imatutu_customize_register');

/**
 * Enqueue script for real-time live preview in Customizer
 */
function imatutu_customizer_live_preview() {
    wp_enqueue_script(
        'imatutu-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('customize-preview', 'jquery'),
        '1.0.0',
        true
    );
    wp_enqueue_script(
        'imatutu-builder-preview',
        get_template_directory_uri() . '/assets/js/builder-preview.js',
        array('customize-preview', 'jquery'),
        '1.0.0',
        true
    );
}
add_action('customize_preview_init', 'imatutu_customizer_live_preview');
