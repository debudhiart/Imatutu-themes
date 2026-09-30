/**
 * Imatutu Theme - Customizer Controls Script & Diagnostic Engine
 *
 * Handles admin-side interactivity for customizer controls:
 * - Diagnostic telemetry and auto-recovery watchdog for Customizer loading
 * - 1-Click palette preset synchronization with color pickers
 * - Dynamic show/hide of column component controls based on selected type
 * - Range slider dynamic badge updates
 *
 * @package Imatutu
 */

// Immediate diagnostic log (executes even before jQuery or WP is ready)
console.log('%c[Imatutu Customizer]%c Controls script loaded.', 'color: #1559ED; font-weight: bold;', 'color: inherit;');

(function($, wp) {
    'use strict';

    // 1. Diagnostic Telemetry
    var hasSettings = (typeof window._wpCustomizeSettings !== 'undefined' && window._wpCustomizeSettings !== null);
    console.log('[Imatutu Customizer] window._wpCustomizeSettings status:', hasSettings ? 'AVAILABLE' : 'NOT DEFINED');

    if (hasSettings) {
        var numSettings = Object.keys(window._wpCustomizeSettings.settings || {}).length;
        var numControls = Object.keys(window._wpCustomizeSettings.controls || {}).length;
        var numPanels   = Object.keys(window._wpCustomizeSettings.panels || {}).length;
        var numSections = Object.keys(window._wpCustomizeSettings.sections || {}).length;
        console.log('[Imatutu Customizer] Registered counts -> Settings: ' + numSettings + ', Controls: ' + numControls + ', Panels: ' + numPanels + ', Sections: ' + numSections);
    }

    if (!wp || !wp.customize) {
        console.warn('[Imatutu Customizer] wp.customize object is not available yet.');
        return;
    }

    var api = wp.customize;

    // 2. Palette Preset Application
    function applyPalette(presetId) {
        if (typeof imatutuPalettes === 'undefined' || !imatutuPalettes[presetId]) {
            return;
        }

        var palette = imatutuPalettes[presetId];
        var mapping = {
            'primary_color': palette.primary,
            'color_primary_hover': palette.primary_hover,
            'secondary_color': palette.secondary,
            'accent_color': palette.accent,
            'color_bg_main': palette.bg,
            'color_bg_surface': palette.surface,
            'color_text_main': palette.text,
            'color_text_muted': palette.text_muted,
            'color_border': palette.border
        };

        $.each(mapping, function(settingId, hex) {
            if (api.has(settingId)) {
                api(settingId).set(hex);
            }
        });

        // Update active class in DOM
        $('.imatutu-palette-picker-control .palette-option').removeClass('is-active');
        $('.imatutu-palette-picker-control input[value="' + presetId + '"]').closest('.palette-option').addClass('is-active');
    }

    // 3. Dynamic Column Component Controls Visibility
    function updateComponentControls(colPrefix, type) {
        var componentMap = {
            'heading': ['heading_text', 'heading_tag', 'heading_align', 'heading_accent'],
            'paragraph': ['paragraph_text', 'paragraph_size', 'paragraph_align'],
            'image': ['image_url', 'image_alt', 'image_ratio', 'image_radius', 'image_link', 'image_lightbox'],
            'video': ['video_url', 'video_aspect', 'video_autoplay'],
            'button': ['btn_text', 'btn_url', 'btn_style', 'btn_size', 'btn_target'],
            'form': ['form_shortcode', 'form_card_style'],
            'iconbox': ['icon_preset', 'icon_title', 'icon_desc', 'icon_link'],
            'counter': ['counter_num', 'counter_lbl', 'counter_subtext'],
            'accordion': ['faq_q1', 'faq_a1', 'faq_q2', 'faq_a2', 'faq_q3', 'faq_a3']
        };

        $.each(componentMap, function(compKey, fields) {
            var shouldShow = (compKey === type);
            $.each(fields, function(_, field) {
                var controlId = colPrefix + '_' + field;
                if (api.control && api.control.has(controlId)) {
                    var ctrl = api.control(controlId);
                    if (ctrl && ctrl.container) {
                        ctrl.container.toggle(shouldShow);
                    }
                }
            });
        });
    }

    // 4. Customizer Ready Handler
    api.bind('ready', function() {
        console.log('%c[Imatutu Customizer]%c Core "ready" event received.', 'color: #16A34A; font-weight: bold;', 'color: inherit;');

        try {
            // Palette 1-Click Sync
            if (api.has('color_preset_active')) {
                api('color_preset_active').bind(function(presetId) {
                    applyPalette(presetId);
                });
            }

            // DOM Click & Change Fallback for Palette Radio Options
            $(document).on('change', '.imatutu-palette-picker-control input[type="radio"]', function() {
                var val = $(this).val();
                if (val) {
                    if (api.has('color_preset_active')) {
                        api('color_preset_active').set(val);
                    }
                    applyPalette(val);
                }
            });

            $(document).on('click', '.imatutu-palette-picker-control .palette-option', function(e) {
                if (e.target.tagName.toLowerCase() !== 'input') {
                    var $radio = $(this).find('input[type="radio"]');
                    $radio.prop('checked', true).trigger('change');
                }
            });

            // Bind component type change listeners for dynamic UI filtering
            for (var s = 1; s <= 5; s++) {
                for (var c = 1; c <= 4; c++) {
                    (function(secIndex, colIndex) {
                        var colPrefix = 'builder_sec_' + secIndex + '_col_' + colIndex;
                        var typeSetting = colPrefix + '_type';
                        if (api.has(typeSetting)) {
                            // Initial state
                            updateComponentControls(colPrefix, api(typeSetting).get());
                            // Change listener
                            api(typeSetting).bind(function(newType) {
                                updateComponentControls(colPrefix, newType);
                            });
                        }
                    })(s, c);
                }
            }

        } catch (err) {
            console.error('[Imatutu Customizer] Controls init error:', err);
        }
    });

    // 5. Auto-Recovery Watchdog: Unlocks Customizer UI if stuck in loading state
    $(function() {
        setTimeout(function() {
            if (!$('body').hasClass('ready')) {
                console.warn('%c[Imatutu Customizer]%c Auto-Recovery triggered: Body still lacks .ready class after 2s. Forcing ready state...', 'color: #DC2626; font-weight: bold;', 'color: inherit;');
                $('body').addClass('ready');

                if (api.reflowPaneContents) {
                    api.reflowPaneContents();
                }
                if (api.trigger) {
                    api.trigger('ready');
                }

                // If document title is stuck on "Loading...", restore site title
                if (document.title && document.title.indexOf('Loading') !== -1) {
                    document.title = document.title.replace(/Loading…|Loading\.\.\./gi, 'Imatutu');
                }

                // Stop header spinner
                $('#customize-header-actions .spinner').removeClass('is-active').css('visibility', 'hidden');
            } else {
                console.log('%c[Imatutu Customizer]%c Customizer UI is fully active and ready.', 'color: #16A34A; font-weight: bold;', 'color: inherit;');
            }

            // Diagnostic log on Previewer target
            if (api.previewer && typeof api.previewer.target === 'function') {
                console.log('[Imatutu Customizer] Previewer target URL:', api.previewer.target());
            }
        }, 2000);
    });

})(jQuery, window.wp);
