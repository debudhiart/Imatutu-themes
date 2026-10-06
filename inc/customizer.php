<?php
/**
 * Imatutu Theme Customizer - Ultra-Lean Global Edition
 * Contains only site-wide settings (Colors, Top Bar Contacts, Fastbots AI).
 * Content layout & text are managed universally via Gutenberg Block Patterns.
 *
 * @package Imatutu
 * @version 2.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

function imatutu_customize_register($wp_customize) {

    // Main Panel
    $wp_customize->add_panel('panel_imatutu_global', array(
        'title'       => esc_html__('Imatutu Global Settings', 'imatutu'),
        'description' => esc_html__('Configure corporate brand colors, topbar contacts, and chatbot integration. To edit page content, use the WordPress Page Editor (Pages > Home).', 'imatutu'),
        'priority'    => 20,
    ));

    // -------------------------------------------------------------
    // Section 1: Corporate Colors
    // -------------------------------------------------------------
    $wp_customize->add_section('sec_imatutu_colors', array(
        'title'    => esc_html__('1. Corporate Colors', 'imatutu'),
        'panel'    => 'panel_imatutu_global',
        'priority' => 10,
    ));

    $wp_customize->add_setting('primary_color', array(
        'default'           => '#1559ED',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'    => esc_html__('Primary Corporate Blue', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
    )));

    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#0B192C',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'    => esc_html__('Secondary Navy Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
    )));

    $wp_customize->add_setting('accent_color', array(
        'default'           => '#E21F23',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'    => esc_html__('Accent Red Color', 'imatutu'),
        'section'  => 'sec_imatutu_colors',
    )));

    // -------------------------------------------------------------
    // Section 2: Top Bar & Contact Info
    // -------------------------------------------------------------
    $wp_customize->add_section('sec_imatutu_contacts', array(
        'title'    => esc_html__('2. Top Bar & Contacts', 'imatutu'),
        'panel'    => 'panel_imatutu_global',
        'priority' => 20,
    ));

    $wp_customize->add_setting('imatutu_company_subtitle', array(
        'default'           => 'by PT Karya Antara Negeri | PT Karya Antara Benua',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('imatutu_company_subtitle', array(
        'label'   => esc_html__('Legal Entity Subtitle', 'imatutu'),
        'section' => 'sec_imatutu_contacts',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('imatutu_phone', array(
        'default'           => '+62 851 6893 2460',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('imatutu_phone', array(
        'label'   => esc_html__('Phone Number', 'imatutu'),
        'section' => 'sec_imatutu_contacts',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('imatutu_email', array(
        'default'           => 'office@imatutu.com',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('imatutu_email', array(
        'label'   => esc_html__('Email Address', 'imatutu'),
        'section' => 'sec_imatutu_contacts',
        'type'    => 'email',
    ));

    // -------------------------------------------------------------
    // Section 3: AI Chatbot Integration
    // -------------------------------------------------------------
    $wp_customize->add_section('sec_imatutu_chatbot', array(
        'title'    => esc_html__('3. Fastbots AI Chatbot', 'imatutu'),
        'panel'    => 'panel_imatutu_global',
        'priority' => 30,
    ));

    $wp_customize->add_setting('imatutu_chatbot_id', array(
        'default'           => 'cm8gjb24m11rmrik59ko46vdi',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('imatutu_chatbot_id', array(
        'label'       => esc_html__('Fastbots Bot ID', 'imatutu'),
        'description' => esc_html__('Input your Fastbots.ai Bot ID (Default: cm8gjb24m11rmrik59ko46vdi)', 'imatutu'),
        'section'     => 'sec_imatutu_chatbot',
        'type'        => 'text',
    ));
}
add_action('customize_register', 'imatutu_customize_register');
