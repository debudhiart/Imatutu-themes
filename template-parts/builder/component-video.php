<?php
/**
 * Builder Component: Responsive Video
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

$video_url = get_theme_mod("{$prefix}_video_url", '');
?>

<div class="builder-component component-video">
    <?php if (!empty($video_url)) : ?>
        <div class="builder-video-responsive ratio-16-9">
            <?php
            $embed_code = wp_oembed_get($video_url);
            if ($embed_code) {
                echo $embed_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else {
                echo '<video controls playsinline><source src="' . esc_url($video_url) . '" type="video/mp4"></video>';
            }
            ?>
        </div>
    <?php else : ?>
        <div class="builder-video-placeholder">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
            <span><?php esc_html_e('Enter YouTube, Vimeo, or MP4 URL in Customizer', 'imatutu'); ?></span>
        </div>
    <?php endif; ?>
</div>
