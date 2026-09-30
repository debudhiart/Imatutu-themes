<?php
// Pure minimal mock - no WordPress require needed, just math
// Builder loop: 3 sections * 3 cols
$sec_level_controls = 8;  // enable, label, bg_type, padding, layout, gap, valign = 7+1 = 8
$col_type_control = 1;
$component_controls = 32; // heading(4) + paragraph(3) + image(6) + video(3) + button(5) + form(2) + iconbox(4) + counter(3) + accordion(6) = ~36... let me count

// heading: text, tag, align, accent = 4
// paragraph: text, size, align = 3
// image: url, alt, ratio, radius, link, lightbox = 6
// video: url, aspect, autoplay = 3
// button: text, url, style, size, target = 5
// form: shortcode, card_style = 2
// iconbox: preset, title, desc, link = 4
// counter: num, lbl, subtext = 3
// accordion: q1,a1,q2,a2,q3,a3 = 6
$component_total = 4+3+6+3+5+2+4+3+6; // 36
$per_col = $col_type_control + $component_total; // 37

$builder_controls = 3 * ($sec_level_controls + 3 * $per_col);
echo "Builder controls: $builder_controls\n";
echo "Main customizer: ~121\n";
echo "Total: " . ($builder_controls + 121) . "\n";
