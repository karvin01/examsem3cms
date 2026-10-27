<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header(); 
?>

<main id="main-content">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article>
                <h1><?php the_title(); ?></h1>
                <div><?php the_content(); ?></div>
            </article>
        <?php endwhile;
    else :
        echo '<p>No content found</p>';
    endif;
    ?>
</main>

<?php get_footer(); ?>