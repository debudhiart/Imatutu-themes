<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main error-404-main">
    <div class="site-container error-404-container">
        <div class="error-404-card">
            <span class="error-code-badge">404</span>
            <h1 class="error-title"><?php esc_html_e('Oops! Page Not Found', 'imatutu'); ?></h1>
            <p class="error-desc"><?php esc_html_e('The page you are looking for might have been moved, removed, or is temporarily unavailable.', 'imatutu'); ?></p>
            <div class="error-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary btn-lg">
                    <span><?php esc_html_e('Back to Homepage', 'imatutu'); ?></span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
