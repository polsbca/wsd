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

$clinical_specialists = array(
	array(
		'image'    => $theme_uri . '/assets/images/team-andrew.png',
		'role'     => 'Principal Dentist & Founder',
		'prefix'   => 'Dr',
		'name'     => 'Andrew Parashchak',
		'gdc'      => '229709',
		'bio'      => 'Dr Andrew Parashchak founded Waterside Dental Care to deliver expert, patient-focused care, specialising in cosmetic and implant dentistry.',
		'focus'    => array( 'Dental Implants', 'Cosmetic Dentistry', 'Smile Makeovers', 'Sedation Dentistry' ),
	),
	array(
		'image'    => $theme_uri . '/assets/images/team-tom.png',
		'role'     => 'Dental Implantologist',
		'prefix'   => 'Dr',
		'name'     => 'Tom Owen',
		'gdc'      => '265375',
		'bio'      => 'Thomas specialises in oral surgery and dental implants, with expertise in complex extractions. He delivers clear, patient-focused care with a calm and professional approach.',
		'focus'    => array( 'Dental Implants', 'Cosmetic Dentistry', 'Smile Makeovers', 'Sedation Dentistry' ),
	),
	array(
		'image'    => $theme_uri . '/assets/images/team-emmanuel.png',
		'role'     => 'Oral Surgeon',
		'prefix'   => 'Dr',
		'name'     => 'Emmanuel Egbase',
		'gdc'      => '230459',
		'bio'      => 'Emmanuel specialises in oral surgery and dental implants, with expertise in complex extractions. He delivers clear, patient-focused care with a calm and professional approach.',
		'focus'    => array( 'Dental Implants', 'Cosmetic Dentistry', 'Smile Makeovers', 'Sedation Dentistry' ),
	),
);

$support_categories = array(
	'general'      => 'General Dentistry',
	'hygiene'      => 'Hygiene & Preventive Care',
	'clinical'     => 'Clinical Support',
	'admin'        => 'Patient Care & Administration',
);

$support_members = array(
	array(
		'category' => 'clinical',
		'image'    => $theme_uri . '/assets/images/team-kim.png',
		'role'     => 'Practice Manager',
		'name'     => 'Kim',
		'gdc'      => '171510',
		'bio'      => 'Kim O\'Connor plays a key role in managing patient relationships, ensuring every individual feels supported, informed, and at ease throughout their dental journey.',
		'focus'    => 'Ensure the smooth running of the Practice',
	),
	array(
		'category' => 'clinical',
		'image'    => $theme_uri . '/assets/images/team-kim.png',
		'role'     => 'Practice Manager',
		'name'     => 'Kim',
		'gdc'      => '171510',
		'bio'      => 'Kim O\'Connor plays a key role in managing patient relationships, ensuring every individual feels supported, informed, and at ease throughout their dental journey.',
		'focus'    => 'Ensure the smooth running of the Practice',
	),
);
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
					<p class="teams-hero-description hero-description">Our team combines clinical expertise with patient-focused care to create healthy, confident smiles in a calm and welcoming environment.</p>
				</div>
				<div class="teams-hero-actions">
					<a href="<?php echo esc_url( home_url( '/#book-appointment' ) ); ?>" class="btn btn-primary teams-hero-btn"><?php esc_html_e( 'Book an appointment', 'wsd' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/#fees-membership' ) ); ?>" class="btn btn-secondary teams-hero-btn teams-hero-btn--outline"><?php esc_html_e( 'Fees & Membership', 'wsd' ); ?></a>
				</div>
			</div>
			<div class="teams-hero-image-col">
				<div class="teams-hero-image-frame">
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
					<?php foreach ( $clinical_specialists as $index => $member ) : ?>
						<article class="teams-member-card teams-member-card--clinical<?php echo 0 === $index ? ' is-active' : ''; ?>" data-slide-index="<?php echo esc_attr( (string) $index ); ?>">
							<div class="teams-member-photo">
								<img src="<?php echo esc_url( $member['image'] ); ?>" alt="<?php echo esc_attr( $member['prefix'] . ' ' . $member['name'] ); ?>">
							</div>
							<div class="teams-member-info">
								<p class="teams-member-role"><?php echo esc_html( $member['role'] ); ?></p>
								<div class="teams-member-identity">
									<h3 class="teams-member-name">
										<span class="teams-member-prefix"><?php echo esc_html( $member['prefix'] ); ?></span>
										<span class="teams-member-fullname"><?php echo esc_html( ' ' . $member['name'] ); ?></span>
									</h3>
									<p class="teams-member-gdc"><?php echo esc_html( 'GDC Number: ' . $member['gdc'] ); ?></p>
									<p class="teams-member-bio"><?php echo esc_html( $member['bio'] ); ?></p>
								</div>
								<div class="teams-member-focus">
									<p class="teams-member-focus-label"><?php esc_html_e( 'Clinical Focus', 'wsd' ); ?></p>
									<ul class="teams-member-tags">
										<?php foreach ( $member['focus'] as $tag ) : ?>
											<li class="teams-member-tag"><?php echo esc_html( $tag ); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
								<div class="teams-member-actions">
									<a href="<?php echo esc_url( $referrals_url ); ?>" class="teams-member-btn teams-member-btn--outline"><?php esc_html_e( 'Refer a Patient', 'wsd' ); ?></a>
									<a href="#teams-clinical-heading" class="teams-member-btn teams-member-btn--solid"><?php esc_html_e( 'Read more', 'wsd' ); ?></a>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
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
			</div>
		</div>
	</section>

	<section class="teams-support-section" aria-labelledby="teams-support-heading">
		<div class="teams-support-header">
			<h2 id="teams-support-heading" class="teams-support-heading">
				<span class="teams-support-heading-main">Meet Our</span>
				<span class="teams-support-heading-accent"> Support Team</span>
			</h2>

			<div class="teams-support-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Support team categories', 'wsd' ); ?>">
				<?php foreach ( $support_categories as $slug => $label ) : ?>
					<button
						type="button"
						class="teams-support-tab teams-support-tab--<?php echo esc_attr( $slug ); ?><?php echo 'clinical' === $slug ? ' is-active' : ''; ?>"
						role="tab"
						aria-selected="<?php echo 'clinical' === $slug ? 'true' : 'false'; ?>"
						data-support-category="<?php echo esc_attr( $slug ); ?>"
					>
						<?php echo esc_html( $label ); ?>
					</button>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="teams-slider teams-support-slider" data-teams-slider="support" data-active-category="clinical">
			<div class="teams-slider-viewport">
				<div class="teams-slider-track">
					<?php foreach ( $support_members as $index => $member ) : ?>
						<article
							class="teams-member-card teams-member-card--support<?php echo 0 === $index ? ' is-active' : ''; ?>"
							data-slide-index="<?php echo esc_attr( (string) $index ); ?>"
							data-support-category="<?php echo esc_attr( $member['category'] ); ?>"
						>
							<div class="teams-member-photo teams-member-photo--support">
								<img src="<?php echo esc_url( $member['image'] ); ?>" alt="<?php echo esc_attr( $member['name'] ); ?>">
							</div>
							<div class="teams-member-info teams-member-info--support">
								<p class="teams-member-role teams-member-role--support"><?php echo esc_html( $member['role'] ); ?></p>
								<div class="teams-member-details">
									<h3 class="teams-member-name teams-member-name--support"><?php echo esc_html( $member['name'] ); ?></h3>
									<p class="teams-member-gdc teams-member-gdc--support"><?php echo esc_html( 'GDC Number: ' . $member['gdc'] ); ?></p>
									<div class="teams-member-copy">
										<p class="teams-member-bio teams-member-bio--support"><?php echo esc_html( $member['bio'] ); ?></p>
										<div class="teams-member-focus teams-member-focus--support">
											<p class="teams-member-focus-label teams-member-focus-label--support"><?php esc_html_e( 'Clinical Focus', 'wsd' ); ?></p>
											<p class="teams-member-focus-text"><?php echo esc_html( $member['focus'] ); ?></p>
										</div>
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
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
