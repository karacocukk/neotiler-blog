<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NeoTiler_Blog
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page"
		class="site bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 min-h-screen flex flex-col transition-colors duration-300">
		<a class="skip-link screen-reader-text sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-primary text-white px-4 py-2 z-50"
			href="#primary"><?php esc_html_e('Skip to content', 'neotiler-blog'); ?></a>

		<!-- Top Bar (Date & Socials) -->
		<div
			class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 text-xs font-semibold text-slate-900 dark:text-white py-1.5 hidden md:block transition-colors duration-300">
			<div class="container mx-auto px-4 max-w-[1200px] flex items-center justify-between">
				<!-- Date -->
				<div class="flex items-center gap-2 tracking-wide uppercase">
					<?php echo date_i18n('j F Y, l'); ?>
				</div>
				<!-- Socials -->
				<div class="flex items-center gap-4">
					<span class="uppercase tracking-widest text-[10px] font-bold text-slate-900 dark:text-white">FOLLOW
						ME:</span>
					<div class="flex items-center gap-3">
						<?php if (get_theme_mod('neotiler_twitter_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_twitter_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="hover:text-blue-500 transition-colors"
								aria-label="Twitter">
								<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_youtube_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_youtube_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="hover:text-red-600 transition-colors" aria-label="YouTube">
								<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_instagram_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_instagram_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="hover:text-pink-600 transition-colors"
								aria-label="Instagram">
								<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_facebook_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_facebook_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="hover:text-blue-700 transition-colors"
								aria-label="Facebook">
								<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_pinterest_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_pinterest_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="hover:text-red-700 transition-colors"
								aria-label="Pinterest">
								<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M12 0c-6.627 0-12 5.372-12 12 0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146 1.124.347 2.317.535 3.554.535 6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_linkedin_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_linkedin_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="hover:text-blue-600 transition-colors"
								aria-label="LinkedIn">
								<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_tiktok_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_tiktok_url')); ?>" target="_blank"
								rel="noopener noreferrer"
								class="hover:text-slate-900 dark:hover:text-white transition-colors" aria-label="TikTok">
								<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_reddit_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_reddit_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="hover:text-orange-600 transition-colors"
								aria-label="Reddit">
								<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M24 11.779c0-1.459-1.192-2.645-2.657-2.645-.715 0-1.363.286-1.84.746-1.81-1.191-4.259-1.949-6.971-2.046l1.483-4.669 4.016.941-.006.058c0 1.193.975 2.163 2.174 2.163 1.198 0 2.172-.97 2.172-2.163s-.975-2.164-2.172-2.164c-.92 0-1.704.574-2.021 1.379l-4.329-1.015c-.189-.046-.381.063-.44.249l-1.654 5.207c-2.838.034-5.409.798-7.3 2.025-.474-.438-1.103-.712-1.799-.712-1.465 0-2.656 1.187-2.656 2.646 0 .97.533 1.811 1.317 2.271-.052.282-.086.567-.086.857 0 3.911 4.808 7.093 10.719 7.093s10.72-3.182 10.72-7.093c0-.274-.031-.542-.075-.81.8-.464 1.341-1.311 1.341-2.283zm-14.373 1.984c0-.769.645-1.393 1.441-1.393.194 0 .379.036.553.1.585.218.978.786.978 1.432 0 .769-.646 1.392-1.442 1.392-.795 0-1.441-.623-1.441-1.392l-.089-.139zm7.402 4.503c-1.298 1.303-4.042 1.405-5.028 1.405s-3.731-.102-5.028-1.405c-.165-.166-.165-.435 0-.6.163-.166.432-.166.596 0 .818.817 2.563 1.108 4.432 1.108s3.614-.291 4.432-1.108c.164-.166.433-.166.596 0 .166.165.166.434 0 .6zm-.099-3.11c-.795 0-1.44-.624-1.44-1.393 0-.646.393-1.214.978-1.432.174-.064.359-.1.553-.1.796 0 1.441.624 1.441 1.393 0 .769-.645 1.392-1.441 1.392l-.091.14z" />
								</svg>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Main Header with Tailwind -->
		<header id="masthead"
			class="site-header relative z-40 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 transition-colors duration-300">
			<div class="container mx-auto px-4 max-w-[1200px]">
				<div class="flex items-center justify-between h-20 md:h-24 relative">

					<!-- Mobile Hamburger (Left) -->
					<button
						class="lg:hidden menu-toggle p-2 text-slate-600 dark:text-slate-400 flex-shrink-0 z-10 relative"
						aria-label="<?php esc_attr_e('Toggle mobile menu', 'neotiler-blog'); ?>"
						aria-controls="mobile-drawer" aria-expanded="false">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M4 6h16M4 12h16M4 18h16"></path>
						</svg>
					</button>

					<!-- Left Area: Logo -->
					<?php
					$logo_height = max(10, absint(get_theme_mod('neotiler_logo_height', 40)));
					$logo_width = absint(get_theme_mod('neotiler_logo_width', 0));
					$mobile_logo_height = absint(get_theme_mod('neotiler_mobile_logo_height', 0));
					$mobile_logo_width = absint(get_theme_mod('neotiler_mobile_logo_width', 0));
					?>
					<div class="site-branding flex-shrink-0 flex items-center gap-2 z-10 relative">
						<?php if (has_custom_logo()): ?>
							<?php the_custom_logo(); ?>
							<style>
								.site-header .custom-logo,
								.site-branding .custom-logo-link img {
									height:
										<?php echo $logo_height; ?>
										px !important;
									<?php echo $logo_width > 0 ? "width: " . $logo_width . "px !important;" : "width: auto !important;"; ?>
									max-height: none !important;
									object-fit: contain !important;
								}

								@media (max-width: 1023px) {

									.site-header .custom-logo,
									.site-branding .custom-logo-link img {
										<?php if ($mobile_logo_height > 0)
											echo "height: {$mobile_logo_height}px !important;\n"; ?>
										<?php if ($mobile_logo_width > 0)
											echo "width: {$mobile_logo_width}px !important;\n"; ?>
									}
								}
							</style>
						<?php else: ?>
							<a href="<?php echo esc_url(home_url('/')); ?>" rel="home"
								class="text-3xl font-black tracking-tighter text-slate-900 dark:text-white flex items-center gap-2">
								<?php bloginfo('name'); ?>
							</a>
						<?php endif; ?>
					</div>

					<!-- Navigation Section (Flow layout) -->
					<nav id="site-navigation"
						class="hidden lg:flex flex-1 items-center justify-center pl-8 xl:pl-16 -translate-x-[10px]">
						<div class="">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'menu_id' => 'primary-menu',
									'container' => false,
									'menu_class' => 'flex items-center gap-6 xl:gap-8 text-[13px] font-bold tracking-widest uppercase text-slate-800 dark:text-white',
									'fallback_cb' => false,
								)
							);
							?>
						</div>
					</nav>

					<!-- Right Area: Actions -->
					<div class="flex items-center justify-end gap-3 flex-shrink-0 z-10 relative">

						<!-- Search Button -->
						<button id="search-toggle" aria-label="Search"
							class="p-2 text-slate-600 hover:text-primary dark:text-slate-200 dark:hover:text-white transition-colors">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
							</svg>
						</button>

						<!-- Dark Mode Toggle Button -->
						<button id="theme-toggle" aria-label="Toggle Dark Mode"
							class="p-2 text-slate-600 hover:text-blue-600 dark:text-white dark:hover:text-amber-400 transition-colors">
							<!-- Moon Icon -->
							<svg class="w-6 h-6 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
								</path>
							</svg>
							<!-- Sun Icon -->
							<svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor"
								viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
								</path>
							</svg>
						</button>


					</div>
				</div>
			</div>
		</header><!-- #masthead -->
		<!-- Search Overlay -->
		<div id="search-overlay"
			class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm items-center justify-center">
			<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-xl mx-4 p-6 relative">
				<button id="search-close"
					class="absolute top-3 right-3 text-slate-400 hover:text-slate-700 dark:hover:text-white transition-colors"
					aria-label="Close">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
						</path>
					</svg>
				</button>
				<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
					<label
						class="block text-sm font-semibold text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-wider">Search</label>
					<div class="relative">
						<input id="search-input" type="search" name="s" placeholder="What are you looking for?"
							class="w-full px-5 py-4 text-lg bg-slate-100 dark:bg-slate-700 text-slate-900 dark:text-white rounded-xl border-2 border-transparent focus:border-blue-500 focus:outline-none transition-colors"
							value="<?php echo get_search_query(); ?>" />
						<button type="submit"
							class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-500 transition-colors">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
							</svg>
						</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Mobile Drawer Menu -->
		<div id="mobile-drawer-overlay"
			class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity duration-300 opacity-0"></div>
		<nav id="mobile-drawer"
			class="fixed top-[var(--wp-admin--admin-bar--height,0px)] left-0 h-[calc(100%-var(--wp-admin--admin-bar--height,0px))] w-[85%] max-w-sm bg-white dark:bg-slate-900 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto shadow-2xl">
			<!-- Drawer Header -->
			<div class="flex items-center justify-between p-5 border-b border-slate-200 dark:border-slate-700">
				<div class="flex-shrink-0 drawer-logo">
					<?php if (has_custom_logo()): ?>
						<?php the_custom_logo(); ?>
						<style>
							#mobile-drawer .custom-logo,
							#mobile-drawer .custom-logo-link img {
								height:
									<?php echo $mobile_logo_height > 0 ? $mobile_logo_height : $logo_height; ?>
									px !important;
								<?php
								$target_width = $mobile_logo_width > 0 ? $mobile_logo_width : $logo_width;
								echo $target_width > 0 ? "width: {$target_width}px !important;" : "width: auto !important;";
								?>
								max-height: none !important;
								object-fit: contain !important;
							}
						</style>
					<?php else: ?>
						<a href="<?php echo esc_url(home_url('/')); ?>"
							class="text-2xl font-black text-slate-900 dark:text-white">
							<?php bloginfo('name'); ?>
						</a>
					<?php endif; ?>
				</div>
				<button id="drawer-close"
					class="p-2 text-slate-400 hover:text-slate-700 dark:hover:text-white transition-colors"
					aria-label="Close menu">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
						</path>
					</svg>
				</button>
			</div>
			<!-- Drawer Navigation -->
			<div class="px-5 py-6">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id' => 'mobile-primary-menu',
						'container' => false,
						'menu_class' => 'flex flex-col',
						'fallback_cb' => false,
						'link_before' => '<span class="block py-4 text-base font-bold tracking-wider uppercase text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-slate-800 hover:text-blue-500 transition-colors">',
						'link_after' => '</span>',
					)
				);
				?>
			</div>
			<!-- Drawer Social Icons -->
			<div class="px-5 pt-4 pb-6 border-t border-slate-100 dark:border-slate-800">
				<div class="flex items-center gap-4">
					<?php if (get_theme_mod('neotiler_twitter_url')): ?>
						<a href="<?php echo esc_url(get_theme_mod('neotiler_twitter_url')); ?>" target="_blank"
							rel="noopener noreferrer" class="text-blue-500 hover:text-blue-600 transition-colors"
							aria-label="Twitter">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
								<path
									d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
							</svg>
						</a>
					<?php endif; ?>
					<?php if (get_theme_mod('neotiler_youtube_url')): ?>
						<a href="<?php echo esc_url(get_theme_mod('neotiler_youtube_url')); ?>" target="_blank"
							rel="noopener noreferrer" class="text-red-600 hover:text-red-700 transition-colors"
							aria-label="YouTube">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
								<path
									d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
							</svg>
						</a>
					<?php endif; ?>
					<?php if (get_theme_mod('neotiler_instagram_url')): ?>
						<a href="<?php echo esc_url(get_theme_mod('neotiler_instagram_url')); ?>" target="_blank"
							rel="noopener noreferrer" class="text-pink-600 hover:text-pink-700 transition-colors"
							aria-label="Instagram">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
								<path
									d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
							</svg>
						</a>
					<?php endif; ?>
					<?php if (get_theme_mod('neotiler_facebook_url')): ?>
						<a href="<?php echo esc_url(get_theme_mod('neotiler_facebook_url')); ?>" target="_blank"
							rel="noopener noreferrer" class="text-blue-700 hover:text-blue-800 transition-colors"
							aria-label="Facebook">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
								<path
									d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
							</svg>
						</a>
					<?php endif; ?>
					<?php if (get_theme_mod('neotiler_pinterest_url')): ?>
						<a href="<?php echo esc_url(get_theme_mod('neotiler_pinterest_url')); ?>" target="_blank"
							rel="noopener noreferrer" class="text-red-700 hover:text-red-800 transition-colors"
							aria-label="Pinterest">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
								<path
									d="M12 0c-6.627 0-12 5.372-12 12 0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146 1.124.347 2.317.535 3.554.535 6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z" />
							</svg>
						</a>
					<?php endif; ?>
					<?php if (get_theme_mod('neotiler_linkedin_url')): ?>
						<a href="<?php echo esc_url(get_theme_mod('neotiler_linkedin_url')); ?>" target="_blank"
							rel="noopener noreferrer" class="text-blue-600 hover:text-blue-700 transition-colors"
							aria-label="LinkedIn">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
								<path
									d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
							</svg>
						</a>
					<?php endif; ?>
					<?php if (get_theme_mod('neotiler_tiktok_url')): ?>
						<a href="<?php echo esc_url(get_theme_mod('neotiler_tiktok_url')); ?>" target="_blank"
							rel="noopener noreferrer"
							class="text-slate-800 dark:text-white hover:text-slate-600 transition-colors"
							aria-label="TikTok">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
								<path
									d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
							</svg>
						</a>
					<?php endif; ?>
					<?php if (get_theme_mod('neotiler_reddit_url')): ?>
						<a href="<?php echo esc_url(get_theme_mod('neotiler_reddit_url')); ?>" target="_blank"
							rel="noopener noreferrer" class="text-orange-600 hover:text-orange-700 transition-colors"
							aria-label="Reddit">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
								<path
									d="M24 11.779c0-1.459-1.192-2.645-2.657-2.645-.715 0-1.363.286-1.84.746-1.81-1.191-4.259-1.949-6.971-2.046l1.483-4.669 4.016.941-.006.058c0 1.193.975 2.163 2.174 2.163 1.198 0 2.172-.97 2.172-2.163s-.975-2.164-2.172-2.164c-.92 0-1.704.574-2.021 1.379l-4.329-1.015c-.189-.046-.381.063-.44.249l-1.654 5.207c-2.838.034-5.409.798-7.3 2.025-.474-.438-1.103-.712-1.799-.712-1.465 0-2.656 1.187-2.656 2.646 0 .97.533 1.811 1.317 2.271-.052.282-.086.567-.086.857 0 3.911 4.808 7.093 10.719 7.093s10.72-3.182 10.72-7.093c0-.274-.031-.542-.075-.81.8-.464 1.341-1.311 1.341-2.283zm-14.373 1.984c0-.769.645-1.393 1.441-1.393.194 0 .379.036.553.1.585.218.978.786.978 1.432 0 .769-.646 1.392-1.442 1.392-.795 0-1.441-.623-1.441-1.392l-.089-.139zm7.402 4.503c-1.298 1.303-4.042 1.405-5.028 1.405s-3.731-.102-5.028-1.405c-.165-.166-.165-.435 0-.6.163-.166.432-.166.596 0 .818.817 2.563 1.108 4.432 1.108s3.614-.291 4.432-1.108c.164-.166.433-.166.596 0 .166.165.166.434 0 .6zm-.099-3.11c-.795 0-1.44-.624-1.44-1.393 0-.646.393-1.214.978-1.432.174-.064.359-.1.553-.1.796 0 1.441.624 1.441 1.393 0 .769-.645 1.392-1.441 1.392l-.091.14z" />
							</svg>
						</a>
					<?php endif; ?>
				</div>
				<p class="text-xs text-slate-400 dark:text-slate-500 mt-4"><?php bloginfo('description'); ?></p>
			</div>
		</nav>
		<main id="primary" class="site-main flex-grow">