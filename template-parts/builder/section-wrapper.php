<?php
/**
 * Dynamic Section Wrapper Template
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

$sec_index = get_query_var('section_index', 1);
$is_enabled = get_theme_mod("builder_sec_{$sec_index}_enable", ($sec_index <= 2));

if (!$is_enabled) {
    return;
}

$bg_type  = get_theme_mod("builder_sec_{$sec_index}_bg_type", ($sec_index % 2 === 0) ? 'soft_slate' : 'default_white');
$padding  = get_theme_mod("builder_sec_{$sec_index}_padding", 'medium');

$classes = array(
    'section',
    'builder-section',
    "builder-sec-{$sec_index}",
    "bg-{$bg_type}",
    "pad-{$padding}",
);
?>

<section id="modular-section-<?php echo esc_attr($sec_index); ?>" class="<?php echo esc_attr(implode(' ', $classes)); ?>">
    <div class="site-container builder-container">
        <?php
        set_query_var('section_index', $sec_index);
        get_template_part('template-parts/builder/row', 'column');
        ?>
    </div>
</section>
