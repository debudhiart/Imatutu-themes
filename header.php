<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <main id="primary">
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site-wrapper">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'imatutu'); ?></a>

    <!-- Top Utility Bar -->
    <div class="top-utility-bar">
        <div class="site-container utility-container">
            <div class="utility-left">
                <span class="status-indicator">
                    <span class="status-dot"></span>
                    <span class="status-text"><?php esc_html_e('24/7 Support Center Active', 'imatutu'); ?></span>
                </span>
                <span class="utility-divider">|</span>
                <span class="utility-entity"><?php echo esc_html(get_theme_mod('header_subtitle', 'by PT Karya Antara Negeri | PT Karya Antara Benua')); ?></span>
            </div>
            <div class="utility-right">
                <?php 
                $phone = get_theme_mod('footer_phone', '+62 851 6893 2460');
                $email = get_theme_mod('footer_email', 'office@imatutu.com');
                ?>
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="utility-link">
                    <svg class="utility-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    <span class="header-phone-text"><?php echo esc_html($phone); ?></span>
                </a>
                <span class="utility-divider">|</span>
                <a href="mailto:<?php echo esc_attr($email); ?>" class="utility-link">
                    <svg class="utility-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <span class="header-email-text"><?php echo esc_html($email); ?></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header (Sticky & Glassmorphism) -->
    <header id="masthead" class="site-header">
        <div class="site-container header-container">
            <!-- Brand Logo -->
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="custom-logo-wrap">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-link" rel="home">
                        <span class="brand-text"><?php echo esc_html(get_theme_mod('header_brand_text', 'IMATUTU')); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Desktop Navigation Menu -->
            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Main Navigation', 'imatutu'); ?>">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'depth'          => 2,
                    ));
                } else {
                    imatutu_default_primary_menu();
                }
                ?>
            </nav>

            <!-- Header Action Button & Mobile Toggle -->
            <div class="header-actions">
                <?php
                $header_cta_text = get_theme_mod('header_cta_text', 'Contact');
                $header_cta_link = get_theme_mod('header_cta_link', 'https://imatutu.com/contact-us/');
                if (!empty($header_cta_text)) :
                ?>
                    <a href="<?php echo esc_url($header_cta_link); ?>" class="btn btn-primary btn-header">
                        <span><?php echo esc_html($header_cta_text); ?></span>
                        <svg class="btn-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                <?php endif; ?>

                <button id="mobile-menu-toggle" class="mobile-toggle" aria-controls="mobile-navigation" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation menu', 'imatutu'); ?>">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-navigation" class="mobile-drawer" aria-hidden="true">
        <div class="mobile-drawer-overlay" id="mobile-drawer-overlay"></div>
        <div class="mobile-drawer-inner">
            <div class="mobile-drawer-header">
                <span class="brand-text"><?php echo esc_html(get_theme_mod('header_brand_text', 'IMATUTU')); ?></span>
                <button id="mobile-menu-close" class="mobile-close-btn" aria-label="<?php esc_attr_e('Close navigation menu', 'imatutu'); ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <nav class="mobile-nav-content">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'mobile-nav-menu',
                        'container'      => false,
                    ));
                } else {
                    imatutu_default_primary_menu();
                }
                ?>
            </nav>

            <div class="mobile-drawer-footer">
                <a href="<?php echo esc_url($header_cta_link); ?>" class="btn btn-primary btn-block">
                    <?php echo esc_html($header_cta_text); ?>
                </a>
                <div class="mobile-contact-info">
                    <p><strong><?php esc_html_e('Phone:', 'imatutu'); ?></strong> <?php echo esc_html($phone); ?></p>
                    <p><strong><?php esc_html_e('Email:', 'imatutu'); ?></strong> <?php echo esc_html($email); ?></p>
                </div>
            </div>
        </div>
    </div>
