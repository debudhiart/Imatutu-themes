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
$footer_phone     = get_theme_mod('footer_phone', '+62 851 6893 2460');
$footer_email     = get_theme_mod('footer_email', 'office@imatutu.com');
$footer_copyright = get_theme_mod('footer_copyright', '© Copyright Imatutu. All Rights Reserved.');
$fastbots_bot_id  = get_theme_mod('fastbots_bot_id', 'cm8gjb24m11rmrik59ko46vdi');
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

<!-- Fastbots AI Chatbot Integration -->
<?php if (!empty($fastbots_bot_id)) : ?>
    <script id="fastbots-chatbot-js" defer data-bot-id="<?php echo esc_attr($fastbots_bot_id); ?>" src="https://app.fastbots.ai/embed.js"></script>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
