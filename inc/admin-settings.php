<?php
/**
 * Imatutu Theme - Independent Admin Settings Dashboard
 *
 * Dedicated lightweight settings page inside WordPress Dashboard (wp-admin).
 * Bypasses the Customizer to ensure 100% stability on Plesk / restricted hosting.
 * Directly integrates with get_theme_mod() / set_theme_mod().
 *
 * @package Imatutu
 * @version 2.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Independent Menu Page in WordPress Admin Dashboard
 */
function imatutu_register_admin_settings_menu() {
    // Top-level Dashboard Menu
    add_menu_page(
        esc_html__('Imatutu Theme Settings', 'imatutu'),
        esc_html__('Imatutu Settings', 'imatutu'),
        'edit_theme_options',
        'imatutu-settings',
        'imatutu_render_admin_settings_page',
        'dashicons-art',
        59
    );

    // Submenu under Appearance for ease of discovery
    add_theme_page(
        esc_html__('Imatutu Theme Settings', 'imatutu'),
        esc_html__('Imatutu Global Settings', 'imatutu'),
        'edit_theme_options',
        'imatutu-settings',
        'imatutu_render_admin_settings_page'
    );
}
add_action('admin_menu', 'imatutu_register_admin_settings_menu');

/**
 * Handle Settings Form Submission
 */
function imatutu_handle_admin_settings_save() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['imatutu_settings_nonce'])) {
        return;
    }

    if (!check_admin_referer('imatutu_save_settings_action', 'imatutu_settings_nonce')) {
        wp_die(esc_html__('Security check failed.', 'imatutu'));
    }

    if (!current_user_can('edit_theme_options')) {
        wp_die(esc_html__('You do not have permission to edit theme settings.', 'imatutu'));
    }

    $active_tab = isset($_POST['current_tab']) ? sanitize_key($_POST['current_tab']) : 'colors';

    // 1. Typography Settings
    if (isset($_POST['typo_body_font'])) {
        set_theme_mod('typo_body_font', sanitize_text_field($_POST['typo_body_font']));
    }
    if (isset($_POST['typo_heading_font'])) {
        set_theme_mod('typo_heading_font', sanitize_text_field($_POST['typo_heading_font']));
    }
    if (isset($_POST['typo_base_size'])) {
        $size = absint($_POST['typo_base_size']);
        if ($size >= 12 && $size <= 24) {
            set_theme_mod('typo_base_size', $size);
        }
    }

    // 2. Color Settings
    if (isset($_POST['color_preset'])) {
        set_theme_mod('color_preset', sanitize_key($_POST['color_preset']));
    }
    if (isset($_POST['primary_color'])) {
        set_theme_mod('primary_color', sanitize_hex_color($_POST['primary_color']));
    }
    if (isset($_POST['secondary_color'])) {
        set_theme_mod('secondary_color', sanitize_hex_color($_POST['secondary_color']));
    }
    if (isset($_POST['accent_color'])) {
        set_theme_mod('accent_color', sanitize_hex_color($_POST['accent_color']));
    }

    // 3. Brand Identity & Header Contacts
    if (isset($_POST['imatutu_company_subtitle'])) {
        set_theme_mod('imatutu_company_subtitle', sanitize_text_field($_POST['imatutu_company_subtitle']));
    }
    if (isset($_POST['imatutu_phone'])) {
        set_theme_mod('imatutu_phone', sanitize_text_field($_POST['imatutu_phone']));
    }
    if (isset($_POST['imatutu_email'])) {
        set_theme_mod('imatutu_email', sanitize_email($_POST['imatutu_email']));
    }
    if (isset($_POST['imatutu_whatsapp_number'])) {
        set_theme_mod('imatutu_whatsapp_number', sanitize_text_field($_POST['imatutu_whatsapp_number']));
    }

    // 4. Floating WhatsApp & AI Chatbot
    $enable_wa = !empty($_POST['imatutu_enable_floating_wa']);
    set_theme_mod('imatutu_enable_floating_wa', $enable_wa);

    if (isset($_POST['imatutu_chatbot_id'])) {
        set_theme_mod('imatutu_chatbot_id', sanitize_text_field($_POST['imatutu_chatbot_id']));
    }

    // 5. Footer & Legal
    if (isset($_POST['footer_tagline'])) {
        set_theme_mod('footer_tagline', sanitize_text_field($_POST['footer_tagline']));
    }
    if (isset($_POST['footer_address_1'])) {
        set_theme_mod('footer_address_1', sanitize_textarea_field($_POST['footer_address_1']));
    }
    if (isset($_POST['footer_address_2'])) {
        set_theme_mod('footer_address_2', sanitize_textarea_field($_POST['footer_address_2']));
    }
    if (isset($_POST['footer_copyright'])) {
        set_theme_mod('footer_copyright', sanitize_text_field($_POST['footer_copyright']));
    }

    // Redirect to prevent form resubmission
    $redirect_url = add_query_arg(
        array(
            'page'  => 'imatutu-settings',
            'tab'   => $active_tab,
            'saved' => 'true',
        ),
        admin_url('admin.php')
    );

    wp_safe_redirect($redirect_url);
    exit;
}
add_action('admin_init', 'imatutu_handle_admin_settings_save');

/**
 * Render the Admin Settings Page
 */
function imatutu_render_admin_settings_page() {
    if (!current_user_can('edit_theme_options')) {
        return;
    }

    // Active Tab Handling
    $active_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'colors';
    $is_saved   = isset($_GET['saved']) && $_GET['saved'] === 'true';

    // Fonts & Palettes Helpers
    $fonts    = function_exists('imatutu_get_curated_fonts') ? imatutu_get_curated_fonts() : array('Plus Jakarta Sans' => 'Plus Jakarta Sans');
    $palettes = function_exists('imatutu_get_color_palettes') ? imatutu_get_color_palettes() : array();

    // Current Values
    $current_preset    = get_theme_mod('color_preset', 'pertamina_blue');
    $default_colors    = isset($palettes[$current_preset]) ? $palettes[$current_preset] : array('primary' => '#1559ED', 'secondary' => '#0B192C', 'accent' => '#E21F23');
    $primary_color     = get_theme_mod('primary_color', $default_colors['primary']);
    $secondary_color   = get_theme_mod('secondary_color', $default_colors['secondary']);
    $accent_color      = get_theme_mod('accent_color', $default_colors['accent']);

    $body_font         = get_theme_mod('typo_body_font', 'Plus Jakarta Sans');
    $heading_font      = get_theme_mod('typo_heading_font', 'Plus Jakarta Sans');
    $base_size         = get_theme_mod('typo_base_size', 16);

    $company_subtitle  = get_theme_mod('imatutu_company_subtitle', 'by PT Karya Antara Negeri | PT Karya Antara Benua');
    $phone             = get_theme_mod('imatutu_phone', '+62 851 6893 2460');
    $email             = get_theme_mod('imatutu_email', 'office@imatutu.com');
    $whatsapp_number   = get_theme_mod('imatutu_whatsapp_number', '6285168932460');
    $enable_floating_wa = get_theme_mod('imatutu_enable_floating_wa', true);
    $chatbot_id        = get_theme_mod('imatutu_chatbot_id', 'cm8gjb24m11rmrik59ko46vdi');

    $footer_tagline    = get_theme_mod('footer_tagline', 'Integrated Solutions for All Your Business Needs');
    $footer_address_1  = get_theme_mod('footer_address_1', 'Jl. Gatot Subroto Barat No.283, Pemecutan Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80111');
    $footer_address_2  = get_theme_mod('footer_address_2', 'Jl. Gatot Subroto Tengah No.45F, Dauh Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80239');
    $footer_copyright  = get_theme_mod('footer_copyright', '© Copyright Imatutu. All Rights Reserved.');
    ?>

    <div class="wrap imatutu-settings-wrap">
        <h1 class="wp-heading-inline">
            <span class="dashicons dashicons-art" style="font-size: 28px; width: 28px; height: 28px; margin-right: 8px; vertical-align: middle; color: #1559ED;"></span>
            <?php esc_html_e('Imatutu Theme Settings', 'imatutu'); ?>
        </h1>
        <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" class="page-title-action" style="margin-left: 10px;">
            <?php esc_html_e('Lihat Website Frontend', 'imatutu'); ?> &rarr;
        </a>
        <hr class="wp-header-end">

        <?php if ($is_saved) : ?>
            <div class="notice notice-success is-dismissible" style="border-left-color: #10B981; margin-top: 15px;">
                <p><strong><?php esc_html_e('Pengaturan Imatutu berhasil disimpan!', 'imatutu'); ?></strong> <?php esc_html_e('Seluruh perubahan warna, font, dan identitas langsung diterapkan pada website.', 'imatutu'); ?></p>
            </div>
        <?php endif; ?>

        <p class="description" style="font-size: 14px; margin-bottom: 20px;">
            <?php esc_html_e('Panel pengaturan independen tema Imatutu. Bekerja langsung di Dashboard tanpa beban memori Customizer sehingga 100% aman, stabil, dan cepat.', 'imatutu'); ?>
        </p>

        <!-- Navigation Tabs -->
        <nav class="nav-tab-wrapper wp-clearfix" style="margin-bottom: 25px;">
            <a href="?page=imatutu-settings&tab=colors" class="nav-tab <?php echo $active_tab === 'colors' ? 'nav-tab-active' : ''; ?>">
                <span class="dashicons dashicons-color-picker" style="margin-right: 4px;"></span>
                <?php esc_html_e('1. Warna & Palet Brand', 'imatutu'); ?>
            </a>
            <a href="?page=imatutu-settings&tab=typography" class="nav-tab <?php echo $active_tab === 'typography' ? 'nav-tab-active' : ''; ?>">
                <span class="dashicons dashicons-editor-textcolor" style="margin-right: 4px;"></span>
                <?php esc_html_e('2. Tipografi & Font', 'imatutu'); ?>
            </a>
            <a href="?page=imatutu-settings&tab=contacts" class="nav-tab <?php echo $active_tab === 'contacts' ? 'nav-tab-active' : ''; ?>">
                <span class="dashicons dashicons-id" style="margin-right: 4px;"></span>
                <?php esc_html_e('3. Identitas & Kontak Header', 'imatutu'); ?>
            </a>
            <a href="?page=imatutu-settings&tab=floating" class="nav-tab <?php echo $active_tab === 'floating' ? 'nav-tab-active' : ''; ?>">
                <span class="dashicons dashicons-format-chat" style="margin-right: 4px;"></span>
                <?php esc_html_e('4. WhatsApp & AI Chatbot', 'imatutu'); ?>
            </a>
            <a href="?page=imatutu-settings&tab=footer" class="nav-tab <?php echo $active_tab === 'footer' ? 'nav-tab-active' : ''; ?>">
                <span class="dashicons dashicons-editor-table" style="margin-right: 4px;"></span>
                <?php esc_html_e('5. Footer & Legal', 'imatutu'); ?>
            </a>
        </nav>

        <form method="post" action="" style="max-width: 900px; background: #fff; padding: 25px 30px; border-radius: 8px; border: 1px solid #c3c4c7; box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
            <?php wp_nonce_field('imatutu_save_settings_action', 'imatutu_settings_nonce'); ?>
            <input type="hidden" name="current_tab" value="<?php echo esc_attr($active_tab); ?>">

            <!-- ========================================================= -->
            <!-- TAB 1: COLORS & PALETTES                                 -->
            <!-- ========================================================= -->
            <?php if ($active_tab === 'colors') : ?>
                <h2 style="font-size: 18px; border-bottom: 2px solid #1559ED; padding-bottom: 10px; margin-bottom: 20px;">
                    <?php esc_html_e('Pengaturan Palet Warna Identitas Brand', 'imatutu'); ?>
                </h2>

                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="color_preset"><?php esc_html_e('1-Click Color Preset', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <select name="color_preset" id="color_preset" style="min-width: 320px; font-size: 14px; padding: 6px 10px;">
                                    <?php foreach ($palettes as $key => $pal) : ?>
                                        <option value="<?php echo esc_attr($key); ?>" <?php selected($current_preset, $key); ?>>
                                            <?php echo esc_html($pal['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="description" style="margin-top: 8px;">
                                    <?php esc_html_e('Pilih kombinasi warna korporat siap pakai. Klik preset untuk otomatis mengisi nilai warna di bawah.', 'imatutu'); ?>
                                </p>

                                <!-- Visual Preset Swatches -->
                                <div style="display: flex; gap: 12px; margin-top: 15px; flex-wrap: wrap;">
                                    <?php foreach ($palettes as $key => $pal) : ?>
                                        <button type="button" class="button btn-apply-preset <?php echo $current_preset === $key ? 'button-primary' : ''; ?>" data-preset="<?php echo esc_attr($key); ?>" data-primary="<?php echo esc_attr($pal['primary']); ?>" data-secondary="<?php echo esc_attr($pal['secondary']); ?>" data-accent="<?php echo esc_attr($pal['accent']); ?>" style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px;">
                                            <span style="display: inline-block; width: 14px; height: 14px; border-radius: 50%; background: <?php echo esc_attr($pal['primary']); ?>; border: 1px solid #fff; box-shadow: 0 0 2px rgba(0,0,0,0.3);"></span>
                                            <span style="display: inline-block; width: 14px; height: 14px; border-radius: 50%; background: <?php echo esc_attr($pal['secondary']); ?>; border: 1px solid #fff; box-shadow: 0 0 2px rgba(0,0,0,0.3);"></span>
                                            <span style="display: inline-block; width: 14px; height: 14px; border-radius: 50%; background: <?php echo esc_attr($pal['accent']); ?>; border: 1px solid #fff; box-shadow: 0 0 2px rgba(0,0,0,0.3);"></span>
                                            <span><?php echo esc_html(explode(' (', $pal['name'])[0]); ?></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="primary_color"><?php esc_html_e('Primary Color (Warna Utama)', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <input type="color" id="primary_color_picker" value="<?php echo esc_attr($primary_color); ?>" style="width: 44px; height: 36px; padding: 2px; cursor: pointer; border-radius: 4px; border: 1px solid #8c8f94;">
                                    <input type="text" name="primary_color" id="primary_color" value="<?php echo esc_attr($primary_color); ?>" class="regular-text" style="width: 140px; font-family: monospace; font-size: 14px;">
                                </div>
                                <p class="description"><?php esc_html_e('Warna aksen tombol utama, badge highlight, dan link hover (Default: #1559ED).', 'imatutu'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="secondary_color"><?php esc_html_e('Secondary Color (Navy Gelap)', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <input type="color" id="secondary_color_picker" value="<?php echo esc_attr($secondary_color); ?>" style="width: 44px; height: 36px; padding: 2px; cursor: pointer; border-radius: 4px; border: 1px solid #8c8f94;">
                                    <input type="text" name="secondary_color" id="secondary_color" value="<?php echo esc_attr($secondary_color); ?>" class="regular-text" style="width: 140px; font-family: monospace; font-size: 14px;">
                                </div>
                                <p class="description"><?php esc_html_e('Warna judul section, latar belakang footer, dan topbar kontras (Default: #0B192C).', 'imatutu'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="accent_color"><?php esc_html_e('Accent Color (Aksen Merah/Emas)', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <input type="color" id="accent_color_picker" value="<?php echo esc_attr($accent_color); ?>" style="width: 44px; height: 36px; padding: 2px; cursor: pointer; border-radius: 4px; border: 1px solid #8c8f94;">
                                    <input type="text" name="accent_color" id="accent_color" value="<?php echo esc_attr($accent_color); ?>" class="regular-text" style="width: 140px; font-family: monospace; font-size: 14px;">
                                </div>
                                <p class="description"><?php esc_html_e('Warna garis aksen judul, badge diskon, dan titik status aktif (Default: #E21F23).', 'imatutu'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>

            <!-- ========================================================= -->
            <!-- TAB 2: TYPOGRAPHY                                        -->
            <!-- ========================================================= -->
            <?php elseif ($active_tab === 'typography') : ?>
                <h2 style="font-size: 18px; border-bottom: 2px solid #1559ED; padding-bottom: 10px; margin-bottom: 20px;">
                    <?php esc_html_e('Pengaturan Tipografi & Google Fonts Terkurasi', 'imatutu'); ?>
                </h2>

                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="typo_body_font"><?php esc_html_e('Body Font Family', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <select name="typo_body_font" id="typo_body_font" style="min-width: 320px; font-size: 14px; padding: 6px 10px;">
                                    <?php foreach ($fonts as $font_name => $font_label) : ?>
                                        <option value="<?php echo esc_attr($font_name); ?>" <?php selected($body_font, $font_name); ?>>
                                            <?php echo esc_html($font_label); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="description"><?php esc_html_e('Font utama untuk paragraf dan teks isi website (Default: Plus Jakarta Sans).', 'imatutu'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="typo_heading_font"><?php esc_html_e('Headings Font Family', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <select name="typo_heading_font" id="typo_heading_font" style="min-width: 320px; font-size: 14px; padding: 6px 10px;">
                                    <?php foreach ($fonts as $font_name => $font_label) : ?>
                                        <option value="<?php echo esc_attr($font_name); ?>" <?php selected($heading_font, $font_name); ?>>
                                            <?php echo esc_html($font_label); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="description"><?php esc_html_e('Font khusus untuk judul section, hero title, dan kartu bento (H1 - H6).', 'imatutu'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="typo_base_size"><?php esc_html_e('Base Font Size (px)', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <input type="number" name="typo_base_size" id="typo_base_size" value="<?php echo esc_attr($base_size); ?>" min="14" max="20" step="1" style="width: 90px; padding: 6px 10px; font-size: 14px;"> px
                                <p class="description"><?php esc_html_e('Ukuran dasar font teks body (Rentang: 14px - 20px, Default: 16px). Seluruh ukuran rem akan menyesuaikan otomatis.', 'imatutu'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>

            <!-- ========================================================= -->
            <!-- TAB 3: CONTACTS & BRAND IDENTITY                         -->
            <!-- ========================================================= -->
            <?php elseif ($active_tab === 'contacts') : ?>
                <h2 style="font-size: 18px; border-bottom: 2px solid #1559ED; padding-bottom: 10px; margin-bottom: 20px;">
                    <?php esc_html_e('Identitas Brand & Kontak Topbar Header', 'imatutu'); ?>
                </h2>

                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="imatutu_company_subtitle"><?php esc_html_e('Legal Entity Subtitle', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="imatutu_company_subtitle" id="imatutu_company_subtitle" value="<?php echo esc_attr($company_subtitle); ?>" class="large-text" style="font-size: 14px;">
                                <p class="description"><?php esc_html_e('Keterangan nama entitas perseroan di top utility bar (Default: by PT Karya Antara Negeri | PT Karya Antara Benua).', 'imatutu'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="imatutu_phone"><?php esc_html_e('Nomor Telepon Kantor', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="imatutu_phone" id="imatutu_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text" style="font-size: 14px;">
                                <p class="description"><?php esc_html_e('Ditampilkan di topbar dan footer (Contoh: +62 851 6893 2460).', 'imatutu'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="imatutu_email"><?php esc_html_e('Alamat Email Resmi', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <input type="email" name="imatutu_email" id="imatutu_email" value="<?php echo esc_attr($email); ?>" class="regular-text" style="font-size: 14px;">
                                <p class="description"><?php esc_html_e('Email kontak korporat di top utility bar & footer (Contoh: office@imatutu.com).', 'imatutu'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="imatutu_whatsapp_number"><?php esc_html_e('WhatsApp Number (Direct Link)', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="imatutu_whatsapp_number" id="imatutu_whatsapp_number" value="<?php echo esc_attr($whatsapp_number); ?>" class="regular-text" style="font-size: 14px;">
                                <p class="description"><?php esc_html_e('Nomor WhatsApp internasional tanpa tanda + (Contoh: 6285168932460).', 'imatutu'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>

            <!-- ========================================================= -->
            <!-- TAB 4: FLOATING & AI CHATBOT                             -->
            <!-- ========================================================= -->
            <?php elseif ($active_tab === 'floating') : ?>
                <h2 style="font-size: 18px; border-bottom: 2px solid #1559ED; padding-bottom: 10px; margin-bottom: 20px;">
                    <?php esc_html_e('Tombol Melayang WhatsApp & Fastbots AI Chatbot', 'imatutu'); ?>
                </h2>

                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <?php esc_html_e('Floating WhatsApp Button', 'imatutu'); ?>
                            </th>
                            <td>
                                <label for="imatutu_enable_floating_wa" style="font-weight: 600; cursor: pointer;">
                                    <input type="checkbox" name="imatutu_enable_floating_wa" id="imatutu_enable_floating_wa" value="1" <?php checked($enable_floating_wa, true); ?>>
                                    <?php esc_html_e('Aktifkan Tombol WhatsApp Melayang di Pojok Kanan Bawah', 'imatutu'); ?>
                                </label>
                                <p class="description"><?php esc_html_e('Memberikan akses direct chat seketika bagi pengunjung website ke nomor WhatsApp yang dikonfigurasi.', 'imatutu'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="imatutu_chatbot_id"><?php esc_html_e('Fastbots.ai Bot ID', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="imatutu_chatbot_id" id="imatutu_chatbot_id" value="<?php echo esc_attr($chatbot_id); ?>" class="regular-text" style="font-size: 14px;">
                                <p class="description"><?php esc_html_e('Masukkan Bot ID dari Fastbots.ai (Kosongkan input ini jika ingin menonaktifkan widget chatbot).', 'imatutu'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>

            <!-- ========================================================= -->
            <!-- TAB 5: FOOTER & LEGAL                                    -->
            <!-- ========================================================= -->
            <?php elseif ($active_tab === 'footer') : ?>
                <h2 style="font-size: 18px; border-bottom: 2px solid #1559ED; padding-bottom: 10px; margin-bottom: 20px;">
                    <?php esc_html_e('Informasi Footer & Legal Kantor', 'imatutu'); ?>
                </h2>

                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="footer_tagline"><?php esc_html_e('Footer Brand Tagline', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="footer_tagline" id="footer_tagline" value="<?php echo esc_attr($footer_tagline); ?>" class="large-text" style="font-size: 14px;">
                                <p class="description"><?php esc_html_e('Slogan merek di bawah logo footer.', 'imatutu'); ?></p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="footer_address_1"><?php esc_html_e('Alamat Kantor 1 (Gatot Subroto Barat)', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <textarea name="footer_address_1" id="footer_address_1" rows="3" class="large-text" style="font-size: 14px;"><?php echo esc_textarea($footer_address_1); ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="footer_address_2"><?php esc_html_e('Alamat Kantor 2 (Gatot Subroto Tengah)', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <textarea name="footer_address_2" id="footer_address_2" rows="3" class="large-text" style="font-size: 14px;"><?php echo esc_textarea($footer_address_2); ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="footer_copyright"><?php esc_html_e('Teks Hak Cipta (Copyright)', 'imatutu'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="footer_copyright" id="footer_copyright" value="<?php echo esc_attr($footer_copyright); ?>" class="large-text" style="font-size: 14px;">
                                <p class="description"><?php esc_html_e('Teks copyright di baris paling bawah footer (Tahun akan otomatis disesuaikan).', 'imatutu'); ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            <?php endif; ?>

            <!-- Submit Button Bar -->
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #dcdcde; display: flex; align-items: center; justify-content: space-between;">
                <input type="submit" name="submit" id="submit" class="button button-primary button-large" value="<?php esc_attr_e('Simpan Perubahan', 'imatutu'); ?>" style="padding: 4px 24px; font-size: 15px; height: 42px;">
                <span class="description" style="font-style: italic;">
                    <?php esc_html_e('Data disimpan langsung ke theme_mods tanpa ketergantungan Customizer.', 'imatutu'); ?>
                </span>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sync color picker with text input
        function bindColorInput(pickerId, textId) {
            var picker = document.getElementById(pickerId);
            var text = document.getElementById(textId);
            if (!picker || !text) return;

            picker.addEventListener('input', function() {
                text.value = picker.value.toUpperCase();
            });
            text.addEventListener('input', function() {
                if (/^#[0-9A-F]{6}$/i.test(text.value)) {
                    picker.value = text.value;
                }
            });
        }
        bindColorInput('primary_color_picker', 'primary_color');
        bindColorInput('secondary_color_picker', 'secondary_color');
        bindColorInput('accent_color_picker', 'accent_color');

        // Apply 1-Click Color Preset buttons
        var presetBtns = document.querySelectorAll('.btn-apply-preset');
        presetBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var preset = this.getAttribute('data-preset');
                var pri = this.getAttribute('data-primary');
                var sec = this.getAttribute('data-secondary');
                var acc = this.getAttribute('data-accent');

                var sel = document.getElementById('color_preset');
                if (sel) sel.value = preset;

                var priInput = document.getElementById('primary_color');
                var priPick = document.getElementById('primary_color_picker');
                if (priInput && priPick) { priInput.value = pri; priPick.value = pri; }

                var secInput = document.getElementById('secondary_color');
                var secPick = document.getElementById('secondary_color_picker');
                if (secInput && secPick) { secInput.value = sec; secPick.value = sec; }

                var accInput = document.getElementById('accent_color');
                var accPick = document.getElementById('accent_color_picker');
                if (accInput && accPick) { accInput.value = acc; accPick.value = acc; }

                presetBtns.forEach(function(b) { b.classList.remove('button-primary'); });
                this.classList.add('button-primary');
            });
        });

        // Also update colors when dropdown changes
        var presetSelect = document.getElementById('color_preset');
        if (presetSelect) {
            presetSelect.addEventListener('change', function() {
                var selectedVal = this.value;
                var targetBtn = document.querySelector('.btn-apply-preset[data-preset="' + selectedVal + '"]');
                if (targetBtn) {
                    targetBtn.click();
                }
            });
        }
    });
    </script>
    <?php
}
