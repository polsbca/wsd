<?php
/**
 * Template Name: Privacy Policy Page Template
 *
 * @package wsd
 */

get_header();

$theme_uri = get_template_directory_uri();
?>

<main id="main" class="site-main privacy-policy-main">
	<section class="privacy-policy-hero" aria-labelledby="privacy-policy-heading">
		<div class="privacy-policy-hero-waves" aria-hidden="true">
			<img src="<?php echo esc_url( $theme_uri . '/assets/images/hero-bg-waves.svg' ); ?>" alt="" class="privacy-policy-hero-waves-img">
		</div>
		<div class="privacy-policy-hero-content">
			<h1 id="privacy-policy-heading" class="privacy-policy-hero-title">
				<span class="privacy-policy-hero-brand">Waterside Dental Care</span>
				<span class="privacy-policy-hero-accent">Privacy Policy</span>
			</h1>
		</div>
	</section>

	<div class="privacy-policy-content px-lg-120">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if ( trim( get_the_content() ) !== '' ) : ?>
					<div class="privacy-policy-intro entry-content">
						<?php the_content(); ?>
					</div>
				<?php else : ?>
					<p class="privacy-policy-intro">
						This privacy policy sets out how Waterside Dental Care uses and protects any information that you give us when you use this website.
					</p>

					<section class="privacy-policy-section" aria-labelledby="privacy-section-1">
						<h2 id="privacy-section-1" class="privacy-policy-section-title">1.&emsp;Introduction</h2>
						<div class="privacy-policy-section-body">
							<p>1.1&emsp;We are committed to safeguarding the privacy of our website visitors and service users.</p>
							<p>1.2&emsp;This policy applies where we are acting as a data controller with respect to the personal data of our website visitors and service users; in other words, where we determine the purposes and means of the processing of that personal data.</p>
							<p>1.3&emsp;We will ask you to consent to our use of cookies in accordance with the terms of this policy when you first visit our website where applicable.</p>
						</div>
					</section>

					<section class="privacy-policy-section" aria-labelledby="privacy-section-2">
						<h2 id="privacy-section-2" class="privacy-policy-section-title">2.&emsp;Credit</h2>
						<div class="privacy-policy-section-body">
							<p>2.1&emsp;This document was created using a template from SEQ Legal (<a href="https://seqlegal.com" target="_blank" rel="noopener noreferrer">https://seqlegal.com</a>)</p>
						</div>
					</section>

					<section class="privacy-policy-section" aria-labelledby="privacy-section-3">
						<h2 id="privacy-section-3" class="privacy-policy-section-title">3.&emsp;How we use your personal data</h2>
						<div class="privacy-policy-section-body">
							<p>3.1&emsp;In this Section 3 we have set out:</p>
							<p>(a)&emsp;the general categories of personal data that we may process;</p>
							<p>(b)&emsp;the purposes for which we may process personal data; and</p>
							<p>(c)&emsp;the legal bases of the processing.</p>
							<p>3.2&emsp;Where applicable we may process data about your use of our website and services (&ldquo;usage data&rdquo;). The usage data may include your IP address, geographical location, browser type and version, operating system, referral source, length of visit, page views and website navigation paths, as well as information about the timing, frequency and pattern of your service use. The source of the usage data is our analytics tracking system. This usage data may be processed for the purposes of analysing the use of the website and services. The legal basis for this processing is our legitimate interests, namely monitoring and improving our website and services. The usage data is anonymous and cannot be traced back to you in person.</p>
							<p>3.3&emsp;We may process your account data (&ldquo;account data&rdquo;). The account data may include your name and email address as provided by you. The account data may be processed for the purposes of operating our website, providing our services, ensuring the security of our website and services, maintaining back-ups of our databases and communicating with you. The legal basis for this processing is our legitimate interests, namely the proper administration of our website and business or the performance of a contract between you and us and/or taking steps, at your request, to enter into such a contract.</p>
							<p>3.4&emsp;We may process your personal data that are provided in the course of the use of our services (&ldquo;service data&rdquo;). The service data may include your name and contact details provided by you. The service data may be processed for the purposes of operating our website, providing our services, ensuring the security of our website and services, maintaining back-ups of our databases and communicating with you. The legal basis for this processing is our legitimate interests, namely the proper administration of our website and business or the performance of a contract between you and us and/or taking steps, at your request, to enter into such a contract.</p>
							<p>3.5&emsp;We may process information contained in any enquiry you submit to us regarding goods and/or services (&ldquo;enquiry data&rdquo;). The enquiry data may be processed for the purposes of offering, marketing and selling relevant goods and/or services to you. The legal basis for this processing is consent or the performance of a contract between you and us and/or taking steps, at your request, to enter into such a contract.</p>
							<p>3.6&emsp;We may process information that you provide to us for the purpose of subscribing to our email notifications and/or newsletters (&ldquo;notification data&rdquo;). The notification data may be processed for the purposes of sending you the relevant notifications and/or newsletters. The legal basis for this processing is consent or the performance of a contract between you and us and/or taking steps, at your request, to enter into such a contract.</p>
							<p>3.7&emsp;We may process information contained in or relating to any communication that you send to us (&ldquo;correspondence data&rdquo;). The correspondence data may include the communication content and metadata associated with the communication. Our website will generate the metadata associated with communications made using the website contact forms. The correspondence data may be processed for the purposes of communicating with you and record-keeping] The legal basis for this processing is our legitimate interests, namely the proper administration of our website and business and communications with users.</p>
							<p>3.8&emsp;We may process any of your personal data identified in this policy where necessary for the establishment, exercise or defence of legal claims, whether in court proceedings or in an administrative or out-of-court procedure. The legal basis for this processing is our legitimate interests, namely the protection and assertion of our legal rights, your legal rights and the legal rights of others.</p>
							<p>3.9&emsp;We may process any of your personal data identified in this policy where necessary for [the purposes of obtaining or maintaining insurance coverage, managing risks, or obtaining professional advice. The legal basis for this processing is our legitimate interests, namely the proper protection of our business against risks.</p>
							<p>3.10&emsp;In addition to the specific purposes for which we may process your personal data set out in this Section 3, we may also process any of your personal data] where such processing is necessary for compliance with a legal obligation to which we are subject, or in order to protect your vital interests or the vital interests of another natural person.</p>
							<p>3.11&emsp;Please do not supply any other person&rsquo;s personal data to us, unless we prompt you to do so.</p>
						</div>
					</section>
				<?php endif; ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
