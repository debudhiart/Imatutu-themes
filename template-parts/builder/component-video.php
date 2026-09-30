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
$aspect    = get_theme_mod("{$prefix}_video_aspect", '16-9');
$autoplay  = get_theme_mod("{$prefix}_video_autoplay", false);
?>

<div class="builder-component component-video">
    <?php if (!empty($video_url)) : ?>
        <div class="builder-video-responsive ratio-<?php echo esc_attr($aspect); ?>">
            <?php
            $embed_code = wp_oembed_get($video_url);
            if ($embed_code) {
                if ($autoplay) {
                    $embed_code = preg_replace('/src="([^"]+)"/', 'src="$1&autoplay=1&mute=1"', $embed_code);
                }
                echo $embed_code; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            } else {
                $auto_attr = $autoplay ? ' autoplay muted loop' : '';
                echo '<video controls playsinline' . $auto_attr . '><source src="' . esc_url($video_url) . '" type="video/mp4"></video>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
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
