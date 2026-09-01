<?php get_header(); ?>

<main class="site-main">
    <!-- hero section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <span class="hero-tagline"><?php the_field('hero-tagline'); ?></span>
                <h1 class="hero-title"><?php the_field('hero-title'); ?></h1>
                <p class="hero-description"><?php the_field('hero-description'); ?></p>
                <div class="hero-buttons">
                    <a href="<?php echo esc_url(home_url('/shop')); ?>" class="btn btn-primary">Shop products</a>
                    <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn btn-secondary">Read the blog</a>
                </div>
            </div>

            <div class="hero-image">
                <?php if ($hero_img = get_field('hero-image')) : ?>
                    <img src="<?php echo esc_url($hero_img); ?>" alt="<?php echo esc_attr(get_field('hero-title')); ?>">
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- brand message -->
    <section class="brand-message">
        <div class="brand-container">
            <h2><?php echo esc_html(get_field('brand-title') ?: 'Why choose Moto Shop'); ?></h2>
            <p><?php echo esc_html(get_field('brand-description') ?: 'We provide precision-tuned motorcycles and rigorously tested gear designed for longevity, safety, and uncompromising performance.'); ?></p>
        </div>
    </section>

    <!-- video -->
    <?php if (get_field('featured_video')) : ?>
        <section class="video-section">
            <div class="video-container">
                <?php if (get_field('video_title')) : ?>
                    <h2><?php echo esc_html(get_field('video_title')); ?></h2>
                <?php endif; ?>

                <div class="video-wrapper">
                    <?php the_field('featured_video'); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- testimonials -->
    <section class="testimonials">
        <div class="testimonials-container">
            <h2><?php echo esc_html(get_field('testimonials_title') ?: 'Customer feedback'); ?></h2>

            <div class="testimonial-items">
                <?php for ($i = 1; $i <= 3; $i++) : 

                    $is_active = get_field("testimonial_{$i}_active");
                    $name   = get_field("testimonial_{$i}_name");

                    // If toggle is OFF or name is empty, skip this review completely
                        if (!$is_active || empty($name)) {
                            continue;
                        }

                    $avatar = get_field("testimonial_{$i}_avatar");
                    $rating = (int) (get_field("testimonial_{$i}_rating") ?: 5);
                    $quote  = get_field("testimonial_{$i}_quote");
                ?>
                    <div class="testimonial-item">
                        <div class="testimonial-header">
                            <?php if ($avatar) : ?>
                                <div class="testimonial-avatar">
                                    <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($name); ?>">
                                </div>
                            <?php endif; ?>

                            <div class="testimonial-meta">
                                <h3 class="testimonial-author"><?php echo esc_html($name); ?></h3>
                                <div class="testimonial-stars"><?php echo esc_html(str_repeat('★', $rating)); ?></div>
                            </div>
                        </div>

                        <p class="testimonial-quote">“<?php echo esc_html($quote); ?>”</p>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>