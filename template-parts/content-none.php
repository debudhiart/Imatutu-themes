<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

<section class="no-results not-found site-container text-center" style="padding: 80px 20px;">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e('Nothing Found', 'imatutu'); ?></h1>
    </header>

    <div class="page-content" style="max-width: 600px; margin: 20px auto;">
        <?php if (is_home() && current_user_can('publish_posts')) : ?>
            <p><?php printf(wp_kses(__('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'imatutu'), array('a' => array('href' => array()))), esc_url(admin_url('post-new.php'))); ?></p>
        <?php elseif (is_search()) : ?>
            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'imatutu'); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'imatutu'); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </div>
</section>
