<?php
/**
 * The header for our theme
 *
 * @package wsd
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$is_home_active       = is_front_page();
$is_treatments_active = is_singular( 'services' ) || is_post_type_archive( 'services' ) || is_tax( 'service_category' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@600&display=swap" rel="stylesheet">
	<script>document.documentElement.classList.add('wsd-js');</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="page" class="site">
		<div class="header-top d-none d-lg-block">
			<div class="container-fluid px-lg-0">
				<div class="row align-items-center justify-content-between">
					<div class="col-12 col-md-auto text-center text-md-start mb-3 mb-md-0">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link d-inline-block">
							<div class="logo-wrapper">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-mark.svg' ); ?>" alt="Waterside Dentalcare Logo Mark" class="logo-mark">
								<div class="logo-text-group">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-text-top.svg' ); ?>" alt="WATERSIDE" class="logo-text-top">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-text-bottom.svg' ); ?>" alt="DENTALCARE" class="logo-text-bottom">
								</div>
							</div>
						</a>
					</div>
					<div class="col-12 col-md-auto d-flex justify-content-center">
						<div class="header-search">
							<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<div class="search-input-wrapper">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/search-icon.svg' ); ?>" alt="Search" class="search-icon-img">
									<input type="search" class="search-field" placeholder="Search for 'veneers'" value="<?php echo get_search_query(); ?>" name="s" />
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<header id="masthead" class="site-header d-none d-lg-flex">
			<div class="container-fluid px-lg-0">
				<div class="row justify-content-center">
					<div class="col-12">
						<nav id="site-navigation" class="main-navigation text-center">
							<button class="menu-toggle d-md-none" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'wsd' ); ?></button>
							<ul id="primary-menu" class="menu d-none d-md-flex justify-content-center align-items-center">
								<li class="menu-item <?php echo $is_home_active ? 'current-menu-item' : ''; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
								<li class="menu-item menu-item-has-children">
									<a href="<?php echo esc_url( home_url( '/#our-practice' ) ); ?>" class="our-practice-trigger">Our Practice</a>
									<!-- Our Practice Dropdown Menu -->
									<div class="our-practice-dropdown-container">
										<div class="dropdown-item active">
											<a href="<?php echo esc_url( home_url( '/#blog-advice' ) ); ?>">Blog & Advice</a>
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right.svg' ); ?>" alt="" class="arrow-icon">
										</div>
										<div class="dropdown-item">
											<a href="<?php echo esc_url( home_url( '/#team' ) ); ?>">Meet the Team</a>
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right.svg' ); ?>" alt="" class="arrow-icon">
										</div>
										<div class="dropdown-item">
											<a href="<?php echo esc_url( home_url( '/#smile-gallery' ) ); ?>">Smile Gallery</a>
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right.svg' ); ?>" alt="" class="arrow-icon">
										</div>
									</div>
								</li>
								<li class="menu-item menu-item-has-children <?php echo $is_treatments_active ? 'current-menu-item' : ''; ?>">
									<a href="<?php echo esc_url( home_url( '/#treatments' ) ); ?>" class="treatments-trigger">Treatments</a>
									<!-- Treatments Dropdown Menu -->
									<div class="treatments-dropdown-container">
										<div class="dropdown-item active">
											<a href="/services/all-about-general-dentistry-services/">General Dentistry</a>
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right.svg' ); ?>" alt="" class="arrow-icon">
										</div>
										<div class="dropdown-item">
											<a href="/services/all-about-cosmetic-dentistry-services">Cosmetic Dentistry</a>
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right.svg' ); ?>" alt="" class="arrow-icon">
										</div>
										<div class="dropdown-item">
											<a href="<?php echo esc_url( home_url( '/#dental-implants' ) ); ?>">Dental Implants</a>
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right.svg' ); ?>" alt="" class="arrow-icon">
										</div>
										<div class="dropdown-item">
											<a href="<?php echo esc_url( home_url( '/#invisalign' ) ); ?>">Invisalign</a>
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/arrow-right.svg' ); ?>" alt="" class="arrow-icon">
										</div>
									</div>
								</li>
								<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#fees-membership' ) ); ?>">Fees & Membership</a></li>
								<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#referrals' ) ); ?>">Referrals</a></li>
								<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#contact-us' ) ); ?>">Contact Us</a></li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</header>

		<!-- Mobile Header -->
		<div class="mobile-header d-lg-none">
			<div class="mobile-header-container">
				<!-- Main Bar (Visible by default) -->
				<div class="mobile-main-bar d-flex align-items-center justify-content-between w-100">
					<!-- Logo -->
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-logo-link">
						<div class="mobile-logo-wrapper">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-mark.svg' ); ?>" alt="Waterside Dentalcare Logo Mark" class="mobile-logo-mark">
							<div class="mobile-logo-text-group">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-text-top.svg' ); ?>" alt="WATERSIDE" class="mobile-logo-text-top">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-text-bottom.svg' ); ?>" alt="DENTALCARE" class="mobile-logo-text-bottom">
							</div>
						</div>
					</a>
					
					<!-- Right Controls -->
					<div class="mobile-header-controls">
						<button class="mobile-search-toggle" aria-label="Toggle Search">
							<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="mobile-search-icon">
								<path d="M12.5599 11.9408L9.8217 9.20318C10.6153 8.25036 11.0111 7.02825 10.9266 5.79108C10.8422 4.55391 10.284 3.39693 9.3682 2.56082C8.45242 1.72471 7.24955 1.27385 6.00982 1.30203C4.77009 1.3302 3.58894 1.83524 2.71209 2.71209C1.83524 3.58894 1.3302 4.77009 1.30203 6.00982C1.27385 7.24955 1.72471 8.45242 2.56082 9.3682C3.39693 10.284 4.55391 10.8422 5.79108 10.9266C7.02825 11.0111 8.25036 10.6153 9.20318 9.8217L11.9408 12.5599C11.9815 12.6005 12.0297 12.6328 12.0829 12.6548C12.136 12.6768 12.1929 12.6881 12.2504 12.6881C12.3079 12.6881 12.3648 12.6768 12.4179 12.6548C12.471 12.6328 12.5193 12.6005 12.5599 12.5599C12.6005 12.5193 12.6328 12.471 12.6548 12.4179C12.6768 12.3648 12.6881 12.3079 12.6881 12.2504C12.6881 12.1929 12.6768 12.136 12.6548 12.0829C12.6328 12.0297 12.6005 11.9815 12.5599 11.9408ZM2.18787 6.12537C2.18787 5.3466 2.4188 4.58533 2.85146 3.93781C3.28412 3.29029 3.89907 2.78561 4.61855 2.48759C5.33804 2.18957 6.12974 2.1116 6.89354 2.26353C7.65734 2.41546 8.35893 2.79047 8.9096 3.34114C9.46027 3.89181 9.83528 4.5934 9.98721 5.3572C10.1391 6.121 10.0612 6.9127 9.76315 7.63218C9.46513 8.35167 8.96045 8.96662 8.31293 9.39928C7.66541 9.83194 6.90413 10.0629 6.12537 10.0629C5.08143 10.0617 4.08059 9.6465 3.34241 8.90832C2.60424 8.17015 2.18903 7.1693 2.18787 6.12537Z" fill="#5E5D5F"/>
							</svg>
						</button>
						<button class="mobile-menu-toggle" aria-label="Toggle Menu">
							<svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M23.625 13.5C23.625 13.7238 23.5361 13.9384 23.3779 14.0966C23.2196 14.2549 23.005 14.3438 22.7812 14.3438H4.21875C3.99497 14.3438 3.78036 14.2549 3.62213 14.0966C3.46389 13.9384 3.375 13.7238 3.375 13.5C3.375 13.2762 3.46389 13.0616 3.62213 12.9034C3.78036 12.7451 3.99497 12.6562 4.21875 12.6562H22.7812C23.005 12.6562 23.2196 12.7451 23.3779 12.9034C23.5361 13.0616 23.625 13.2762 23.625 13.5ZM4.21875 7.59375H22.7812C23.005 7.59375 23.2196 7.50486 23.3779 7.34662C23.5361 7.18839 23.625 6.97378 23.625 6.75C23.625 6.52622 23.5361 6.31161 23.3779 6.15338C23.2196 5.99514 23.005 5.90625 22.7812 5.90625H4.21875C3.99497 5.90625 3.78036 5.99514 3.62213 6.15338C3.46389 6.31161 3.375 6.52622 3.375 6.75C3.375 6.97378 3.46389 7.18839 3.62213 7.34662C3.78036 7.50486 3.99497 7.59375 4.21875 7.59375ZM22.7812 19.4062H4.21875C3.99497 19.4062 3.78036 19.4951 3.62213 19.6534C3.46389 19.8116 3.375 20.0262 3.375 20.25C3.375 20.4738 3.46389 20.6884 3.62213 20.8466C3.78036 21.0049 3.99497 21.0938 4.21875 21.0938H22.7812C23.005 21.0938 23.2196 21.0049 23.3779 20.8466C23.5361 20.6884 23.625 20.4738 23.625 20.25C23.625 20.0262 23.5361 19.8116 23.3779 19.6534C23.2196 19.4951 23.005 19.4062 22.7812 19.4062Z" fill="#D8A444"/>
							</svg>
						</button>
					</div>
				</div>
				
				<!-- Search Active Bar (Hidden by default) -->
				<div class="mobile-search-active-bar d-none w-100">
					<form role="search" method="get" class="search-form w-100" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div class="search-active-input-wrapper">
							<svg width="11" height="12" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="search-active-icon">
								<path d="M12.5599 11.9408L9.8217 9.20318C10.6153 8.25036 11.0111 7.02825 10.9266 5.79108C10.8422 4.55391 10.284 3.39693 9.3682 2.56082C8.45242 1.72471 7.24955 1.27385 6.00982 1.30203C4.77009 1.3302 3.58894 1.83524 2.71209 2.71209C1.83524 3.58894 1.3302 4.77009 1.30203 6.00982C1.27385 7.24955 1.72471 8.45242 2.56082 9.3682C3.39693 10.284 4.55391 10.8422 5.79108 10.9266C7.02825 11.0111 8.25036 10.6153 9.20318 9.8217L11.9408 12.5599C11.9815 12.6005 12.0297 12.6328 12.0829 12.6548C12.136 12.6768 12.1929 12.6881 12.2504 12.6881C12.3079 12.6881 12.3648 12.6768 12.4179 12.6548C12.471 12.6328 12.5193 12.6005 12.5599 12.5599C12.6005 12.5193 12.6328 12.471 12.6548 12.4179C12.6768 12.3648 12.6881 12.3079 12.6881 12.2504C12.6881 12.1929 12.6768 12.136 12.6548 12.0829C12.6328 12.0297 12.6005 11.9815 12.5599 11.9408ZM2.18787 6.12537C2.18787 5.3466 2.4188 4.58533 2.85146 3.93781C3.28412 3.29029 3.89907 2.78561 4.61855 2.48759C5.33804 2.18957 6.12974 2.1116 6.89354 2.26353C7.65734 2.41546 8.35893 2.79047 8.9096 3.34114C9.46027 3.89181 9.83528 4.5934 9.98721 5.3572C10.1391 6.121 10.0612 6.9127 9.76315 7.63218C9.46513 8.35167 8.96045 8.96662 8.31293 9.39928C7.66541 9.83194 6.90413 10.0629 6.12537 10.0629C5.08143 10.0617 4.08059 9.6465 3.34241 8.90832C2.60424 8.17015 2.18903 7.1693 2.18787 6.12537Z" fill="#5E5D5F"/>
							</svg>
							<input type="search" class="search-field-active" placeholder="Search for ‘veneers’" value="<?php echo get_search_query(); ?>" name="s" />
						</div>
					</form>
					<button class="mobile-search-close-btn" aria-label="Close Search">
						<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M6.17511 7L1.62923 2.45412L2.45419 1.62916L7.00006 6.17499L11.5459 1.62916L12.3709 2.45412L7.82501 7L12.3709 11.5458L11.5459 12.3708L7.00006 7.82495L2.45419 12.3708L1.62923 11.5458L6.17511 7Z" fill="#5E5D5F"/>
						</svg>
					</button>
				</div>
			</div>
			
			<!-- Mobile Backdrop -->
			<div class="mobile-drawer-backdrop"></div>

			<!-- Mobile Drawer Menu (Full-width Overlay) -->
			<div class="mobile-navigation-drawer" id="mobile-navigation">
				<!-- Header bar inside drawer -->
				<div class="drawer-header-bar d-flex justify-content-between align-items-center">
					<!-- Logo -->
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mobile-logo-link">
						<div class="mobile-logo-wrapper">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-mark.svg' ); ?>" alt="Waterside Dentalcare Logo Mark" class="mobile-logo-mark">
							<div class="mobile-logo-text-group">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-text-top.svg' ); ?>" alt="WATERSIDE" class="mobile-logo-text-top">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo-text-bottom.svg' ); ?>" alt="DENTALCARE" class="mobile-logo-text-bottom">
							</div>
						</div>
					</a>
					<div class="drawer-controls d-flex align-items-center gap-24">
						<button class="mobile-search-toggle drawer-search-btn" aria-label="Toggle Search">
							<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="mobile-search-icon">
								<path d="M12.5599 11.9408L9.8217 9.20318C10.6153 8.25036 11.0111 7.02825 10.9266 5.79108C10.8422 4.55391 10.284 3.39693 9.3682 2.56082C8.45242 1.72471 7.24955 1.27385 6.00982 1.30203C4.77009 1.3302 3.58894 1.83524 2.71209 2.71209C1.83524 3.58894 1.3302 4.77009 1.30203 6.00982C1.27385 7.24955 1.72471 8.45242 2.56082 9.3682C3.39693 10.284 4.55391 10.8422 5.79108 10.9266C7.02825 11.0111 8.25036 10.6153 9.20318 9.8217L11.9408 12.5599C11.9815 12.6005 12.0297 12.6328 12.0829 12.6548C12.136 12.6768 12.1929 12.6881 12.2504 12.6881C12.3079 12.6881 12.3648 12.6768 12.4179 12.6548C12.471 12.6328 12.5193 12.6005 12.5599 12.5599C12.6005 12.5193 12.6328 12.471 12.6548 12.4179C12.6768 12.3648 12.6881 12.3079 12.6881 12.2504C12.6881 12.1929 12.6768 12.136 12.6548 12.0829C12.6328 12.0297 12.6005 11.9815 12.5599 11.9408ZM2.18787 6.12537C2.18787 5.3466 2.4188 4.58533 2.85146 3.93781C3.28412 3.29029 3.89907 2.78561 4.61855 2.48759C5.33804 2.18957 6.12974 2.1116 6.89354 2.26353C7.65734 2.41546 8.35893 2.79047 8.9096 3.34114C9.46027 3.89181 9.83528 4.5934 9.98721 5.3572C10.1391 6.121 10.0612 6.9127 9.76315 7.63218C9.46513 8.35167 8.96045 8.96662 8.31293 9.39928C7.66541 9.83194 6.90413 10.0629 6.12537 10.0629C5.08143 10.0617 4.08059 9.6465 3.34241 8.90832C2.60424 8.17015 2.18903 7.1693 2.18787 6.12537Z" fill="#D8A444"/>
							</svg>
						</button>
						<button class="drawer-close" aria-label="Close Menu">
							<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M6.17511 7L1.62923 2.45412L2.45419 1.62916L7.00006 6.17499L11.5459 1.62916L12.3709 2.45412L7.82501 7L12.3709 11.5458L11.5459 12.3708L7.00006 7.82495L2.45419 12.3708L1.62923 11.5458L6.17511 7Z" fill="#D8A444"/>
							</svg>
						</button>
					</div>
				</div>
				<nav class="mobile-nav-menu">
					<ul class="mobile-menu">
						<li class="menu-item <?php echo $is_home_active ? 'current-menu-item' : ''; ?>"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
						<li class="menu-item menu-item-has-children-mobile">
							<div class="menu-item-row">
								<a href="<?php echo esc_url( home_url( '/#our-practice' ) ); ?>">Our Practice</a>
								<button class="submenu-toggle-btn" aria-label="Toggle Submenu">
									<!-- plus icon -->
									<svg class="plus-icon" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.28568 7.59726L16.8831 7.59709V9.28543L9.28568 9.2856L9.28568 16.8831H7.59739V9.2856L3.38117e-05 9.28577L0 7.59743L7.59739 7.59726L7.5973 8.45318e-06L9.28559 0L9.28568 7.59726Z" fill="#D8A444"/>
									</svg>
									<!-- cross icon -->
									<svg class="cross-icon d-none" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M8.44144 7.24764L13.8135 1.87536L15.0073 3.0692L9.63528 8.44148L15.0075 13.8137L13.8137 15.0075L8.44148 9.63528L3.06946 15.0075L1.8756 13.8137L7.24764 8.44144L1.87551 3.06943L3.06931 1.87563L8.44144 7.24764Z" fill="#D8A444"/>
									</svg>
								</button>
							</div>
							<div class="sub-menu-container">
								<ul class="sub-menu">
									<li><a href="<?php echo esc_url( home_url( '/#blog-advice' ) ); ?>">Blog & Advice</a></li>
									<li><a href="<?php echo esc_url( home_url( '/#team' ) ); ?>">Meet the Team</a></li>
									<li><a href="<?php echo esc_url( home_url( '/#smile-gallery' ) ); ?>">Smile Gallery</a></li>
								</ul>
							</div>
						</li>
						<li class="menu-item menu-item-has-children-mobile <?php echo $is_treatments_active ? 'current-menu-item' : ''; ?>">
							<div class="menu-item-row">
								<a href="<?php echo esc_url( home_url( '/#treatments' ) ); ?>">Treatments</a>
								<button class="submenu-toggle-btn" aria-label="Toggle Submenu">
									<!-- plus icon -->
									<svg class="plus-icon" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M9.28568 7.59726L16.8831 7.59709V9.28543L9.28568 9.2856L9.28568 16.8831H7.59739V9.2856L3.38117e-05 9.28577L0 7.59743L7.59739 7.59726L7.5973 8.45318e-06L9.28559 0L9.28568 7.59726Z" fill="#D8A444"/>
									</svg>
									<!-- cross icon -->
									<svg class="cross-icon d-none" width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M8.44144 7.24764L13.8135 1.87536L15.0073 3.0692L9.63528 8.44148L15.0075 13.8137L13.8137 15.0075L8.44148 9.63528L3.06946 15.0075L1.8756 13.8137L7.24764 8.44144L1.87551 3.06943L3.06931 1.87563L8.44144 7.24764Z" fill="#D8A444"/>
									</svg>
								</button>
							</div>
							<div class="sub-menu-container">
								<ul class="sub-menu">
									<li><a href="<?php echo esc_url( home_url( '/#general-dentistry' ) ); ?>">General Dentistry</a></li>
									<li><a href="<?php echo esc_url( home_url( '/#cosmetic-dentistry' ) ); ?>">Cosmetic Dentistry</a></li>
									<li><a href="<?php echo esc_url( home_url( '/#dental-implants' ) ); ?>">Dental Implants</a></li>
									<li><a href="<?php echo esc_url( home_url( '/#invisalign' ) ); ?>">Invisalign</a></li>
								</ul>
							</div>
						</li>
						<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#fees-membership' ) ); ?>">Fees & Membership</a></li>
						<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#referrals' ) ); ?>">Referrals</a></li>
						<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#contact-us' ) ); ?>">Contact Us</a></li>
					</ul>
				</nav>
			</div>
		</div>

		<div id="content" class="site-content">
