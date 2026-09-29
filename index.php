<?php
/**
 * The main template file
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main page-template-main">
    <section class="page-banner-section">
        <div class="site-container">
            <header class="entry-header text-center">
                <span class="section-pill"><?php esc_html_e('Articles & Updates', 'imatutu'); ?></span>
                <h1 class="entry-title"><?php single_post_title(); ?></h1>
                <div class="title-accent-bar"></div>
            </header>
        </div>
    </section>

    <div class="site-container page-content-container">
        <?php if (have_posts()) : ?>
            <div class="archive-posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-card-thumb">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-card-content">
                            <div class="post-meta">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
                            </div>
                            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <div class="post-excerpt"><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="post-readmore">
                                <span><?php esc_html_e('Read Article', 'imatutu'); ?></span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="posts-pagination">
                <?php the_posts_pagination(array(
                    'prev_text' => '&larr; ' . esc_html__('Previous', 'imatutu'),
                    'next_text' => esc_html__('Next', 'imatutu') . ' &rarr;',
                )); ?>
            </div>
        <?php else : ?>
            <?php get_template_part('template-parts/content', 'none'); ?>
        <?php endif; ?>
    </div>
</main>

<?php
get_footer();
