<?php
/**
 * WooCommerce Catch-All Template (woocommerce.php)
 *
 * @package MotoShop
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header(); 
?>

<main id="main-content" class="site-main shop-main">
    <div class="shop-container">
        
        <?php if ( function_exists('is_shop') && ( is_shop() || is_product_taxonomy() ) ) : ?>
            <?php if ( is_shop() ) : ?>
                <aside class="shop-promo-banner" role="region" aria-label="First order discount">
                    <div class="promo-content">
                        <span class="promo-tag">Special Offer</span>
                        <p>Get <strong>10% off</strong> your first order! Use voucher code <code class="promo-code">HALLOWEEN10</code> at checkout.</p>
                    </div>
                    <button type="button" class="promo-close" aria-label="Dismiss banner">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </aside>
            <?php endif; ?>

            <div class="shop-layout">
                <!-- Sidebar Filter -->
                <aside class="shop-sidebar" aria-label="Shop Filters">
                    <?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
                        <?php dynamic_sidebar( 'shop-sidebar' ); ?>
                    <?php else : ?>
                        <div class="shop-widget widget_product_categories">
                            <!-- Native collapsible element: open on desktop, toggled on mobile via CSS -->
                            <details class="category-collapsible" open>
                                <summary class="widget-title">
                                    <span>Categories</span>
                                    <span class="toggle-icon" aria-hidden="true">▾</span>
                                </summary>
                                
                                <ul class="product-categories">
                                    <?php
                                    wp_list_categories( array(
                                        'taxonomy'     => 'product_cat',
                                        'title_li'     => '',
                                        'show_count'   => true,
                                        'hierarchical' => true,
                                        'hide_empty'   => false,
                                        'orderby'      => 'name',
                                        'order'        => 'ASC',
                                    ) );
                                    ?>
                                </ul>
                            </details>
                        </div>
                    <?php endif; ?>
                </aside>
                
                <!-- Product Grid -->
                <div class="shop-content">
                    <?php 
                    if ( function_exists('woocommerce_content') ) {
                        woocommerce_content(); 
                    }
                    ?>
                </div>
            </div>
        <?php else : ?>
            <!-- Single product, Cart, Checkout, Account views or non-WooCommerce fallback -->
            <div class="shop-content-full">
                <?php 
                if ( function_exists('woocommerce_content') ) {
                    woocommerce_content(); 
                } else {
                    while ( have_posts() ) : the_post();
                        the_content();
                    endwhile;
                }
                ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>