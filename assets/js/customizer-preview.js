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

    var api = wp.customize;

    // Helper: Safely convert linebreaks to <br> without crashing on null/undefined
    function safeNl2br(val) {
        if (!val) return '';
        return String(val).replace(/\n/g, '<br>');
    }

    api.bind('preview-ready', function() {
        console.log('%c[Imatutu Preview]%c Live preview listener initialized.', 'color: #1559ED; font-weight: bold;', 'color: inherit;');

        // =============================================================
        // 1. Color Palette & Dynamic CSS Variables
        // =============================================================
        var colorMap = {
            'primary_color': '--color-primary',
            'color_primary_hover': '--color-primary-dark',
            'secondary_color': '--color-secondary',
            'accent_color': '--color-accent',
            'color_bg_main': '--color-bg',
            'color_bg_surface': '--color-bg-secondary',
            'color_text_main': '--color-text',
            'color_text_muted': '--color-text-muted',
            'color_border': '--color-border'
        };

        $.each(colorMap, function(settingId, cssVar) {
            api(settingId, function(value) {
                value.bind(function(newval) {
                    if (newval) {
                        document.documentElement.style.setProperty(cssVar, newval);
                    }
                });
            });
        });

        // =============================================================
        // 2. Header & Branding Settings
        // =============================================================
        api('header_brand_text', function(value) {
            value.bind(function(newval) {
                $('.brand-text, .footer-brand-title').text(newval || '');
            });
        });

        api('header_subtitle', function(value) {
            value.bind(function(newval) {
                $('.utility-entity').text(newval || '');
            });
        });

        api('header_cta_text', function(value) {
            value.bind(function(newval) {
                $('.btn-header span').text(newval || '');
            });
        });

        // =============================================================
        // 3. Hero Section
        // =============================================================
        api('hero_heading_1', function(value) {
            value.bind(function(newval) {
                $('.hero-title').text(newval || '');
            });
        });

        api('hero_heading_2', function(value) {
            value.bind(function(newval) {
                $('.hero-subtitle').html(safeNl2br(newval));
            });
        });

        api('hero_cta_primary_text', function(value) {
            value.bind(function(newval) {
                $('.hero-actions .btn-primary span').text(newval || '');
            });
        });

        api('hero_cta_secondary_text', function(value) {
            value.bind(function(newval) {
                $('.hero-actions .btn-secondary span').text(newval || '');
            });
        });

        // =============================================================
        // 4. Services Section
        // =============================================================
        api('services_subtitle', function(value) {
            value.bind(function(newval) {
                $('.services-section .section-pill').text(newval || '');
            });
        });

        api('services_title', function(value) {
            value.bind(function(newval) {
                $('.services-section .section-title').text(newval || '');
            });
        });

        // =============================================================
        // 5. Global Reach & Stats Section
        // =============================================================
        api('stats_title', function(value) {
            value.bind(function(newval) {
                $('.stats-section .section-title').text(newval || '');
            });
        });

        api('stats_desc', function(value) {
            value.bind(function(newval) {
                $('.stats-description-text').html(safeNl2br(newval));
            });
        });

        [1, 2, 3].forEach(function(i) {
            api('stat_' + i + '_number', function(value) {
                value.bind(function(newval) {
                    $('.stat-num-' + i).text(newval || '');
                });
            });
            api('stat_' + i + '_label', function(value) {
                value.bind(function(newval) {
                    $('.stat-lbl-' + i).text(newval || '');
                });
            });
            api('stat_' + i + '_desc', function(value) {
                value.bind(function(newval) {
                    $('.stat-desc-' + i).text(newval || '');
                });
            });
        });

        // =============================================================
        // 6. Clients Section
        // =============================================================
        api('clients_section_title', function(value) {
            value.bind(function(newval) {
                $('.clients-section .section-title').text(newval || '');
            });
        });

        // =============================================================
        // 7. Footer
        // =============================================================
        api('footer_tagline', function(value) {
            value.bind(function(newval) {
                $('.footer-brand-tagline').text(newval || '');
            });
        });

        api('footer_copyright', function(value) {
            value.bind(function(newval) {
                $('.copyright-text').text(newval || '');
            });
        });
    });

})(jQuery);
