<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #page and #content div and all content after.
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

$footer_tagline   = get_theme_mod('footer_tagline', 'Integrated Solutions for All Your Business Needs');
$footer_address_1 = get_theme_mod('footer_address_1', 'Jl. Gatot Subroto Barat No.283, Pemecutan Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80111');
$footer_address_2 = get_theme_mod('footer_address_2', 'Jl. Gatot Subroto Tengah No.45F, Dauh Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80239');
$footer_phone     = get_theme_mod('imatutu_phone', get_theme_mod('footer_phone', '+62 851 6893 2460'));
$footer_email     = get_theme_mod('imatutu_email', get_theme_mod('footer_email', 'office@imatutu.com'));
$footer_copyright = get_theme_mod('footer_copyright', '© Copyright Imatutu. All Rights Reserved.');
$fastbots_bot_id  = get_theme_mod('imatutu_chatbot_id', get_theme_mod('fastbots_bot_id', 'cm8gjb24m11rmrik59ko46vdi'));
?>

    <footer id="colophon" class="site-footer">
        <!-- Main Footer Content -->
        <div class="site-container footer-container">
            <div class="footer-grid">
                <!-- Column 1: Brand & Identity -->
                <div class="footer-col footer-col-brand">
                    <div class="footer-brand-wrap">
                        <span class="footer-brand-title"><?php echo esc_html(get_theme_mod('header_brand_text', 'IMATUTU')); ?></span>
                        <p class="footer-brand-tagline"><?php echo esc_html($footer_tagline); ?></p>
                    </div>
                    <div class="footer-corporate-entities">
                        <span class="entity-badge"><?php esc_html_e('Operated by:', 'imatutu'); ?></span>
                        <p class="entity-names">PT Karya Antara Negeri<br>PT Karya Antara Benua</p>
                    </div>
                </div>

                <!-- Column 2: Contact & Operational Offices -->
                <div class="footer-col footer-col-contact">
                    <h3 class="footer-heading"><?php esc_html_e('Our Locations & Contact', 'imatutu'); ?></h3>
                    
                    <div class="footer-contact-item">
                        <div class="contact-icon-wrap">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <div class="contact-text-wrap">
                            <strong class="office-label"><?php esc_html_e('Head Office (Gatshu Barat):', 'imatutu'); ?></strong>
                            <p class="footer-address-1"><?php echo nl2br(esc_html($footer_address_1)); ?></p>
                        </div>
                    </div>

                    <div class="footer-contact-item">
                        <div class="contact-icon-wrap">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <div class="contact-text-wrap">
                            <strong class="office-label"><?php esc_html_e('Branch Office (Gatshu Tengah):', 'imatutu'); ?></strong>
                            <p class="footer-address-2"><?php echo nl2br(esc_html($footer_address_2)); ?></p>
                        </div>
                    </div>

                    <div class="footer-direct-contacts">
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $footer_phone)); ?>" class="direct-contact-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span class="footer-phone-text"><?php echo esc_html($footer_phone); ?></span>
                        </a>
                        <a href="mailto:<?php echo esc_attr($footer_email); ?>" class="direct-contact-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <span class="footer-email-text"><?php echo esc_html($footer_email); ?></span>
                        </a>
                    </div>
                </div>

                <!-- Column 3: Quick Links Navigation -->
                <div class="footer-col footer-col-nav">
                    <h3 class="footer-heading"><?php esc_html_e('Quick Links', 'imatutu'); ?></h3>
                    <nav class="footer-navigation" aria-label="<?php esc_attr_e('Footer Navigation', 'imatutu'); ?>">
                        <?php
                        if (has_nav_menu('footer')) {
                            wp_nav_menu(array(
                                'theme_location' => 'footer',
                                'menu_class'     => 'footer-links-list',
                                'container'      => false,
                                'depth'          => 1,
                            ));
                        } else {
                            imatutu_default_footer_menu();
                        }
                        ?>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright Bar -->
        <div class="footer-bottom">
            <div class="site-container footer-bottom-container">
                <p class="copyright-text">
                    <?php 
                    $year = date('Y');
                    $custom_copy = str_replace('© Copyright', '© ' . $year, $footer_copyright);
                    echo esc_html($custom_copy);
                    ?>
                </p>
                <div class="footer-security-note">
                    <span><?php esc_html_e('Enterprise Business Process Outsourcing (BPO) & Contact Center Solutions', 'imatutu'); ?></span>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<!-- Fastbots AI Chatbot Integration (Disabled in Customizer Preview) -->
<?php if (!is_customize_preview() && !empty($fastbots_bot_id) && !wp_script_is('fastbots-chatbot', 'enqueued') && !wp_script_is('fastbots-chatbot', 'done')) : ?>
    <script id="fastbots-chatbot-js" defer data-bot-id="<?php echo esc_attr($fastbots_bot_id); ?>" src="https://app.fastbots.ai/embed.js"></script>
<?php endif; ?>

<!-- Floating WhatsApp Button -->
<?php if (get_theme_mod('imatutu_enable_floating_wa', true)) : 
    $wa_number = get_theme_mod('imatutu_whatsapp_number', '6285168932460');
?>
    <a href="https://wa.me/<?php echo esc_attr($wa_number); ?>" class="floating-wa-btn" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.044c.101-.116.433-.506.549-.68.116-.174.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.123.553 4.116 1.517 5.845l-1.611 5.885 6.06-1.589c1.657.904 3.559 1.417 5.58 1.417 6.627 0 12-5.373 12-12s-5.373-12-12-12z"/></svg>
    </a>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
