<?php
/**
 * The front page template file
 *
 * Serves as the orchestrator for the homepage components.
 *
 * @package Imatutu
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="primary" class="site-main">
    <?php
    get_template_part('template-parts/home/section', 'hero');
    get_template_part('template-parts/home/section', 'services');

    // Render Dynamic Modular Builder Sections from Customizer
    for ($i = 1; $i <= 5; $i++) {
        if (get_theme_mod("builder_sec_{$i}_enable", ($i <= 2))) {
            set_query_var('section_index', $i);
            get_template_part('template-parts/builder/section', 'wrapper');
        }
    }

    get_template_part('template-parts/home/section', 'stats');
    get_template_part('template-parts/home/section', 'clients');
    ?>
</main>

<?php
get_footer();
