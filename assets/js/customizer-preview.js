/**
 * Theme Customizer Live Preview
 *
 * Updates theme settings in real-time in the Customizer preview window
 *
 * @package Imatutu
 */

(function($) {
    'use strict';

    if (typeof wp === 'undefined' || !wp.customize) {
        return;
    }

    // =============================================================
    // 1. Color Palette & Dynamic CSS Variables
    // =============================================================

    // Primary Brand Color
    wp.customize('primary_color', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-primary', newval);
        });
    });

    // Primary Hover Color
    wp.customize('color_primary_hover', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-primary-dark', newval);
        });
    });

    // Secondary Color (Navy/Dark)
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

    // Background Main Color
    wp.customize('color_bg_main', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-bg', newval);
        });
    });

    // Background Surface / Card Color
    wp.customize('color_bg_surface', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-bg-secondary', newval);
        });
    });

    // Main Text Color
    wp.customize('color_text_main', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-text', newval);
        });
    });

    // Muted / Subtitle Text Color
    wp.customize('color_text_muted', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-text-muted', newval);
        });
    });

    // Border & Divider Color
    wp.customize('color_border', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--color-border', newval);
        });
    });

    // =============================================================
    // 2. Header & Branding Settings
    // =============================================================

    // Brand Logo Text Fallback
    wp.customize('header_brand_text', function(value) {
        value.bind(function(newval) {
            $('.brand-text, .footer-brand-title').text(newval);
        });
    });

    // Header Subtitle / Corporate Entity
    wp.customize('header_subtitle', function(value) {
        value.bind(function(newval) {
            $('.utility-entity').text(newval);
        });
    });

    // Header CTA Button Text
    wp.customize('header_cta_text', function(value) {
        value.bind(function(newval) {
            $('.btn-header span').text(newval);
        });
    });

    // =============================================================
    // 3. Hero Section
    // =============================================================

    // Hero Main Heading (H1)
    wp.customize('hero_heading_1', function(value) {
        value.bind(function(newval) {
            $('.hero-title').text(newval);
        });
    });

    // Hero Subheading
    wp.customize('hero_heading_2', function(value) {
        value.bind(function(newval) {
            $('.hero-subtitle').html(newval.replace(/\n/g, '<br>'));
        });
    });

    // Hero Primary CTA Text
    wp.customize('hero_cta_primary_text', function(value) {
        value.bind(function(newval) {
            $('.hero-actions .btn-primary span').text(newval);
        });
    });

    // Hero Secondary CTA Text
    wp.customize('hero_cta_secondary_text', function(value) {
        value.bind(function(newval) {
            $('.hero-actions .btn-secondary span').text(newval);
        });
    });

    // =============================================================
    // 4. Services Section
    // =============================================================

    // Services Subtitle Pill
    wp.customize('services_subtitle', function(value) {
        value.bind(function(newval) {
            $('.services-section .section-pill').text(newval);
        });
    });

    // Services Section Title
    wp.customize('services_title', function(value) {
        value.bind(function(newval) {
            $('.services-section .section-title').text(newval);
        });
    });

    // =============================================================
    // 5. Global Reach & Stats Section
    // =============================================================

    // Stats Section Title
    wp.customize('stats_title', function(value) {
        value.bind(function(newval) {
            $('.stats-section .section-title').text(newval);
        });
    });

    // Stats Description Text
    wp.customize('stats_desc', function(value) {
        value.bind(function(newval) {
            $('.stats-description-text').html(newval.replace(/\n/g, '<br>'));
        });
    });

    // Stat Metric 1-3
    [1, 2, 3].forEach(function(i) {
        wp.customize('stat_' + i + '_number', function(value) {
            value.bind(function(newval) {
                $('.stat-num-' + i).text(newval);
            });
        });
        wp.customize('stat_' + i + '_label', function(value) {
            value.bind(function(newval) {
                $('.stat-lbl-' + i).text(newval);
            });
        });
        wp.customize('stat_' + i + '_desc', function(value) {
            value.bind(function(newval) {
                $('.stat-desc-' + i).text(newval);
            });
        });
    });

    // =============================================================
    // 6. Clients Section
    // =============================================================

    // Clients Title
    wp.customize('clients_section_title', function(value) {
        value.bind(function(newval) {
            $('.clients-section .section-title').text(newval);
        });
    });

    // =============================================================
    // 7. Footer
    // =============================================================

    // Footer Tagline
    wp.customize('footer_tagline', function(value) {
        value.bind(function(newval) {
            $('.footer-brand-tagline').text(newval);
        });
    });

    // Footer Copyright
    wp.customize('footer_copyright', function(value) {
        value.bind(function(newval) {
            $('.copyright-text').text(newval);
        });
    });

})(jQuery);
