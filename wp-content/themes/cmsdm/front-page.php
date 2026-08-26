<?php get_header(); ?>

<main class="site-main">
    <!-- hero section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <span class="hero-tagline"><?php the_field('hero-tagline'); ?></span>
                <h1 class="hero-title"><?php the_field('hero-title'); ?></h1>
                <p class="hero-description">
                    <?php the_field('hero-description'); ?>
                </p>
                <div class="hero-buttons">
                    <a href="<?php echo esc_url(home_url('/shop')); ?>" class="btn btn-primary">Shop products</a>
                    <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn btn-secondary">Read the blog</a>
                </div>
            </div>

            <div class="hero-image">
                <?php 
                $hero_img = get_field('hero-image');
                if ($hero_img) : ?>
                    <img src="<?php echo esc_url($hero_img); ?>" alt="<?php echo esc_attr(get_field('hero-title')); ?>">
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-image.jpg" alt="Hero Motorcycle Image">
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- brand message -->
    <section class="brand-message">
        <div class="brand-container">
            <h2>
                <?php 
                echo esc_html(
                    get_field('brand-title') ?: 'Why choose Moto Shop'
                ); 
                ?>
            </h2>
            <p>
                <?php 
                echo esc_html(
                    get_field('brand-description') ?: 'We provide precision-tuned motorcycles and rigorously tested gear designed for longevity, safety, and uncompromising performance. Every build meets strict quality standards so you can ride with total confidence.'
                ); 
                ?>
            </p>
        </div>
    </section>
</main>

<?php get_footer(); ?>