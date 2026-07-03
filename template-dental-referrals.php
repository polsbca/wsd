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

				<h1 id="dental-referrals-heading" class="dental-referrals-title hero-title">

					<span class="dental-referrals-title-main">Dental</span>

					<span class="dental-referrals-title-accent">Referrals</span>

				</h1>

				<div class="dental-referrals-intro-text hero-description">

					<p>We welcome referrals from other dental practices in our region and beyond. Perhaps you would like to discuss a problem with a case or maybe you would like us to offer advice or a full treatment option? We are here to help and will care for your patient with due diligence.</p>

					<p>We will keep you updated and informed as to treatment options and progression. At the end of treatment we will return your patient to you for your continued care and review</p>

					<p>If you would like to refer please complete the form below and we will be in touch.</p>

				</div>

			</div>



			<div class="dental-referrals-form-panel">

				<div class="dental-referrals-mobile-progress" aria-hidden="true">

					<span class="dental-referrals-mobile-progress-fill"></span>

				</div>



				<div class="dental-referrals-panel-track" aria-hidden="true">

					<span class="dental-referrals-panel-track-fill"></span>

				</div>



				<form class="dental-referrals-form" action="#" method="post" enctype="multipart/form-data">

					<section class="dental-referrals-form-section dental-referrals-accordion is-expanded" aria-labelledby="referring-dentist-heading">

						<div class="dental-referrals-section-header">

							<h2 id="referring-dentist-heading" class="dental-referrals-section-title">Referring Dentist Details</h2>

							<button type="button" class="dental-referrals-accordion-toggle" aria-expanded="true" aria-controls="referring-dentist-panel">

								<?php wsd_dental_referrals_accordion_icon(); ?>

								<span class="screen-reader-text"><?php esc_html_e( 'Toggle Referring Dentist Details section', 'wsd' ); ?></span>

							</button>

						</div>

						<div id="referring-dentist-panel" class="dental-referrals-section-body">

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

						</div>

					</section>



					<div class="dental-referrals-section-divider" aria-hidden="true"></div>



					<section class="dental-referrals-form-section dental-referrals-accordion" aria-labelledby="referring-practice-heading">

						<div class="dental-referrals-section-header">

							<h2 id="referring-practice-heading" class="dental-referrals-section-title">Referring Practice Details</h2>

							<button type="button" class="dental-referrals-accordion-toggle" aria-expanded="false" aria-controls="referring-practice-panel">

								<?php wsd_dental_referrals_accordion_icon(); ?>

								<span class="screen-reader-text"><?php esc_html_e( 'Toggle Referring Practice Details section', 'wsd' ); ?></span>

							</button>

						</div>

						<div id="referring-practice-panel" class="dental-referrals-section-body">

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

						</div>

					</section>



					<div class="dental-referrals-section-divider" aria-hidden="true"></div>



					<section class="dental-referrals-form-section dental-referrals-accordion" aria-labelledby="patient-details-heading">

						<div class="dental-referrals-section-header">

							<h2 id="patient-details-heading" class="dental-referrals-section-title">Patient Details</h2>

							<button type="button" class="dental-referrals-accordion-toggle" aria-expanded="false" aria-controls="patient-details-panel">

								<?php wsd_dental_referrals_accordion_icon(); ?>

								<span class="screen-reader-text"><?php esc_html_e( 'Toggle Patient Details section', 'wsd' ); ?></span>

							</button>

						</div>

						<div id="patient-details-panel" class="dental-referrals-section-body">

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

						</div>

					</section>



					<div class="dental-referrals-section-divider" aria-hidden="true"></div>



					<section class="dental-referrals-form-section dental-referrals-accordion" aria-labelledby="treatments-required-heading">

						<div class="dental-referrals-section-header">

							<h2 id="treatments-required-heading" class="dental-referrals-section-title">Treatments Required</h2>

							<button type="button" class="dental-referrals-accordion-toggle" aria-expanded="false" aria-controls="treatments-required-panel">

								<?php wsd_dental_referrals_accordion_icon(); ?>

								<span class="screen-reader-text"><?php esc_html_e( 'Toggle Treatments Required section', 'wsd' ); ?></span>

							</button>

						</div>

						<div id="treatments-required-panel" class="dental-referrals-section-body">

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

						</div>

					</section>



					<div class="dental-referrals-section-divider" aria-hidden="true"></div>



					<section class="dental-referrals-form-section dental-referrals-accordion" aria-labelledby="patient-media-heading">

						<div class="dental-referrals-section-header">

							<h2 id="patient-media-heading" class="dental-referrals-section-title">Patient Related Test/Media</h2>

							<button type="button" class="dental-referrals-accordion-toggle" aria-expanded="false" aria-controls="patient-media-panel">

								<?php wsd_dental_referrals_accordion_icon(); ?>

								<span class="screen-reader-text"><?php esc_html_e( 'Toggle Patient Related Test/Media section', 'wsd' ); ?></span>

							</button>

						</div>

						<div id="patient-media-panel" class="dental-referrals-section-body">

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

						</div>

					</section>



					<div class="dental-referrals-section-divider" aria-hidden="true"></div>



					<section class="dental-referrals-form-section dental-referrals-accordion" aria-labelledby="further-info-heading">

						<div class="dental-referrals-section-header">

							<h2 id="further-info-heading" class="dental-referrals-section-title">Any further information</h2>

							<button type="button" class="dental-referrals-accordion-toggle" aria-expanded="false" aria-controls="further-info-panel">

								<?php wsd_dental_referrals_accordion_icon(); ?>

								<span class="screen-reader-text"><?php esc_html_e( 'Toggle Any further information section', 'wsd' ); ?></span>

							</button>

						</div>

						<div id="further-info-panel" class="dental-referrals-section-body">

							<label class="dental-referrals-field">

								<span class="screen-reader-text"><?php esc_html_e( 'Any further information', 'wsd' ); ?></span>

								<input type="text" name="further_information" placeholder="Any further information">

							</label>

						</div>

					</section>



					<div class="dental-referrals-section-divider" aria-hidden="true"></div>



					<section class="dental-referrals-form-section dental-referrals-accordion" aria-labelledby="medical-history-heading">

						<div class="dental-referrals-section-header">

							<h2 id="medical-history-heading" class="dental-referrals-section-title">

								<span class="dental-referrals-section-title-full">Relevant Medical and Dental History</span>

								<span class="dental-referrals-section-title-short">Medical and Dental History</span>

							</h2>

							<button type="button" class="dental-referrals-accordion-toggle" aria-expanded="false" aria-controls="medical-history-panel">

								<?php wsd_dental_referrals_accordion_icon(); ?>

								<span class="screen-reader-text"><?php esc_html_e( 'Toggle Medical and Dental History section', 'wsd' ); ?></span>

							</button>

						</div>

						<div id="medical-history-panel" class="dental-referrals-section-body">

							<label class="dental-referrals-field">

								<span class="screen-reader-text"><?php esc_html_e( 'Relevant Medical and Dental History', 'wsd' ); ?></span>

								<input type="text" name="medical_history" placeholder="Relevant Medical and Dental History">

							</label>

						</div>

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

	</section>

</main>



<?php

get_footer();


