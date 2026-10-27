<?php
/**
 * The template for displaying the blog posts index (home.php)
 *
 * @package MotoShop
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header(); 
?>

<main id="main-content" class="site-main">
    <div class="blog-container">
        <h1><?php echo esc_html(single_post_title('', false) ?: __('Latest Articles', 'cmsdm')); ?></h1>

        <div class="blog-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php echo esc_url(get_permalink()); ?>" aria-label="<?php echo esc_attr(sprintf(__('Read more about %s', 'cmsdm'), the_title_attribute(array('echo' => false)))); ?>">
                                <?php the_post_thumbnail('medium', array('loading' => 'lazy')); ?>
                            </a>
                        <?php endif; ?>

                        <div class="blog-card-content">
                            <h2>
                                <a href="<?php echo esc_url(get_permalink()); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h2>
                            <div class="blog-card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="read-more">
                                <?php echo esc_html__('Read More', 'cmsdm'); ?>
                            </a>
                        </div>
                    </article>

                <?php endwhile; ?>

                <div class="blog-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('&larr; Previous', 'cmsdm'),
                        'next_text' => __('Next &rarr;', 'cmsdm'),
                    ));
                    ?>
                </div>

            <?php else : ?>
                <p><?php echo esc_html__('No posts found.', 'cmsdm'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>