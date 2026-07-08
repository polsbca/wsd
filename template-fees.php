<?php
/**
 * Template Name: Fees Page Template
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

$theme_uri     = get_template_directory_uri();
$fees_page_id  = get_the_ID();
$fees_hero_alt = __( 'Family smiling after dental care', 'wsd' );

if ( $fees_page_id && has_post_thumbnail( $fees_page_id ) ) {
	$thumbnail_alt = get_post_meta( (int) get_post_thumbnail_id( $fees_page_id ), '_wp_attachment_image_alt', true );
	if ( $thumbnail_alt ) {
		$fees_hero_alt = $thumbnail_alt;
	}
}

$fees_hero_image = wsd_get_fees_hero_image_url( $fees_page_id );

$service_fee_items = array(
	__( 'New Patient Examination', 'wsd' ),
	__( 'New Patient Examination', 'wsd' ),
	__( 'New Patient Examination', 'wsd' ),
	__( 'New Patient Examination', 'wsd' ),
	__( 'New Patient Examination', 'wsd' ),
	__( 'New Patient Examination', 'wsd' ),
	__( 'New Patient Examination', 'wsd' ),
	__( 'New Patient Examination', 'wsd' ),
	__( 'New Patient Examination', 'wsd' ),
);

$consultation_items = array(
	__( 'New Patient Consultation', 'wsd' ),
	__( 'Emergency Consultation', 'wsd' ),
	__( 'Specialist Consultation', 'wsd' ),
	__( 'Treatment Planning Appointment', 'wsd' ),
);

$membership_items = array(
	__( 'Adult Membership Plan', 'wsd' ),
	__( 'Child Membership Plan', 'wsd' ),
	__( 'Family Membership Plan', 'wsd' ),
	__( 'Hygiene Membership', 'wsd' ),
);

$finance_items = array(
	__( '0% Finance Options', 'wsd' ),
	__( 'Flexible Monthly Payments', 'wsd' ),
	__( 'Treatment Finance Plans', 'wsd' ),
	__( 'Finance Calculator', 'wsd' ),
);

/**
 * Render a fees accordion panel.
 *
 * @param string   $panel_id  Panel id.
 * @param string[] $items     Accordion titles.
 * @param bool     $is_active Whether this panel is visible.
 */
if ( ! function_exists( 'wsd_render_fees_accordion_panel' ) ) {
	/**
	 * @param string   $panel_id  Panel id.
	 * @param string[] $items     Accordion titles.
	 * @param bool     $is_active Whether this panel is visible.
	 */
	function wsd_render_fees_accordion_panel( $panel_id, $items, $is_active = false ) {
		$theme_uri = get_template_directory_uri();
		?>
		<div
			class="fees-accordion-panel<?php echo $is_active ? ' is-active' : ''; ?>"
			id="<?php echo esc_attr( $panel_id ); ?>"
			role="tabpanel"
			<?php echo $is_active ? '' : 'hidden'; ?>
		>
			<div class="fees-accordion-list">
				<?php foreach ( $items as $title ) : ?>
					<div class="fees-accordion-item">
						<button
							type="button"
							class="fees-accordion-trigger"
							aria-expanded="false"
						>
							<span class="fees-accordion-title"><?php echo esc_html( $title ); ?></span>
							<span class="fees-accordion-icon" aria-hidden="true">
								<img src="<?php echo esc_url( $theme_uri . '/assets/images/fees-accordion-arrow.svg' ); ?>" alt="" width="25" height="25">
							</span>
						</button>
						<div class="fees-accordion-content" hidden>
							<div class="fees-accordion-content-inner">
								<p><?php esc_html_e( 'A full written estimate will be provided before any treatment begins. Please speak to our team for the latest pricing.', 'wsd' ); ?></p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
?>

<main id="main" class="site-main fees-page-main">

	<section class="fees-hero-page" aria-labelledby="fees-hero-heading">
		<div class="fees-hero-inner">
			<div class="fees-hero-content-col">
				<div class="fees-hero-copy">
					<h1 id="fees-hero-heading" class="fees-hero-title hero-title">
						<span class="fees-hero-title-main"><?php esc_html_e( 'Fees & Membership ', 'wsd' ); ?></span>
						<span class="fees-hero-title-accent"><?php esc_html_e( 'Plans', 'wsd' ); ?></span>
					</h1>
					<p class="fees-hero-description hero-description">
						<?php esc_html_e( 'Clear, honest pricing with no surprises. Every patient receives a written cost estimate before any treatment begins. We also offer flexible finance and membership options to suit every budget.', 'wsd' ); ?>
					</p>
				</div>
				<div class="hero-buttons">
					<a href="<?php echo esc_url( home_url( '/#book-appointment' ) ); ?>" class="btn btn-primary"><span><?php esc_html_e( 'Book an appointment', 'wsd' ); ?></span></a>
					<a href="<?php echo esc_url( home_url( '/#smile-gallery' ) ); ?>" class="btn btn-secondary"><?php esc_html_e( 'Smile Gallery', 'wsd' ); ?></a>
				</div>
			</div>
			<div class="fees-hero-image-col">
				<div class="fees-hero-image-frame hero-image-wrapper">
					<?php
					if ( $fees_page_id && has_post_thumbnail( $fees_page_id ) ) {
						echo wp_get_attachment_image(
							(int) get_post_thumbnail_id( $fees_page_id ),
							'full',
							false,
							array(
								'class'    => 'fees-hero-img',
								'alt'      => $fees_hero_alt,
								'loading'  => 'eager',
								'decoding' => 'async',
							)
						);
					} else {
						?>
					<img
						src="<?php echo esc_url( $fees_hero_image ); ?>"
						alt="<?php echo esc_attr( $fees_hero_alt ); ?>"
						class="fees-hero-img"
						width="840"
						height="788"
						loading="eager"
						decoding="async"
					>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>

	<section class="fees-info-section" aria-labelledby="fees-info-heading">
		<div class="fees-info-inner">
			<div class="fees-info-header">
				<h2 id="fees-info-heading" class="fees-info-title">
					<span class="fees-info-title-main"><?php esc_html_e( 'Consultation, Membership & Payment ', 'wsd' ); ?></span>
					<span class="fees-info-title-accent"><?php esc_html_e( 'Information', 'wsd' ); ?></span>
				</h2>
				<p class="fees-info-subtitle">
					<?php esc_html_e( 'Learn about consultation services, membership plans, fees, and flexible financing options.', 'wsd' ); ?>
				</p>
			</div>

			<div class="fees-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Fees and membership categories', 'wsd' ); ?>">
				<span class="fees-tabs-indicator" aria-hidden="true"></span>
				<button type="button" class="fees-tab is-active" role="tab" aria-selected="true" aria-controls="fees-panel-service" id="fees-tab-service" data-fees-tab="service">
					<span class="fees-tab-icon" aria-hidden="true">
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/fees-icon-pound.svg' ); ?>" alt="" width="24" height="24">
					</span>
					<span class="fees-tab-label"><?php esc_html_e( 'Service Fees', 'wsd' ); ?></span>
				</button>
				<button type="button" class="fees-tab" role="tab" aria-selected="false" aria-controls="fees-panel-consultation" id="fees-tab-consultation" data-fees-tab="consultation" tabindex="-1">
					<span class="fees-tab-icon" aria-hidden="true">
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/fees-icon-calendar.svg' ); ?>" alt="" width="24" height="24">
					</span>
					<span class="fees-tab-label"><?php esc_html_e( 'Consultation Charges', 'wsd' ); ?></span>
				</button>
				<button type="button" class="fees-tab" role="tab" aria-selected="false" aria-controls="fees-panel-membership" id="fees-tab-membership" data-fees-tab="membership" tabindex="-1">
					<span class="fees-tab-icon" aria-hidden="true">
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/fees-icon-heart.svg' ); ?>" alt="" width="24" height="24">
					</span>
					<span class="fees-tab-label"><?php esc_html_e( 'Membership plan', 'wsd' ); ?></span>
				</button>
				<button type="button" class="fees-tab" role="tab" aria-selected="false" aria-controls="fees-panel-finance" id="fees-tab-finance" data-fees-tab="finance" tabindex="-1">
					<span class="fees-tab-icon" aria-hidden="true">
						<img src="<?php echo esc_url( $theme_uri . '/assets/images/fees-icon-wallet.svg' ); ?>" alt="" width="24" height="24">
					</span>
					<span class="fees-tab-label"><?php esc_html_e( 'Finance options', 'wsd' ); ?></span>
				</button>
			</div>

			<div class="fees-panels">
				<?php
				wsd_render_fees_accordion_panel( 'fees-panel-service', $service_fee_items, true );
				wsd_render_fees_accordion_panel( 'fees-panel-consultation', $consultation_items, false );
				wsd_render_fees_accordion_panel( 'fees-panel-membership', $membership_items, false );
				wsd_render_fees_accordion_panel( 'fees-panel-finance', $finance_items, false );
				?>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
