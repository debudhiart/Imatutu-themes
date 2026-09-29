<?php
/**
 * Layout Engine & Modular Page Builder Customizer Controller
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

function imatutu_register_builder_customizer($wp_customize) {
    // -------------------------------------------------------------
    // Main Builder Panel
    // -------------------------------------------------------------
    $wp_customize->add_panel('panel_imatutu_builder', array(
        'title'       => esc_html__('Imatutu Layout & Page Builder', 'imatutu'),
        'description' => esc_html__('Build and customize dynamic grid sections, rows, columns, and content components.', 'imatutu'),
        'priority'    => 28,
    ));

    // Support up to 5 dynamic modular sections
    for ($s = 1; $s <= 5; $s++) {
        $sec_id = "sec_builder_s{$s}";
        
        $wp_customize->add_section($sec_id, array(
            'title'    => sprintf(esc_html__('Modular Section %d', 'imatutu'), $s),
            'panel'    => 'panel_imatutu_builder',
            'priority' => 10 * $s,
        ));

        // 1. Enable / Disable Section
        $wp_customize->add_setting("builder_sec_{$s}_enable", array(
            'default'           => ($s <= 2), // Sections 1 and 2 enabled by default
            'sanitize_callback' => 'imatutu_sanitize_checkbox',
        ));
        $wp_customize->add_control("builder_sec_{$s}_enable", array(
            'label'   => esc_html__('Enable This Section', 'imatutu'),
            'section' => $sec_id,
            'type'    => 'checkbox',
        ));

        // 2. Section Name / Internal Label
        $wp_customize->add_setting("builder_sec_{$s}_admin_label", array(
            'default'           => sprintf(esc_html__('Dynamic Section %d', 'imatutu'), $s),
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("builder_sec_{$s}_admin_label", array(
            'label'   => esc_html__('Section Reference Label', 'imatutu'),
            'section' => $sec_id,
            'type'    => 'text',
        ));

        // 3. Section Background Style
        $wp_customize->add_setting("builder_sec_{$s}_bg_type", array(
            'default'           => ($s % 2 === 0) ? 'soft_slate' : 'default_white',
            'sanitize_callback' => 'sanitize_key',
        ));
        $wp_customize->add_control("builder_sec_{$s}_bg_type", array(
            'label'   => esc_html__('Section Background', 'imatutu'),
            'section' => $sec_id,
            'type'    => 'select',
            'choices' => array(
                'default_white' => esc_html__('Pure White (#FFFFFF)', 'imatutu'),
                'soft_slate'    => esc_html__('Soft Slate (#F8FAFC)', 'imatutu'),
                'navy_dark'     => esc_html__('Deep Navy (#0B192C)', 'imatutu'),
                'primary_tint'  => esc_html__('Soft Primary Tint', 'imatutu'),
            ),
        ));

        // 4. Section Padding
        $wp_customize->add_setting("builder_sec_{$s}_padding", array(
            'default'           => 'medium',
            'sanitize_callback' => 'sanitize_key',
        ));
        $wp_customize->add_control("builder_sec_{$s}_padding", array(
            'label'   => esc_html__('Vertical Spacing (Padding)', 'imatutu'),
            'section' => $sec_id,
            'type'    => 'select',
            'choices' => array(
                'small'  => esc_html__('Compact (40px)', 'imatutu'),
                'medium' => esc_html__('Standard (80px)', 'imatutu'),
                'large'  => esc_html__('Generous (120px)', 'imatutu'),
            ),
        ));

        // 5. Grid Column Layout
        $wp_customize->add_setting("builder_sec_{$s}_layout", array(
            'default'           => ($s === 1) ? 'col-2' : (($s === 2) ? 'col-3' : 'col-1'),
            'sanitize_callback' => 'sanitize_key',
        ));
        $wp_customize->add_control("builder_sec_{$s}_layout", array(
            'label'   => esc_html__('Grid Column Structure', 'imatutu'),
            'section' => $sec_id,
            'type'    => 'select',
            'choices' => array(
                'col-1'   => esc_html__('1 Column (Full Width 100%)', 'imatutu'),
                'col-2'   => esc_html__('2 Equal Columns (50% : 50%)', 'imatutu'),
                'col-3'   => esc_html__('3 Equal Columns (33% : 33% : 33%)', 'imatutu'),
                'col-4'   => esc_html__('4 Equal Columns (25% : 25% : 25% : 25%)', 'imatutu'),
                'col-1-2' => esc_html__('Asymmetric (33% Left : 66% Right)', 'imatutu'),
                'col-2-1' => esc_html__('Asymmetric (66% Left : 33% Right)', 'imatutu'),
            ),
        ));

        // 6. Grid Spacing (Gap)
        $wp_customize->add_setting("builder_sec_{$s}_gap", array(
            'default'           => '24',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new Imatutu_Range_Slider_Control($wp_customize, "builder_sec_{$s}_gap", array(
            'label'   => esc_html__('Grid Gap (Spacing between columns)', 'imatutu'),
            'section' => $sec_id,
            'min'     => 0,
            'max'     => 64,
            'step'    => 8,
            'unit'    => 'px',
        )));

        // 7. Vertical Alignment
        $wp_customize->add_setting("builder_sec_{$s}_valign", array(
            'default'           => 'center',
            'sanitize_callback' => 'sanitize_key',
        ));
        $wp_customize->add_control("builder_sec_{$s}_valign", array(
            'label'   => esc_html__('Vertical Alignment', 'imatutu'),
            'section' => $sec_id,
            'type'    => 'select',
            'choices' => array(
                'top'     => esc_html__('Top Aligned', 'imatutu'),
                'center'  => esc_html__('Middle / Center Aligned', 'imatutu'),
                'stretch' => esc_html__('Equal Height (Stretch)', 'imatutu'),
            ),
        ));

        // Column Components (Up to 4 columns per section)
        for ($c = 1; $c <= 4; $c++) {
            $col_prefix = "builder_sec_{$s}_col_{$c}";

            // Component Type
            $wp_customize->add_setting("{$col_prefix}_type", array(
                'default'           => ($s === 1 && $c === 1) ? 'heading' : (($s === 1 && $c === 2) ? 'image' : (($s === 2 && $c <= 3) ? 'iconbox' : 'none')),
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_type", array(
                'label'       => sprintf(esc_html__('--- Column %d Component Type ---', 'imatutu'), $c),
                'description' => esc_html__('Select the type of content for this column.', 'imatutu'),
                'section'     => $sec_id,
                'type'        => 'select',
                'choices'     => array(
                    'none'      => esc_html__('-- Empty Column --', 'imatutu'),
                    'heading'   => esc_html__('Heading Title', 'imatutu'),
                    'paragraph' => esc_html__('Paragraph Text', 'imatutu'),
                    'image'     => esc_html__('Image / Visual', 'imatutu'),
                    'video'     => esc_html__('Responsive Video', 'imatutu'),
                    'button'    => esc_html__('CTA Button / Link', 'imatutu'),
                    'form'      => esc_html__('WPForms / Shortcode Form', 'imatutu'),
                    'iconbox'   => esc_html__('Icon Feature Box', 'imatutu'),
                    'counter'   => esc_html__('Metric Counter Statistic', 'imatutu'),
                    'accordion' => esc_html__('Accordion / FAQ Lipat', 'imatutu'),
                ),
            ));

            // Heading Settings
            $wp_customize->add_setting("{$col_prefix}_heading_text", array(
                'default'           => 'Empowering Enterprise Operations',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control("{$col_prefix}_heading_text", array(
                'label'   => sprintf(esc_html__('Col %d: Heading Text', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_heading_tag", array(
                'default'           => 'h2',
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_heading_tag", array(
                'label'   => sprintf(esc_html__('Col %d: Heading Tag', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'select',
                'choices' => array('h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4'),
            ));

            // Paragraph Content
            $wp_customize->add_setting("{$col_prefix}_paragraph_text", array(
                'default'           => 'Our dedicated outsourcing solutions help streamline business workflows and accelerate growth with 24/7 reliability.',
                'sanitize_callback' => 'sanitize_textarea_field',
            ));
            $wp_customize->add_control("{$col_prefix}_paragraph_text", array(
                'label'   => sprintf(esc_html__('Col %d: Paragraph Text', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'textarea',
            ));

            // Image Upload
            $wp_customize->add_setting("{$col_prefix}_image_url", array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ));
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "{$col_prefix}_image_url", array(
                'label'   => sprintf(esc_html__('Col %d: Image Upload', 'imatutu'), $c),
                'section' => $sec_id,
            )));

            $wp_customize->add_setting("{$col_prefix}_image_alt", array(
                'default'           => 'Imatutu Corporate Visual',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control("{$col_prefix}_image_alt", array(
                'label'   => sprintf(esc_html__('Col %d: Image Alt Text', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            // Video URL
            $wp_customize->add_setting("{$col_prefix}_video_url", array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ));
            $wp_customize->add_control("{$col_prefix}_video_url", array(
                'label'       => sprintf(esc_html__('Col %d: Video URL (YouTube, Vimeo, MP4)', 'imatutu'), $c),
                'description' => esc_html__('Paste a YouTube, Vimeo, or direct MP4 video link.', 'imatutu'),
                'section'     => $sec_id,
                'type'        => 'url',
            ));

            // Button Settings
            $wp_customize->add_setting("{$col_prefix}_btn_text", array(
                'default'           => 'Get Started Today',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control("{$col_prefix}_btn_text", array(
                'label'   => sprintf(esc_html__('Col %d: Button Text', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_btn_url", array(
                'default'           => 'https://imatutu.com/contact-us/',
                'sanitize_callback' => 'esc_url_raw',
            ));
            $wp_customize->add_control("{$col_prefix}_btn_url", array(
                'label'   => sprintf(esc_html__('Col %d: Button Link URL', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'url',
            ));

            $wp_customize->add_setting("{$col_prefix}_btn_style", array(
                'default'           => 'primary',
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_btn_style", array(
                'label'   => sprintf(esc_html__('Col %d: Button Style', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'select',
                'choices' => array(
                    'primary'   => esc_html__('Primary Solid (Blue)', 'imatutu'),
                    'secondary' => esc_html__('Secondary Solid (Navy)', 'imatutu'),
                    'outline'   => esc_html__('Outline Border', 'imatutu'),
                    'ghost'     => esc_html__('Ghost / Arrow Link', 'imatutu'),
                ),
            ));

            // Form Shortcode
            $wp_customize->add_setting("{$col_prefix}_form_shortcode", array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control("{$col_prefix}_form_shortcode", array(
                'label'       => sprintf(esc_html__('Col %d: Form Shortcode (WPForms / CF7)', 'imatutu'), $c),
                'description' => esc_html__('Example: [wpforms id="123"] or [contact-form-7 id="456"]', 'imatutu'),
                'section'     => $sec_id,
                'type'        => 'text',
            ));

            // Icon Box Settings
            $wp_customize->add_setting("{$col_prefix}_icon_preset", array(
                'default'           => ($c === 1) ? 'phone' : (($c === 2) ? 'monitor' : 'shield'),
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_icon_preset", array(
                'label'   => sprintf(esc_html__('Col %d: Icon Symbol', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'select',
                'choices' => array(
                    'phone'   => esc_html__('Phone (Contact Center)', 'imatutu'),
                    'monitor' => esc_html__('Monitor (Technical Support)', 'imatutu'),
                    'shield'  => esc_html__('Shield (Security & Trust)', 'imatutu'),
                    'chart'   => esc_html__('Chart (Analytics & Stats)', 'imatutu'),
                    'clock'   => esc_html__('Clock (24/7 Service)', 'imatutu'),
                    'file'    => esc_html__('File (Administration & Accounting)', 'imatutu'),
                ),
            ));

            $wp_customize->add_setting("{$col_prefix}_icon_title", array(
                'default'           => sprintf(esc_html__('Specialized Solution %d', 'imatutu'), $c),
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control("{$col_prefix}_icon_title", array(
                'label'   => sprintf(esc_html__('Col %d: Icon Box Title', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_icon_desc", array(
                'default'           => 'Enterprise service delivery tailored precisely to suit client requirements with high accuracy.',
                'sanitize_callback' => 'sanitize_textarea_field',
            ));
            $wp_customize->add_control("{$col_prefix}_icon_desc", array(
                'label'   => sprintf(esc_html__('Col %d: Icon Box Description', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'textarea',
            ));

            // Metric Counter
            $wp_customize->add_setting("{$col_prefix}_counter_num", array(
                'default'           => '99.9%',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control("{$col_prefix}_counter_num", array(
                'label'   => sprintf(esc_html__('Col %d: Counter Number', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_counter_lbl", array(
                'default'           => 'Uptime & Service Reliability',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control("{$col_prefix}_counter_lbl", array(
                'label'   => sprintf(esc_html__('Col %d: Counter Label', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            // Accordion FAQ (Q1 & A1)
            $wp_customize->add_setting("{$col_prefix}_faq_q", array(
                'default'           => 'How quickly can Imatutu deploy support teams?',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control("{$col_prefix}_faq_q", array(
                'label'   => sprintf(esc_html__('Col %d: Accordion Question', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_faq_a", array(
                'default'           => 'Our trained agents and technicians can be onboarded and active within 48 to 72 hours depending on scope.',
                'sanitize_callback' => 'sanitize_textarea_field',
            ));
            $wp_customize->add_control("{$col_prefix}_faq_a", array(
                'label'   => sprintf(esc_html__('Col %d: Accordion Answer', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'textarea',
            ));
        }
    }
}
add_action('customize_register', 'imatutu_register_builder_customizer', 30);

/**
 * Sanitization helper for checkboxes
 */
function imatutu_sanitize_checkbox($checked) {
    return (isset($checked) && true === (bool) $checked);
}
