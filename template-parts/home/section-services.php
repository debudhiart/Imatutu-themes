<?php
/**
 * Template part for displaying the Services Section on the Homepage
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

$services_subtitle = get_theme_mod('services_subtitle', 'What We OFFER');
$services_title    = get_theme_mod('services_title', 'Taylor Made Solutions for Your Business');

$services = array(
    1 => array(
        'title' => get_theme_mod('service_1_title', 'Customer Service Support'),
        'desc'  => get_theme_mod('service_1_desc', 'We provide 24/7 contact center services tailored to suit your industry needs from, handling inquiries, transport bookings, handling customer feedback and resolving issues promptly to ensure customer satisfaction. Our team is trained to deliver exceptional service in every interaction.'),
        'image' => get_theme_mod('service_1_image', ''),
        'icon'  => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>',
        'tag'   => '24/7 Contact Center',
    ),
    2 => array(
        'title' => get_theme_mod('service_2_title', 'Full Technical Support'),
        'desc'  => get_theme_mod('service_2_desc', 'Our experts offer reliable troubleshooting and technical assistance, for multiple systems helping clients resolve technical problems efficiently. We focus on quick solutions to minimize downtime.'),
        'image' => get_theme_mod('service_2_image', ''),
        'icon'  => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>',
        'tag'   => 'IT & Systems Troubleshooting',
    ),
    3 => array(
        'title' => get_theme_mod('service_3_title', 'Administration Support'),
        'desc'  => get_theme_mod('service_3_desc', 'Full accounting services available, teamed up with data processing, general administration and customer service support'),
        'image' => get_theme_mod('service_3_image', ''),
        'icon'  => '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
        'tag'   => 'Accounting & Back Office',
    ),
);
?>

<section id="services" class="section services-section">
    <div class="site-container">
        <!-- Section Header -->
        <div class="section-header text-center">
            <span class="section-pill"><?php echo esc_html($services_subtitle); ?></span>
            <h2 class="section-title"><?php echo esc_html($services_title); ?></h2>
            <div class="title-accent-bar"></div>
        </div>

        <!-- Services Grid -->
        <div class="services-grid">
            <?php foreach ($services as $index => $item) : ?>
                <div class="service-card">
                    <div class="service-card-inner">
                        <?php if (!empty($item['image'])) : ?>
                            <div class="service-card-media">
                                <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>" loading="lazy" />
                            </div>
                        <?php endif; ?>

                        <div class="service-card-body">
                            <div class="service-icon-box">
                                <?php echo $item['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                            
                            <span class="service-tag"><?php echo esc_html($item['tag']); ?></span>
                            <h3 class="service-title"><?php echo esc_html($item['title']); ?></h3>
                            <p class="service-description"><?php echo esc_html($item['desc']); ?></p>

                            <div class="service-footer">
                                <a href="<?php echo esc_url(get_theme_mod('header_cta_link', 'https://imatutu.com/contact-us/')); ?>" class="service-link">
                                    <span><?php esc_html_e('Learn More', 'imatutu'); ?></span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
