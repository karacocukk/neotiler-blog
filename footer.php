<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package NeoTiler_Blog
 */

?>

</main><!-- #primary -->

<?php
$footer_bg = get_theme_mod('footer_bg_color', '#0f172a');
$footer_text = get_theme_mod('footer_text_color', '#cbd5e1');
$footer_link = get_theme_mod('footer_link_color', '#94a3b8');
$footer_heading = get_theme_mod('footer_heading_color', '#ffffff');
$footer_padding_y = get_theme_mod('footer_padding_y', 4);

// Sütun yapıları
$show_logo = get_theme_mod('footer_show_logo', true);
$brand_desc = get_theme_mod('footer_brand_desc', '');
$show_social = get_theme_mod('footer_show_social', true);

$col2_heading = get_theme_mod('footer_col2_heading', 'Categories');
$col2_html = get_theme_mod('footer_col2_custom_html', '');

$col3_heading = get_theme_mod('footer_col3_heading', 'Company');
$col3_html = get_theme_mod('footer_col3_custom_html', '');

$col4_heading = get_theme_mod('footer_col4_heading', 'Subscribe');
$col4_desc = get_theme_mod('footer_col4_desc', 'Get the latest news directly to your inbox. No spam, we promise.');
$show_newsletter = get_theme_mod('footer_show_newsletter', true);
$col4_html = get_theme_mod('footer_col4_custom_html', '');

$copyright_text = get_theme_mod('footer_copyright_text', 'All rights reserved.');
$powered_by_text = get_theme_mod('footer_powered_by_text', 'Powered by');
$powered_by_link = get_theme_mod('footer_powered_by_link_text', 'NEO');
$powered_by_url = get_theme_mod('footer_powered_by_url', 'https://getneotiler.com/');
?>

<footer id="colophon" class="site-footer border-t border-slate-800"
	style="background-color: <?php echo esc_attr($footer_bg); ?>; color: <?php echo esc_attr($footer_text); ?>; --neotiler-footer-link: <?php echo esc_attr($footer_link); ?>; --neotiler-footer-heading: <?php echo esc_attr($footer_heading); ?>; padding-top: <?php echo esc_attr($footer_padding_y); ?>rem; padding-bottom: <?php echo esc_attr($footer_padding_y); ?>rem; margin-top: 5rem;">
	<style>
		.site-footer a:not(.footer-social a) {
			color: var(--neotiler-footer-link);
			transition: color 0.3s ease;
		}

		.site-footer a:not(.footer-social a):hover {
			color: var(--neotiler-primary);
		}

		.site-footer .footer-social a {
			transition: color 0.3s ease;
		}

		.site-footer h3 {
			color: var(--neotiler-footer-heading);
		}

		.site-footer .nav-links-menu {
			display: flex;
			flex-direction: column;
			gap: 0.35rem;
			font-size: 0.875rem;
		}
	</style>
	<div class="container mx-auto px-4 max-w-[1200px]">
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-12 mb-12">
			<!-- Brand Column -->
			<div class="lg:col-span-2">
				<?php if ($show_logo): ?>
					<?php if (has_custom_logo()): ?>
						<div class="mb-4">
							<?php
							$custom_logo_id = get_theme_mod('custom_logo');
							$logo = wp_get_attachment_image_src($custom_logo_id, 'full');
							echo '<a href="' . esc_url(home_url('/')) . '" class="inline-block">';
							echo '<img src="' . esc_url($logo[0]) . '" alt="' . get_bloginfo('name') . '" class="h-10 w-auto object-contain">';
							echo '</a>';
							?>
						</div>
					<?php else: ?>
						<a href="<?php echo esc_url(home_url('/')); ?>" class="text-2xl font-black flex items-center gap-2 mb-4"
							style="color: <?php echo esc_attr($footer_heading); ?>;">
							<span
								class="w-8 h-8 bg-primary text-white flex items-center justify-center text-xl rounded-sm">N</span>
							<?php bloginfo('name'); ?>
						</a>
					<?php endif; ?>
				<?php endif; ?>

				<div class="text-sm mb-6 leading-relaxed opacity-80">
					<?php
					if (!empty($brand_desc)) {
						echo wp_kses_post($brand_desc);
					} else {
						echo get_bloginfo('description', 'display');
					}
					?>
				</div>

				<!-- Social Links -->
				<?php if ($show_social): ?>
					<div class="footer-social flex items-center gap-4">
						<?php if (get_theme_mod('neotiler_twitter_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_twitter_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="text-[#1DA1F2] hover:text-blue-400 transition-colors"
								aria-label="Twitter">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_youtube_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_youtube_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="text-[#FF0000] hover:text-red-400 transition-colors"
								aria-label="YouTube">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_instagram_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_instagram_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="text-[#E1306C] hover:text-pink-400 transition-colors"
								aria-label="Instagram">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_facebook_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_facebook_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="text-[#1877F2] hover:text-blue-400 transition-colors"
								aria-label="Facebook">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_pinterest_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_pinterest_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="text-[#BD081C] hover:text-red-500 transition-colors"
								aria-label="Pinterest">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M12 0c-6.627 0-12 5.372-12 12 0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738.098.119.112.224.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146 1.124.347 2.317.535 3.554.535 6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_linkedin_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_linkedin_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="text-[#0A66C2] hover:text-blue-400 transition-colors"
								aria-label="LinkedIn">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_tiktok_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_tiktok_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="text-slate-800 hover:text-slate-600 transition-colors"
								aria-label="TikTok">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
								</svg>
							</a>
						<?php endif; ?>
						<?php if (get_theme_mod('neotiler_reddit_url')): ?>
							<a href="<?php echo esc_url(get_theme_mod('neotiler_reddit_url')); ?>" target="_blank"
								rel="noopener noreferrer" class="text-[#FF4500] hover:text-orange-400 transition-colors"
								aria-label="Reddit">
								<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
									<path
										d="M24 11.779c0-1.459-1.192-2.645-2.657-2.645-.715 0-1.363.286-1.84.746-1.81-1.191-4.259-1.949-6.971-2.046l1.483-4.669 4.016.941-.006.058c0 1.193.975 2.163 2.174 2.163 1.198 0 2.172-.97 2.172-2.163s-.975-2.164-2.172-2.164c-.92 0-1.704.574-2.021 1.379l-4.329-1.015c-.189-.046-.381.063-.44.249l-1.654 5.207c-2.838.034-5.409.798-7.3 2.025-.474-.438-1.103-.712-1.799-.712-1.465 0-2.656 1.187-2.656 2.646 0 .97.533 1.811 1.317 2.271-.052.282-.086.567-.086.857 0 3.911 4.808 7.093 10.719 7.093s10.72-3.182 10.72-7.093c0-.274-.031-.542-.075-.81.8-.464 1.341-1.311 1.341-2.283zm-14.373 1.984c0-.769.645-1.393 1.441-1.393.194 0 .379.036.553.1.585.218.978.786.978 1.432 0 .769-.646 1.392-1.442 1.392-.795 0-1.441-.623-1.441-1.392l-.089-.139zm7.402 4.503c-1.298 1.303-4.042 1.405-5.028 1.405s-3.731-.102-5.028-1.405c-.165-.166-.165-.435 0-.6.163-.166.432-.166.596 0 .818.817 2.563 1.108 4.432 1.108s3.614-.291 4.432-1.108c.164-.166.433-.166.596 0 .166.165.166.434 0 .6zm-.099-3.11c-.795 0-1.44-.624-1.44-1.393 0-.646.393-1.214.978-1.432.174-.064.359-.1.553-.1.796 0 1.441.624 1.441 1.393 0 .769-.645 1.392-1.441 1.392l-.091.14z" />
								</svg>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<!-- Menu Column 2 -->
			<div class="lg:col-span-1">
				<?php if (!empty($col2_heading)): ?>
					<h3 class="font-semibold tracking-wide uppercase text-sm"
						style="border-bottom: 1px solid rgba(148,163,184,0.3); display: inline-block; padding-bottom: 4px; margin-bottom: 12px;">
						<?php echo esc_html($col2_heading); ?>
					</h3>
					<div class="mb-0"></div>
				<?php endif; ?>

				<?php
				if (!empty($col2_html)) {
					echo wp_kses_post($col2_html);
				} elseif (has_nav_menu('footer-categories')) {
					wp_nav_menu(array(
						'theme_location' => 'footer-categories',
						'container' => false,
						'menu_class' => 'nav-links-menu',
						'depth' => 1,
					));
				} else {
					// Fallback
					?>
					<ul class="nav-links-menu">
						<li><a href="#">Technology</a></li>
						<li><a href="#">Reviews</a></li>
						<li><a href="#">Software</a></li>
						<li><a href="#">Hardware</a></li>
					</ul>
				<?php } ?>
			</div>

			<!-- Menu Column 3 -->
			<div class="lg:col-span-1">
				<?php if (!empty($col3_heading)): ?>
					<h3 class="font-semibold tracking-wide uppercase text-sm"
						style="border-bottom: 1px solid rgba(148,163,184,0.3); display: inline-block; padding-bottom: 4px; margin-bottom: 12px;">
						<?php echo esc_html($col3_heading); ?>
					</h3>
					<div class="mb-0"></div>
				<?php endif; ?>

				<?php
				if (!empty($col3_html)) {
					echo wp_kses_post($col3_html);
				} elseif (has_nav_menu('footer-links')) {
					wp_nav_menu(array(
						'theme_location' => 'footer-links',
						'container' => false,
						'menu_class' => 'nav-links-menu',
						'depth' => 1,
					));
				} else {
					// Fallback
					?>
					<ul class="nav-links-menu">
						<li><a href="#">About Us</a></li>
						<li><a href="#">Contact</a></li>
						<li><a href="#">Privacy Policy</a></li>
						<li><a href="#">Terms of Service</a></li>
					</ul>
				<?php } ?>
			</div>

			<!-- Newsletter Column 4 -->
			<div class="lg:col-span-2">
				<?php if (!empty($col4_heading)): ?>
					<h3 class="font-semibold tracking-wide uppercase text-sm"
						style="border-bottom: 1px solid rgba(148,163,184,0.3); display: inline-block; padding-bottom: 4px; margin-bottom: 12px;">
						<?php echo esc_html($col4_heading); ?>
					</h3>
					<div class="mb-0"></div>
				<?php endif; ?>

				<?php if (!empty($col4_desc)): ?>
					<p class="text-sm mb-4 opacity-80"><?php echo esc_html($col4_desc); ?></p>
				<?php endif; ?>

				<?php
				if (!empty($col4_html)) {
					echo do_shortcode($col4_html);
				} elseif (get_theme_mod('footer_show_newsletter', true)) {
					// Fallback Mailchimp URL from the code block you provided
					$default_mailchimp_url = 'https://getneotiler.us2.list-manage.com/subscribe/post?u=88143aa1857892e3a7a873903&amp;id=1f999c82cd&amp;f_id=006ba6e0f0';
					$mailchimp_url = get_theme_mod('footer_mailchimp_url', $default_mailchimp_url);

					// Just in case it's actually empty at setting level
					if (empty($mailchimp_url)) {
						$mailchimp_url = $default_mailchimp_url;
					}
					?>
					<form action="<?php echo esc_url($mailchimp_url); ?>" method="post" target="_blank"
						class="flex flex-col gap-3 mt-2">
						<input type="email" name="EMAIL" placeholder="Your email address" required
							class="bg-white border border-gray-300 text-black px-4 py-3 rounded focus:ring-2 focus:ring-primary outline-none w-full text-sm placeholder:text-gray-500 shadow-sm">

						<!-- Hidden input for Mailchimp bot protection -->
						<div aria-hidden="true" style="position: absolute; left: -5000px;">
							<input type="text" name="b_88143aa1857892e3a7a873903_1f999c82cd" tabindex="-1" value="">
						</div>

						<button type="submit"
							class="bg-black hover:bg-primary text-white font-semibold px-4 py-3 rounded transition-colors w-full text-sm shadow-md">
							Subscribe
						</button>
					</form>
				<?php } ?>
			</div>
		</div>

		<!-- Copyright Area -->
		<div
			class="pt-8 border-t border-slate-800/50 flex flex-col md:flex-row items-center justify-between text-xs opacity-60">

			<p>
				<?php
				if (empty($copyright_text) || $copyright_text === 'All rights reserved.') {
					// Default fallback if default or empty
					echo '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.';
				} else {
					// Show user's exact text
					echo esc_html($copyright_text);
				}
				?>
			</p>

			<?php if (!empty($powered_by_text) || !empty($powered_by_link)): ?>
				<p class="mt-2 md:mt-0">
					<?php echo esc_html($powered_by_text); ?>
					<?php if (!empty($powered_by_link) && !empty($powered_by_url)): ?>
						<a href="<?php echo esc_url($powered_by_url); ?>" target="_blank"
							class="hover:opacity-100 transition-opacity"><?php echo esc_html($powered_by_link); ?></a>
					<?php elseif (!empty($powered_by_link)): ?>
						<?php echo esc_html($powered_by_link); ?>
					<?php endif; ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>