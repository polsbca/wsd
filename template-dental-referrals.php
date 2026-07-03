<?php
/**
 * Template Name: Dental Referrals Page Template
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$theme_uri = get_template_directory_uri();

$referral_treatments = array(
	'implants'           => 'Implants',
	'oral_surgery'       => 'Oral Surgery',
	'orthodontics'       => 'Orthodontics',
	'endodontics'        => 'Endodontics',
	'periodontics'       => 'Periodontics',
	'prosthodontics'     => 'Prosthodontics',
	'digital_panoramic'  => 'Digital Panoramic/DPT',
	'cone_beam_ct'       => 'Cone BeamCT',
);
?>

<main id="main" class="site-main dental-referrals-main">
	<section class="dental-referrals-layout" aria-labelledby="dental-referrals-heading">
		<div class="dental-referrals-layout-inner">
			<div class="dental-referrals-intro">
				<h1 id="dental-referrals-heading" class="dental-referrals-title">
					<span class="dental-referrals-title-main">Dental</span>
					<span class="dental-referrals-title-accent">Referrals</span>
				</h1>
				<div class="dental-referrals-intro-text">
					<p>We welcome referrals from other dental practices in our region and beyond. Perhaps you would like to discuss a problem with a case or maybe you would like us to offer advice or a full treatment option? We are here to help and will care for your patient with due diligence.</p>
					<p>We will keep you updated and informed as to treatment options and progression. At the end of treatment we will return your patient to you for your continued care and review</p>
					<p>If you would like to refer please complete the form below and we will be in touch.</p>
				</div>
			</div>

			<div class="dental-referrals-form-panel">
				<div class="dental-referrals-panel-track" aria-hidden="true">
					<span class="dental-referrals-panel-track-fill"></span>
				</div>

				<form class="dental-referrals-form" action="#" method="post" enctype="multipart/form-data">
					<section class="dental-referrals-form-section" aria-labelledby="referring-dentist-heading">
						<h2 id="referring-dentist-heading" class="dental-referrals-section-title">Referring Dentist Details</h2>
						<div class="dental-referrals-fields">
							<label class="dental-referrals-field">
								<span class="screen-reader-text"><?php esc_html_e( 'Dentist Name', 'wsd' ); ?></span>
								<input type="text" name="dentist_name" placeholder="Dentist Name" autocomplete="name" required>
							</label>
							<div class="dental-referrals-form-row">
								<label class="dental-referrals-field">
									<span class="screen-reader-text"><?php esc_html_e( 'Clinic Name', 'wsd' ); ?></span>
									<input type="text" name="clinic_name" placeholder="Clinic Name" required>
								</label>
								<label class="dental-referrals-field">
									<span class="screen-reader-text"><?php esc_html_e( 'Email Address', 'wsd' ); ?></span>
									<input type="email" name="dentist_email" placeholder="Email Address" autocomplete="email" required>
								</label>
							</div>
							<div class="dental-referrals-form-row">
								<label class="dental-referrals-field">
									<span class="screen-reader-text"><?php esc_html_e( 'GDC Number', 'wsd' ); ?></span>
									<input type="text" name="gdc_number" placeholder="GDC Number" required>
								</label>
								<label class="dental-referrals-field">
									<span class="screen-reader-text"><?php esc_html_e( 'Telephone Number', 'wsd' ); ?></span>
									<input type="tel" name="dentist_phone" placeholder="Telephone Number" autocomplete="tel" required>
								</label>
							</div>
						</div>
					</section>

					<div class="dental-referrals-section-divider" aria-hidden="true"></div>

					<section class="dental-referrals-form-section" aria-labelledby="referring-practice-heading">
						<h2 id="referring-practice-heading" class="dental-referrals-section-title">Referring Practice Details</h2>
						<div class="dental-referrals-fields">
							<label class="dental-referrals-field">
								<span class="screen-reader-text"><?php esc_html_e( 'Practice Name', 'wsd' ); ?></span>
								<input type="text" name="practice_name" placeholder="Practice Name" required>
							</label>
							<label class="dental-referrals-field">
								<span class="screen-reader-text"><?php esc_html_e( 'Telephone Number', 'wsd' ); ?></span>
								<input type="tel" name="practice_phone" placeholder="Telephone Number" autocomplete="tel" required>
							</label>
						</div>
					</section>

					<div class="dental-referrals-section-divider" aria-hidden="true"></div>

					<section class="dental-referrals-form-section" aria-labelledby="patient-details-heading">
						<h2 id="patient-details-heading" class="dental-referrals-section-title">Patient Details</h2>
						<div class="dental-referrals-fields">
							<label class="dental-referrals-field">
								<span class="screen-reader-text"><?php esc_html_e( 'Name', 'wsd' ); ?></span>
								<input type="text" name="patient_name" placeholder="Name" autocomplete="name" required>
							</label>
							<div class="dental-referrals-form-row">
								<label class="dental-referrals-field">
									<span class="screen-reader-text"><?php esc_html_e( 'Telephone Number', 'wsd' ); ?></span>
									<input type="tel" name="patient_phone" placeholder="Telephone Number" autocomplete="tel" required>
								</label>
								<label class="dental-referrals-field">
									<span class="screen-reader-text"><?php esc_html_e( 'Email Address', 'wsd' ); ?></span>
									<input type="email" name="patient_email" placeholder="Email Address" autocomplete="email">
								</label>
							</div>
							<label class="dental-referrals-field">
								<span class="screen-reader-text"><?php esc_html_e( 'Age', 'wsd' ); ?></span>
								<input type="text" name="patient_age" placeholder="Age" inputmode="numeric">
							</label>
						</div>
					</section>

					<div class="dental-referrals-section-divider" aria-hidden="true"></div>

					<section class="dental-referrals-form-section" aria-labelledby="treatments-required-heading">
						<h2 id="treatments-required-heading" class="dental-referrals-section-title">Treatments Required</h2>
						<div class="dental-referrals-treatments-grid" role="group" aria-labelledby="treatments-required-heading">
							<?php foreach ( $referral_treatments as $treatment_key => $treatment_label ) : ?>
								<label class="dental-referrals-checkbox">
									<input type="checkbox" name="treatments[]" value="<?php echo esc_attr( $treatment_key ); ?>">
									<span><?php echo esc_html( $treatment_label ); ?></span>
								</label>
							<?php endforeach; ?>
						</div>
						<div class="dental-referrals-other-field">
							<span class="dental-referrals-other-label">Other (please specify):</span>
							<label class="dental-referrals-field dental-referrals-field--inline">
								<span class="screen-reader-text"><?php esc_html_e( 'Other treatment', 'wsd' ); ?></span>
								<input type="text" name="treatment_other" placeholder="">
							</label>
						</div>
					</section>

					<div class="dental-referrals-section-divider" aria-hidden="true"></div>

					<section class="dental-referrals-form-section" aria-labelledby="patient-media-heading">
						<h2 id="patient-media-heading" class="dental-referrals-section-title">Patient Related Test/Media</h2>
						<div class="dental-referrals-media-uploads">
							<label class="dental-referrals-media-btn">
								<span class="screen-reader-text"><?php esc_html_e( 'Upload radiograph', 'wsd' ); ?></span>
								<input type="file" name="radiograph" accept="image/*,.pdf">
								<span class="dental-referrals-media-btn-text">Radiograph</span>
							</label>
							<label class="dental-referrals-media-btn">
								<span class="screen-reader-text"><?php esc_html_e( 'Upload clinical photos', 'wsd' ); ?></span>
								<input type="file" name="clinical_photos" accept="image/*" multiple>
								<span class="dental-referrals-media-btn-text">Clinical Photos</span>
							</label>
						</div>
					</section>

					<div class="dental-referrals-section-divider" aria-hidden="true"></div>

					<section class="dental-referrals-form-section" aria-labelledby="further-info-heading">
						<h2 id="further-info-heading" class="dental-referrals-section-title">Any further information</h2>
						<label class="dental-referrals-field">
							<span class="screen-reader-text"><?php esc_html_e( 'Any further information', 'wsd' ); ?></span>
							<input type="text" name="further_information" placeholder="Any further information">
						</label>
					</section>

					<div class="dental-referrals-section-divider" aria-hidden="true"></div>

					<section class="dental-referrals-form-section" aria-labelledby="medical-history-heading">
						<h2 id="medical-history-heading" class="dental-referrals-section-title">Relevant Medical and Dental History</h2>
						<label class="dental-referrals-field">
							<span class="screen-reader-text"><?php esc_html_e( 'Relevant Medical and Dental History', 'wsd' ); ?></span>
							<input type="text" name="medical_history" placeholder="Relevant Medical and Dental History">
						</label>
					</section>

					<div class="dental-referrals-form-footer">
						<label class="dental-referrals-consent">
							<input type="checkbox" name="referral_consent" required>
							<span>I consent to my data being used in accordance to the <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a></span>
						</label>
						<button type="submit" class="dental-referrals-submit-btn">SUBMIT</button>
					</div>
				</form>
			</div>
		</div>

		<div class="call-us-tab dental-referrals-contact-tab">
			<a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-call-us">
				<img src="<?php echo esc_url( $theme_uri . '/assets/images/phone-icon.svg' ); ?>" alt="" class="phone-icon">
				<span class="call-text">Contact us</span>
			</a>
		</div>
	</section>
</main>

<?php
get_footer();
