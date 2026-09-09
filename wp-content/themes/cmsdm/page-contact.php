<?php get_header(); ?>
<!-- Contact Page Hero Section -->
<section class="hero-contact">
    <div class="contact-hero-container">
        <!-- Left col -->
        <div class="opening-hours">
            <h2>Opening Hours</h2>
            <div class="opening-hours-info">
                <ul>
                    <?php 
                    $mon_fri  = get_field('hours_mon_fri') ?: 'Monday - Friday: 9 AM - 6 PM';
                    $saturday = get_field('hours_saturday') ?: 'Saturday: 10 AM - 4 PM';
                    $sunday   = get_field('hours_sunday') ?: 'Sunday: Closed';
                    ?>

                    <?php if ($mon_fri) : ?>
                        <li><?php echo esc_html($mon_fri); ?></li>
                    <?php endif; ?>

                    <?php if ($saturday) : ?>
                        <li><?php echo esc_html($saturday); ?></li>
                    <?php endif; ?>

                    <?php if ($sunday) : ?>
                        <li><?php echo esc_html($sunday); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <!-- Right col -->
        <div class="map">
            <h2>Our Location</h2>
            <div class="map-info">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3607.6663923129713!2d8.444219244931912!3d55.48854680044522!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x464b20de0dc1b019%3A0xf131cc5b28fe1f27!2sSyddansk%20Erhvervsakademi!5e0!3m2!1scs!2sdk!4v1788886439155!5m2!1scs!2sdk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
        </div>

        <!-- Showroom pic -->
        <?php 
        $image   = get_field('storefront_image');
        $caption = get_field('storefront_caption');
        ?>

        <?php if ($image) : ?>
            <div class="storefront-preview">
                <img src="<?php echo esc_url($image); ?>" alt="Showroom picture">
                <?php if ($caption) : ?>
                    <span class="storefront-caption"><?php echo esc_html($caption); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Contact page showroom video section -->
<section class="showroom-video-section">
    <div class="showroom-video-container">
        <span class="showroom-subtitle">Take A Tour</span>
        <h2>Explore Our Showroom</h2>
        <p>Take a virtual walk through our dealership and check out our latest motorcycles and riding gear.</p>
        
        <div class="showroom-video-wrapper">
            <iframe src="https://www.youtube.com/embed/AehjuE4ari4?si=QPfbCjzMYdqvkuD_" title="Showroom Tour" allowfullscreen loading="lazy"></iframe>
        </div>
    </div>
</section>


<!-- Contact form with mail message -->
<section class="contact-form-section" id="contact-form-section">
    <div class="contact-form-container">
        <h2>Send Us A Message</h2>

        <!-- Check for and display transient errors -->
        <?php if ( $errors = get_transient('contact_form_errors') ) : ?>
            <div class="form-feedback error">
                <ul>
                    <?php foreach ( $errors as $error ) : ?>
                        <li><?php echo esc_html($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php delete_transient('contact_form_errors'); ?>
        <?php endif; ?>

        <!-- Check for and display transient success -->
        <?php if ( $success = get_transient('contact_form_success') ) : ?>
            <div class="form-feedback success">
                <p><?php echo esc_html($success); ?></p>
            </div>
            <?php delete_transient('contact_form_success'); ?>
        <?php endif; ?>

        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" class="custom-contact-form">
            <!-- Hidden action matches your add_action name in functions.php -->
            <input type="hidden" name="action" value="handle_contact_form">

            <!-- Security nonce -->
            <?php wp_nonce_field('contact_form_action', 'contact_form_nonce'); ?>

            <div class="form-group">
                <label for="contact_name">Full name <span class="required">*</span></label>
                <input type="text" name="contact_name" id="contact_name" required minlength="4">
            </div>

            <div class="form-group">
                <label for="contact_email">Email <span class="required">*</span></label>
                <input type="email" name="contact_email" id="contact_email" required>
            </div>

            <div class="form-group">
                <label for="contact_subject">Subject <span class="required">*</span></label>
                <input type="text" name="contact_subject" id="contact_subject" required minlength="3">
            </div>

            <div class="form-group">
                <label for="contact_message">Message <span class="required">*</span></label>
                <textarea name="contact_message" id="contact_message" rows="5" required minlength="10"></textarea>
            </div>

            <button type="submit" class="btn-submit">Send Message</button>
        </form>
    </div>
</section>
<?php get_footer(); ?>