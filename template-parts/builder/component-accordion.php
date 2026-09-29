<?php
/**
 * Builder Component: Accordion / FAQ
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

$q = get_theme_mod("{$prefix}_faq_q", 'How quickly can Imatutu deploy support teams?');
$a = get_theme_mod("{$prefix}_faq_a", 'Our trained agents and technicians can be onboarded and active within 48 to 72 hours depending on scope.');
?>

<div class="builder-component component-accordion">
    <div class="builder-accordion-item">
        <button class="builder-accordion-header" type="button" aria-expanded="false">
            <span class="accordion-question"><?php echo esc_html($q); ?></span>
            <span class="accordion-icon" aria-hidden="true">+</span>
        </button>
        <div class="builder-accordion-body" style="display: none;">
            <p><?php echo nl2br(esc_html($a)); ?></p>
        </div>
    </div>
</div>
