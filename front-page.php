<?php
/**
 * The Front Page Template (Hybrid Implementation)
 *
 * Checks if the front page has content authored in WordPress Gutenberg editor.
 * If content exists, it renders the_content() seamlessly.
 * If empty, it renders default fallback components so the site is never blank.
 *
 * @package Imatutu
 * @version 2.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main front-page-hybrid">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            $page_content = trim(get_the_content());

            if (!empty($page_content)) :
                // Render visual block patterns authored in WordPress Page Editor
                the_content();
            else :
                // Default Fallback: Renders original corporate sections
                get_template_part('template-parts/home/section', 'hero');
                get_template_part('template-parts/home/section', 'services');
                get_template_part('template-parts/home/section', 'stats');
                get_template_part('template-parts/home/section', 'clients');
            endif;
        endwhile;
    else :
        // Secondary fallback
        get_template_part('template-parts/home/section', 'hero');
        get_template_part('template-parts/home/section', 'services');
        get_template_part('template-parts/home/section', 'stats');
        get_template_part('template-parts/home/section', 'clients');
    endif;
    ?>
</main>

<?php
get_footer();
