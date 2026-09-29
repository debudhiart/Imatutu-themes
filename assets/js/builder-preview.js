/**
 * Imatutu Theme - Builder Customizer Live Preview
 *
 * Real-time DOM updates via postMessage for Layout Builder settings
 *
 * @package Imatutu
 */

(function($) {
    'use strict';

    if (typeof wp === 'undefined' || !wp.customize) {
        return;
    }

    // =============================================================
    // 1. Dynamic Section Controls (Sections 1 - 5)
    // =============================================================
    for (var s = 1; s <= 5; s++) {
        (function(secIndex) {
            // Gap slider
            wp.customize('builder_sec_' + secIndex + '_gap', function(value) {
                value.bind(function(newval) {
                    $('#modular-section-' + secIndex + ' .builder-grid').css('--builder-gap', newval + 'px');
                });
            });

            // Vertical Padding
            wp.customize('builder_sec_' + secIndex + '_padding', function(value) {
                value.bind(function(newval) {
                    var sec = $('#modular-section-' + secIndex);
                    sec.removeClass('pad-small pad-medium pad-large').addClass('pad-' + newval);
                });
            });

            // Background Type
            wp.customize('builder_sec_' + secIndex + '_bg_type', function(value) {
                value.bind(function(newval) {
                    var sec = $('#modular-section-' + secIndex);
                    sec.removeClass('bg-default_white bg-soft_slate bg-navy_dark bg-primary_tint').addClass('bg-' + newval);
                });
            });

            // Vertical Alignment
            wp.customize('builder_sec_' + secIndex + '_valign', function(value) {
                value.bind(function(newval) {
                    var grid = $('#modular-section-' + secIndex + ' .builder-grid');
                    grid.removeClass('valign-top valign-center valign-stretch').addClass('valign-' + newval);
                });
            });

            // Column Components (Columns 1 - 4)
            for (var c = 1; c <= 4; c++) {
                (function(colIndex) {
                    var colPrefix = 'builder_sec_' + secIndex + '_col_' + colIndex;
                    var colSelector = '.builder-sec-' + secIndex + ' .builder-col-' + colIndex;

                    // Heading Text
                    wp.customize(colPrefix + '_heading_text', function(value) {
                        value.bind(function(newval) {
                            $(colSelector + ' .builder-heading-text').text(newval);
                        });
                    });

                    // Paragraph Text
                    wp.customize(colPrefix + '_paragraph_text', function(value) {
                        value.bind(function(newval) {
                            $(colSelector + ' .builder-body-text').html(newval.replace(/\n/g, '<br>'));
                        });
                    });

                    // Button Text
                    wp.customize(colPrefix + '_btn_text', function(value) {
                        value.bind(function(newval) {
                            $(colSelector + ' .btn-text-label').text(newval);
                        });
                    });

                    // Iconbox Title & Description
                    wp.customize(colPrefix + '_icon_title', function(value) {
                        value.bind(function(newval) {
                            $(colSelector + ' .iconbox-title').text(newval);
                        });
                    });
                    wp.customize(colPrefix + '_icon_desc', function(value) {
                        value.bind(function(newval) {
                            $(colSelector + ' .iconbox-desc').html(newval.replace(/\n/g, '<br>'));
                        });
                    });

                    // Counter Number, Label, and Subtext
                    wp.customize(colPrefix + '_counter_num', function(value) {
                        value.bind(function(newval) {
                            $(colSelector + ' .builder-counter-val').text(newval);
                        });
                    });
                    wp.customize(colPrefix + '_counter_lbl', function(value) {
                        value.bind(function(newval) {
                            $(colSelector + ' .builder-counter-lbl').text(newval);
                        });
                    });
                    wp.customize(colPrefix + '_counter_subtext', function(value) {
                        value.bind(function(newval) {
                            $(colSelector + ' .builder-counter-subtext').text(newval);
                        });
                    });

                    // Accordion Q&A (Items 1 - 3)
                    for (var i = 1; i <= 3; i++) {
                        (function(itemIdx) {
                            wp.customize(colPrefix + '_faq_q' + itemIdx, function(value) {
                                value.bind(function(newval) {
                                    $(colSelector + ' .faq-q-' + itemIdx).text(newval);
                                });
                            });
                            wp.customize(colPrefix + '_faq_a' + itemIdx, function(value) {
                                value.bind(function(newval) {
                                    $(colSelector + ' .faq-a-' + itemIdx).html(newval.replace(/\n/g, '<br>'));
                                });
                            });
                        })(i);
                    }
                })(c);
            }
        })(s);
    }

    // =============================================================
    // 2. Typography Engine Sliders
    // =============================================================
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

    wp.customize('typo_h3_size', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--h3-size', newval + 'px');
        });
    });

    wp.customize('typo_body_size', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--body-size', newval + 'px');
        });
    });

    wp.customize('typo_body_line_height', function(value) {
        value.bind(function(newval) {
            document.documentElement.style.setProperty('--body-line-height', newval);
        });
    });

})(jQuery);
