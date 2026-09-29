<?php
/**
 * Builder Component: Paragraph
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

$content = get_theme_mod("{$prefix}_paragraph_text", 'Our dedicated outsourcing solutions help streamline business workflows and accelerate growth with 24/7 reliability.');
$size    = get_theme_mod("{$prefix}_paragraph_size", 'regular');
$align   = get_theme_mod("{$prefix}_paragraph_align", 'left');

$p_classes = array(
    'builder-body-text',
    "size-{$size}",
    "text-{$align}",
);
?>

<div class="builder-component component-paragraph">
    <p class="<?php echo esc_attr(implode(' ', $p_classes)); ?>">
        <?php echo nl2br(esc_html($content)); ?>
    </p>
</div>
