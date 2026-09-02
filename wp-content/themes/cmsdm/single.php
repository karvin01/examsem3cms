<?php get_header(); ?>

<main class="site-main">
    <article class="single-post-container">
        <?php while (have_posts()) : the_post(); ?>

            <header class="post-header">
                <h1 class="post-title"><?php the_title(); ?></h1>
                <div class="post-meta">
                    <span>Published on <?php echo get_the_date(); ?></span>
                    <span>by <?php the_author(); ?></span>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="post-content">
                <?php the_content(); ?>
            </div>

            <!-- Comment section -->
            <section class="post-comments">
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </section>

        <?php endwhile; ?>
    </article>
</main>

<?php get_footer(); ?>