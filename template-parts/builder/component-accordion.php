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

$items = array(
    1 => array(
        'q' => get_theme_mod("{$prefix}_faq_q1", get_theme_mod("{$prefix}_faq_q", 'How quickly can Imatutu deploy support teams?')),
        'a' => get_theme_mod("{$prefix}_faq_a1", get_theme_mod("{$prefix}_faq_a", 'Our trained agents and technicians can be onboarded and active within 48 to 72 hours depending on scope.')),
    ),
    2 => array(
        'q' => get_theme_mod("{$prefix}_faq_q2", 'What industries does Imatutu specialize in?'),
        'a' => get_theme_mod("{$prefix}_faq_a2", 'We provide comprehensive business support across logistics, transport dispatch, IT technical support, customer care, and corporate administration.'),
    ),
    3 => array(
        'q' => get_theme_mod("{$prefix}_faq_q3", 'Do you offer 24/7 round-the-clock coverage?'),
        'a' => get_theme_mod("{$prefix}_faq_a3", 'Yes, our operational hubs operate 24/7/365 to deliver continuous global support across multiple timezones.'),
    ),
);
?>

<div class="builder-component component-accordion">
    <div class="builder-accordion-group">
        <?php foreach ($items as $idx => $item) : 
            if (empty(trim($item['q']))) {
                continue;
            }
        ?>
            <div class="builder-accordion-item" data-accordion-index="<?php echo esc_attr($idx); ?>">
                <button class="builder-accordion-header" type="button" aria-expanded="false">
                    <span class="accordion-question faq-q-<?php echo esc_attr($idx); ?>"><?php echo esc_html($item['q']); ?></span>
                    <span class="accordion-icon" aria-hidden="true">+</span>
                </button>
                <div class="builder-accordion-body" style="display: none;">
                    <p class="faq-a-<?php echo esc_attr($idx); ?>"><?php echo nl2br(esc_html($item['a'])); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
