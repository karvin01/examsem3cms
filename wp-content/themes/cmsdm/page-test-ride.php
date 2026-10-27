<?php
/**
 * Template Name: Test Ride Dialogue Form
 * Description: Multi-step interactive motorcycle test ride booking form.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header(); 
?>

<main id="main-content" class="site-main test-ride-page">
    <div class="test-ride-container">
        
        <header class="section-header">
            <span class="sub-badge">Showroom Experience</span>
            <h1>Book a Motorcycle Test Ride</h1>
            <p>Complete this quick dialogue to schedule your test ride with one of our specialists.</p>
        </header>

        <!-- Step Indicator -->
        <nav class="step-progress" aria-label="Booking Progress">
            <div class="progress-bar-track">
                <div class="progress-bar-fill" id="progressFill" style="width: 33.33%;"></div>
            </div>
            <ul class="progress-steps" role="list">
                <li class="step-indicator active" data-step="1"><span>1</span> Bike & License</li>
                <li class="step-indicator" data-step="2"><span>2</span> Date & Slot</li>
                <li class="step-indicator" data-step="3"><span>3</span> Rider Info</li>
            </ul>
        </nav>

        <!-- Success & Error Banners -->
        <?php if ( isset($_GET['booking']) && $_GET['booking'] === 'success' ) : ?>
            <div class="form-feedback success" role="status">
                <p><strong>Request Sent!</strong> Your test ride booking has been received. Check your inbox for confirmation.</p>
            </div>
        <?php elseif ( isset($_GET['booking']) && $_GET['booking'] === 'error' ) : ?>
            <div class="form-feedback error" role="alert">
                <p><strong>Submission Failed:</strong> Please verify all required fields and try again.</p>
            </div>
        <?php endif; ?>

        <!-- Dialogue Form -->
        <form id="testRideForm" class="dialogue-form" method="POST" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" novalidate>
            
            <input type="hidden" name="action" value="submit_test_ride">
            <?php wp_nonce_field( 'test_ride_verify', 'test_ride_nonce' ); ?>

            <!-- Anti-Spam Honeypot -->
            <div style="position: absolute; left: -9999px; top: -9999px;" aria-hidden="true">
                <label for="test_ride_honeypot">Do not fill this field</label>
                <input type="text" name="test_ride_honeypot" id="test_ride_honeypot" tabindex="-1" autocomplete="off">
            </div>

            <!-- STEP 1: Bike & License -->
            <fieldset class="form-step active" data-step="1">
                <legend class="step-legend">Step 1: Choose Motorcycle & License</legend>

                <div class="form-group">
                    <label for="motorcycle_model">Select Motorcycle <span class="required">*</span></label>
                    <select id="motorcycle_model" name="motorcycle_model" required>
                        <option value="">-- Choose a bike --</option>
                        <option value="Yamaha MT-07">Yamaha MT-07 (689cc)</option>
                        <option value="Kawasaki Ninja 650">Kawasaki Ninja 650 (649cc)</option>
                        <option value="Honda CB500F">Honda CB500F (A2 Compliant)</option>
                        <option value="BMW R 1250 GS">BMW R 1250 GS (1254cc)</option>
                        <option value="Ducati Monster">Ducati Monster (937cc)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="license_type">Your Drivers License Category <span class="required">*</span></label>
                    <select id="license_type" name="license_type" required>
                        <option value="">-- Select category --</option>
                        <option value="A (Unrestricted)">Category A (Full / Unrestricted)</option>
                        <option value="A2 (Medium)">Category A2 (Up to 35 kW)</option>
                        <option value="A1 (Light)">Category A1 (125cc / 11 kW)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="experience_level">Riding Experience</label>
                    <select id="experience_level" name="experience_level">
                        <option value="Under 1 year">Less than 1 year (Beginner)</option>
                        <option value="1-3 years">1 - 3 years</option>
                        <option value="3-5 years">3 - 5 years</option>
                        <option value="5+ years">5+ years</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-primary next-step">Next: Pick Date &rarr;</button>
                </div>
            </fieldset>

            <!-- STEP 2: Date & Slot -->
            <fieldset class="form-step" data-step="2" hidden>
                <legend class="step-legend">Step 2: Pick Date & Time Slot</legend>

                <div class="form-group">
                    <label for="ride_date">Preferred Date <span class="required">*</span></label>
                    <input type="date" id="ride_date" name="ride_date" min="<?php echo esc_attr( wp_date('Y-m-d') ); ?>" required>
                </div>

                <div class="form-group">
                    <label for="ride_time">Preferred Time Slot <span class="required">*</span></label>
                    <select id="ride_time" name="ride_time" required>
                        <option value="">-- Choose a window --</option>
                        <option value="10:00 - 11:30">Morning: 10:00 - 11:30</option>
                        <option value="12:00 - 13:30">Midday: 12:00 - 13:30</option>
                        <option value="14:00 - 15:30">Afternoon: 14:00 - 15:30</option>
                        <option value="16:00 - 17:30">Late Afternoon: 16:00 - 17:30</option>
                    </select>
                </div>

                <div class="form-group checkbox-row">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="loaner_gear" name="loaner_gear" value="Yes">
                        <span>I need to borrow gear (Helmet, Jacket, Gloves) provided.</span>
                    </label>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary prev-step">&larr; Back</button>
                    <button type="button" class="btn btn-primary next-step">Next: Rider Info &rarr;</button>
                </div>
            </fieldset>

            <!-- STEP 3: Rider Info & Confirmation -->
            <fieldset class="form-step" data-step="3" hidden>
                <legend class="step-legend">Step 3: Rider Information</legend>

                <div class="form-group">
                    <label for="rider_name">Full Name <span class="required">*</span></label>
                    <input type="text" id="rider_name" name="rider_name" placeholder="John Doe" required autocomplete="name">
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label for="rider_email">Email Address <span class="required">*</span></label>
                        <input type="email" id="rider_email" name="rider_email" placeholder="john@example.com" required autocomplete="email">
                    </div>
                    <div class="form-group">
                        <label for="rider_phone">Phone Number <span class="required">*</span></label>
                        <input type="tel" id="rider_phone" name="rider_phone" placeholder="+45 12 34 56 78" required autocomplete="tel">
                    </div>
                </div>

                <div class="form-group">
                    <label for="rider_notes">Special Requests / Questions (Optional)</label>
                    <textarea id="rider_notes" name="rider_notes" rows="3" placeholder="Seat height questions, routes, etc..."></textarea>
                </div>

                <div class="form-group checkbox-row">
                    <label class="custom-checkbox">
                        <input type="checkbox" id="terms_agree" name="terms_agree" value="1" required>
                        <span>I confirm I hold a valid motorcycle driver's license. <span class="required">*</span></span>
                    </label>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary prev-step">&larr; Back</button>
                    <button type="submit" class="btn btn-primary submit-btn">Confirm Booking</button>
                </div>
            </fieldset>

        </form>
    </div>
</main>

<?php get_footer(); ?>