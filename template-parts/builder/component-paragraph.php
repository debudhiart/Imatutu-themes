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
?>

<div class="builder-component component-paragraph">
    <p class="builder-body-text">
        <?php echo nl2br(esc_html($content)); ?>
    </p>
</div>
