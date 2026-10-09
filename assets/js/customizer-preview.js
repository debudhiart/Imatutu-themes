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

    // Helper: Dynamically load Google Font in preview
    function loadGoogleFont(fontName) {
        if (!fontName || fontName === 'System') return;
        var fontSlug = fontName.replace(/\s+/g, '-').toLowerCase();
        var linkId = 'imatutu-dynamic-font-' + fontSlug;
        if (!document.getElementById(linkId)) {
            var link = document.createElement('link');
            link.id = linkId;
            link.rel = 'stylesheet';
            var formatted = fontName.trim().replace(/\s+/g, '+');
            link.href = 'https://fonts.googleapis.com/css2?family=' + formatted + ':ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap';
            document.head.appendChild(link);
        }
    }

    api.bind('preview-ready', function() {
        console.log('%c[Imatutu Preview]%c Customizer live preview initialized.', 'color: #1559ED; font-weight: bold;', 'color: inherit;');

        // =============================================================
        // 1. Color Palette & Dynamic CSS Variables
        // =============================================================
        var colorMap = {
            'primary_color': '--color-primary',
            'secondary_color': '--color-secondary',
            'accent_color': '--color-accent'
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

        // 1-Click Color Preset in Preview
        api('color_preset', function(value) {
            value.bind(function(presetKey) {
                if (typeof imatutuPalettes !== 'undefined' && imatutuPalettes[presetKey]) {
                    var pal = imatutuPalettes[presetKey];
                    if (pal.primary) document.documentElement.style.setProperty('--color-primary', pal.primary);
                    if (pal.secondary) document.documentElement.style.setProperty('--color-secondary', pal.secondary);
                    if (pal.accent) document.documentElement.style.setProperty('--color-accent', pal.accent);
                    if (pal.surface) {
                        document.documentElement.style.setProperty('--color-surface', pal.surface);
                        document.documentElement.style.setProperty('--color-bg-surface', pal.surface);
                    }
                    if (pal.text) document.documentElement.style.setProperty('--color-text', pal.text);
                }
            });
        });

        // =============================================================
        // 2. Typography & Fonts
        // =============================================================
        api('typo_body_font', function(value) {
            value.bind(function(newval) {
                if (!newval) return;
                if (newval === 'System') {
                    document.documentElement.style.setProperty('--font-main', 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif');
                } else {
                    loadGoogleFont(newval);
                    document.documentElement.style.setProperty('--font-main', "'" + newval + "', sans-serif");
                }
            });
        });

        api('typo_heading_font', function(value) {
            value.bind(function(newval) {
                if (!newval) return;
                if (newval === 'System') {
                    document.documentElement.style.setProperty('--font-heading', 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif');
                } else {
                    loadGoogleFont(newval);
                    document.documentElement.style.setProperty('--font-heading', "'" + newval + "', sans-serif");
                }
            });
        });

        api('typo_base_size', function(value) {
            value.bind(function(newval) {
                if (newval) {
                    document.documentElement.style.setProperty('--body-size', newval + 'px');
                    document.body.style.fontSize = newval + 'px';
                }
            });
        });

        // =============================================================
        // 3. Header Contacts & Brand Identity
        // =============================================================
        api('imatutu_company_subtitle', function(value) {
            value.bind(function(newval) {
                $('.utility-entity').text(newval || '');
            });
        });

        api('imatutu_phone', function(value) {
            value.bind(function(newval) {
                $('.header-phone-text, .footer-phone-text').text(newval || '');
                var cleanPhone = String(newval || '').replace(/[^0-9+]/g, '');
                $('a[href^="tel:"]').attr('href', 'tel:' + cleanPhone);
            });
        });

        api('imatutu_email', function(value) {
            value.bind(function(newval) {
                $('.header-email-text, .footer-email-text').text(newval || '');
                $('a[href^="mailto:"]').attr('href', 'mailto:' + (newval || ''));
            });
        });

        // =============================================================
        // 4. Floating WhatsApp
        // =============================================================
        api('imatutu_enable_floating_wa', function(value) {
            value.bind(function(newval) {
                if (newval) {
                    $('.floating-wa-btn').fadeIn(200);
                } else {
                    $('.floating-wa-btn').fadeOut(200);
                }
            });
        });

        api('imatutu_whatsapp_number', function(value) {
            value.bind(function(newval) {
                var clean = String(newval || '').replace(/[^0-9]/g, '');
                $('.floating-wa-btn').attr('href', 'https://wa.me/' + clean);
            });
        });

        // =============================================================
        // 5. Footer & Legal Information
        // =============================================================
        api('footer_tagline', function(value) {
            value.bind(function(newval) {
                $('.footer-brand-tagline').text(newval || '');
            });
        });

        api('footer_address_1', function(value) {
            value.bind(function(newval) {
                $('.footer-address-1').html(safeNl2br(newval));
            });
        });

        api('footer_address_2', function(value) {
            value.bind(function(newval) {
                $('.footer-address-2').html(safeNl2br(newval));
            });
        });

        api('footer_copyright', function(value) {
            value.bind(function(newval) {
                var year = new Date().getFullYear();
                var text = (newval || '').replace('© Copyright', '© ' + year);
                $('.copyright-text').text(text);
            });
        });

        // Backward-compatibility listeners for older template parts
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

        api('footer_phone', function(value) {
            value.bind(function(newval) {
                $('.footer-phone-text, .header-phone-text').text(newval || '');
            });
        });

        api('footer_email', function(value) {
            value.bind(function(newval) {
                $('.footer-email-text, .header-email-text').text(newval || '');
            });
        });
    });

})(jQuery);
