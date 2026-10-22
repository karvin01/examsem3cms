<!-- Blog Page - whenever there is blog post about gear or whatever, it needs the link to the shop part with this stuff-->
<?php get_header(); ?>

<main id="main-content" class="site-main">
    <div class="blog-container">
        <h1>Latest Articles</h1>

        <div class="blog-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>

                    <article class="blog-card">
                        <!-- esc_url() sanitizes the destination link; the_title_attribute() escapes the ARIA label -->
                        <a href="<?php echo esc_url(get_permalink()); ?>" aria-label="<?php echo esc_attr(sprintf('Read more about %s', get_the_title())); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                        <div class="blog-card-content">
                            <h2>
                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <?php echo esc_html(get_the_title()); ?>
                                </a>
                            </h2>
                            <div><?php the_excerpt(); ?></div>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more">Read More</a>
                        </div>
                    </article>

                <?php endwhile; ?>
            <?php else : ?>
                <p><?php echo esc_html__('No posts found.', 'cmsdm'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>