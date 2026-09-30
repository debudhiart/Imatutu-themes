<?php
/**
 * Row and Column Grid Handler Template
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

$sec_index = get_query_var('section_index', 1);
$layout    = get_theme_mod("builder_sec_{$sec_index}_layout", ($sec_index === 1) ? 'col-2' : (($sec_index === 2) ? 'col-3' : 'col-1'));
$gap       = get_theme_mod("builder_sec_{$sec_index}_gap", 24);
$valign    = get_theme_mod("builder_sec_{$sec_index}_valign", 'center');

// Determine maximum columns to render based on layout
$max_cols = 1;
if ($layout === 'col-2' || $layout === 'col-1-2' || $layout === 'col-2-1') {
    $max_cols = 2;
} elseif ($layout === 'col-3') {
    $max_cols = 3;
} elseif ($layout === 'col-4') {
    $max_cols = 4;
}

$grid_classes = array(
    'builder-grid',
    "grid-{$layout}",
    "valign-{$valign}",
);

$grid_style = 'style="--builder-gap: ' . esc_attr($gap) . 'px;"';
?>

<div class="<?php echo esc_attr(implode(' ', $grid_classes)); ?>" <?php echo $grid_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <?php for ($c = 1; $c <= $max_cols; $c++) : 
        $col_prefix = "builder_sec_{$sec_index}_col_{$c}";
        $comp_type  = get_theme_mod("{$col_prefix}_type", ($sec_index === 1 && $c === 1) ? 'heading' : (($sec_index === 1 && $c === 2) ? 'image' : (($sec_index === 2 && $c <= 3) ? 'iconbox' : 'none')));

        if ($comp_type === 'none') {
            continue;
        }

        set_query_var('component_prefix', $col_prefix);
        set_query_var('col_index', $c);
    ?>
        <div class="builder-column builder-col-<?php echo esc_attr($c); ?>">
            <?php get_template_part('template-parts/builder/component', $comp_type); ?>
        </div>
    <?php endfor; ?>
</div>
