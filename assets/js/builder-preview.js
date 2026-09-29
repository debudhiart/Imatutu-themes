/**
 * Imatutu Theme - Builder Customizer Live Preview
 *
 * @package Imatutu
 */

(function($) {
    'use strict';

    // Live update gap
    for (let s = 1; s <= 5; s++) {
        (function(secIndex) {
            wp.customize('builder_sec_' + secIndex + '_gap', function(value) {
                value.bind(function(newval) {
                    $('#modular-section-' + secIndex + ' .builder-grid').css('--builder-gap', newval + 'px');
                });
            });

            wp.customize('builder_sec_' + secIndex + '_padding', function(value) {
                value.bind(function(newval) {
                    const sec = $('#modular-section-' + secIndex);
                    sec.removeClass('pad-small pad-medium pad-large').addClass('pad-' + newval);
                });
            });

            wp.customize('builder_sec_' + secIndex + '_bg_type', function(value) {
                value.bind(function(newval) {
                    const sec = $('#modular-section-' + secIndex);
                    sec.removeClass('bg-default_white bg-soft_slate bg-navy_dark bg-primary_tint').addClass('bg-' + newval);
                });
            });
        })(s);
    }

    // Typography live updates
    wp.customize('typo_h1_size', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--h1-size', newval + 'px');
        });
    });

    wp.customize('typo_h2_size', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--h2-size', newval + 'px');
        });
    });

    wp.customize('typo_body_size', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--body-size', newval + 'px');
        });
    });

})(jQuery);
