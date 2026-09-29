/**
 * Theme Customizer Live Preview
 *
 * Updates theme settings in real-time in the Customizer preview window
 *
 * @package Imatutu
 */

(function($) {
    'use strict';

    // Primary Color
    wp.customize('primary_color', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-primary', newval);
        });
    });

    // Secondary Color
    wp.customize('secondary_color', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-secondary', newval);
        });
    });

    // Accent Color
    wp.customize('accent_color', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-accent', newval);
        });
    });

    // Brand Logo Text
    wp.customize('header_brand_text', function(value) {
        value.bind(function(newval) {
            $('.brand-text, .footer-brand-title').text(newval);
        });
    });

    // Header Subtitle
    wp.customize('header_subtitle', function(value) {
        value.bind(function(newval) {
            $('.utility-entity').text(newval);
        });
    });

    // Hero Main Heading (H1)
    wp.customize('hero_heading_1', function(value) {
        value.bind(function(newval) {
            $('.hero-title').text(newval);
        });
    });

    // Hero Subheading
    wp.customize('hero_heading_2', function(value) {
        value.bind(function(newval) {
            $('.hero-subtitle').text(newval);
        });
    });

    // Services Subtitle & Title
    wp.customize('services_subtitle', function(value) {
        value.bind(function(newval) {
            $('.services-section .section-pill').text(newval);
        });
    });

    wp.customize('services_title', function(value) {
        value.bind(function(newval) {
            $('.services-section .section-title').text(newval);
        });
    });

    // Stats Title
    wp.customize('stats_title', function(value) {
        value.bind(function(newval) {
            $('.stats-section .section-title').text(newval);
        });
    });

    // Clients Title
    wp.customize('clients_section_title', function(value) {
        value.bind(function(newval) {
            $('.clients-section .section-title').text(newval);
        });
    });

})(jQuery);
