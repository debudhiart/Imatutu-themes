<?php
/**
 * Template Name: Full-Width Canvas (No Box / 21st.dev Builder)
 * Template Post Type: page
 *
 * @package Imatutu
 * @version 2.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main page-template-fullwidth">
    <?php
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php
get_footer();
