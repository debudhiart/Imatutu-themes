<?php
/**
 * Builder Component: Metric Counter
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

$prefix = get_query_var('component_prefix', '');
if (empty($prefix)) {
    return;
}

$number  = get_theme_mod("{$prefix}_counter_num", '99.9%');
$label   = get_theme_mod("{$prefix}_counter_lbl", 'Uptime & Service Reliability');
$subtext = get_theme_mod("{$prefix}_counter_subtext", 'Continuous 24/7 Monitoring');
?>

<div class="builder-component component-counter">
    <div class="builder-counter-card">
        <span class="builder-counter-val"><?php echo esc_html($number); ?></span>
        <span class="builder-counter-lbl"><?php echo esc_html($label); ?></span>
        <?php if (!empty($subtext)) : ?>
            <span class="builder-counter-subtext"><?php echo esc_html($subtext); ?></span>
        <?php endif; ?>
    </div>
</div>
