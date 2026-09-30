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

    var api = wp.customize;

    function safeNl2br(val) {
        if (!val) return '';
        return String(val).replace(/\n/g, '<br>');
    }

    api.bind('preview-ready', function() {
        console.log('%c[Imatutu Builder Preview]%c Live builder preview listener initialized.', 'color: #1559ED; font-weight: bold;', 'color: inherit;');

        // =============================================================
        // 1. Dynamic Section Controls (Sections 1 - 5)
        // =============================================================
        for (var s = 1; s <= 5; s++) {
            (function(secIndex) {
                // Gap slider
                api('builder_sec_' + secIndex + '_gap', function(value) {
                    value.bind(function(newval) {
                        $('#modular-section-' + secIndex + ' .builder-grid').css('--builder-gap', (newval || 24) + 'px');
                    });
                });

                // Vertical Padding
                api('builder_sec_' + secIndex + '_padding', function(value) {
                    value.bind(function(newval) {
                        var sec = $('#modular-section-' + secIndex);
                        sec.removeClass('pad-small pad-medium pad-large').addClass('pad-' + (newval || 'medium'));
                    });
                });

                // Background Type
                api('builder_sec_' + secIndex + '_bg_type', function(value) {
                    value.bind(function(newval) {
                        var sec = $('#modular-section-' + secIndex);
                        sec.removeClass('bg-default_white bg-soft_slate bg-navy_dark bg-primary_tint').addClass('bg-' + (newval || 'default_white'));
                    });
                });

                // Vertical Alignment
                api('builder_sec_' + secIndex + '_valign', function(value) {
                    value.bind(function(newval) {
                        var grid = $('#modular-section-' + secIndex + ' .builder-grid');
                        grid.removeClass('valign-top valign-center valign-stretch').addClass('valign-' + (newval || 'center'));
                    });
                });

                // Column Components (Columns 1 - 4)
                for (var c = 1; c <= 4; c++) {
                    (function(colIndex) {
                        var colPrefix = 'builder_sec_' + secIndex + '_col_' + colIndex;
                        var colSelector = '.builder-sec-' + secIndex + ' .builder-col-' + colIndex;

                        // Heading Text
                        api(colPrefix + '_heading_text', function(value) {
                            value.bind(function(newval) {
                                $(colSelector + ' .builder-heading-text').text(newval || '');
                            });
                        });

                        // Paragraph Text
                        api(colPrefix + '_paragraph_text', function(value) {
                            value.bind(function(newval) {
                                $(colSelector + ' .builder-body-text').html(safeNl2br(newval));
                            });
                        });

                        // Button Text
                        api(colPrefix + '_btn_text', function(value) {
                            value.bind(function(newval) {
                                $(colSelector + ' .btn-text-label').text(newval || '');
                            });
                        });

                        // Iconbox Title & Description
                        api(colPrefix + '_icon_title', function(value) {
                            value.bind(function(newval) {
                                $(colSelector + ' .iconbox-title').text(newval || '');
                            });
                        });
                        api(colPrefix + '_icon_desc', function(value) {
                            value.bind(function(newval) {
                                $(colSelector + ' .iconbox-desc').html(safeNl2br(newval));
                            });
                        });

                        // Counter Number, Label, and Subtext
                        api(colPrefix + '_counter_num', function(value) {
                            value.bind(function(newval) {
                                $(colSelector + ' .builder-counter-val').text(newval || '');
                            });
                        });
                        api(colPrefix + '_counter_lbl', function(value) {
                            value.bind(function(newval) {
                                $(colSelector + ' .builder-counter-lbl').text(newval || '');
                            });
                        });
                        api(colPrefix + '_counter_subtext', function(value) {
                            value.bind(function(newval) {
                                $(colSelector + ' .builder-counter-subtext').text(newval || '');
                            });
                        });

                        // Accordion Q&A (Items 1 - 3)
                        for (var i = 1; i <= 3; i++) {
                            (function(itemIdx) {
                                api(colPrefix + '_faq_q' + itemIdx, function(value) {
                                    value.bind(function(newval) {
                                        $(colSelector + ' .faq-q-' + itemIdx).text(newval || '');
                                    });
                                });
                                api(colPrefix + '_faq_a' + itemIdx, function(value) {
                                    value.bind(function(newval) {
                                        $(colSelector + ' .faq-a-' + itemIdx).html(safeNl2br(newval));
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
        var typoMap = {
            'typo_h1_size': { prop: '--h1-size', unit: 'px' },
            'typo_h2_size': { prop: '--h2-size', unit: 'px' },
            'typo_h3_size': { prop: '--h3-size', unit: 'px' },
            'typo_body_size': { prop: '--body-size', unit: 'px' },
            'typo_body_line_height': { prop: '--body-line-height', unit: '' }
        };

        $.each(typoMap, function(settingId, cfg) {
            api(settingId, function(value) {
                value.bind(function(newval) {
                    if (newval) {
                        document.documentElement.style.setProperty(cfg.prop, newval + cfg.unit);
                    }
                });
            });
        });
    });

})(jQuery);
