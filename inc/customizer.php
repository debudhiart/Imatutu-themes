<?php
/**
 * Imatutu Theme Customizer - Enterprise Global Edition
 *
 * @package Imatutu
 * @version 2.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/customizer-palettes.php';
require_once get_template_directory() . '/inc/customizer-typography.php';

function imatutu_customize_register($wp_customize) {

    // -------------------------------------------------------------
    // Main Panel: Imatutu Enterprise Settings
    // -------------------------------------------------------------
    $wp_customize->add_panel('panel_imatutu_global', array(
        'title'       => esc_html__('Imatutu Global Settings', 'imatutu'),
        'description' => esc_html__('Configure corporate identity, typography, brand colors, header contacts, and AI chatbot. Page contents are managed visually in WordPress Block Editor (Pages > Edit).', 'imatutu'),
        'priority'    => 25,
    ));

    // =============================================================
    // SECTION 1: Typography & Fonts
    // =============================================================
    $wp_customize->add_section('sec_imatutu_typography', array(
        'title'    => esc_html__('1. Typography & Google Fonts', 'imatutu'),
        'panel'    => 'panel_imatutu_global',
        'priority' => 10,
    ));

    $fonts = imatutu_get_curated_fonts();

    $wp_customize->add_setting('typo_body_font', array(
        'default'           => 'Plus Jakarta Sans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('typo_body_font', array(
        'label'    => esc_html__('Body Font Family', 'imatutu'),
        'section'  => 'sec_imatutu_typography',
        'type'     => 'select',
        'choices'  => $fonts,
    ));

    $wp_customize->add_setting('typo_heading_font', array(
        'default'           => 'Plus Jakarta Sans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('typo_heading_font', array(
        'label'    => esc_html__('Headings Font Family', 'imatutu'),
        'section'  => 'sec_imatutu_typography',
        'type'     => 'select',
        'choices'  => $fonts,
    ));

    $wp_customize->add_setting('typo_base_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('typo_base_size', array(
        'label'       => esc_html__('Base Font Size (px)', 'imatutu'),
        'description' => esc_html__('Default is 16px', 'imatutu'),
        'section'     => 'sec_imatutu_typography',
        'type'        => 'number',
        'input_attrs' => array('min' => 14, 'max' => 20, 'step' => 1),
    ));

    // =============================================================
    // SECTION 2: Color Palette & Brand Colors
    // =============================================================
    $wp_customize->add_section('sec_imatutu_colors', array(
        'title'    => esc_html__('2. Colors & Palettes', 'imatutu'),
        'panel'    => 'panel_imatutu_global',
        'priority' => 20,
    ));

    $palettes = imatutu_get_color_palettes();
    $preset_choices = array();
    foreach ($palettes as $key => $pal) {
        $preset_choices[$key] = $pal['name'];
    }

    $wp_customize->add_setting('color_preset', array(
        'default'           => 'pertamina_blue',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('color_preset', array(
        'label'    => esc_html__('1-Click Color Preset', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
        'type'     => 'select',
        'choices'  => $preset_choices,
    ));

    $color_controls = array(
        'primary_color'   => array('label' => esc_html__('Primary Corporate Blue', 'imatutu'), 'default' => '#1559ED'),
        'secondary_color' => array('label' => esc_html__('Secondary Navy Color', 'imatutu'), 'default' => '#0B192C'),
        'accent_color'    => array('label' => esc_html__('Accent Red Color', 'imatutu'), 'default' => '#E21F23'),
    );

    foreach ($color_controls as $color_id => $data) {
        $wp_customize->add_setting($color_id, array(
            'default'           => $data['default'],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ));
        if (class_exists('WP_Customize_Color_Control')) {
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $color_id, array(
                'label'    => $data['label'],
                'section'  => 'sec_imatutu_colors',
                'settings' => $color_id,
            )));
        } else {
            $wp_customize->add_control($color_id, array(
                'label'    => $data['label'],
                'section'  => 'sec_imatutu_colors',
                'type'     => 'color',
            ));
        }
    }

    // =============================================================
    // SECTION 3: Brand Identity & Topbar Contacts
    // =============================================================
    $wp_customize->add_section('sec_imatutu_contacts', array(
        'title'    => esc_html__('3. Brand Identity & Header Contacts', 'imatutu'),
        'panel'    => 'panel_imatutu_global',
        'priority' => 30,
    ));

    $wp_customize->add_setting('imatutu_company_subtitle', array(
        'default'           => 'by PT Karya Antara Negeri | PT Karya Antara Benua',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('imatutu_company_subtitle', array(
        'label'   => esc_html__('Legal Entity Subtitle', 'imatutu'),
        'section' => 'sec_imatutu_contacts',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('imatutu_phone', array(
        'default'           => '+62 851 6893 2460',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('imatutu_phone', array(
        'label'   => esc_html__('Phone Number', 'imatutu'),
        'section' => 'sec_imatutu_contacts',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('imatutu_email', array(
        'default'           => 'office@imatutu.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('imatutu_email', array(
        'label'   => esc_html__('Email Address', 'imatutu'),
        'section' => 'sec_imatutu_contacts',
        'type'    => 'email',
    ));

    $wp_customize->add_setting('imatutu_whatsapp_number', array(
        'default'           => '6285168932460',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('imatutu_whatsapp_number', array(
        'label'       => esc_html__('WhatsApp Number (Direct Link)', 'imatutu'),
        'description' => esc_html__('Format: country code without + (e.g. 6285168932460)', 'imatutu'),
        'section'     => 'sec_imatutu_contacts',
        'type'        => 'text',
    ));

    // =============================================================
    // SECTION 4: Floating Buttons & AI Chatbot
    // =============================================================
    $wp_customize->add_section('sec_imatutu_floating', array(
        'title'    => esc_html__('4. Floating WhatsApp & AI Chatbot', 'imatutu'),
        'panel'    => 'panel_imatutu_global',
        'priority' => 40,
    ));

    $wp_customize->add_setting('imatutu_enable_floating_wa', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('imatutu_enable_floating_wa', array(
        'label'   => esc_html__('Enable Floating WhatsApp Button', 'imatutu'),
        'section' => 'sec_imatutu_floating',
        'type'    => 'checkbox',
    ));

    $wp_customize->add_setting('imatutu_chatbot_id', array(
        'default'           => 'cm8gjb24m11rmrik59ko46vdi',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('imatutu_chatbot_id', array(
        'label'       => esc_html__('Fastbots AI Bot ID', 'imatutu'),
        'description' => esc_html__('Input your Fastbots.ai Bot ID (Leave empty to disable)', 'imatutu'),
        'section'     => 'sec_imatutu_floating',
        'type'        => 'text',
    ));

    // =============================================================
    // SECTION 5: Footer & Legal Information
    // =============================================================
    $wp_customize->add_section('sec_imatutu_footer', array(
        'title'    => esc_html__('5. Footer & Legal Information', 'imatutu'),
        'panel'    => 'panel_imatutu_global',
        'priority' => 50,
    ));

    $wp_customize->add_setting('footer_tagline', array(
        'default'           => 'Integrated Solutions for All Your Business Needs',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('footer_tagline', array(
        'label'   => esc_html__('Footer Brand Tagline', 'imatutu'),
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
 * Enqueue scripts for real-time live preview in Customizer
 */
function imatutu_customizer_preview_scripts() {
    $script_path = get_template_directory() . '/assets/js/customizer-preview.js';
    $version     = file_exists($script_path) ? filemtime($script_path) : IMATUTU_VERSION;

    wp_enqueue_script(
        'imatutu-customizer-preview',
        get_template_directory_uri() . '/assets/js/customizer-preview.js',
        array('customize-preview', 'jquery'),
        $version,
        true
    );

    if (function_exists('imatutu_get_color_palettes')) {
        wp_localize_script('imatutu-customizer-preview', 'imatutuPalettes', imatutu_get_color_palettes());
    }
}
add_action('customize_preview_init', 'imatutu_customizer_preview_scripts');

/**
 * Enqueue scripts and dependencies for Customizer controls pane
 */
function imatutu_customizer_controls_scripts() {
    $script_path = get_template_directory() . '/assets/js/customizer-controls.js';
    $version     = file_exists($script_path) ? filemtime($script_path) : IMATUTU_VERSION;

    wp_enqueue_script(
        'imatutu-customizer-controls',
        get_template_directory_uri() . '/assets/js/customizer-controls.js',
        array('customize-controls', 'jquery'),
        $version,
        true
    );

    if (function_exists('imatutu_get_color_palettes')) {
        wp_localize_script('imatutu-customizer-controls', 'imatutuPalettes', imatutu_get_color_palettes());
    }
}
add_action('customize_controls_enqueue_scripts', 'imatutu_customizer_controls_scripts');
