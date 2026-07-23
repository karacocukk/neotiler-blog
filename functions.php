<?php
/**
 * NeoTiler Blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NeoTiler_Blog
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function neotiler_blog_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on NeoTiler Blog, use a find and replace
	 * to change 'neotiler-blog' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('neotiler-blog', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'neotiler-blog'),
			'header-left' => esc_html__('Header Left Menu', 'neotiler-blog'),
			'header-right' => esc_html__('Header Right Menu', 'neotiler-blog'),
			'footer-categories' => esc_html__('Footer Categories', 'neotiler-blog'),
			'footer-links' => esc_html__('Footer Links', 'neotiler-blog'),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'neotiler_blog_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'neotiler_blog_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function neotiler_blog_content_width()
{
	$GLOBALS['content_width'] = apply_filters('neotiler_blog_content_width', 640);
}
add_action('after_setup_theme', 'neotiler_blog_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function neotiler_blog_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'neotiler-blog'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'neotiler-blog'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'neotiler_blog_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function neotiler_blog_scripts()
{
	$theme_version = wp_get_theme()->get('Version');
	$css_version = file_exists(get_template_directory() . '/style.css') ? filemtime(get_template_directory() . '/style.css') : $theme_version;

	// --- Smart Hybrid Font Loading ---
	$body_font = get_theme_mod('neotiler_body_font', 'Inter');
	$heading_font = get_theme_mod('neotiler_heading_font', 'Inter');
	$nav_font = get_theme_mod('neotiler_nav_font', 'Montserrat');

	$selected_fonts = array_unique(array($body_font, $heading_font, $nav_font));
	$local_fonts = array('Inter', 'Montserrat');

	// Local font CSS'ini her ihtimale karşı yükle (kısmi kullanımlar için)
	wp_enqueue_style('neotiler-local-fonts', get_template_directory_uri() . '/assets/css/local-fonts.css', array(), $theme_version);

	// Google Fonts API'den çekilecek fontları belirle
	$google_fonts_needed = array_diff($selected_fonts, $local_fonts);

	$google_fonts_deps = array('neotiler-local-fonts');

	if (!empty($google_fonts_needed)) {
		$font_families = array();
		foreach ($google_fonts_needed as $font) {
			$font_families[] = str_replace(' ', '+', $font) . ':wght@400;500;600;700;800;900';
		}
		$google_fonts_url = 'https://fonts.googleapis.com/css2?' . implode('&', array_map(function ($f) {
			return 'family=' . $f;
		}, $font_families)) . '&display=swap';

		wp_enqueue_style('neotiler-google-fonts', $google_fonts_url, array(), null);
		$google_fonts_deps[] = 'neotiler-google-fonts';
	}

	wp_enqueue_style('neotiler-blog-style', get_stylesheet_uri(), $google_fonts_deps, $css_version);
	wp_style_add_data('neotiler-blog-style', 'rtl', 'replace');

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	// Emoji Picker Elements (Modern Library) - Only on single posts with comments
	if (is_singular() && comments_open()) {
		wp_enqueue_script('emoji-picker-element', 'https://cdn.jsdelivr.net/npm/emoji-picker-element@1/index.js', array(), '1.0.0', true);

		// Add type="module" for emoji-picker-element
		add_filter('script_loader_tag', function ($tag, $handle, $src) {
			if ('emoji-picker-element' === $handle) {
				return '<script type="module" src="' . esc_url($src) . '"></script>';
			}
			return $tag;
		}, 10, 3);
	}

	// Theme JS (dark mode, search, mobile menu)
	wp_enqueue_script('neotiler-theme-js', get_template_directory_uri() . '/js/theme.js', array(), $theme_version, true);

	// Localize script for AJAX calls
	wp_localize_script('neotiler-theme-js', 'neotiler_ajax', array(
		'ajaxurl' => admin_url('admin-ajax.php')
	));
}
add_action('wp_enqueue_scripts', 'neotiler_blog_scripts');

/**
 * Post View Counter — Günlük + All-time görüntülenme takibi.
 * Her gün için ayrı meta key (neotiler_views_20260227 gibi) tutar.
 * All-time toplam: neotiler_post_views
 */
function neotiler_set_post_views($post_id)
{
	if (is_admin() || defined('DOING_AJAX') || defined('DOING_CRON'))
		return;

	// All-time sayaç
	$count = (int) get_post_meta($post_id, 'neotiler_post_views', true);
	update_post_meta($post_id, 'neotiler_post_views', $count + 1);

	// Günlük sayaç (rolling 7-gün trending için)
	$today_key = 'neotiler_views_' . date('Ymd');
	$daily = (int) get_post_meta($post_id, $today_key, true);
	update_post_meta($post_id, $today_key, $daily + 1);
}

function neotiler_track_post_views()
{
	if (is_single()) {
		neotiler_set_post_views(get_the_ID());
	}
}
add_action('wp_head', 'neotiler_track_post_views');

// ─── SEO: Arşiv Sayfaları Noindex ────────────────────────────────────────────
function neotiler_noindex_archives() {
    if (is_tag() || is_category() || is_author()) {
        echo '<meta name="robots" content="noindex, follow" />' . PHP_EOL;
    }
}
add_action('wp_head', 'neotiler_noindex_archives', 1);


function neotiler_get_post_views($post_id)
{
	return (int) get_post_meta($post_id, 'neotiler_post_views', true);
}

/**
 * Trending Posts — Son 7 günün en çok okunanları.
 * Gece 12'ye kadar cache'li kalır, 12'den sonra ilk ziyarette yeniden hesaplanır.
 * @param int $count Kaç post dönsün (varsayılan 6)
 * @return array Post ID listesi
 */
function neotiler_get_trending_post_ids($count = 6)
{
	// v2: force refresh — cache'i bir kez temizle
	if (!get_option('neotiler_trending_v2')) {
		delete_transient('neotiler_trending_ids');
		update_option('neotiler_trending_v2', true);
	}

	$cached = get_transient('neotiler_trending_ids');
	if ($cached !== false && is_array($cached) && count($cached) >= $count) {
		return $cached;
	}
	// Eğer cache'deki sonuç sayısı yetersizse, yeniden hesapla
	delete_transient('neotiler_trending_ids');

	// Son 7 günün meta key'leri
	$meta_keys = array();
	for ($i = 0; $i < 7; $i++) {
		$meta_keys[] = 'neotiler_views_' . date('Ymd', strtotime("-{$i} days"));
	}

	// Tüm yayınlanmış postları çek ve 7 günlük toplamlarını hesapla
	global $wpdb;
	$placeholders = implode(',', array_fill(0, count($meta_keys), '%s'));
	$sql = $wpdb->prepare(
		"SELECT p.ID, COALESCE(SUM(CAST(pm.meta_value AS UNSIGNED)), 0) AS weekly_views
		 FROM {$wpdb->posts} p
		 INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
		 WHERE p.post_type = 'post' AND p.post_status = 'publish'
		   AND pm.meta_key IN ({$placeholders})
		 GROUP BY p.ID
		 ORDER BY weekly_views DESC
		 LIMIT %d",
		array_merge($meta_keys, array($count))
	);
	$results = $wpdb->get_results($sql);

	$ids = array();
	if ($results) {
		foreach ($results as $row) {
			$ids[] = (int) $row->ID;
		}
	}

	// Eksik kalan yerleri en son yazılarla doldur (Fallback)
	if (count($ids) < $count) {
		$needed = $count - count($ids);
		$latest_ids = get_posts(array(
			'posts_per_page' => $needed,
			'post__not_in' => $ids,
			'fields' => 'ids',
			'orderby' => 'date',
			'order' => 'DESC',
		));
		if (!empty($latest_ids)) {
			$ids = array_merge($ids, $latest_ids);
		}
	}

	// Gece 12'ye kadar cache'le
	$midnight = strtotime('tomorrow midnight');
	$seconds_until_midnight = $midnight - time();
	set_transient('neotiler_trending_ids', $ids, $seconds_until_midnight);

	return $ids;
}

/**
 * 8 günden eski günlük view meta kayıtlarını temizle (performans için).
 */
function neotiler_cleanup_old_daily_views()
{
	global $wpdb;
	$cutoff = date('Ymd', strtotime('-8 days'));
	$wpdb->query(
		$wpdb->prepare(
			"DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE %s AND meta_key < %s",
			'neotiler_views_%',
			'neotiler_views_' . $cutoff
		)
	);
}
// Günde bir kez temizlik yap
if (!wp_next_scheduled('neotiler_daily_cleanup')) {
	wp_schedule_event(time(), 'daily', 'neotiler_daily_cleanup');
}
add_action('neotiler_daily_cleanup', 'neotiler_cleanup_old_daily_views');


/**
 * Font CSS Custom Properties — <head> içine inline CSS olarak ekler.
 * Tüm tipografi ayarlarını dinamik CSS değişkenleri ile uygular.
 * Responsive ve Dark Mode desteği dahil.
 */
function neotiler_blog_font_custom_properties()
{
	$body_font = get_theme_mod('neotiler_body_font', 'Inter');
	$heading_font = get_theme_mod('neotiler_heading_font', 'Inter');
	$nav_font = get_theme_mod('neotiler_nav_font', 'Montserrat');

	$body_size = get_theme_mod('neotiler_body_font_size', '1');
	$body_weight = get_theme_mod('neotiler_body_font_weight', '500');
	$body_lh = get_theme_mod('neotiler_body_line_height', '1.6');

	$heading_weight = get_theme_mod('neotiler_heading_font_weight', '700');
	$heading_ls = get_theme_mod('neotiler_heading_letter_spacing', '-0.025');
	$h1_size = get_theme_mod('neotiler_h1_font_size', '3');
	$h2_size = get_theme_mod('neotiler_h2_font_size', '2');
	$h3_size = get_theme_mod('neotiler_h3_font_size', '1.5');

	$nav_size = get_theme_mod('neotiler_nav_font_size', '0.9');
	$nav_weight = get_theme_mod('neotiler_nav_font_weight', '700');

	$meta_size = get_theme_mod('neotiler_meta_font_size', '0.75');
	$btn_radius = get_theme_mod('neotiler_btn_border_radius', '0');
	?>
	<style id="neotiler-font-properties">
		:root {
			font-size: 16px;
			/* Font Families */
			--font-body: '<?php echo esc_attr($body_font); ?>', system-ui, -apple-system, sans-serif;
			--font-heading: '<?php echo esc_attr($heading_font); ?>', system-ui, -apple-system, sans-serif;
			--font-nav: '<?php echo esc_attr($nav_font); ?>', system-ui, -apple-system, sans-serif;

			/* Body */
			--font-body-size:
				<?php echo str_replace(',', '.', esc_attr($body_size)); ?>rem;
				--font-body-weight:
				<?php echo esc_attr($body_weight); ?>;
				--font-body-line-height:
				<?php echo str_replace(',', '.', esc_attr($body_lh)); ?>;

				/* Headings */
				--font-heading-weight:
				<?php echo esc_attr($heading_weight); ?>;
				--font-heading-letter-spacing:
				<?php echo str_replace(',', '.', esc_attr($heading_ls)); ?>em;
				--font-h1-size:
				<?php echo str_replace(',', '.', esc_attr($h1_size)); ?>rem;
				--font-h2-size:
				<?php echo str_replace(',', '.', esc_attr($h2_size)); ?>rem;
				--font-h3-size:
				<?php echo str_replace(',', '.', esc_attr($h3_size)); ?>rem;

				/* Navigation */
				--font-nav-size:
				<?php echo str_replace(',', '.', esc_attr($nav_size)); ?>rem;
				--font-nav-weight:
				<?php echo esc_attr($nav_weight); ?>;

				/* Meta & Buttons */
				--font-meta-size:
				<?php echo str_replace(',', '.', esc_attr($meta_size)); ?>rem;
				--btn-border-radius:
				<?php echo esc_attr($btn_radius); ?>px;

				/* Colors — Light Mode */
				--color-body-text: #3a3a3a;
			--color-heading-text: #1a1a1a;
		}

		/* ─── Base Typography ─── */
		html {
			font-size: 100% !important;
		}

		body {
			font-family: var(--font-body);
			font-size: var(--font-body-size);
			font-weight: var(--font-body-weight);
			line-height: var(--font-body-line-height);
			color: var(--color-body-text);
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6,
		.entry-title,
		.site-title {
			font-family: var(--font-heading);
			font-weight: var(--font-heading-weight);
			letter-spacing: var(--font-heading-letter-spacing);
		}

		/* Entry content içindeki başlıklar — sadece makalede renk uygula */
		.entry-content h1,
		.entry-content h2,
		.entry-content h3,
		.entry-content h4,
		.entry-content h5,
		.entry-content h6 {
			color: var(--color-heading-text);
		}

		.entry-content h1 {
			font-size: var(--font-h1-size);
		}

		.entry-content h2 {
			font-size: var(--font-h2-size);
		}

		.entry-content h3 {
			font-size: var(--font-h3-size);
		}

		/* Heading spacing — nefes alan boşluklar */
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			margin-top: 0;
			margin-bottom: 0;
			line-height: 1.2;
		}

		.entry-content h1,
		.entry-content h2,
		.entry-content h3,
		.entry-content h4,
		.entry-content h5,
		.entry-content h6 {
			margin-top: 2em;
			margin-bottom: 0.75em;
		}

		/* Body paragraphs */
		p {
			line-height: var(--font-body-line-height);
			margin-bottom: 1.25em;
		}

		/* ─── Navigation ─── */
		#site-navigation,
		#site-navigation ul,
		#site-navigation ul li,
		#site-navigation ul li a,
		.main-navigation,
		.main-navigation a {
			font-family: var(--font-nav) !important;
			font-size: var(--font-nav-size) !important;
			font-weight: var(--font-nav-weight) !important;
			text-transform: uppercase !important;
		}

		/* ─── Meta & Buttons ─── */
		.entry-meta,
		.cat-links,
		.tags-links,
		.posted-on,
		.byline,
		.entry-footer,
		time,
		.post-date,
		.post-categories {
			font-size: var(--font-meta-size);
			font-weight: 600;
			text-transform: uppercase;
			letter-spacing: 0.05em;
		}

		/* ─── Butonlar ─── */
		button,
		.btn,
		input[type="submit"],
		input[type="button"],
		a.btn,
		.wp-block-button__link {
			border-radius: var(--btn-border-radius);
			font-family: var(--font-nav);
			font-weight: 700;
		}

		/* ─── Dark Mode ─── */
		.dark {
			--color-body-text: #dbdbdb;
			--color-heading-text: #ffffff;
		}

		.dark body,
		html.dark body {
			background-color: #0a0c0d;
			color: var(--color-body-text);
		}

		.dark .entry-content h1,
		.dark .entry-content h2,
		.dark .entry-content h3,
		.dark .entry-content h4,
		.dark .entry-content h5,
		.dark .entry-content h6 {
			color: var(--color-heading-text);
		}

		/* ─── Responsive — Mobil ─── */
		@media (max-width: 768px) {
			:root {
				--font-h1-size: 2rem;
				--font-h2-size: 1.5rem;
				--font-h3-size: 1.25rem;
			}
		}
	</style>
<?php
}
add_action('wp_head', 'neotiler_blog_font_custom_properties', 5);



/**
 * License Manager — Lemon Squeezy entegrasyonu, trial sistemi ve kilitleme.
 */
// require get_template_directory() . '/inc/license-manager.php';

/**
 * License Admin Page — Appearance → NeoTiler Lisansı
 */
// require get_template_directory() . '/inc/license-page.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * ============================================================================
 * PERFORMANCE & OPTIMIZATION ADDITIONS 
 * (Added per User Request)
 * ============================================================================
 */

/**
 * 1. Lottie Animation Support
 * Enqueue the lightweight Lottie Web Player for vector animations
 */
function neotiler_blog_enqueue_lottie()
{
	// Only load on front-end
	if (!is_admin()) {
		wp_enqueue_script(
			'lottie-player',
			'https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js',
			array(),
			null,
			true
		);
	}
}
// Lottie Animation Support (Commented out to save 95KB on page load, uncomment if you decide to use animations later)
// add_action('wp_enqueue_scripts', 'neotiler_blog_enqueue_lottie');


/**
 * 2. Automatic WebP Image Conversion & Optimization
 * Hooks into WordPress upload process to automatically convert JPEG/PNG to WebP 
 * if the server supports it (ImageMagick/GD).
 */

// Enable WebP uploads if not already supported by default in this WP version
function neotiler_blog_enable_webp_upload($mime_types)
{
	$mime_types['webp'] = 'image/webp';
	return $mime_types;
}
add_filter('upload_mimes', 'neotiler_blog_enable_webp_upload');

// Output WebP format for generated sub-sizes (Requires WP 5.8+)
function neotiler_blog_set_webp_quality($quality, $mime_type)
{
	if ('image/webp' === $mime_type) {
		return 85; // Optimal balance for quality and size
	}
	return $quality;
}
add_filter('wp_editor_set_quality', 'neotiler_blog_set_webp_quality', 10, 2);

// Force WordPress to create WebP sub-sizes from JPEG/PNG uploads
add_filter('image_editor_output_format', function ($formats) {
	if (!isset($formats['image/jpeg']) || !isset($formats['image/png'])) {
		return $formats;
	}
	$formats['image/jpeg'] = 'image/webp';
	$formats['image/png'] = 'image/webp';
	return $formats;
});

/**
 * ============================================================================
 * AJAX LOAD MORE FOR POPULAR POSTS
 * ============================================================================
 */
function neotiler_ajax_load_more_posts()
{
	// Verify nonce for security if needed (optional for public read-only data, but good practice)
	// check_ajax_referer('load_more_posts', 'security');

	$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 6;
	$posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 6;

	$args = array(
		'posts_per_page' => $posts_per_page,
		'offset' => $offset,
		'post_status' => 'publish',
		'ignore_sticky_posts' => 1,
		'orderby' => 'date',
		'order' => 'DESC',
	);

	$query = new WP_Query($args);

	if ($query->have_posts()):
		while ($query->have_posts()):
			$query->the_post();
			$thumbnail_url = get_the_post_thumbnail_url(null, 'medium_large') ?: 'https://via.placeholder.com/600x400';
			$categories = get_the_category();
			$cat_name = !empty($categories) ? $categories[0]->name : '';
			?>
			<article class="flex flex-col md:flex-row gap-6 mb-10 group items-start">
				<a href="<?php echo esc_url(get_permalink()); ?>"
					class="block w-full md:w-2/5 flex-shrink-0 relative overflow-hidden aspect-[16/10] bg-slate-100 dark:bg-slate-800">
					<img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
						class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
				</a>
				<div class="flex flex-col flex-1 justify-center py-2">
					<div
						class="flex items-center gap-3 text-[10px] lg:text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">
						<?php if ($cat_name): ?>
							<span class="text-primary"><?php echo esc_html($cat_name); ?></span> &bull;
						<?php endif; ?>
						<span><?php echo get_the_date('j F Y'); ?></span>
					</div>
					<h3
						class="text-xl md:text-2xl font-black leading-tight text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors line-clamp-3">
						<a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
					</h3>
					<p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 md:line-clamp-3 mb-4">
						<?php echo wp_trim_words(get_the_excerpt(), 25); ?>
					</p>
					<div
						class="mt-auto flex items-center gap-2 text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
						<?php echo get_avatar(get_the_author_meta('ID'), 24, '', '', array('class' => 'rounded-full')); ?>
						<span class="ml-2"><?php the_author(); ?></span>
					</div>
				</div>
			</article>
			<?php
		endwhile;
		wp_reset_postdata();
	else:
		echo ''; // Return empty to indicate no more posts
	endif;

	wp_die();
}
add_action('wp_ajax_load_more_posts', 'neotiler_ajax_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'neotiler_ajax_load_more_posts');


/**
 * Custom callback for HTML5 comment list - Premium Design.
 */
function neotiler_blog_comment($comment, $args, $depth)
{
	$tag = ('div' === $args['style']) ? 'div' : 'li';
	$is_post_author = ($comment->user_id === get_post_field('post_author', $comment->comment_post_ID));
	?>
	<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class($args['has_children'] ? 'parent mb-6' : 'mb-6'); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body relative transition-all">
			<div class="flex gap-4 group">
				<!-- Avatar -->
				<div class="flex-shrink-0 z-10">
					<?php if (0 != $args['avatar_size'])
						echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'rounded-full border border-slate-200 dark:border-slate-800 shadow-sm w-10 h-10 md:w-12 md:h-12')); ?>
				</div>

				<!-- Content Area -->
				<div class="flex-grow min-w-0">
					<div class="flex items-center gap-2 mb-1">
						<span class="font-bold text-slate-900 dark:text-white text-sm md:text-base leading-tight">
							<?php echo get_comment_author_link(); ?>
						</span>
						<?php if ($is_post_author): ?>
							<span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-blue-500 text-white"
								title="Post Author">
								<svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd"
										d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
										clip-rule="evenodd"></path>
								</svg>
							</span>
						<?php endif; ?>
						<span class="text-xs text-slate-500 dark:text-slate-400">
							<?php printf('%s ago', human_time_diff(get_comment_time('U'), current_time('timestamp'))); ?>
						</span>
					</div>

					<div
						class="comment-content prose-sm dark:prose-invert text-slate-700 dark:text-slate-300 mb-3 leading-relaxed">
						<?php comment_text(); ?>
					</div>

					<?php
					$upvotes = (int) get_comment_meta($comment->comment_ID, 'upvotes', true);
					$downvotes = (int) get_comment_meta($comment->comment_ID, 'downvotes', true);
					$vote_score = $upvotes - $downvotes;
					?>

					<!-- Actions: Upvote, Reply, More -->
					<div class="flex items-center gap-4 text-xs font-semibold text-slate-500 dark:text-slate-400">
						<!-- Upvote -->
						<button
							class="vote-btn upvote flex items-center gap-1.5 hover:text-primary transition-colors cursor-pointer"
							data-id="<?php comment_ID(); ?>" data-type="upvote">
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7">
								</path>
							</svg>
							<span
								class="vote-count"><?php echo $vote_score > 0 ? '+' . $vote_score : ($vote_score < 0 ? $vote_score : '0'); ?></span>
						</button>

						<!-- Downvote -->
						<button
							class="vote-btn downvote flex items-center gap-1.5 hover:text-red-500 transition-colors cursor-pointer"
							data-id="<?php comment_ID(); ?>" data-type="downvote">
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7">
								</path>
							</svg>
						</button>

						<!-- Reply -->
						<div class="hover:text-primary transition-colors">
							<?php
							comment_reply_link(array_merge($args, array(
								'add_below' => 'div-comment',
								'depth' => $depth,
								'max_depth' => $args['max_depth'],
								'reply_text' => 'Reply',
								'before' => '',
								'after' => '',
							)));
							?>
						</div>

						<!-- More Menu Placeholder -->
						<button class="hover:text-primary transition-colors cursor-pointer">
							<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
								<path
									d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM18 10a2 2 0 11-4 0 2 2 0 014 0z">
								</path>
							</svg>
						</button>
					</div>

					<?php if ('0' == $comment->comment_approved): ?>
						<em
							class="comment-awaiting-moderation inline-block px-2 py-0.5 bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-[10px] uppercase tracking-wider font-bold rounded mt-2 border border-amber-100 dark:border-amber-800/50">
							<?php esc_html_e('Awaiting moderation', 'neotiler-blog'); ?>
						</em>
					<?php endif; ?>
				</div>
			</div>
		</article>
		<?php
}

/**
 * Handle Comment Voting via AJAX
 */
function neotiler_handle_comment_vote()
{
	$comment_id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : 0;
	$vote_type = isset($_POST['vote_type']) ? sanitize_text_field($_POST['vote_type']) : '';

	if (!$comment_id || !in_array($vote_type, array('upvote', 'downvote'))) {
		wp_send_json_error('Invalid request');
	}

	// Checking cookie to prevent double voting
	$cookie_name = 'voted_comment_' . $comment_id;
	if (isset($_COOKIE[$cookie_name])) {
		wp_send_json_error('You already voted');
	}

	$upvotes = (int) get_comment_meta($comment_id, 'upvotes', true);
	$downvotes = (int) get_comment_meta($comment_id, 'downvotes', true);

	if ($vote_type === 'upvote') {
		$upvotes++;
		update_comment_meta($comment_id, 'upvotes', $upvotes);
	} else {
		$downvotes++;
		update_comment_meta($comment_id, 'downvotes', $downvotes);
	}

	// Update combined score for sorting
	$score = $upvotes - $downvotes;
	update_comment_meta($comment_id, 'vote_score', $score);

	// Set cookie for 30 days
	setcookie($cookie_name, '1', time() + (30 * DAY_IN_SECONDS), COOKIEPATH, COOKIE_DOMAIN);

	wp_send_json_success(array(
		'score' => ($score > 0 ? '+' . $score : ($score < 0 ? $score : '0')),
		'comment_id' => $comment_id
	));
}
add_action('wp_ajax_comment_vote', 'neotiler_handle_comment_vote');
add_action('wp_ajax_nopriv_comment_vote', 'neotiler_handle_comment_vote');

/**
 * Comment Sorting Logic
 */
add_filter('comments_template_query_args', function ($args) {
	if (is_admin())
		return $args;

	$sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';

	switch ($sort) {
		case 'oldest':
			$args['order'] = 'ASC';
			$args['orderby'] = 'comment_date';
			break;
		case 'top':
			$args['orderby'] = array(
				'meta_value_num' => 'DESC',
				'comment_date' => 'DESC'
			);
			$args['meta_key'] = 'vote_score';
			break;
		case 'newest':
		default:
			$args['order'] = 'DESC';
			$args['orderby'] = 'comment_date';
			break;
	}
	return $args;
});

/**
 * Handle AJAX Comment Submission
 */
function neotiler_ajax_submit_comment()
{
	$comment = wp_handle_comment_submission(wp_unslash($_POST));

	if (is_wp_error($comment)) {
		wp_send_json_error($comment->get_error_message());
	}

	$user = wp_get_current_user();
	do_action('set_comment_cookies', $comment, $user);

	$GLOBALS['comment'] = $comment;

	ob_start();
	neotiler_blog_comment($comment, array(
		'style' => 'ul',
		'short_ping' => true,
		'has_children' => false,
		'avatar_size' => 48,
		'max_depth' => get_option('thread_comments_depth')
	), 1);
	$comment_html = ob_get_clean();

	wp_send_json_success(array(
		'comment_html' => $comment_html,
		'message' => 'Comment added successfully.'
	));
}
add_action('wp_ajax_submit_ajax_comment', 'neotiler_ajax_submit_comment');
add_action('wp_ajax_nopriv_submit_ajax_comment', 'neotiler_ajax_submit_comment');


/**
 * ============================================================================
 * CUSTOM SITEMAP — SimpleXML Gerektirmeyen Özel Sitemap
 * SimpleXML eksikliği nedeniyle WordPress dahili sitemap'i çalışmıyor.
 * Bu sistem DOMDocument veya SimpleXML yerine saf string birleştirme kullanır.
 * ============================================================================
 */

// WordPress'in kendi sitemap sistemini devre dışı bırak
add_filter('wp_sitemaps_enabled', '__return_false');

// /sitemap.xml ve /wp-sitemap.xml rewrite kurallarını kaydet
function neotiler_sitemap_rewrite_rules()
{
	add_rewrite_rule('^sitemap\.xml$', 'index.php?neotiler_sitemap=1', 'top');
	add_rewrite_rule('^wp-sitemap\.xml$', 'index.php?neotiler_sitemap=1', 'top');
	add_rewrite_rule('^sitemap-posts\.xml$', 'index.php?neotiler_sitemap=posts', 'top');
	add_rewrite_rule('^sitemap-pages\.xml$', 'index.php?neotiler_sitemap=pages', 'top');
	add_rewrite_rule('^sitemap-categories\.xml$', 'index.php?neotiler_sitemap=categories', 'top');
}
add_action('init', 'neotiler_sitemap_rewrite_rules');

// Sitemap URL'lerinin sonuna slash eklenmesini (redirect_canonical) engelle
function neotiler_disable_sitemap_redirect_canonical($redirect_url, $requested_url)
{
	if (get_query_var('neotiler_sitemap')) {
		return false;
	}
	return $redirect_url;
}
add_filter('redirect_canonical', 'neotiler_disable_sitemap_redirect_canonical', 10, 2);

// Query var ekle
function neotiler_sitemap_query_vars($vars)
{
	$vars[] = 'neotiler_sitemap';
	return $vars;
}
add_filter('query_vars', 'neotiler_sitemap_query_vars');

// Sitemap isteğini yakala ve XML çıktısını üret
function neotiler_sitemap_output()
{
	$type = get_query_var('neotiler_sitemap');
	if (empty($type))
		return;

	// Cache kontrolü — 1 saat
	$cache_key = 'neotiler_sitemap_' . $type;
	$cached_xml = get_transient($cache_key);

	if ($cached_xml !== false) {
		header('Content-Type: application/xml; charset=UTF-8');
		header('X-Robots-Tag: noindex, follow');
		echo $cached_xml;
		exit;
	}

	$xml = '';

	if ($type === '1') {
		// Ana sitemap index
		$xml = neotiler_build_sitemap_index();
	} elseif ($type === 'posts') {
		$xml = neotiler_build_posts_sitemap();
	} elseif ($type === 'pages') {
		$xml = neotiler_build_pages_sitemap();
	} elseif ($type === 'categories') {
		$xml = neotiler_build_categories_sitemap();
	}

	if (!empty($xml)) {
		// 1 saat cache'le
		set_transient($cache_key, $xml, HOUR_IN_SECONDS);
		header('Content-Type: application/xml; charset=UTF-8');
		header('X-Robots-Tag: noindex, follow');
		echo $xml;
		exit;
	}
}
add_action('template_redirect', 'neotiler_sitemap_output');

/**
 * Ana sitemap index — alt sitemap'lere pointer.
 */
function neotiler_build_sitemap_index()
{
	$home = trailingslashit(home_url());
	$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	$sitemaps = array(
		array('loc' => $home . 'sitemap-posts.xml', 'lastmod' => date('Y-m-d')),
		array('loc' => $home . 'sitemap-pages.xml', 'lastmod' => date('Y-m-d')),
		array('loc' => $home . 'sitemap-categories.xml', 'lastmod' => date('Y-m-d')),
	);

	foreach ($sitemaps as $s) {
		$xml .= "\t<sitemap>\n";
		$xml .= "\t\t<loc>" . esc_url($s['loc']) . "</loc>\n";
		$xml .= "\t\t<lastmod>" . esc_html($s['lastmod']) . "</lastmod>\n";
		$xml .= "\t</sitemap>\n";
	}

	$xml .= '</sitemapindex>';
	return $xml;
}

/**
 * Blog yazıları sitemap'i.
 */
function neotiler_build_posts_sitemap()
{
	$posts = get_posts(array(
		'posts_per_page' => 1000,
		'post_status' => 'publish',
		'post_type' => 'post',
		'orderby' => 'modified',
		'order' => 'DESC',
	));

	$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	foreach ($posts as $post) {
		$xml .= "\t<url>\n";
		$xml .= "\t\t<loc>" . esc_url(get_permalink($post->ID)) . "</loc>\n";
		$xml .= "\t\t<lastmod>" . date('Y-m-d', strtotime($post->post_modified_gmt)) . "</lastmod>\n";
		$xml .= "\t\t<changefreq>weekly</changefreq>\n";
		$xml .= "\t\t<priority>0.8</priority>\n";
		$xml .= "\t</url>\n";
	}

	$xml .= '</urlset>';
	return $xml;
}

/**
 * Sayfalar sitemap'i.
 */
function neotiler_build_pages_sitemap()
{
	$pages = get_posts(array(
		'posts_per_page' => 500,
		'post_status' => 'publish',
		'post_type' => 'page',
		'orderby' => 'modified',
		'order' => 'DESC',
	));

	$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	// Ana sayfa
	$xml .= "\t<url>\n";
	$xml .= "\t\t<loc>" . esc_url(home_url('/')) . "</loc>\n";
	$xml .= "\t\t<changefreq>daily</changefreq>\n";
	$xml .= "\t\t<priority>1.0</priority>\n";
	$xml .= "\t</url>\n";

	foreach ($pages as $page) {
		$xml .= "\t<url>\n";
		$xml .= "\t\t<loc>" . esc_url(get_permalink($page->ID)) . "</loc>\n";
		$xml .= "\t\t<lastmod>" . date('Y-m-d', strtotime($page->post_modified_gmt)) . "</lastmod>\n";
		$xml .= "\t\t<changefreq>monthly</changefreq>\n";
		$xml .= "\t\t<priority>0.6</priority>\n";
		$xml .= "\t</url>\n";
	}

	$xml .= '</urlset>';
	return $xml;
}

/**
 * Kategoriler sitemap'i.
 */
function neotiler_build_categories_sitemap()
{
	$categories = get_categories(array(
		'hide_empty' => true,
		'number' => 200,
	));

	$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	foreach ($categories as $cat) {
		$xml .= "\t<url>\n";
		$xml .= "\t\t<loc>" . esc_url(get_category_link($cat->term_id)) . "</loc>\n";
		$xml .= "\t\t<changefreq>weekly</changefreq>\n";
		$xml .= "\t\t<priority>0.5</priority>\n";
		$xml .= "\t</url>\n";
	}

	$xml .= '</urlset>';
	return $xml;
}

// Post/sayfa güncellendiğinde sitemap cache'ini temizle
function neotiler_flush_sitemap_cache($post_id)
{
	if (wp_is_post_revision($post_id))
		return;
	delete_transient('neotiler_sitemap_1');
	delete_transient('neotiler_sitemap_posts');
	delete_transient('neotiler_sitemap_pages');
	delete_transient('neotiler_sitemap_categories');
}
add_action('save_post', 'neotiler_flush_sitemap_cache');
add_action('create_category', 'neotiler_flush_sitemap_cache');
add_action('delete_category', 'neotiler_flush_sitemap_cache');

// Rewrite kurallarını flushlama (sadece bir kez yapılır)
function neotiler_maybe_flush_rewrite_rules()
{
	if (get_option('neotiler_sitemap_rules_flushed') !== _S_VERSION) {
		flush_rewrite_rules();
		update_option('neotiler_sitemap_rules_flushed', _S_VERSION);
	}
}
add_action('init', 'neotiler_maybe_flush_rewrite_rules', 20);

