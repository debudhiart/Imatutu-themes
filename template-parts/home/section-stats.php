<?php
/**
 * Template part for displaying the Global Reach & Stats Section on the Homepage
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

$stats_title = get_theme_mod('stats_title', 'Our Global Reach');
$stats_desc  = get_theme_mod('stats_desc', 'With numerous clients, successful projects and a wide reach, Imatutu is making a mark as the preferred outsourcing partner. We support our global clients, delivering excellence in every project. Our services span across multiple countries and multiple industries, helping businesses achieve their goals globally.');
$stats_image = get_theme_mod('stats_side_image', '');

$stats = array(
    1 => array(
        'number' => get_theme_mod('stat_1_number', '150+'),
        'label'  => get_theme_mod('stat_1_label', 'Client'),
        'desc'   => get_theme_mod('stat_1_desc', 'Active enterprise clients'),
    ),
    2 => array(
        'number' => get_theme_mod('stat_2_number', '150+'),
        'label'  => get_theme_mod('stat_2_label', 'Project'),
        'desc'   => get_theme_mod('stat_2_desc', 'Delivered successfully'),
    ),
    3 => array(
        'number' => get_theme_mod('stat_3_number', '3'),
        'label'  => get_theme_mod('stat_3_label', 'Country'),
        'desc'   => get_theme_mod('stat_3_desc', 'Global coverage (AU, NZ, ID)'),
    ),
);
?>

<section id="global-reach" class="section stats-section">
    <div class="site-container">
        <div class="stats-layout-grid">
            <!-- Left Content Column -->
            <div class="stats-content-col">
                <span class="section-pill"><?php esc_html_e('International Track Record', 'imatutu'); ?></span>
                <h2 class="section-title text-left"><?php echo esc_html($stats_title); ?></h2>
                <div class="title-accent-bar left-align"></div>

                <p class="stats-description-text">
                    <?php echo nl2br(esc_html($stats_desc)); ?>
                </p>

                <!-- 3 Stats Metrics (Using span tags for semantic heading validity) -->
                <div class="stats-counters-grid">
                    <?php foreach ($stats as $idx => $stat) : ?>
                        <div class="stat-counter-card stat-card-<?php echo esc_attr($idx); ?>">
                            <span class="stat-number stat-num-<?php echo esc_attr($idx); ?>"><?php echo esc_html($stat['number']); ?></span>
                            <span class="stat-label stat-lbl-<?php echo esc_attr($idx); ?>"><?php echo esc_html($stat['label']); ?></span>
                            <span class="stat-sublabel stat-desc-<?php echo esc_attr($idx); ?>"><?php echo esc_html($stat['desc']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right Showcase Graphic Column -->
            <div class="stats-visual-col">
                <div class="stats-showcase-card">
                    <?php if (!empty($stats_image)) : ?>
                        <img src="<?php echo esc_url($stats_image); ?>" alt="<?php esc_attr_e('Imatutu Global Operations', 'imatutu'); ?>" class="stats-custom-img" loading="lazy" />
                    <?php else : ?>
                        <!-- Modern SVG Graphic Representation of Global Connectivity -->
                        <div class="stats-graphic-wrapper">
                            <div class="globe-decor-circle"></div>
                            <div class="connectivity-badge">
                                <div class="badge-icon-pulse"></div>
                                <div>
                                    <strong class="badge-title"><?php esc_html_e('Australia & New Zealand', 'imatutu'); ?></strong>
                                    <p class="badge-desc"><?php esc_html_e('Primary Transport & Enterprise Dispatch Network', 'imatutu'); ?></p>
                                </div>
                            </div>
                            
                            <div class="connectivity-network-list">
                                <div class="network-item">
                                    <span class="network-flag">🇦🇺</span>
                                    <div class="network-info">
                                        <strong>Australia</strong>
                                        <span>Canberra, ACT & Nationwide</span>
                                    </div>
                                </div>
                                <div class="network-item">
                                    <span class="network-flag">🇳🇿</span>
                                    <div class="network-info">
                                        <strong>New Zealand</strong>
                                        <span>Auckland, Wellington & Palmerston North</span>
                                    </div>
                                </div>
                                <div class="network-item">
                                    <span class="network-flag">🇮🇩</span>
                                    <div class="network-info">
                                        <strong>Indonesia</strong>
                                        <span>Denpasar Hub & Operational Centers</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
