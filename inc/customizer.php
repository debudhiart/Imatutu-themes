<?php
/**
 * Imatutu Theme Customizer - Lean Dedicated Edition
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/customizer-palettes.php';
require_once get_template_directory() . '/inc/customizer-typography.php';

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

    $wp_customize->add_setting('primary_color', array(
        'default'           => '#1559ED',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'    => esc_html__('Primary Corporate Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
    )));

    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#0B192C',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'    => esc_html__('Secondary Navy Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
    )));

    $wp_customize->add_setting('accent_color', array(
        'default'           => '#E21F23',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'    => esc_html__('Accent Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
    )));

    // =============================================================
    // SECTION 2: Header Settings
    // =============================================================
    $wp_customize->add_section('sec_imatutu_header', array(
        'title'    => esc_html__('2. Header & Navigation', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 20,
    ));

    $wp_customize->add_setting('header_brand_text', array(
        'default'           => 'IMATUTU',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('header_brand_text', array(
        'label'   => esc_html__('Brand Name Text', 'imatutu'),
        'section' => 'sec_imatutu_header',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('header_subtitle', array(
        'default'           => 'by PT Karya Antara Negeri | PT Karya Antara Benua',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('header_subtitle', array(
        'label'   => esc_html__('Company Subtitle / Entity', 'imatutu'),
        'section' => 'sec_imatutu_header',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('header_cta_text', array(
        'default'           => 'Contact',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('header_cta_text', array(
        'label'   => esc_html__('Header Button Label', 'imatutu'),
        'section' => 'sec_imatutu_header',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('header_cta_link', array(
        'default'           => 'https://imatutu.com/contact-us/',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('header_cta_link', array(
        'label'   => esc_html__('Header Button URL', 'imatutu'),
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

    $wp_customize->add_setting('hero_heading_1', array(
        'default'           => 'The Trusted Choice For Your Business Support Requirements',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('hero_heading_1', array(
        'label'   => esc_html__('Main Hero Title (H1)', 'imatutu'),
        'section' => 'sec_imatutu_hero',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hero_heading_2', array(
        'default'           => 'Integrated Solutions for All Your Business Needs',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('hero_heading_2', array(
        'label'   => esc_html__('Hero Subtitle', 'imatutu'),
        'section' => 'sec_imatutu_hero',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('hero_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_bg_image', array(
        'label'   => esc_html__('Hero Background Image', 'imatutu'),
        'section' => 'sec_imatutu_hero',
    )));

    $wp_customize->add_setting('hero_cta_primary_text', array(
        'default'           => 'Contact Us',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('hero_cta_primary_text', array(
        'label'   => esc_html__('Primary Button Label', 'imatutu'),
        'section' => 'sec_imatutu_hero',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('hero_cta_primary_link', array(
        'default'           => 'https://imatutu.com/contact-us/',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('hero_cta_primary_link', array(
        'label'   => esc_html__('Primary Button Link', 'imatutu'),
        'section' => 'sec_imatutu_hero',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('hero_cta_secondary_text', array(
        'default'           => 'Our Services',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('hero_cta_secondary_text', array(
        'label'   => esc_html__('Secondary Button Label', 'imatutu'),
        'section' => 'sec_imatutu_hero',
        'type'    => 'text',
    ));

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
        'title'    => esc_html__('4. Services Section (3 Items)', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 40,
    ));

    $wp_customize->add_setting('services_subtitle', array(
        'default'           => 'What We OFFER',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('services_subtitle', array(
        'label'   => esc_html__('Section Subtitle', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('services_title', array(
        'default'           => 'Taylor Made Solutions for Your Business',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('services_title', array(
        'label'   => esc_html__('Section Main Title', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'text',
    ));

    // Service 1
    $wp_customize->add_setting('service_1_title', array(
        'default'           => 'Customer Service Support',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('service_1_title', array(
        'label'   => esc_html__('Service 1: Title', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('service_1_desc', array(
        'default'           => 'We provide 24/7 contact center services tailored to suit your industry needs from, handling inquiries, transport bookings, handling customer feedback and resolving issues promptly to ensure customer satisfaction. Our team is trained to deliver exceptional service in every interaction.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
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
        'label'   => esc_html__('Service 1: Image', 'imatutu'),
        'section' => 'sec_imatutu_services',
    )));

    // Service 2
    $wp_customize->add_setting('service_2_title', array(
        'default'           => 'Full Technical Support',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('service_2_title', array(
        'label'   => esc_html__('Service 2: Title', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('service_2_desc', array(
        'default'           => 'Our experts offer reliable troubleshooting and technical assistance, for multiple systems helping clients resolve technical problems efficiently. We focus on quick solutions to minimize downtime.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
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
        'label'   => esc_html__('Service 2: Image', 'imatutu'),
        'section' => 'sec_imatutu_services',
    )));

    // Service 3
    $wp_customize->add_setting('service_3_title', array(
        'default'           => 'Administration Support',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('service_3_title', array(
        'label'   => esc_html__('Service 3: Title', 'imatutu'),
        'section' => 'sec_imatutu_services',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('service_3_desc', array(
        'default'           => 'Full accounting services available, teamed up with data processing, general administration and customer service support',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
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
        'label'   => esc_html__('Service 3: Image', 'imatutu'),
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
        'transport'         => 'postMessage',
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
        'label'   => esc_html__('Side Image (Global Reach)', 'imatutu'),
        'section' => 'sec_imatutu_stats',
    )));

    // Metric 1
    $wp_customize->add_setting('stat_1_number', array(
        'default'           => '150+',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('stat_1_number', array(
        'label'   => esc_html__('Stat 1: Number', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('stat_1_label', array(
        'default'           => 'Client',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('stat_1_label', array(
        'label'   => esc_html__('Stat 1: Label', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));

    // Metric 2
    $wp_customize->add_setting('stat_2_number', array(
        'default'           => '150+',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('stat_2_number', array(
        'label'   => esc_html__('Stat 2: Number', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('stat_2_label', array(
        'default'           => 'Project',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('stat_2_label', array(
        'label'   => esc_html__('Stat 2: Label', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));

    // Metric 3
    $wp_customize->add_setting('stat_3_number', array(
        'default'           => '3',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('stat_3_number', array(
        'label'   => esc_html__('Stat 3: Number', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));
    $wp_customize->add_setting('stat_3_label', array(
        'default'           => 'Country',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('stat_3_label', array(
        'label'   => esc_html__('Stat 3: Label', 'imatutu'),
        'section' => 'sec_imatutu_stats',
        'type'    => 'text',
    ));

    // =============================================================
    // SECTION 6: Partner & Client Logos
    // =============================================================
    $wp_customize->add_section('sec_imatutu_clients', array(
        'title'    => esc_html__('6. Partner & Client Logos (9)', 'imatutu'),
        'panel'    => 'panel_imatutu',
        'priority' => 60,
    ));

    $wp_customize->add_setting('clients_section_title', array(
        'default'           => 'Our Trusted Partners',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('clients_section_title', array(
        'label'   => esc_html__('Section Heading', 'imatutu'),
        'section' => 'sec_imatutu_clients',
        'type'    => 'text',
    ));

    $default_partners = array(
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

    for ($i = 1; $i <= 9; $i++) {
        $wp_customize->add_setting("client_{$i}_name", array(
            'default'           => $default_partners[$i]['name'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("client_{$i}_name", array(
            'label'   => sprintf(esc_html__('Partner %d: Name', 'imatutu'), $i),
            'section' => 'sec_imatutu_clients',
            'type'    => 'text',
        ));

        $wp_customize->add_setting("client_{$i}_url", array(
            'default'           => $default_partners[$i]['url'],
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("client_{$i}_url", array(
            'label'   => sprintf(esc_html__('Partner %d: Website URL', 'imatutu'), $i),
            'section' => 'sec_imatutu_clients',
            'type'    => 'url',
        ));

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
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('footer_tagline', array(
        'label'   => esc_html__('Footer Tagline', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('footer_address_1', array(
        'default'           => 'Jl. Gatot Subroto Barat No.283, Pemecutan Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80111',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('footer_address_1', array(
        'label'   => esc_html__('Office Address 1 (Denpasar Barat)', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('footer_address_2', array(
        'default'           => 'Jl. Gatot Subroto Tengah No.45F, Dauh Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80239',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('footer_address_2', array(
        'label'   => esc_html__('Office Address 2 (Denpasar Tengah)', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'textarea',
    ));

    $wp_customize->add_setting('footer_phone', array(
        'default'           => '+62 851 6893 2460',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('footer_phone', array(
        'label'   => esc_html__('Phone Number', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('footer_email', array(
        'default'           => 'office@imatutu.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
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
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('footer_copyright', array(
        'label'   => esc_html__('Copyright Notice', 'imatutu'),
        'section' => 'sec_imatutu_footer',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'imatutu_customize_register');

/**
 * Enqueue script for real-time live preview in Customizer iframe
 */
if (!function_exists('imatutu_customizer_live_preview')) {
    function imatutu_customizer_live_preview() {
        $preview_ver = file_exists(get_template_directory() . '/assets/js/customizer-preview.js')
            ? filemtime(get_template_directory() . '/assets/js/customizer-preview.js')
            : '2.1.0';

        wp_enqueue_script(
            'imatutu-customizer-preview',
            get_template_directory_uri() . '/assets/js/customizer-preview.js',
            array('customize-preview', 'jquery'),
            $preview_ver,
            true
        );
    }
}
add_action('customize_preview_init', 'imatutu_customizer_live_preview');
