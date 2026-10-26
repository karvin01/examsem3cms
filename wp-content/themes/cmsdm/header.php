<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <a class="skip-link" href="#main-content">Skip to main content</a>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="logo">
        <a href="<?php echo home_url(); ?>">
            <!-- Logo Image -->
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/LogoMotoshopHeader1.png" alt="Motoshop Logo">
        </a>
    </div>

    <!-- Added id="primary-menu" and aria-label for accessibility -->
    <nav class="main-nav" id="primary-menu" aria-label="Main Navigation">
        <ul>
            <li><a href="<?php echo home_url('/shop'); ?>">Shop</a></li>
            <li><a href="<?php echo home_url('/test'); ?>">Test drive</a></li>
            <li><a href="<?php echo home_url('/blog'); ?>">Blog</a></li>
            <li><a href="<?php echo home_url('/sustainability'); ?>">Sustainability initiatives</a></li>
            <li><a href="<?php echo home_url('/contact'); ?>">Contact</a></li>
        </ul>
    </nav>

    <!-- Grouped Cart and Toggle Button on the right -->
    <div class="header-right">
        <div class="cart">
            <a href="<?php echo home_url('/cart'); ?>" aria-label="Shopping Cart">
                <!-- Cart Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32" aria-hidden="true">
                    <path d="M0 0h32v32H0z" fill="none" />
                    <circle cx="10" cy="28" r="2" fill="currentColor" />
                    <circle cx="24" cy="28" r="2" fill="currentColor" />
                    <path fill="currentColor" d="M28 7H5.82L5 2.8A1 1 0 0 0 4 2H0v2h3.18L7 23.2a1 1 0 0 0 1 .8h18v-2H8.82L8 18h18a1 1 0 0 0 1-.78l2-9A1 1 0 0 0 28 7m-2.8 9H7.62l-1.4-7h20.53Z" />
                </svg>
                <span>Cart</span>
            </a>
        </div>

        <!-- Accessible Hamburger Toggle Button (WCAG 2.5.8 >= 44x44px) -->
        <button class="menu-toggle" id="menu-toggle" aria-expanded="false" aria-controls="primary-menu" aria-label="Open main menu">
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
            <span class="hamburger-bar"></span>
        </button>
    </div>
</header>

<div id="content" class="site-content"></div>