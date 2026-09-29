<?php
/**
 * Template part for displaying the Partners & Clients Section on the Homepage
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

$clients_title = get_theme_mod('clients_section_title', 'Our Trusted Partners');

$default_clients = array(
    1 => array('name' => 'Alert Taxis', 'url' => 'http://www.alerttaxis.co.nz', 'loc' => 'New Zealand'),
    2 => array('name' => 'Canberra Elite', 'url' => 'http://www.canberraelite.com.au', 'loc' => 'Australia'),
    3 => array('name' => 'NZTC', 'url' => 'http://www.nztc.net.nz', 'loc' => 'New Zealand'),
    4 => array('name' => 'Aerial Capital Group', 'url' => 'http://www.aerialcapitalgroup.com.au', 'loc' => 'Australia'),
    5 => array('name' => 'First Direct', 'url' => 'http://www.firstdirect.net.nz', 'loc' => 'New Zealand'),
    6 => array('name' => 'PN Taxis', 'url' => 'http://www.pntaxis.co.nz', 'loc' => 'New Zealand'),
    7 => array('name' => 'BusMe', 'url' => 'http://www.busme.com.au', 'loc' => 'Australia'),
    8 => array('name' => 'Silver Service Canberra', 'url' => 'http://www.silverservicecanberra.com.au', 'loc' => 'Australia'),
    9 => array('name' => 'QE Taxis', 'url' => 'http://www.qetaxis.com.au', 'loc' => 'Australia'),
);
?>

<section id="clients" class="section clients-section">
    <div class="site-container">
        <!-- Section Header -->
        <div class="section-header text-center">
            <span class="section-pill"><?php esc_html_e('Partnership & Clients', 'imatutu'); ?></span>
            <h2 class="section-title"><?php echo esc_html($clients_title); ?></h2>
            <div class="title-accent-bar"></div>
            <p class="section-subtitle-text"><?php esc_html_e('Empowering leading enterprise transport and business service networks across Australia and New Zealand.', 'imatutu'); ?></p>
        </div>

        <!-- 9 Partners Grid -->
        <div class="clients-grid">
            <?php for ($i = 1; $i <= 9; $i++) : 
                $client_name = get_theme_mod("client_{$i}_name", $default_clients[$i]['name']);
                $client_url  = get_theme_mod("client_{$i}_url", $default_clients[$i]['url']);
                $client_logo = get_theme_mod("client_{$i}_logo", '');
                $client_loc  = isset($default_clients[$i]['loc']) ? $default_clients[$i]['loc'] : 'Global';
            ?>
                <a href="<?php echo esc_url($client_url); ?>" class="client-card" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr($client_name); ?> - Official Website">
                    <div class="client-card-inner">
                        <?php if (!empty($client_logo)) : ?>
                            <img src="<?php echo esc_url($client_logo); ?>" alt="<?php echo esc_attr($client_name . ' Partner Logo'); ?>" class="client-logo-img" loading="lazy" />
                        <?php else : ?>
                            <div class="client-badge-placeholder">
                                <div class="client-initial-badge">
                                    <?php 
                                    $words = explode(' ', $client_name);
                                    $initials = '';
                                    foreach (array_slice($words, 0, 2) as $w) {
                                        $initials .= strtoupper(substr($w, 0, 1));
                                    }
                                    echo esc_html($initials);
                                    ?>
                                </div>
                                <span class="client-name-text"><?php echo esc_html($client_name); ?></span>
                                <span class="client-loc-tag"><?php echo esc_html($client_loc); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="client-hover-arrow" aria-hidden="true">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </div>
                    </div>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</section>
