<?php get_header(); ?>

<main id="main-content" class="site-main">
    <article class="single-post-container">
        <?php while (have_posts()) : the_post(); ?>

            <header class="post-header">
                <!-- Escaped title output -->
                <h1 class="post-title"><?php echo esc_html(get_the_title()); ?></h1>
                <div class="post-meta">
                    <!-- esc_html() prevents any malicious script injection from date or author strings -->
                    <span>Published on <?php echo esc_html(get_the_date()); ?></span>
                    <span>by <?php echo esc_html(get_the_author()); ?></span>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="post-content">
                <!-- the_content() runs through WordPress wp_kses_post filter automatically -->
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