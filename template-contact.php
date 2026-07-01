<?php
/**
 * Template Name: Contact Page Template
 *
 * @package wsd
 */

get_header();

$theme_uri = get_template_directory_uri();
$phone     = '01706 632 661';
$email     = 'info@waterside-dentalcare.co.uk';
$address   = '330 Yorkshire Street, Rochdale Greater Manchester OL16 2DS';
$maps_url  = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( 'Waterside Dental Care, 330 Yorkshire Street, Rochdale, OL16 2DS' );
?>

<main id="main" class="site-main contact-page-main">
	<section class="contact-page-layout">
		<div class="contact-layout-inner">
			<div class="contact-hero-intro">
				<h1 class="contact-intro-head hero-title">Contact <span class="accent">Information</span></h1>
				<p class="contact-intro-text hero-description">We look forward to receiving your query whether you are a new or returning patient. Please complete the form opposite to receive further information. If your query is urgent, please call the practice to avoid delay in responding.</p>
			</div>

			<div class="contact-body-row">
				<aside class="contact-sidebar" aria-label="<?php esc_attr_e( 'Contact page sections', 'wsd' ); ?>">
				<div class="contact-parking-note">
					<p class="contact-parking-label">Note: Parking</p>
					<p class="contact-parking-text">If no parking is available in front, additional spaces are located at the rear via Denmark Street (access from Oswald Street).</p>
				</div>

				<nav class="contact-section-nav">
					<a href="#contact-form" class="contact-section-link is-active" data-contact-section="contact-form">Contact Us form</a>
					<a href="#quick-information" class="contact-section-link" data-contact-section="quick-information">Quick information</a>
					<a href="#availability-timings" class="contact-section-link" data-contact-section="availability-timings">Availability timings</a>
				</nav>
			</aside>

				<div class="contact-main-panel">
				<div class="contact-panel-track" aria-hidden="true">
					<span class="contact-panel-track-fill"></span>
				</div>

				<div id="contact-form" class="contact-panel-block contact-form-block">
					<h2 class="contact-panel-title">Contact Us form</h2>

					<form class="contact-form" action="#" method="post">
						<div class="contact-form-fields">
							<label class="contact-field">
								<span class="screen-reader-text"><?php esc_html_e( 'Your Name', 'wsd' ); ?></span>
								<input type="text" name="contact_name" placeholder="Your Name" autocomplete="name" required>
							</label>
							<label class="contact-field">
								<span class="screen-reader-text"><?php esc_html_e( 'Email Address', 'wsd' ); ?></span>
								<input type="email" name="contact_email" placeholder="Email Address" autocomplete="email" required>
							</label>
							<label class="contact-field">
								<span class="screen-reader-text"><?php esc_html_e( 'Subject', 'wsd' ); ?></span>
								<input type="text" name="contact_subject" placeholder="Subject" required>
							</label>
							<label class="contact-field contact-field-message">
								<span class="screen-reader-text"><?php esc_html_e( 'Message', 'wsd' ); ?></span>
								<textarea name="contact_message" placeholder="Message" rows="4" required></textarea>
							</label>
						</div>

						<label class="contact-consent">
							<input type="checkbox" name="contact_consent" required>
							<span>I consent to Waterside Dental storing the information on this form (required)</span>
						</label>

						<button type="submit" class="contact-submit-btn">SUBMIT</button>
					</form>
				</div>

				<div class="contact-panel-divider" aria-hidden="true"></div>

				<div class="contact-panel-block contact-info-block">
					<h2 class="contact-panel-title" id="quick-information">Contact Information</h2>

					<div class="contact-info-list">
						<div class="contact-info-item">
							<span class="contact-info-icon" aria-hidden="true">
								<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M5 6.25H25V23.75H5V6.25Z" stroke="#D8A444" stroke-width="1.5" stroke-linejoin="round"/>
									<path d="M5 8.75L15 15.625L25 8.75" stroke="#D8A444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</span>
							<div class="contact-info-copy">
								<p class="contact-info-label">Email address</p>
								<p class="contact-info-value">
									<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
								</p>
							</div>
						</div>

						<div class="contact-info-item">
							<span class="contact-info-icon" aria-hidden="true">
								<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M8.75 5H12.5L14.375 10.625L11.5625 12.1875C12.6719 14.5156 14.4844 16.3281 16.8125 17.4375L18.375 14.625L24 16.5V20.25C24 20.913 23.7366 21.5489 23.2678 22.0178C22.7989 22.4866 22.163 22.75 21.5 22.75C17.4493 22.5225 13.5627 20.8909 10.6094 17.9375C7.65603 14.9841 6.02446 11.0975 5.79688 7.04688C5.79688 6.38386 6.06027 5.74799 6.52911 5.27915C6.99795 4.81031 7.63382 4.54688 8.29688 4.54688H8.75Z" stroke="#D8A444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</span>
							<div class="contact-info-copy">
								<p class="contact-info-label">Phone number</p>
								<p class="contact-info-value">
									<a href="tel:01706632661"><?php echo esc_html( $phone ); ?></a>
								</p>
							</div>
						</div>

						<div class="contact-info-item contact-info-hours" id="availability-timings">
							<span class="contact-info-icon" aria-hidden="true">
								<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
									<circle cx="15" cy="15" r="10" stroke="#D8A444" stroke-width="1.5"/>
									<path d="M15 9.375V15L18.75 17.8125" stroke="#D8A444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</span>
							<div class="contact-info-copy">
								<p class="contact-info-label">Opening Hours</p>
								<div class="contact-hours-list">
									<p>Mon: 8.45am – 1pm</p>
									<p>Tue: 8.45am – 6pm</p>
									<p>Wed: 8.45am – 6pm</p>
									<p>Thu: 8.45am – 7pm</p>
									<p>Fri: 8.45am – 1pm</p>
									<div class="contact-hours-sat-row">
										<p class="contact-sat-hours">Sat: Some Saturdays by Appointment</p>
										<div class="contact-social-row">
											<span class="contact-social-label">Follow Us On:</span>
											<div class="contact-social-icons">
												<a href="#" class="contact-social-link contact-social-link--instagram" aria-label="<?php esc_attr_e( 'Instagram', 'wsd' ); ?>">
													<img src="<?php echo esc_url( $theme_uri . '/assets/images/instagram-icon-gold.svg' ); ?>" alt="" width="37" height="37">
												</a>
												<a href="#" class="contact-social-link contact-social-link--facebook" aria-label="<?php esc_attr_e( 'Facebook', 'wsd' ); ?>">
													<img src="<?php echo esc_url( $theme_uri . '/assets/images/facebook-icon-gold.svg' ); ?>" alt="" width="35" height="35">
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="contact-map-card">
					<img src="<?php echo esc_url( $theme_uri . '/assets/images/contact-clinic.jpg' ); ?>" alt="" class="contact-map-image">
					<div class="contact-map-overlay" aria-hidden="true"></div>
					<div class="contact-map-content">
						<p class="contact-map-label">Clinic Address</p>
						<p class="contact-map-brand">Waterside Dental</p>
						<p class="contact-map-address"><?php echo esc_html( $address ); ?></p>
						<a href="<?php echo esc_url( $maps_url ); ?>" class="contact-direction-btn" target="_blank" rel="noopener noreferrer">GET DIRECTION</a>
					</div>
				</div>
				</div>
			</div>
		</div>

		<div class="call-us-tab">
			<a href="tel:01706632661" class="btn-call-us">
				<img src="<?php echo esc_url( $theme_uri . '/assets/images/phone-icon.svg' ); ?>" alt="" class="phone-icon">
				<span class="call-text">Call Us</span>
			</a>
		</div>
	</section>
</main>

<?php get_footer(); ?>
