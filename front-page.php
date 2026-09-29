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
    get_template_part('template-parts/home/section', 'stats');
    get_template_part('template-parts/home/section', 'clients');
    ?>
</main>

<?php
get_footer();
