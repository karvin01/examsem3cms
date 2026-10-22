<!-- Blog Page - whenever there is blog post about gear or whatever, it needs the link to the shop part with this stuff-->
<?php get_header(); ?>

<main class="site-main">
    <div class="blog-container">
        <h1>Latest Articles</h1>

        <div class="blog-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>

                    <article class="blog-card">
                        <a href="<?php the_permalink(); ?>" aria-label="Read more about <?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('medium'); ?>
                        </a>
                        <div class="blog-card-content">
                            <h2>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <div><?php the_excerpt(); ?></div>
                            <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                        </div>
                    </article>

                <?php endwhile; ?>
            <?php else : ?>
                <p>No posts found.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>