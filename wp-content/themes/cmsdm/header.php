<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="logo">
        <a href="<?php echo home_url(); ?>">
            <!-- Logo Image -->
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/LogoMotoshop1.png" alt="Motoshop Logo">
        </a>
    </div>

    <nav class="main-nav">
        <ul>
            <li><a href="<?php echo home_url('/shop'); ?>">Shop</a></li>
            <li><a href="<?php echo home_url('/categories'); ?>">Categories</a></li>
            <li><a href="<?php echo home_url('/blog'); ?>">Blog</a></li>
            <li><a href="<?php echo home_url('/about'); ?>">About</a></li>
        </ul>
    </nav>

    <div class="cart">
        <a href="<?php echo home_url('/cart'); ?>">
        <!-- Cart Icon -->
         <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
            <path d="M0 0h32v32H0z" fill="none" />
            <circle cx="10" cy="28" r="2" fill="currentColor" />
            <circle cx="24" cy="28" r="2" fill="currentColor" />
            <path fill="currentColor" d="M28 7H5.82L5 2.8A1 1 0 0 0 4 2H0v2h3.18L7 23.2a1 1 0 0 0 1 .8h18v-2H8.82L8 18h18a1 1 0 0 0 1-.78l2-9A1 1 0 0 0 28 7m-2.8 9H7.62l-1.4-7h20.53Z" />
        </svg>
        <span> Cart </span>
        </a>
    </div>
</header>

<div id="content" class="site-content"></div>