<?php
/**
 * Template part for displaying the Hero Section on the Homepage
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

$hero_h1        = get_theme_mod('hero_heading_1', 'The Trusted Choice For Your Business Support Requirements');
$hero_h2        = get_theme_mod('hero_heading_2', 'Integrated Solutions for All Your Business Needs');
$hero_bg        = get_theme_mod('hero_bg_image', '');
$hero_cta1_text = get_theme_mod('hero_cta_primary_text', 'Contact Us');
$hero_cta1_link = get_theme_mod('hero_cta_primary_link', 'https://imatutu.com/contact-us/');
$hero_cta2_text = get_theme_mod('hero_cta_secondary_text', 'Our Services');
$hero_cta2_link = get_theme_mod('hero_cta_secondary_link', '#services');

$hero_style = '';
if (!empty($hero_bg)) {
    $hero_style = 'style="background-image: linear-gradient(135deg, rgba(11, 25, 44, 0.92) 0%, rgba(21, 89, 237, 0.82) 100%), url(\'' . esc_url($hero_bg) . '\'); background-size: cover; background-position: center;"';
}
?>

<section id="hero" class="hero-section" <?php echo $hero_style; ?>>
    <div class="hero-shape-decor" aria-hidden="true"></div>
    <div class="site-container hero-container">
        <div class="hero-content">
            <!-- Badge Pill -->
            <div class="hero-badge-wrap">
                <span class="badge-pill">
                    <span class="badge-glow"></span>
                    <span class="badge-text"><?php esc_html_e('Premier BPO & Contact Center Solutions', 'imatutu'); ?></span>
                </span>
            </div>

            <!-- Single Main H1 -->
            <h1 class="hero-title"><?php echo esc_html($hero_h1); ?></h1>

            <!-- Subtitle / Tagline -->
            <p class="hero-subtitle"><?php echo nl2br(esc_html($hero_h2)); ?></p>

            <!-- CTA Buttons -->
            <div class="hero-actions">
                <?php if (!empty($hero_cta1_text)) : ?>
                    <a href="<?php echo esc_url($hero_cta1_link); ?>" class="btn btn-primary btn-lg">
                        <span><?php echo esc_html($hero_cta1_text); ?></span>
                        <svg class="btn-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                <?php endif; ?>

                <?php if (!empty($hero_cta2_text)) : ?>
                    <a href="<?php echo esc_url($hero_cta2_link); ?>" class="btn btn-secondary btn-lg">
                        <span><?php echo esc_html($hero_cta2_text); ?></span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Trust Highlights Strip -->
            <div class="hero-trust-strip">
                <div class="trust-item">
                    <div class="trust-icon-wrap">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <div class="trust-text">
                        <strong><?php esc_html_e('24/7 Operations', 'imatutu'); ?></strong>
                        <span><?php esc_html_e('Round-the-clock reliability', 'imatutu'); ?></span>
                    </div>
                </div>

                <div class="trust-item">
                    <div class="trust-icon-wrap">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div class="trust-text">
                        <strong><?php esc_html_e('Proven Track Record', 'imatutu'); ?></strong>
                        <span><?php esc_html_e('150+ international projects', 'imatutu'); ?></span>
                    </div>
                </div>

                <div class="trust-item">
                    <div class="trust-icon-wrap">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    </div>
                    <div class="trust-text">
                        <strong><?php esc_html_e('Expert Support Teams', 'imatutu'); ?></strong>
                        <span><?php esc_html_e('Skilled & dedicated agents', 'imatutu'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
