/**
 * Imatutu Theme - Customizer Controls Script
 *
 * Handles admin-side interactivity for customizer controls:
 * - 1-Click palette preset synchronization with color pickers
 *
 * @package Imatutu
 */

(function($, wp) {
    'use strict';

    if (!wp || !wp.customize) {
        return;
    }

    var api = wp.customize;

    function applyPalette(presetKey) {
        if (typeof imatutuPalettes === 'undefined' || !imatutuPalettes[presetKey]) {
            return;
        }
        var p = imatutuPalettes[presetKey];

        var mapping = {
            'primary_color': p.primary,
            'secondary_color': p.secondary,
            'accent_color': p.accent
        };

        $.each(mapping, function(settingId, colorVal) {
            if (api.has(settingId) && colorVal) {
                api(settingId).set(colorVal);

                var control = api.control(settingId);
                if (control && control.container) {
                    var $picker = control.container.find('.wp-color-picker');
                    if ($picker.length && $.fn.wpColorPicker) {
                        $picker.wpColorPicker('color', colorVal);
                    }
                }
            }
        });
    }

    api.bind('ready', function() {
        try {
            // 1. Color Palette Preset 1-Click Synchronization
            if (api.has('color_preset')) {
                api('color_preset').bind(function(presetKey) {
                    applyPalette(presetKey);
                });
            }
        } catch (err) {
            if (window.console && console.error) {
                console.error('Imatutu Customizer Controls init error:', err);
            }
        }
    });

})(jQuery, window.wp);
