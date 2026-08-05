<?php
/**
 * Template Name: Teams Page Template
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) {
	the_post();
}

$theme_uri        = get_template_directory_uri();
$teams_page_id    = get_the_ID();
$teams_hero_image = wsd_get_teams_hero_image_url( $teams_page_id );
$teams_hero_alt   = __( 'Waterside Dental Care team', 'wsd' );

if ( $teams_page_id && has_post_thumbnail( $teams_page_id ) ) {
	$thumbnail_alt = get_post_meta( (int) get_post_thumbnail_id( $teams_page_id ), '_wp_attachment_image_alt', true );
	if ( $thumbnail_alt ) {
		$teams_hero_alt = $thumbnail_alt;
	}
}
$referrals_url = function_exists( 'wsd_get_referrals_page_url' ) ? wsd_get_referrals_page_url() : home_url( '/#referrals' );
$gallery_url   = function_exists( 'wsd_get_smile_gallery_page_url' ) ? wsd_get_smile_gallery_page_url() : home_url( '/smile-gallery/' );
$smile_gallery_slides = function_exists( 'wsd_get_smile_gallery_slides' )
	? wsd_get_smile_gallery_slides( array( $teams_page_id, (int) get_option( 'page_on_front' ) ) )
	: array();

if ( empty( $smile_gallery_slides ) ) {
	$smile_gallery_placeholder = $theme_uri . '/assets/images/team-andrew.png';
	$smile_gallery_slides      = array_fill(
		0,
		3,
		array(
			'before_image' => $smile_gallery_placeholder,
			'after_image'  => $smile_gallery_placeholder,
			'treatment'    => '',
		)
	);
}

$clinical_specialists = wsd_get_clinical_specialists();
$support_members      = wsd_get_support_team_members();
$support_categories   = wsd_get_support_team_categories();

if ( empty( $support_categories ) && ! empty( $support_members ) ) {
	foreach ( $support_members as $support_member ) {
		if ( empty( $support_member['category'] ) ) {
			continue;
		}

		$support_categories[ $support_member['category'] ] = ucwords( str_replace( array( '-', '_' ), ' ', $support_member['category'] ) );
	}
}

$default_support_category = ! empty( $support_categories ) ? (string) array_key_first( $support_categories ) : '';
$default_support_slide_count = 0;
foreach ( $support_members as $support_member ) {
	if ( $support_member['category'] === $default_support_category ) {
		$default_support_slide_count++;
	}
}
$teams_hero_description   = wsd_get_teams_hero_description( $teams_page_id );
$teams_doctor_payload     = wsd_get_teams_doctor_modal_payload( $clinical_specialists );
?>

<main id="main" class="site-main teams-page-main">

	<section class="teams-hero-page" aria-labelledby="teams-hero-heading">
		<div class="teams-hero-inner">
			<div class="teams-hero-content-col">
				<div class="teams-hero-copy">
					<h1 id="teams-hero-heading" class="teams-hero-title hero-title">
						<span class="teams-hero-title-main">Meet The </span>
						<span class="teams-hero-title-accent">Team</span>
					</h1>
					<p class="teams-hero-description hero-description"><?php echo esc_html( $teams_hero_description ); ?></p>
				</div>
				<div class="hero-buttons">
					<a href="<?php echo esc_url( wsd_get_contact_page_url() ); ?>" class="btn btn-primary hero-book-appointment-btn"><span><?php esc_html_e( 'Book an appointment', 'wsd' ); ?></span></a>
					<a href="<?php echo esc_url( wsd_get_fees_page_url() ); ?>" class="btn btn-secondary"><?php esc_html_e( 'Fees & Membership', 'wsd' ); ?></a>
				</div>
			</div>
			<div class="teams-hero-image-col">
				<div class="teams-hero-image-frame hero-image-wrapper">
					<img
						src="<?php echo esc_url( $teams_hero_image ); ?>"
						alt="<?php echo esc_attr( $teams_hero_alt ); ?>"
						class="teams-hero-img"
						width="1027"
						height="889"
						loading="eager"
						decoding="async"
					>
				</div>
			</div>
		</div>
	</section>

	<section class="teams-clinical-section" aria-labelledby="teams-clinical-heading">
		<div class="teams-clinical-heading-wrap">
			<h2 id="teams-clinical-heading" class="teams-clinical-heading">
				<span class="teams-clinical-heading-main">Our Clinical </span>
				<span class="teams-clinical-heading-accent">specialist</span>
			</h2>
		</div>

		<div class="teams-slider teams-clinical-slider" data-teams-slider="clinical">
			<div class="teams-slider-viewport">
				<div class="teams-slider-track">
					<?php if ( ! empty( $clinical_specialists ) ) : ?>
						<?php foreach ( $clinical_specialists as $index => $member ) : ?>
							<article class="teams-member-card teams-member-card--clinical<?php echo 0 === $index ? ' is-active' : ''; ?>" data-slide-index="<?php echo esc_attr( (string) $index ); ?>">
								<div class="teams-member-photo">
									<img src="<?php echo esc_url( $member['image'] ); ?>" alt="<?php echo esc_attr( trim( $member['prefix'] . ' ' . $member['name'] ) ); ?>">
								</div>
								<div class="teams-member-info">
									<?php if ( ! empty( $member['role'] ) ) : ?>
										<p class="teams-member-role"><?php echo esc_html( $member['role'] ); ?></p>
									<?php endif; ?>
									<div class="teams-member-identity">
										<h3 class="teams-member-name">
											<?php if ( ! empty( $member['prefix'] ) ) : ?>
												<span class="teams-member-prefix"><?php echo esc_html( $member['prefix'] ); ?></span>
											<?php endif; ?>
											<span class="teams-member-fullname"><?php echo esc_html( ' ' . $member['name'] ); ?></span>
										</h3>
										<?php if ( ! empty( $member['gdc'] ) ) : ?>
											<p class="teams-member-gdc"><?php echo esc_html( 'GDC Number: ' . $member['gdc'] ); ?></p>
										<?php endif; ?>
										<?php if ( ! empty( $member['bio'] ) ) : ?>
											<p class="teams-member-bio"><?php echo esc_html( $member['bio'] ); ?></p>
										<?php endif; ?>
									</div>
									<?php if ( ! empty( $member['focus'] ) ) : ?>
										<div class="teams-member-focus">
											<p class="teams-member-focus-label"><?php esc_html_e( 'Clinical Focus', 'wsd' ); ?></p>
											<ul class="teams-member-tags">
												<?php foreach ( $member['focus'] as $tag ) : ?>
													<li class="teams-member-tag"><?php echo esc_html( $tag ); ?></li>
												<?php endforeach; ?>
											</ul>
										</div>
									<?php endif; ?>
									<div class="teams-member-actions">
										<a href="<?php echo esc_url( $referrals_url ); ?>" class="btn btn-secondary teams-member-btn teams-member-btn--outline"><?php esc_html_e( 'Refer a Patient', 'wsd' ); ?></a>
										<button
											type="button"
											class="btn btn-primary teams-member-btn teams-member-btn--solid js-doctor-modal-open"
											data-doctor-index="<?php echo esc_attr( (string) $index ); ?>"
											data-doctor-image="<?php echo esc_url( $member['image'] ); ?>"
											data-bs-toggle="modal"
											data-bs-target="#teamsDoctorModal"
										><?php esc_html_e( 'Read more', 'wsd' ); ?></button>
									</div>
								</div>
							</article>
						<?php endforeach; ?>
					<?php else : ?>
						<p class="teams-clinical-empty"><?php esc_html_e( 'Clinical specialists will be added soon.', 'wsd' ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="teams-slider-controls">
				<div class="teams-slider-progress" aria-hidden="true">
					<span class="teams-slider-progress-track"></span>
					<span class="teams-slider-progress-fill"></span>
				</div>
				<div class="teams-slider-nav">
					<button type="button" class="teams-slider-nav-btn teams-slider-nav-btn--prev" aria-label="<?php esc_attr_e( 'Previous specialist', 'wsd' ); ?>">
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/left_arrow.svg' ); ?>" alt="" width="26" height="26">
					</button>
					<button type="button" class="teams-slider-nav-btn teams-slider-nav-btn--next is-active" aria-label="<?php esc_attr_e( 'Next specialist', 'wsd' ); ?>">
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/left_arrow.svg' ); ?>" alt="" width="26" height="26">
					</button>
				</div>
				<?php if ( ! empty( $clinical_specialists ) && count( $clinical_specialists ) > 1 ) : ?>
					<div class="teams-slider-dots" aria-label="<?php esc_attr_e( 'Clinical specialist slides', 'wsd' ); ?>">
						<?php foreach ( $clinical_specialists as $dot_index => $unused_member ) : ?>
							<button
								type="button"
								class="teams-slider-dot<?php echo 0 === $dot_index ? ' is-active' : ''; ?>"
								aria-label="<?php echo esc_attr( sprintf( __( 'Go to specialist %d', 'wsd' ), $dot_index + 1 ) ); ?>"
								data-slide-dot="<?php echo esc_attr( (string) $dot_index ); ?>"
							></button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="teams-support-section" aria-labelledby="teams-support-heading">
		<div class="teams-support-header">
			<div class="teams-support-dropdown d-lg-none" aria-label="<?php esc_attr_e( 'Support team categories', 'wsd' ); ?>">
				<select class="teams-support-select" aria-label="<?php esc_attr_e( 'Select support team category', 'wsd' ); ?>">
					<?php foreach ( $support_categories as $slug => $label ) : ?>
						<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $slug, $default_support_category ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<h2 id="teams-support-heading" class="teams-support-heading">
				<span class="teams-support-heading-main">Meet Our</span>
				<span class="teams-support-heading-accent"> Support Team</span>
			</h2>

			<div class="teams-support-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Support team categories', 'wsd' ); ?>">
				<?php foreach ( $support_categories as $slug => $label ) : ?>
					<button
						type="button"
						class="teams-support-tab teams-support-tab--<?php echo esc_attr( $slug ); ?><?php echo $slug === $default_support_category ? ' is-active' : ''; ?>"
						role="tab"
						aria-selected="<?php echo $slug === $default_support_category ? 'true' : 'false'; ?>"
						data-support-category="<?php echo esc_attr( $slug ); ?>"
					>
						<?php echo esc_html( $label ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="teams-slider teams-support-slider" data-teams-slider="support" data-active-category="<?php echo esc_attr( $default_support_category ); ?>">
			<div class="teams-slider-viewport">
				<div class="teams-slider-track">
					<?php
					$support_active_set = false;
					foreach ( $support_members as $index => $member ) :
						$is_member_visible = $member['category'] === $default_support_category;
						$is_member_active  = $is_member_visible && ! $support_active_set;

						if ( $is_member_active ) {
							$support_active_set = true;
						}
						?>
						<article
							class="teams-member-card teams-member-card--support<?php echo $is_member_active ? ' is-active' : ''; ?>"
							data-slide-index="<?php echo esc_attr( (string) $index ); ?>"
							data-support-category="<?php echo esc_attr( $member['category'] ); ?>"
							<?php echo ! $is_member_visible ? ' hidden' : ''; ?>
						>
							<div class="teams-member-photo teams-member-photo--support">
								<img src="<?php echo esc_url( $member['image'] ); ?>" alt="<?php echo esc_attr( $member['name'] ); ?>">
							</div>
							<div class="teams-member-info teams-member-info--support">
								<?php if ( ! empty( $member['role'] ) ) : ?>
									<p class="teams-member-role teams-member-role--support"><?php echo esc_html( $member['role'] ); ?></p>
								<?php endif; ?>
								<div class="teams-member-details">
									<h3 class="teams-member-name teams-member-name--support"><?php echo esc_html( $member['name'] ); ?></h3>
									<?php if ( ! empty( $member['gdc'] ) ) : ?>
										<p class="teams-member-gdc teams-member-gdc--support"><?php echo esc_html( 'GDC Number: ' . $member['gdc'] ); ?></p>
									<?php endif; ?>
									<div class="teams-member-copy">
										<?php if ( ! empty( $member['bio'] ) ) : ?>
											<p class="teams-member-bio teams-member-bio--support"><?php echo esc_html( $member['bio'] ); ?></p>
										<?php endif; ?>
										<?php if ( ! empty( $member['focus'] ) ) : ?>
											<div class="teams-member-focus teams-member-focus--support">
												<p class="teams-member-focus-label teams-member-focus-label--support"><?php esc_html_e( 'Clinical Focus', 'wsd' ); ?></p>
												<p class="teams-member-focus-text"><?php echo esc_html( $member['focus'] ); ?></p>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			</div>

			<p class="teams-support-empty" hidden><?php esc_html_e( 'Team members for this category will be added soon.', 'wsd' ); ?></p>

			<div class="teams-slider-controls">
				<div class="teams-slider-progress" aria-hidden="true">
					<span class="teams-slider-progress-track"></span>
					<span class="teams-slider-progress-fill"></span>
				</div>
				<div class="teams-slider-nav">
					<button type="button" class="teams-slider-nav-btn teams-slider-nav-btn--prev" aria-label="<?php esc_attr_e( 'Previous support team member', 'wsd' ); ?>">
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/left_arrow.svg' ); ?>" alt="" width="26" height="26">
					</button>
					<button type="button" class="teams-slider-nav-btn teams-slider-nav-btn--next is-active" aria-label="<?php esc_attr_e( 'Next support team member', 'wsd' ); ?>">
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/left_arrow.svg' ); ?>" alt="" width="26" height="26">
					</button>
				</div>
				<?php if ( $default_support_slide_count > 1 ) : ?>
					<div class="teams-slider-dots" aria-label="<?php esc_attr_e( 'Support team slides', 'wsd' ); ?>">
						<?php for ( $dot_index = 0; $dot_index < $default_support_slide_count; $dot_index++ ) : ?>
							<button
								type="button"
								class="teams-slider-dot<?php echo 0 === $dot_index ? ' is-active' : ''; ?>"
								aria-label="<?php echo esc_attr( sprintf( __( 'Go to support team member %d', 'wsd' ), $dot_index + 1 ) ); ?>"
								data-slide-dot="<?php echo esc_attr( (string) $dot_index ); ?>"
							></button>
						<?php endfor; ?>
					</div>
				<?php else : ?>
					<div class="teams-slider-dots" aria-label="<?php esc_attr_e( 'Support team slides', 'wsd' ); ?>" hidden></div>
				<?php endif; ?>
			</div>
		</div>
	</section>

</main>

<script>
window.wsdTeamsDoctors = <?php echo wp_json_encode( $teams_doctor_payload ); ?>;
</script>

<?php
$teams_modal_photo_fallback = $theme_uri . '/assets/images/team-andrew.png';
if ( file_exists( get_template_directory() . '/assets/images/doctor-modal-hero.jpg' ) ) {
	$teams_modal_photo_fallback = $theme_uri . '/assets/images/doctor-modal-hero.jpg';
}
?>
<style id="teams-doctor-modal-mobile-hero">
/* Guaranteed mobile hero layout — Figma 4084:44380 */
@media (max-width: 767.98px) {
  #teamsDoctorModal .teams-doctor-hero {
    display: block !important;
    flex: 0 0 auto !important;
    height: auto !important;
    min-height: auto !important;
    padding: 40px 24px 0 !important;
    background: #faf3e6 !important;
    overflow: visible !important;
  }
  #teamsDoctorModal .teams-doctor-hero-inner {
    display: flex !important;
    flex-direction: column !important;
    flex-wrap: nowrap !important;
    align-items: stretch !important;
    justify-content: flex-start !important;
    gap: 30px !important;
    width: 100% !important;
    max-width: 100% !important;
    height: auto !important;
    min-height: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
  }
  #teamsDoctorModal .teams-doctor-hero-copy {
    position: relative !important;
    top: auto !important;
    left: auto !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 30px !important;
    width: 100% !important;
    max-width: 100% !important;
    flex: 0 0 auto !important;
    order: 0 !important;
    opacity: 1 !important;
    visibility: visible !important;
    transform: none !important;
  }
  #teamsDoctorModal .teams-doctor-hero-details {
    width: 100% !important;
    max-width: 254px !important;
    gap: 30px !important;
    align-items: flex-start !important;
    text-align: left !important;
  }
  #teamsDoctorModal .teams-doctor-hero-ctas {
    display: flex !important;
    flex-direction: column !important;
    gap: 15px !important;
    width: 240px !important;
    max-width: 100% !important;
  }
  #teamsDoctorModal .teams-doctor-hero-cta-book,
  #teamsDoctorModal .teams-doctor-hero-cta-refer,
  #teamsDoctorModal .teams-doctor-hero-cta-readmore {
    display: none !important;
  }
  #teamsDoctorModal .teams-doctor-hero-cta-book-mobile,
  #teamsDoctorModal .teams-doctor-hero-cta-gallery {
    display: inline-flex !important;
    width: 100% !important;
    height: 40px !important;
    min-height: 40px !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 32px !important;
    font-size: 14px !important;
    opacity: 1 !important;
    visibility: visible !important;
  }
  #teamsDoctorModal .teams-doctor-hero-cta-book-mobile {
    background: #d8a444 !important;
    border-color: #d8a444 !important;
    color: #fff !important;
  }
  #teamsDoctorModal .teams-doctor-hero-cta-gallery {
    background: #faf3e6 !important;
    border: 1px solid rgba(94, 93, 95, 0.52) !important;
    color: rgba(94, 93, 95, 0.52) !important;
  }
  #teamsDoctorModal .teams-doctor-name,
  #teamsDoctorModal .teams-doctor-gdc,
  #teamsDoctorModal .teams-doctor-role,
  #teamsDoctorModal .teams-doctor-qualifications {
    color: #5e5d5f !important;
    text-align: left !important;
    opacity: 1 !important;
    visibility: visible !important;
  }
  #teamsDoctorModal .teams-doctor-prefix {
    color: #d8a444 !important;
  }
  #teamsDoctorModal .teams-doctor-photo {
    display: block !important;
    position: relative !important;
    left: auto !important;
    right: auto !important;
    top: auto !important;
    bottom: auto !important;
    flex: 0 0 auto !important;
    order: 1 !important;
    width: calc(100% + 48px) !important;
    max-width: calc(100% + 48px) !important;
    height: auto !important;
    min-height: 0 !important;
    margin: 0 0 0 -24px !important;
    overflow: hidden !important;
    background: transparent !important;
  }
  #teamsDoctorModal .teams-doctor-photo-img {
    display: block !important;
    position: static !important;
    left: auto !important;
    top: auto !important;
    width: 100% !important;
    max-width: 100% !important;
    height: auto !important;
    min-height: 280px !important;
    max-height: 432px !important;
    object-fit: cover !important;
    object-position: center top !important;
    opacity: 1 !important;
    visibility: visible !important;
    transform: none !important;
    order: 1 !important;
    margin: 0 !important;
  }
}
</style>
<div class="modal fade teams-doctor-modal" id="teamsDoctorModal" tabindex="-1" aria-hidden="true" data-photo-fallback="<?php echo esc_url( $teams_modal_photo_fallback ); ?>">
	<div class="modal-dialog modal-fullscreen">
		<div class="modal-content teams-doctor-modal-content">
			<div class="teams-doctor-modal-header">
				<button type="button" class="btn-close-circle" data-bs-dismiss="modal" aria-label="<?php esc_attr_e( 'Close', 'wsd' ); ?>">
					<img src="<?php echo esc_url( $theme_uri . '/assets/images/modal-close.svg' ); ?>" alt="" class="teams-doctor-modal-close-icon d-lg-none" width="18" height="18" decoding="async">
					<span class="close-x d-none d-lg-inline" aria-hidden="true">&times;</span>
				</button>

				<nav class="teams-doctor-modal-nav d-none d-md-flex" aria-label="<?php esc_attr_e( 'Doctor sections', 'wsd' ); ?>">
					<a class="teams-doctor-modal-link is-active" href="#teamsDoctorAbout"><?php esc_html_e( 'About', 'wsd' ); ?></a>
					<a class="teams-doctor-modal-link" href="#teamsDoctorClinicalFocus"><?php esc_html_e( 'Clinical Focus', 'wsd' ); ?></a>
					<a class="teams-doctor-modal-link" href="#teamsDoctorQualificationsJourney"><?php esc_html_e( 'Qualifications', 'wsd' ); ?></a>
					<a class="teams-doctor-modal-link" href="#teamsDoctorResultsGallery"><?php esc_html_e( 'Results', 'wsd' ); ?></a>
				</nav>

				<div class="teams-doctor-scroll-nav d-md-none">
					<label class="visually-hidden" for="teamsDoctorScrollNav"><?php esc_html_e( 'Scroll Navigation', 'wsd' ); ?></label>
					<select id="teamsDoctorScrollNav" class="teams-doctor-scroll-select" aria-label="<?php esc_attr_e( 'Scroll Navigation', 'wsd' ); ?>">
						<option value="" selected disabled><?php esc_html_e( 'Scroll Navigation', 'wsd' ); ?></option>
						<option value="#teamsDoctorAbout"><?php esc_html_e( 'About', 'wsd' ); ?></option>
						<option value="#teamsDoctorClinicalFocus"><?php esc_html_e( 'Clinical Focus', 'wsd' ); ?></option>
						<option value="#teamsDoctorQualificationsJourney"><?php esc_html_e( 'Qualifications', 'wsd' ); ?></option>
						<option value="#teamsDoctorResultsGallery"><?php esc_html_e( 'Results', 'wsd' ); ?></option>
					</select>
				</div>
			</div>

			<div class="teams-doctor-modal-body">
				<section class="teams-doctor-hero" id="teamsDoctorAbout">
					<div class="teams-doctor-hero-inner">
						<div class="teams-doctor-hero-copy">
							<div class="teams-doctor-hero-details">
								<div class="teams-doctor-hero-identity">
									<h2 class="teams-doctor-name">
										<span class="teams-doctor-prefix"></span>
										<span class="teams-doctor-fullname"></span>
									</h2>
									<p class="teams-doctor-gdc"></p>
								</div>

								<div class="teams-doctor-hero-meta">
									<p class="teams-doctor-role"></p>
									<p class="teams-doctor-qualifications"></p>
								</div>
							</div>

							<div class="teams-doctor-hero-ctas">
								<a href="<?php echo esc_url( wsd_get_contact_page_url() ); ?>" class="btn btn-primary teams-doctor-hero-cta-book">
									<?php esc_html_e( 'Book Appointment', 'wsd' ); ?>
								</a>
								<a href="<?php echo esc_url( wsd_get_contact_page_url() ); ?>" class="btn btn-primary teams-doctor-hero-cta-book-mobile">
									<?php esc_html_e( 'Book an appointment', 'wsd' ); ?>
								</a>
								<a href="<?php echo esc_url( $referrals_url ); ?>" class="btn btn-secondary teams-doctor-hero-cta-refer"><?php esc_html_e( 'Refer a Patient', 'wsd' ); ?></a>
								<a href="#teamsDoctorAboutDetails" class="btn btn-secondary teams-doctor-hero-cta-readmore"><?php esc_html_e( 'Read more', 'wsd' ); ?></a>
								<a href="<?php echo esc_url( $gallery_url ); ?>" class="btn btn-secondary teams-doctor-hero-cta-gallery"><?php esc_html_e( 'Smile Gallery', 'wsd' ); ?></a>
							</div>
						</div>

						<?php
						$teams_modal_photo_url = $teams_modal_photo_fallback;
						if ( ! empty( $clinical_specialists[0]['detail_image'] ) ) {
							$teams_modal_photo_url = (string) $clinical_specialists[0]['detail_image'];
						} elseif ( ! empty( $clinical_specialists[0]['image'] ) ) {
							$teams_modal_photo_url = (string) $clinical_specialists[0]['image'];
						}
						?>
						<div class="teams-doctor-photo">
							<img
								src="<?php echo esc_url( $teams_modal_photo_url ); ?>"
								alt="<?php esc_attr_e( 'Doctor portrait', 'wsd' ); ?>"
								class="teams-doctor-photo-img skip-lazy"
								width="900"
								height="900"
								loading="eager"
								decoding="async"
								fetchpriority="high"
								data-no-lazy="1"
								onerror="this.onerror=null;this.src='<?php echo esc_url( $theme_uri . '/assets/images/team-andrew.png' ); ?>';"
							>
						</div>
					</div>
				</section>

				<section class="teams-doctor-about" id="teamsDoctorAboutDetails" aria-label="<?php esc_attr_e( 'Doctor biography', 'wsd' ); ?>">
					<div class="teams-doctor-about-header">
						<div class="teams-doctor-about-badge">
							<h3 class="teams-doctor-about-badge-title">
								<span class="teams-doctor-about-badge-desktop d-none d-md-inline">
									<span><?php esc_html_e( 'About', 'wsd' ); ?></span>
									<span class="teams-doctor-about-name-accent">
										<span class="teams-doctor-about-prefix"></span>
										<span class="teams-doctor-about-name"></span>
									</span>
								</span>
								<span class="teams-doctor-about-badge-mobile d-md-none">
									<span class="teams-doctor-about-badge-mobile-prefix"></span>
									<span class="teams-doctor-about-badge-mobile-accent"><?php esc_html_e( 'Patient Results', 'wsd' ); ?></span>
								</span>
							</h3>
						</div>
						<div class="teams-doctor-about-rating" aria-label="<?php esc_attr_e( 'Google rating', 'wsd' ); ?>">
							<p class="teams-doctor-about-rating-count"><?php esc_html_e( '200+ Google reviews', 'wsd' ); ?></p>
							<p class="teams-doctor-about-rating-score"><?php esc_html_e( '4.9 Rating', 'wsd' ); ?></p>
						</div>
					</div>

					<div class="teams-doctor-about-content">
						<h4 class="teams-doctor-about-heading">
							<span><?php esc_html_e( 'Trusted Expertise with', 'wsd' ); ?></span>
							<span class="teams-doctor-about-heading-accent"><?php esc_html_e( ' National Recognition', 'wsd' ); ?></span>
						</h4>
						<div class="teams-doctor-about-text"></div>
					</div>
				</section>

				<section class="teams-doctor-clinical-focus" id="teamsDoctorClinicalFocus" aria-label="<?php esc_attr_e( 'Clinical focus', 'wsd' ); ?>">
					<div class="teams-doctor-clinical-focus-heading-wrap">
						<h3 class="teams-doctor-clinical-focus-heading">
							<span class="d-none d-lg-inline">
								<span><?php esc_html_e( 'Our Clinical ', 'wsd' ); ?></span>
								<span class="teams-doctor-clinical-focus-heading-accent"><?php esc_html_e( 'specialist', 'wsd' ); ?></span>
							</span>
							<span class="d-lg-none">
								<span><?php esc_html_e( 'Areas of ', 'wsd' ); ?></span>
								<span class="teams-doctor-clinical-focus-heading-accent"><?php esc_html_e( 'Clinical Focus', 'wsd' ); ?></span>
							</span>
						</h3>
					</div>

					<div class="teams-doctor-clinical-focus-slider" data-teams-focus-slider>
						<div class="teams-doctor-clinical-focus-viewport">
							<div class="teams-doctor-clinical-focus-grid" aria-label="<?php esc_attr_e( 'Clinical focus areas', 'wsd' ); ?>">
								<?php for ( $focus_card_index = 0; $focus_card_index < 4; $focus_card_index++ ) : ?>
									<article class="teams-doctor-focus-card" data-doctor-focus-card hidden>
										<h4 class="teams-doctor-focus-card-title"></h4>
										<p class="teams-doctor-focus-card-desc"></p>
										<div class="teams-doctor-focus-card-meta">
											<div class="teams-doctor-focus-meter" aria-hidden="true">
												<span class="teams-doctor-focus-meter-track"></span>
												<span class="teams-doctor-focus-meter-fill"></span>
											</div>
											<p class="teams-doctor-focus-card-level"></p>
										</div>
									</article>
								<?php endfor; ?>
							</div>
						</div>
						<div class="teams-doctor-focus-progress d-none d-md-flex d-lg-none" aria-hidden="true">
							<span class="teams-doctor-focus-progress-track"></span>
							<span class="teams-doctor-focus-progress-fill"></span>
						</div>
						<div class="teams-slider-dots teams-doctor-focus-dots" aria-hidden="true"></div>
					</div>
				</section>

				<section class="teams-doctor-feature-media" id="teamsDoctorFeatureMedia">
					<div class="teams-doctor-feature-media-frame">
						<img src="" alt="" class="teams-doctor-feature-media-img" loading="lazy" decoding="async">
					</div>
				</section>

				<section class="teams-doctor-journey" id="teamsDoctorQualificationsJourney" aria-label="<?php esc_attr_e( 'Qualifications and professional journey', 'wsd' ); ?>">
					<div class="teams-doctor-journey-inner">
						<h3 class="teams-doctor-journey-heading">
							<span><?php esc_html_e( 'Qualifications & Professional ', 'wsd' ); ?></span>
							<span class="teams-doctor-journey-heading-accent"><?php esc_html_e( 'Journey', 'wsd' ); ?></span>
						</h3>

						<div class="teams-doctor-journey-text"></div>
					</div>
				</section>

				<section class="teams-doctor-results" id="teamsDoctorResultsGallery" aria-label="<?php esc_attr_e( 'Smile Gallery', 'wsd' ); ?>">
					<div class="teams-doctor-results-heading-wrap">
						<h3 class="teams-doctor-results-heading">
							<span class="d-none d-lg-inline">
								<span><?php esc_html_e( 'About Dr', 'wsd' ); ?></span>
								<span class="teams-doctor-results-heading-accent teams-doctor-results-heading-name"></span>
							</span>
							<span class="teams-doctor-results-heading-mobile d-inline d-lg-none">
								<span class="teams-doctor-results-heading-mobile-prefix"></span>
								<span class="teams-doctor-results-heading-patient"><?php esc_html_e( 'Patient', 'wsd' ); ?></span>
								<span class="teams-doctor-results-heading-accent"><?php esc_html_e( 'Results', 'wsd' ); ?></span>
							</span>
						</h3>
					</div>

					<div class="teams-doctor-results-gallery" data-teams-results-slider role="region" aria-label="<?php esc_attr_e( 'Before and after gallery', 'wsd' ); ?>">
						<div class="teams-doctor-results-viewport">
							<div class="teams-doctor-results-track">
								<?php foreach ( $smile_gallery_slides as $gallery_slide_index => $gallery_slide ) : ?>
									<article class="teams-doctor-result-card" aria-label="<?php echo esc_attr( sprintf( __( 'Smile gallery slide %d', 'wsd' ), $gallery_slide_index + 1 ) ); ?>">
										<div class="teams-doctor-result-pair">
											<div class="teams-doctor-result-image teams-doctor-result-image--before">
												<div class="teams-doctor-result-image-frame">
													<img src="<?php echo esc_url( $gallery_slide['before_image'] ); ?>" alt="<?php esc_attr_e( 'Before treatment', 'wsd' ); ?>" loading="lazy" decoding="async">
												</div>
												<span class="teams-doctor-result-label"><?php esc_html_e( 'Before', 'wsd' ); ?></span>
											</div>

											<div class="teams-doctor-result-arrow" aria-hidden="true">
												<img src="<?php echo esc_url( $theme_uri . '/assets/images/gallery_arrow.svg' ); ?>" alt="" class="teams-doctor-result-arrow-img">
											</div>

											<div class="teams-doctor-result-image teams-doctor-result-image--after">
												<div class="teams-doctor-result-image-frame">
													<img src="<?php echo esc_url( $gallery_slide['after_image'] ); ?>" alt="<?php esc_attr_e( 'After treatment', 'wsd' ); ?>" loading="lazy" decoding="async">
												</div>
												<span class="teams-doctor-result-label"><?php esc_html_e( 'After', 'wsd' ); ?></span>
											</div>

											<a href="<?php echo esc_url( $gallery_url ); ?>" class="teams-doctor-result-readmore"><?php esc_html_e( 'Read More', 'wsd' ); ?></a>
										</div>
									</article>
								<?php endforeach; ?>
							</div>
						</div>

						<div class="teams-doctor-results-controls d-none d-lg-flex">
							<div class="teams-doctor-results-progress" aria-hidden="true">
								<span class="teams-doctor-results-progress-track"></span>
								<span class="teams-doctor-results-progress-fill"></span>
							</div>
							<div class="teams-doctor-results-nav">
								<button type="button" class="teams-slider-nav-btn teams-slider-nav-btn--prev is-disabled" aria-label="<?php esc_attr_e( 'Previous smile gallery slide', 'wsd' ); ?>" aria-disabled="true" tabindex="-1">
									<img src="<?php echo esc_url( $theme_uri . '/assets/images/left_arrow.svg' ); ?>" alt="">
								</button>
								<button type="button" class="teams-slider-nav-btn teams-slider-nav-btn--next is-active" aria-label="<?php esc_attr_e( 'Next smile gallery slide', 'wsd' ); ?>">
									<img src="<?php echo esc_url( $theme_uri . '/assets/images/left_arrow.svg' ); ?>" alt="">
								</button>
							</div>
						</div>
						<div class="teams-slider-dots teams-doctor-results-dots" aria-hidden="true"></div>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
