/**
 * Imatutu Theme - Customizer Controls Script
 *
 * Handles admin-side interactivity for customizer controls:
 * - 1-Click palette preset synchronization with color pickers
 * - Range slider dynamic badge updates
 *
 * @package Imatutu
 */

(function($, wp) {
    'use strict';

    if (!wp || !wp.customize) {
        return;
    }

    var api = wp.customize;

    function applyPalette(presetId) {
        if (typeof imatutuPalettes === 'undefined' || !imatutuPalettes[presetId]) {
            return;
        }
        var p = imatutuPalettes[presetId].values;
        if (!p) return;

        var mapping = {
            'primary_color': p.primary,
            'color_primary_hover': p.primary_h,
            'secondary_color': p.secondary,
            'accent_color': p.accent,
            'color_bg_main': p.bg_main,
            'color_bg_surface': p.bg_surface,
            'color_text_main': p.text_main,
            'color_text_muted': p.text_muted,
            'color_border': p.border
        };

        $.each(mapping, function(settingKey, colorVal) {
            if (api.has(settingKey) && colorVal) {
                api(settingKey).set(colorVal);

                var control = api.control(settingKey);
                if (control && control.container) {
                    var $picker = control.container.find('.wp-color-picker');
                    if ($picker.length && $.fn.wpColorPicker) {
                        $picker.wpColorPicker('color', colorVal);
                    }
                }
            }
        });

        $('.imatutu-palette-picker-control .palette-option').removeClass('is-active');
        $('.imatutu-palette-picker-control input[value="' + presetId + '"]').closest('.palette-option').addClass('is-active');
    }

    api.bind('ready', function() {
        try {
            // 1. Color Palette Preset 1-Click Synchronization
            if (api.has('color_preset_active')) {
                api('color_preset_active').bind(function(presetId) {
                    applyPalette(presetId);
                });
            }

            // 2. DOM Click & Change Fallback for Palette Radio Options
            $(document).on('change', '.imatutu-palette-picker-control input[type="radio"]', function() {
                var val = $(this).val();
                if (val) {
                    applyPalette(val);
                }
            });

            $(document).on('click', '.imatutu-palette-picker-control .palette-option', function() {
                var $radio = $(this).find('input[type="radio"]');
                if ($radio.length && !$radio.prop('checked')) {
                    $radio.prop('checked', true).trigger('change');
                }
            });
        } catch (err) {
            if (window.console && console.error) {
                console.error('Imatutu Customizer Controls init error:', err);
            }
        }
    });

})(jQuery, window.wp);
