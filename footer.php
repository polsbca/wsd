<?php
/**
 * The footer for our theme
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
		</div><!-- #content -->

		<footer id="colophon" class="site-footer">
			<div class="container-fluid px-lg-5">
				<!-- Top Row -->
				<div class="row footer-top-row">
					<!-- Col 1: Logo & Socials -->
					<div class="col-xl-3 col-lg-4 col-12 mb-5 mb-lg-0">
						<div class="footer-brand">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link d-inline-block">
								<div class="logo-wrapper">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/footer-logo-mark.svg' ); ?>" alt="Waterside Dentalcare Logo Mark" class="logo-mark">
									<div class="logo-text-group">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/footer-logo-text-top.svg' ); ?>" alt="WATERSIDE" class="logo-text-top">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/footer-logo-text-bottom.svg' ); ?>" alt="DENTALCARE" class="logo-text-bottom">
									</div>
								</div>
							</a>
						</div>
						
						<div class="footer-socials d-flex flex-column gap-3">
							<div class="social-icons-wrapper d-flex align-items-center gap-3">
								<a href="#" class="social-icon">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/instagram-icon.svg' ); ?>" alt="Instagram">
								</a>
								<a href="#" class="social-icon">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/facebook-icon.svg' ); ?>" alt="Facebook">
								</a>
							</div>
							<span class="follow-text">Follow Us On:</span>
						</div>
					</div>

					<!-- Col 2: Navigation Links, Opening Hours, Contact Info -->
					<div class="col-xl-9 col-lg-8 col-12">
						<div class="row g-4 footer-links-grid">
							<!-- Column 1: Cosmetic & Finance -->
							<div class="col-md-3 col-sm-6 col-12">
								<div class="footer-nav-col mb-5">
									<h4 class="footer-nav-title">Cosmetic Dentistry</h4>
									<ul class="footer-nav-list list-unstyled">
										<li><a href="#whitening">Whitening</a></li>
										<li><a href="#straightening">Straightening</a></li>
										<li><a href="#smile-makeover">Smile Make Over</a></li>
										<li><a href="#veneers">Veneers</a></li>
									</ul>
								</div>
								<div class="footer-nav-col">
									<h4 class="footer-nav-title">Finance</h4>
									<ul class="footer-nav-list list-unstyled">
										<li><a href="#fees">Fees</a></li>
										<li><a href="#calculator">Finance Calculator</a></li>
										<li><a href="#plans">Dental Plans</a></li>
									</ul>
								</div>
							</div>
							
							<!-- Column 2: General & Legal -->
							<div class="col-md-3 col-sm-6 col-12">
								<div class="footer-nav-col mb-5">
									<h4 class="footer-nav-title">General Dentistry</h4>
									<ul class="footer-nav-list list-unstyled">
										<li><a href="#dental-implants">Dental Implants</a></li>
										<li><a href="#checkups">Monthly Checkups</a></li>
										<li><a href="#emergency">Emergency</a></li>
									</ul>
								</div>
								<div class="footer-nav-col">
									<h4 class="footer-nav-title">Legal Links</h4>
									<ul class="footer-nav-list list-unstyled">
										<li><a href="#privacy">Privacy Policy</a></li>
										<li><a href="#gdc">GDC Regulations</a></li>
										<li><a href="#complaints">Complaints Procedure</a></li>
										<li><a href="#terms">Terms of Use</a></li>
									</ul>
								</div>
							</div>

							<!-- Column 3: Opening Hours -->
							<div class="col-md-3 col-sm-6 col-12 footer-nav-col">
								<h4 class="footer-nav-title">Opening Hours</h4>
								<div class="opening-hours-list">
									<p>Mon: 8.45am – 1pm</p>
									<p>Tue: 8.45am – 6pm</p>
									<p>Wed: 8.45am – 6pm</p>
									<p>Thu: 8.45am – 7pm</p>
									<p>Fri: 8.45am – 1pm</p>
									<p>Sat: Saturdays by Appointment</p>
								</div>
							</div>

							<!-- Column 4: Contact Us -->
							<div class="col-md-3 col-sm-6 col-12 footer-nav-col">
								<h4 class="footer-nav-title">Contact Us</h4>
								<div class="footer-contact-details">
									<p>Call Us: <a href="tel:01706632661" class="contact-link text-underline">01706 632 661</a></p>
									<p>Email: <a href="mailto:info@waterside-dentalcare.co.uk" class="contact-link text-underline">info@waterside-dentalcare.co.uk</a></p>
									<p class="address-text">Waterside Dental Care, 330 Yorkshire Street, Rochdale, Greater Manchester, OL16 2DS</p>
									<a href="#" class="btn-directions text-gold text-underline">Get Directions</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Middle Row: Subscribe & Language -->
				<div class="row align-items-end justify-content-between footer-middle-row">
					<!-- Subscribe -->
					<div class="col-lg-7 col-12 mb-4 mb-lg-0 subscribe-col">
						<div class="footer-subscribe d-flex flex-wrap align-items-end gap-4">
							<div class="subscribe-input-wrapper">
								<label for="subscribe-email" class="subscribe-label">Get to know our updates:</label>
								<input type="email" id="subscribe-email" class="subscribe-input" />
								<!-- <div class="subscribe-line-wrapper">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/subscribe-line.svg' ); ?>" alt="" class="subscribe-line-img">
								</div> -->
							</div>
							<div class="subscribe-btn-wrapper">
								<button class="btn btn-subscribe">Subscribe</button>
							</div>
						</div>
					</div>

					<!-- Language Selector -->
					<div class="col-lg-3 col-md-4 col-12 language-col">
						<div class="footer-language text-lg-end">
							<p class="lang-label">Language</p>
							<div class="lang-dropdown">
								<span class="lang-text">English (UK)</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/lang-arrow.svg' ); ?>" alt="" class="lang-arrow">
							</div>
						</div>
					</div>
				</div>

				<!-- Bottom Row: Copyright -->
				<div class="row footer-bottom-row text-white-50">
					<div class="col-md-6 col-12 mb-2 mb-md-0 text-center text-md-start last-updated-text">
						<span>Last updated: June 10, 2025 - 12:55 pm</span>
					</div>
					<div class="col-md-6 col-12 text-center text-md-end copyright-text">
						<span>Copyright 2026 watersidedentalcare | Crafted by Funky Vibes Marketing</span>
					</div>
				</div>
			</div>
		</footer>
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>
