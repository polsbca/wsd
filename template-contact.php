<?php
/**
 * Template Name: Contact Page Template
 *
 * @package wsd
 */

get_header();

$theme_uri = get_template_directory_uri();
$address   = '330 Yorkshire Street, Rochdale Greater Manchester OL16 2DS';
$maps_url  = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( 'Waterside Dental Care, 330 Yorkshire Street, Rochdale, OL16 2DS' );

$parking_note = wsd_get_contact_page_field(
	'parking_note',
	'If no parking is available in front, additional spaces are located at the rear via Denmark Street (access from Oswald Street).'
);

$email = wsd_get_contact_page_field(
	'contact_email_address',
	'info@waterside-dentalcare.co.uk'
);

$phone_raw = wsd_get_contact_page_field(
	'contact_phone_number',
	'01706 632 661'
);

$phone     = wsd_format_phone_number( $phone_raw );
$phone_tel = wsd_get_phone_tel_uri( $phone_raw );

$opening_hours_default = "Mon: 8.45am – 1pm\nTue: 8.45am – 6pm\nWed: 8.45am – 6pm\nThu: 8.45am – 7pm\nFri: 8.45am – 1pm\nSat: Some Saturdays by Appointment";
$all_hours_lines       = wsd_parse_opening_hours_lines(
	wsd_get_contact_page_field( 'opening_hours', $opening_hours_default )
);

$instagram_url = wsd_get_contact_page_field( 'instagram', '' );
$facebook_url  = wsd_get_contact_page_field( 'facebook', '' );
?>

<main id="main" class="site-main contact-page-main">
	<section class="contact-page-layout">
		<div class="contact-layout-inner">
			<div class="contact-hero-intro">
				<h1 class="contact-intro-head hero-title">Contact <span class="accent">Information</span></h1>
				<p class="contact-intro-text hero-description">We look forward to receiving your query whether you are a new or returning patient. Please complete the form opposite to receive further information. If your query is urgent, please call the practice to avoid delay in responding.</p>
			</div>

			<div class="contact-parking-note contact-parking-note--mobile">
				<p class="contact-parking-label">Note: Parking</p>
				<p class="contact-parking-text"><?php echo esc_html( $parking_note ); ?></p>
			</div>

			<nav class="contact-tablet-tabs" aria-label="<?php esc_attr_e( 'Contact page sections', 'wsd' ); ?>">
				<a href="#contact-form" class="contact-section-link is-active" data-contact-section="contact-form"><?php esc_html_e( 'Contact Us form', 'wsd' ); ?></a>
				<a href="#quick-information" class="contact-section-link" data-contact-section="quick-information"><?php esc_html_e( 'Quick information', 'wsd' ); ?></a>
				<a href="#availability-timings" class="contact-section-link" data-contact-section="availability-timings"><?php esc_html_e( 'Availability timings', 'wsd' ); ?></a>
			</nav>

			<div class="contact-mobile-controls">
				<nav class="contact-mobile-tabs" aria-label="<?php esc_attr_e( 'Contact page sections', 'wsd' ); ?>">
					<button type="button" class="contact-mobile-tab is-active" data-contact-slide="0">Contact Us form</button>
					<span class="contact-mobile-tab-divider" aria-hidden="true"></span>
					<button type="button" class="contact-mobile-tab" data-contact-slide="1">Information</button>
					<span class="contact-mobile-tab-divider" aria-hidden="true"></span>
					<button type="button" class="contact-mobile-tab" data-contact-slide="2">timings</button>
					<span class="contact-mobile-tab-divider" aria-hidden="true"></span>
				</nav>
				<div class="contact-mobile-dots" aria-hidden="true">
					<button type="button" class="contact-mobile-dot is-active" data-contact-slide="0" aria-label="<?php esc_attr_e( 'Contact form slide', 'wsd' ); ?>"></button>
					<button type="button" class="contact-mobile-dot" data-contact-slide="1" aria-label="<?php esc_attr_e( 'Information slide', 'wsd' ); ?>"></button>
					<button type="button" class="contact-mobile-dot" data-contact-slide="2" aria-label="<?php esc_attr_e( 'Timings slide', 'wsd' ); ?>"></button>
				</div>
			</div>

			<div class="contact-body-row">
				<aside class="contact-sidebar" aria-label="<?php esc_attr_e( 'Contact page sections', 'wsd' ); ?>">
					<div class="contact-parking-note contact-parking-note--desktop">
						<p class="contact-parking-label">Note: Parking</p>
						<p class="contact-parking-text"><?php echo esc_html( $parking_note ); ?></p>
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

					<div class="contact-panel-inner">
					<div class="contact-mobile-carousel">
						<div class="contact-mobile-carousel-track">
							<div class="contact-mobile-slide" data-contact-slide="0">
								<div id="contact-form" class="contact-panel-block contact-form-block">
									<h2 class="contact-panel-title">Contact Us form</h2>

									<form class="contact-form" action="#" method="post">
										<div class="contact-form-fields">
											<label class="contact-field">
												<span class="screen-reader-text"><?php esc_html_e( 'Your Name', 'wsd' ); ?></span>
												<input type="text" name="contact_name" placeholder="Your Name" autocomplete="name" required>
											</label>
											<div class="contact-form-row">
												<label class="contact-field">
													<span class="screen-reader-text"><?php esc_html_e( 'Email Address', 'wsd' ); ?></span>
													<input type="email" name="contact_email" placeholder="Email Address" autocomplete="email" required>
												</label>
												<label class="contact-field">
													<span class="screen-reader-text"><?php esc_html_e( 'Subject', 'wsd' ); ?></span>
													<input type="text" name="contact_subject" placeholder="Subject" required>
												</label>
											</div>
											<label class="contact-field contact-field-message">
												<span class="screen-reader-text"><?php esc_html_e( 'Message', 'wsd' ); ?></span>
												<textarea name="contact_message" placeholder="Message" rows="4" required></textarea>
											</label>
										</div>

										<div class="contact-consent-group contact-consent-group--desktop">
											<label class="contact-consent">
												<input type="checkbox" name="contact_consent" required>
												<span>I consent to Waterside Dental storing the information on this form (required)</span>
											</label>
										</div>

										<div class="contact-consent-group contact-consent-group--mobile">
											<label class="contact-consent">
												<input type="checkbox" name="contact_consent_privacy_1" required>
												<span>I consent to my data being used in accordance to the Privacy Policy</span>
											</label>
											<label class="contact-consent">
												<input type="checkbox" name="contact_consent_privacy_2" required>
												<span>I consent to my data being used in accordance to the Privacy Policy</span>
											</label>
										</div>

										<div class="contact-consent-group contact-consent-group--tablet">
											<label class="contact-consent">
												<input type="checkbox" name="contact_consent_tablet" required>
												<span>I consent to my data being used in accordance to the Privacy Policy</span>
											</label>
										</div>

										<button type="submit" class="contact-submit-btn">SUBMIT</button>
									</form>
								</div>
							</div>

							<div class="contact-panel-divider contact-panel-divider--form-info" aria-hidden="true"></div>

							<div class="contact-mobile-slide" data-contact-slide="1">
								<div class="contact-panel-block contact-info-block contact-info-block--information" id="quick-information">
									<h2 class="contact-panel-title">Contact Information</h2>

									<div class="contact-info-list">
										<?php if ( $email ) : ?>
											<div class="contact-info-item">
												<span class="contact-info-icon" aria-hidden="true">
													<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
  <path d="M3.75 3.75H26.25C26.9404 3.75 27.5 4.30965 27.5 5V25C27.5 25.6904 26.9404 26.25 26.25 26.25H3.75C3.05965 26.25 2.5 25.6904 2.5 25V5C2.5 4.30965 3.05965 3.75 3.75 3.75ZM25 9.0474L15.0898 17.9225L5 9.01993V23.75H25V9.0474ZM5.63932 6.25L15.0774 14.5775L24.3762 6.25H5.63932Z" fill="#D8A444"/>
</svg>
												</span>
												<div class="contact-info-copy">
													<p class="contact-info-label">Email address</p>
													<p class="contact-info-value">
														<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
													</p>
												</div>
											</div>
										<?php endif; ?>

										<?php if ( $phone ) : ?>
											<div class="contact-info-item">
												<span class="contact-info-icon" aria-hidden="true">
													<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
													<path d="M11.7069 13.3526C12.8775 15.411 14.589 17.1225 16.6474 18.293L17.753 16.7451C18.1206 16.2306 18.8145 16.0716 19.3695 16.3748C21.128 17.3354 23.0714 17.9191 25.0986 18.0796C25.7487 18.1311 26.25 18.6736 26.25 19.3258V24.9043C26.25 25.5451 25.7652 26.0821 25.1278 26.1476C24.4654 26.2157 23.7971 26.25 23.125 26.25C12.4245 26.25 3.75 17.5755 3.75 6.875C3.75 6.20284 3.78428 5.53464 3.85236 4.8722C3.91788 4.23469 4.45493 3.75 5.09581 3.75H10.6743C11.3264 3.75 11.8689 4.2513 11.9204 4.90136C12.0808 6.9286 12.6646 8.87205 13.6252 10.6306C13.9284 11.1855 13.7694 11.8794 13.2549 12.247L11.7069 13.3526ZM8.55531 12.5315L10.9302 10.8351C10.2568 9.38142 9.79535 7.83979 9.55909 6.25H6.26134C6.25379 6.4579 6.25 6.66625 6.25 6.875C6.25 16.1947 13.8053 23.75 23.125 23.75C23.3337 23.75 23.5421 23.7463 23.75 23.7386V20.4409C22.1602 20.2046 20.6186 19.7431 19.1649 19.0697L17.4685 21.4447C16.7823 21.1781 16.1195 20.8644 15.4842 20.5076L15.4116 20.4662C12.9621 19.0734 10.9267 17.0379 9.53375 14.5884L9.49242 14.5158C9.13561 13.8805 8.82193 13.2177 8.55531 12.5315Z" fill="#D8A444"/>
												</svg>
												</span>
												<div class="contact-info-copy">
													<p class="contact-info-label">Phone number</p>
													<p class="contact-info-value">
														<?php if ( $phone_tel ) : ?>
															<a href="<?php echo esc_url( $phone_tel ); ?>"><?php echo esc_html( $phone ); ?></a>
														<?php else : ?>
															<?php echo esc_html( $phone ); ?>
														<?php endif; ?>
													</p>
												</div>
											</div>
										<?php endif; ?>

										<?php if ( ! empty( $all_hours_lines ) ) : ?>
											<div class="contact-info-item contact-info-hours">
												<span class="contact-info-icon" aria-hidden="true">
													<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
														<path d="M15 27.5C8.09644 27.5 2.5 21.9035 2.5 15C2.5 8.09644 8.09644 2.5 15 2.5C21.9035 2.5 27.5 8.09644 27.5 15C27.5 21.9035 21.9035 27.5 15 27.5ZM15 25C20.5229 25 25 20.5229 25 15C25 9.47715 20.5229 5 15 5C9.47715 5 5 9.47715 5 15C5 20.5229 9.47715 25 15 25ZM16.25 15H21.25V17.5H13.75V8.75H16.25V15Z" fill="#D8A444"/>
													</svg>
												</span>
												<div class="contact-info-copy">
													<p class="contact-info-label">Opening Hours</p>
													<div class="contact-hours-list">
														<?php foreach ( $all_hours_lines as $hours_line ) : ?>
															<p><?php echo esc_html( $hours_line ); ?></p>
														<?php endforeach; ?>
													</div>
												</div>
											</div>
										<?php endif; ?>
									</div>

									<?php if ( $instagram_url || $facebook_url ) : ?>
										<div class="contact-social-row contact-social-row--information">
											<span class="contact-social-label">Follow Us On:</span>
											<div class="contact-social-icons">
												<?php if ( $instagram_url ) : ?>
													<a href="<?php echo esc_url( $instagram_url ); ?>" class="contact-social-link contact-social-link--instagram" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'wsd' ); ?>">
														<img src="<?php echo esc_url( $theme_uri . '/assets/images/instagram-icon-gold.svg' ); ?>" alt="" width="30" height="30">
													</a>
												<?php endif; ?>

												<?php if ( $facebook_url ) : ?>
													<a href="<?php echo esc_url( $facebook_url ); ?>" class="contact-social-link contact-social-link--facebook" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'wsd' ); ?>">
														<img src="<?php echo esc_url( $theme_uri . '/assets/images/facebook-icon-gold.svg' ); ?>" alt="" width="26" height="26">
													</a>
												<?php endif; ?>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>

							<div class="contact-mobile-slide" data-contact-slide="2">
								<div class="contact-map-card contact-map-card--timings">
									<img src="<?php echo esc_url( $theme_uri . '/assets/images/contact-clinic.jpg' ); ?>" alt="" class="contact-map-image">
									<div class="contact-map-overlay" aria-hidden="true"></div>
									<div class="contact-map-content">
										<p class="contact-map-brand">Waterside Dental</p>
										<div class="contact-map-center">
											<p class="contact-map-label">Clinic Address</p>
											<p class="contact-map-address"><?php echo esc_html( $address ); ?></p>
										</div>
										<a href="<?php echo esc_url( $maps_url ); ?>" class="contact-direction-btn" target="_blank" rel="noopener noreferrer">GET DIRECTION</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="contact-panel-divider contact-panel-divider--info-map" aria-hidden="true"></div>

					<div class="contact-map-card contact-map-card--desktop" id="availability-timings">
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
		</div>
	</section>
</main>

<?php get_footer(); ?>
