<?php
/**
 * Layout Engine & Modular Page Builder Customizer Controller
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('imatutu_register_builder_customizer')) {
    function imatutu_register_builder_customizer($wp_customize) {
        if (function_exists('imatutu_load_customizer_controls')) {
            imatutu_load_customizer_controls();
        }

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
            'transport'         => 'postMessage',
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
            'transport'         => 'postMessage',
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
            'transport'         => 'postMessage',
        ));
        if (class_exists('Imatutu_Range_Slider_Control')) {
            $wp_customize->add_control(new Imatutu_Range_Slider_Control($wp_customize, "builder_sec_{$s}_gap", array(
                'label'   => esc_html__('Grid Gap (Spacing between columns)', 'imatutu'),
                'section' => $sec_id,
                'min'     => 0,
                'max'     => 64,
                'step'    => 8,
                'unit'    => 'px',
            )));
        } else {
            $wp_customize->add_control("builder_sec_{$s}_gap", array(
                'label'   => esc_html__('Grid Gap (px)', 'imatutu'),
                'section' => $sec_id,
                'type'    => 'number',
            ));
        }

        // 7. Vertical Alignment
        $wp_customize->add_setting("builder_sec_{$s}_valign", array(
            'default'           => 'center',
            'sanitize_callback' => 'sanitize_key',
            'transport'         => 'postMessage',
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

            // A. Heading Settings
            $wp_customize->add_setting("{$col_prefix}_heading_text", array(
                'default'           => 'Empowering Enterprise Operations',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
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

            $wp_customize->add_setting("{$col_prefix}_heading_align", array(
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_heading_align", array(
                'label'   => sprintf(esc_html__('Col %d: Heading Alignment', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'select',
                'choices' => array(
                    'left'   => esc_html__('Left', 'imatutu'),
                    'center' => esc_html__('Center', 'imatutu'),
                    'right'  => esc_html__('Right', 'imatutu'),
                ),
            ));

            $wp_customize->add_setting("{$col_prefix}_heading_accent", array(
                'default'           => true,
                'sanitize_callback' => 'imatutu_sanitize_checkbox',
            ));
            $wp_customize->add_control("{$col_prefix}_heading_accent", array(
                'label'   => sprintf(esc_html__('Col %d: Show Accent Line Bar', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'checkbox',
            ));

            // B. Paragraph Settings
            $wp_customize->add_setting("{$col_prefix}_paragraph_text", array(
                'default'           => 'Our dedicated outsourcing solutions help streamline business workflows and accelerate growth with 24/7 reliability.',
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_paragraph_text", array(
                'label'   => sprintf(esc_html__('Col %d: Paragraph Text', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'textarea',
            ));

            $wp_customize->add_setting("{$col_prefix}_paragraph_size", array(
                'default'           => 'regular',
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_paragraph_size", array(
                'label'   => sprintf(esc_html__('Col %d: Paragraph Text Size', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'select',
                'choices' => array(
                    'small'   => esc_html__('Small (14px)', 'imatutu'),
                    'regular' => esc_html__('Regular (16px)', 'imatutu'),
                    'lead'    => esc_html__('Lead / Large (18px)', 'imatutu'),
                ),
            ));

            $wp_customize->add_setting("{$col_prefix}_paragraph_align", array(
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_paragraph_align", array(
                'label'   => sprintf(esc_html__('Col %d: Paragraph Alignment', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'select',
                'choices' => array(
                    'left'    => esc_html__('Left', 'imatutu'),
                    'center'  => esc_html__('Center', 'imatutu'),
                    'right'   => esc_html__('Right', 'imatutu'),
                    'justify' => esc_html__('Justify', 'imatutu'),
                ),
            ));

            // C. Image Settings
            $wp_customize->add_setting("{$col_prefix}_image_url", array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ));
            if (class_exists('WP_Customize_Image_Control')) {
                $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "{$col_prefix}_image_url", array(
                    'label'   => sprintf(esc_html__('Col %d: Image Upload', 'imatutu'), $c),
                    'section' => $sec_id,
                )));
            } else {
                $wp_customize->add_control("{$col_prefix}_image_url", array(
                    'label'   => sprintf(esc_html__('Col %d: Image URL', 'imatutu'), $c),
                    'section' => $sec_id,
                    'type'    => 'url',
                ));
            }

            $wp_customize->add_setting("{$col_prefix}_image_alt", array(
                'default'           => 'Imatutu Corporate Visual',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control("{$col_prefix}_image_alt", array(
                'label'   => sprintf(esc_html__('Col %d: Image Alt Text', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_image_ratio", array(
                'default'           => 'auto',
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_image_ratio", array(
                'label'   => sprintf(esc_html__('Col %d: Image Aspect Ratio', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'select',
                'choices' => array(
                    'auto' => esc_html__('Original (Auto)', 'imatutu'),
                    '16-9' => esc_html__('Widescreen 16:9', 'imatutu'),
                    '4-3'  => esc_html__('Standard 4:3', 'imatutu'),
                    '1-1'  => esc_html__('Square 1:1', 'imatutu'),
                ),
            ));

            $wp_customize->add_setting("{$col_prefix}_image_radius", array(
                'default'           => 'rounded-xl',
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_image_radius", array(
                'label'   => sprintf(esc_html__('Col %d: Image Border Radius', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'select',
                'choices' => array(
                    'none'         => esc_html__('None (Sharp Corners)', 'imatutu'),
                    'rounded-md'   => esc_html__('Medium (8px)', 'imatutu'),
                    'rounded-xl'   => esc_html__('Large (16px)', 'imatutu'),
                    'rounded-full' => esc_html__('Circular / Pill', 'imatutu'),
                ),
            ));

            $wp_customize->add_setting("{$col_prefix}_image_link", array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ));
            $wp_customize->add_control("{$col_prefix}_image_link", array(
                'label'   => sprintf(esc_html__('Col %d: Image Click URL (Optional)', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'url',
            ));

            $wp_customize->add_setting("{$col_prefix}_image_lightbox", array(
                'default'           => true,
                'sanitize_callback' => 'imatutu_sanitize_checkbox',
            ));
            $wp_customize->add_control("{$col_prefix}_image_lightbox", array(
                'label'       => sprintf(esc_html__('Col %d: Open in Popup Lightbox', 'imatutu'), $c),
                'description' => esc_html__('Enabled when Image Click URL is empty.', 'imatutu'),
                'section'     => $sec_id,
                'type'        => 'checkbox',
            ));

            // D. Video Settings
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

            $wp_customize->add_setting("{$col_prefix}_video_aspect", array(
                'default'           => '16-9',
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_video_aspect", array(
                'label'   => sprintf(esc_html__('Col %d: Video Aspect Ratio', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'select',
                'choices' => array(
                    '16-9' => esc_html__('16:9 Standard Widescreen', 'imatutu'),
                    '4-3'  => esc_html__('4:3 Standard Video', 'imatutu'),
                    '21-9' => esc_html__('21:9 Cinema Ultra-wide', 'imatutu'),
                ),
            ));

            $wp_customize->add_setting("{$col_prefix}_video_autoplay", array(
                'default'           => false,
                'sanitize_callback' => 'imatutu_sanitize_checkbox',
            ));
            $wp_customize->add_control("{$col_prefix}_video_autoplay", array(
                'label'       => sprintf(esc_html__('Col %d: Autoplay Video (Muted)', 'imatutu'), $c),
                'section'     => $sec_id,
                'type'        => 'checkbox',
            ));

            // E. Button Settings
            $wp_customize->add_setting("{$col_prefix}_btn_text", array(
                'default'           => 'Get Started Today',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
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

            $wp_customize->add_setting("{$col_prefix}_btn_size", array(
                'default'           => 'md',
                'sanitize_callback' => 'sanitize_key',
            ));
            $wp_customize->add_control("{$col_prefix}_btn_size", array(
                'label'   => sprintf(esc_html__('Col %d: Button Size', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'select',
                'choices' => array(
                    'sm' => esc_html__('Small', 'imatutu'),
                    'md' => esc_html__('Medium (Default)', 'imatutu'),
                    'lg' => esc_html__('Large CTA', 'imatutu'),
                ),
            ));

            $wp_customize->add_setting("{$col_prefix}_btn_target", array(
                'default'           => false,
                'sanitize_callback' => 'imatutu_sanitize_checkbox',
            ));
            $wp_customize->add_control("{$col_prefix}_btn_target", array(
                'label'   => sprintf(esc_html__('Col %d: Open Link in New Tab (_blank)', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'checkbox',
            ));

            // F. Form Shortcode
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

            $wp_customize->add_setting("{$col_prefix}_form_card_style", array(
                'default'           => true,
                'sanitize_callback' => 'imatutu_sanitize_checkbox',
            ));
            $wp_customize->add_control("{$col_prefix}_form_card_style", array(
                'label'   => sprintf(esc_html__('Col %d: Render with Border Card & Shadow', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'checkbox',
            ));

            // G. Icon Box Settings
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
                    'map'     => esc_html__('Map (Global Network)', 'imatutu'),
                    'user'    => esc_html__('User (Dedicated Specialists)', 'imatutu'),
                ),
            ));

            $wp_customize->add_setting("{$col_prefix}_icon_title", array(
                'default'           => sprintf(esc_html__('Specialized Solution %d', 'imatutu'), $c),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_icon_title", array(
                'label'   => sprintf(esc_html__('Col %d: Icon Box Title', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_icon_desc", array(
                'default'           => 'Enterprise service delivery tailored precisely to suit client requirements with high accuracy.',
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_icon_desc", array(
                'label'   => sprintf(esc_html__('Col %d: Icon Box Description', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'textarea',
            ));

            $wp_customize->add_setting("{$col_prefix}_icon_link", array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ));
            $wp_customize->add_control("{$col_prefix}_icon_link", array(
                'label'   => sprintf(esc_html__('Col %d: Icon Box Link URL (Optional)', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'url',
            ));

            // H. Metric Counter
            $wp_customize->add_setting("{$col_prefix}_counter_num", array(
                'default'           => '99.9%',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_counter_num", array(
                'label'   => sprintf(esc_html__('Col %d: Counter Number', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_counter_lbl", array(
                'default'           => 'Uptime & Service Reliability',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_counter_lbl", array(
                'label'   => sprintf(esc_html__('Col %d: Counter Label', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_counter_subtext", array(
                'default'           => 'Continuous 24/7 Monitoring',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_counter_subtext", array(
                'label'   => sprintf(esc_html__('Col %d: Counter Subtext', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            // I. Accordion FAQ (Items 1 - 3)
            $wp_customize->add_setting("{$col_prefix}_faq_q1", array(
                'default'           => 'How quickly can Imatutu deploy support teams?',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_faq_q1", array(
                'label'   => sprintf(esc_html__('Col %d: Accordion Q1', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_faq_a1", array(
                'default'           => 'Our trained agents and technicians can be onboarded and active within 48 to 72 hours depending on scope.',
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_faq_a1", array(
                'label'   => sprintf(esc_html__('Col %d: Accordion A1', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'textarea',
            ));

            $wp_customize->add_setting("{$col_prefix}_faq_q2", array(
                'default'           => 'What industries does Imatutu specialize in?',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_faq_q2", array(
                'label'   => sprintf(esc_html__('Col %d: Accordion Q2', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_faq_a2", array(
                'default'           => 'We provide comprehensive business support across logistics, transport dispatch, IT technical support, customer care, and corporate administration.',
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_faq_a2", array(
                'label'   => sprintf(esc_html__('Col %d: Accordion A2', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'textarea',
            ));

            $wp_customize->add_setting("{$col_prefix}_faq_q3", array(
                'default'           => 'Do you offer 24/7 round-the-clock coverage?',
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_faq_q3", array(
                'label'   => sprintf(esc_html__('Col %d: Accordion Q3', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'text',
            ));

            $wp_customize->add_setting("{$col_prefix}_faq_a3", array(
                'default'           => 'Yes, our operational hubs operate 24/7/365 to deliver continuous global support across multiple timezones.',
                'sanitize_callback' => 'sanitize_textarea_field',
                'transport'         => 'postMessage',
            ));
            $wp_customize->add_control("{$col_prefix}_faq_a3", array(
                'label'   => sprintf(esc_html__('Col %d: Accordion A3', 'imatutu'), $c),
                'section' => $sec_id,
                'type'    => 'textarea',
            ));
        }
    }
}
}
add_action('customize_register', 'imatutu_register_builder_customizer', 30);

/**
 * Sanitization helper for checkboxes
 */
if (!function_exists('imatutu_sanitize_checkbox')) {
    function imatutu_sanitize_checkbox($checked) {
        return (isset($checked) && true === (bool) $checked);
    }
}
