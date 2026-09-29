<?php
/**
 * The template for displaying all pages
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main page-template-main">
    <!-- Page Hero Banner -->
    <section class="page-banner-section">
        <div class="site-container">
            <header class="entry-header text-center">
                <span class="section-pill"><?php bloginfo('name'); ?></span>
                <h1 class="entry-title"><?php the_title(); ?></h1>
                <div class="title-accent-bar"></div>
            </header>
        </div>
    </section>

    <!-- Page Body Content -->
    <div class="site-container page-content-container">
        <div class="page-article-card">
            <?php
            while (have_posts()) :
                the_post();
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="page-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content typography-content">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'imatutu'),
                            'after'  => '</div>',
                        ));
                        ?>
                    </div>
                </article>
            <?php
            endwhile;
            ?>
        </div>
    </div>
</main>

<?php
get_footer();
