<?php get_header(); ?>

<main class="site-main">
    <!-- hero section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <span class="hero-tagline">Engineered for Performance</span>
                <h1 class="hero-title">Motorcycles & gear built for the open road</h1>
                <p class="hero-description">
                    Discover premium bikes, performance parts, and rider apparel tested to deliver maximum reliability and thrill on every ride.
                </p>
                <div class="hero-buttons">
                    <a href="<?php echo esc_url(home_url('/shop')); ?>" class="btn btn-primary">Shop products</a>
                    <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn btn-secondary">Read the blog</a>
                </div>
            </div>

            <div class="hero-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-image.jpg" alt="Motorcycle on the road" />
            </div>
        </div>
    </section>

    <!-- brand message -->
     <section class="brand-message">
         <div class="brand-container">
             <h2>Why choose Moto Shop</h2>
             <p>We provide precision-tuned motorcycles and rigorously tested gear designed for longevity, safety, and uncompromising performance. Every build meets strict quality standards so you can ride with total confidence.</p>
         </div>
     </section>
</main>

<?php get_footer(); ?>