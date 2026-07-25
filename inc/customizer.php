<?php
/**
 * NeoTiler Blog Theme Customizer
 *
 * @package NeoTiler_Blog
 */

if (class_exists('WP_Customize_Control') && !class_exists('NeoTiler_Customize_Heading_Control')) {
	class NeoTiler_Customize_Heading_Control extends WP_Customize_Control
	{
		public $type = 'heading';
		public function render_content()
		{
			echo '<h3 style="margin-top: 30px; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #dcd7ca; font-size: 14px; font-weight: 600; color: #1d2327; text-transform: uppercase;">' . esc_html($this->label) . '</h3>';
			if (!empty($this->description)) {
				echo '<span class="description customize-control-description">' . wp_kses_post($this->description) . '</span>';
			}
		}
	}
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function neotiler_blog_customize_register($wp_customize)
{
	if ($wp_customize->get_section('title_tagline')) {
		$wp_customize->get_section('title_tagline')->title = esc_html__('General', 'neotiler-blog');
	}
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

	if (isset($wp_customize->selective_refresh)) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector' => '.site-title a',
				'render_callback' => 'neotiler_blog_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector' => '.site-description',
				'render_callback' => 'neotiler_blog_customize_partial_blogdescription',
			)
		);
	}

	// ==========================
	// Google Fonts — Popüler 60+ Font
	// ==========================
	$font_choices = array(
		'Inter' => 'Inter',
		'Montserrat' => 'Montserrat',
		'Roboto' => 'Roboto',
		'Open Sans' => 'Open Sans',
		'Poppins' => 'Poppins',
		'Lato' => 'Lato',
		'Nunito' => 'Nunito',
		'Nunito Sans' => 'Nunito Sans',
		'Raleway' => 'Raleway',
		'Work Sans' => 'Work Sans',
		'DM Sans' => 'DM Sans',
		'Outfit' => 'Outfit',
		'Plus Jakarta Sans' => 'Plus Jakarta Sans',
		'Manrope' => 'Manrope',
		'Space Grotesk' => 'Space Grotesk',
		'Sora' => 'Sora',
		'Figtree' => 'Figtree',
		'Lexend' => 'Lexend',
		'Source Sans 3' => 'Source Sans 3',
		'IBM Plex Sans' => 'IBM Plex Sans',
		'Mulish' => 'Mulish',
		'Barlow' => 'Barlow',
		'Urbanist' => 'Urbanist',
		'Archivo' => 'Archivo',
		'Red Hat Display' => 'Red Hat Display',
		'Noto Sans' => 'Noto Sans',
		'Oswald' => 'Oswald',
		'Playfair Display' => 'Playfair Display',
		'Merriweather' => 'Merriweather',
		'Lora' => 'Lora',
		'Crimson Text' => 'Crimson Text',
		'Rubik' => 'Rubik',
		'Karla' => 'Karla',
		'Cabin' => 'Cabin',
		'Quicksand' => 'Quicksand',
		'Josefin Sans' => 'Josefin Sans',
		'Ubuntu' => 'Ubuntu',
		'Fira Sans' => 'Fira Sans',
		'PT Sans' => 'PT Sans',
		'Hind' => 'Hind',
		'Dosis' => 'Dosis',
		'Titillium Web' => 'Titillium Web',
		'Overpass' => 'Overpass',
		'Exo 2' => 'Exo 2',
		'Kanit' => 'Kanit',
		'Cairo' => 'Cairo',
		'Heebo' => 'Heebo',
		'Libre Franklin' => 'Libre Franklin',
		'Assistant' => 'Assistant',
		'Jost' => 'Jost',
		'Signika' => 'Signika',
		'Catamaran' => 'Catamaran',
		'Asap' => 'Asap',
		'Bitter' => 'Bitter',
		'Source Serif 4' => 'Source Serif 4',
		'Libre Baskerville' => 'Libre Baskerville',
		'EB Garamond' => 'EB Garamond',
		'Cormorant Garamond' => 'Cormorant Garamond',
		'Spectral' => 'Spectral',
		'Alegreya' => 'Alegreya',
		'Vollkorn' => 'Vollkorn',
		'Inconsolata' => 'Inconsolata',
		'JetBrains Mono' => 'JetBrains Mono',
		'Fira Code' => 'Fira Code',
		'Space Mono' => 'Space Mono',
	);

	// Font Weight Seçenekleri
	$weight_choices = array(
		'100' => '100 — Thin',
		'200' => '200 — Extra Light',
		'300' => '300 — Light',
		'400' => '400 — Regular',
		'500' => '500 — Medium',
		'600' => '600 — Semibold',
		'700' => '700 — Bold',
		'800' => '800 — Extra Bold',
		'900' => '900 — Black',
	);

	// ==========================
	// Typography Section
	// ==========================
	$wp_customize->add_section('neotiler_typography_section', array(
		'title' => esc_html__('Typography (Fonts)', 'neotiler-blog'),
		'description' => esc_html__('Select fonts, sizes and weights for different parts of your theme. All fonts are loaded from Google Fonts. Changes are reflected instantly.', 'neotiler-blog'),
		'priority' => 25,
	));

	// ───────────────────────────────────────
	// BODY FONT
	// ───────────────────────────────────────
	$wp_customize->add_setting('neotiler_body_font', array(
		'default' => 'Inter',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_body_font', array(
		'label' => esc_html__('Body Font', 'neotiler-blog'),
		'description' => esc_html__('Used for paragraphs, meta info and general text.', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'select',
		'choices' => $font_choices,
	));

	// Body Font Size
	$wp_customize->add_setting('neotiler_body_font_size', array(
		'default' => '1',
		'sanitize_callback' => 'neotiler_sanitize_float',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_body_font_size', array(
		'label' => esc_html__('Body Font Size (rem)', 'neotiler-blog'),
		'description' => esc_html__('Default: 1rem (16px)', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 0.5,
			'max' => 3,
			'step' => 0.05,
		),
	));

	// Body Font Weight
	$wp_customize->add_setting('neotiler_body_font_weight', array(
		'default' => '500',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_body_font_weight', array(
		'label' => esc_html__('Body Font Weight', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'select',
		'choices' => $weight_choices,
	));

	// Body Line Height
	$wp_customize->add_setting('neotiler_body_line_height', array(
		'default' => '1.6',
		'sanitize_callback' => 'neotiler_sanitize_float',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_body_line_height', array(
		'label' => esc_html__('Body Line Height', 'neotiler-blog'),
		'description' => esc_html__('Default: 1.6 — Higher values improve readability.', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 1,
			'max' => 3,
			'step' => 0.1,
		),
	));

	// ───────────────────────────────────────
	// HEADING FONT
	// ───────────────────────────────────────
	$wp_customize->add_setting('neotiler_heading_font', array(
		'default' => 'Inter',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_heading_font', array(
		'label' => esc_html__('Heading Font', 'neotiler-blog'),
		'description' => esc_html__('Used for h1-h6 titles and post titles.', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'select',
		'choices' => $font_choices,
	));

	// Heading Font Weight
	$wp_customize->add_setting('neotiler_heading_font_weight', array(
		'default' => '700',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_heading_font_weight', array(
		'label' => esc_html__('Heading Font Weight', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'select',
		'choices' => $weight_choices,
	));

	// Heading Letter Spacing
	$wp_customize->add_setting('neotiler_heading_letter_spacing', array(
		'default' => '-0.025',
		'sanitize_callback' => 'neotiler_sanitize_float',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_heading_letter_spacing', array(
		'label' => esc_html__('Heading Letter Spacing (em)', 'neotiler-blog'),
		'description' => esc_html__('Default: -0.025em (tighter)', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'number',
		'input_attrs' => array(
			'min' => -0.1,
			'max' => 0.2,
			'step' => 0.005,
		),
	));

	// H1 Font Size
	$wp_customize->add_setting('neotiler_h1_font_size', array(
		'default' => '3',
		'sanitize_callback' => 'neotiler_sanitize_float',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_h1_font_size', array(
		'label' => esc_html__('H1 Font Size (rem)', 'neotiler-blog'),
		'description' => esc_html__('Default: 3rem (48px)', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 1,
			'max' => 6,
			'step' => 0.1,
		),
	));

	// H2 Font Size
	$wp_customize->add_setting('neotiler_h2_font_size', array(
		'default' => '2',
		'sanitize_callback' => 'neotiler_sanitize_float',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_h2_font_size', array(
		'label' => esc_html__('H2 Font Size (rem)', 'neotiler-blog'),
		'description' => esc_html__('Default: 2rem (32px)', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 0.8,
			'max' => 5,
			'step' => 0.1,
		),
	));

	// H3 Font Size
	$wp_customize->add_setting('neotiler_h3_font_size', array(
		'default' => '1.5',
		'sanitize_callback' => 'neotiler_sanitize_float',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_h3_font_size', array(
		'label' => esc_html__('H3 Font Size (rem)', 'neotiler-blog'),
		'description' => esc_html__('Default: 1.5rem (24px)', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 0.5,
			'max' => 4,
			'step' => 0.1,
		),
	));

	// ───────────────────────────────────────
	// NAVIGATION FONT
	// ───────────────────────────────────────
	$wp_customize->add_setting('neotiler_nav_font', array(
		'default' => 'Montserrat',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_nav_font', array(
		'label' => esc_html__('Navigation Font', 'neotiler-blog'),
		'description' => esc_html__('Used for the main navigation menu links.', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'select',
		'choices' => $font_choices,
	));

	// Nav Font Size
	$wp_customize->add_setting('neotiler_nav_font_size', array(
		'default' => '0.9',
		'sanitize_callback' => 'neotiler_sanitize_float',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_nav_font_size', array(
		'label' => esc_html__('Navigation Font Size (rem)', 'neotiler-blog'),
		'description' => esc_html__('Default: 0.9rem', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 0.5,
			'max' => 2,
			'step' => 0.05,
		),
	));

	// Nav Font Weight
	$wp_customize->add_setting('neotiler_nav_font_weight', array(
		'default' => '700',
		'sanitize_callback' => 'sanitize_text_field',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_nav_font_weight', array(
		'label' => esc_html__('Navigation Font Weight', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'select',
		'choices' => $weight_choices,
	));

	// ───────────────────────────────────────
	// META & BUTTONS
	// ───────────────────────────────────────
	$wp_customize->add_setting('neotiler_meta_font_size', array(
		'default' => '0.75',
		'sanitize_callback' => 'neotiler_sanitize_float',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_meta_font_size', array(
		'label' => esc_html__('Meta Info Font Size (rem)', 'neotiler-blog'),
		'description' => esc_html__('Date, category, tag text size. Default: 0.75rem (12px)', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 0.5,
			'max' => 1.5,
			'step' => 0.05,
		),
	));

	$wp_customize->add_setting('neotiler_btn_border_radius', array(
		'default' => '0',
		'sanitize_callback' => 'absint',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control('neotiler_btn_border_radius', array(
		'label' => esc_html__('Button Border Radius (px)', 'neotiler-blog'),
		'description' => esc_html__('Default: 0px (sharp corners). Set higher for rounded buttons.', 'neotiler-blog'),
		'section' => 'neotiler_typography_section',
		'type' => 'number',
		'input_attrs' => array(
			'min' => 0,
			'max' => 50,
			'step' => 1,
		),
	));

	// ==========================
	// Logo Boyutu (Site Identity altında)
	// ==========================

	// -- Logo Yüksekliği --
	$wp_customize->add_setting('neotiler_logo_height', array(
		'default' => '40',
		'sanitize_callback' => 'absint',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('neotiler_logo_height', array(
		'label' => esc_html__('Logo Height (px)', 'neotiler-blog'),
		'description' => esc_html__('Default: 40px', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'number',
		'priority' => 40,
		'input_attrs' => array(
			'min' => 10,
			'max' => 200,
			'step' => 1,
		),
	));

	// -- Logo Genişliği --
	$wp_customize->add_setting('neotiler_logo_width', array(
		'default' => '150',
		'sanitize_callback' => 'absint',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('neotiler_logo_width', array(
		'label' => esc_html__('Logo Width (px)', 'neotiler-blog'),
		'description' => esc_html__('0 = auto width (Recommended: 150px)', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'number',
		'priority' => 41,
		'input_attrs' => array(
			'min' => 0,
			'max' => 600,
			'step' => 1,
		),
	));

	// -- Mobile Logo Yüksekliği --
	$wp_customize->add_setting('neotiler_mobile_logo_height', array(
		'default' => '0',
		'sanitize_callback' => 'absint',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('neotiler_mobile_logo_height', array(
		'label' => esc_html__('Mobile Logo Height (px)', 'neotiler-blog'),
		'description' => esc_html__('0 = fallback to desktop height', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'number',
		'priority' => 42,
		'input_attrs' => array(
			'min' => 0,
			'max' => 200,
			'step' => 1,
		),
	));

	// -- Mobile Logo Genişliği --
	$wp_customize->add_setting('neotiler_mobile_logo_width', array(
		'default' => '0',
		'sanitize_callback' => 'absint',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('neotiler_mobile_logo_width', array(
		'label' => esc_html__('Mobile Logo Width (px)', 'neotiler-blog'),
		'description' => esc_html__('0 = fallback to desktop width', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'number',
		'priority' => 43,
		'input_attrs' => array(
			'min' => 0,
			'max' => 600,
			'step' => 1,
		),
	));

	// ==========================
	// Social Media Links (Moved to General/Site Identity)
	// ==========================

	$wp_customize->add_setting('neotiler_social_heading', array('sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control(new NeoTiler_Customize_Heading_Control($wp_customize, 'neotiler_social_heading', array(
		'label' => esc_html__('Social Media Icons', 'neotiler-blog'),
		'section' => 'title_tagline',
		'priority' => 70,
	)));

	// Twitter/X URL
	$wp_customize->add_setting('neotiler_twitter_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('neotiler_twitter_url', array(
		'label' => esc_html__('Twitter/X URL', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'url',
		'priority' => 71,
	));

	// YouTube URL
	$wp_customize->add_setting('neotiler_youtube_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('neotiler_youtube_url', array(
		'label' => esc_html__('YouTube URL', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'url',
		'priority' => 72,
	));

	// Instagram URL
	$wp_customize->add_setting('neotiler_instagram_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('neotiler_instagram_url', array(
		'label' => esc_html__('Instagram URL', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'url',
		'priority' => 73,
	));

	// Facebook URL
	$wp_customize->add_setting('neotiler_facebook_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('neotiler_facebook_url', array(
		'label' => esc_html__('Facebook URL', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'url',
		'priority' => 74,
	));

	// Pinterest URL
	$wp_customize->add_setting('neotiler_pinterest_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('neotiler_pinterest_url', array(
		'label' => esc_html__('Pinterest URL', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'url',
		'priority' => 75,
	));

	// LinkedIn URL
	$wp_customize->add_setting('neotiler_linkedin_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('neotiler_linkedin_url', array(
		'label' => esc_html__('LinkedIn URL', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'url',
		'priority' => 76,
	));

	// TikTok URL
	$wp_customize->add_setting('neotiler_tiktok_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('neotiler_tiktok_url', array(
		'label' => esc_html__('TikTok URL', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'url',
		'priority' => 77,
	));

	// Reddit URL
	$wp_customize->add_setting('neotiler_reddit_url', array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
	));
	$wp_customize->add_control('neotiler_reddit_url', array(
		'label' => esc_html__('Reddit URL', 'neotiler-blog'),
		'section' => 'title_tagline',
		'type' => 'url',
		'priority' => 78,
	));

	// ==========================
	// Video Carousel Section
	// ==========================
	$wp_customize->add_section('neotiler_video_section', array(
		'title' => esc_html__('Video Carousel', 'neotiler-blog'),
		'description' => esc_html__('Add YouTube video URLs for the homepage video carousel. Leave blank to hide.', 'neotiler-blog'),
		'priority' => 35,
	));

	$wp_customize->add_setting('neotiler_video_title', array(
		'default' => 'İzlemeden Geçme!',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('neotiler_video_title', array(
		'label' => esc_html__('Section Title', 'neotiler-blog'),
		'section' => 'neotiler_video_section',
		'type' => 'text',
	));

	$wp_customize->add_setting('neotiler_video_description', array(
		'default' => 'Güncel video incelemelerimiz, rehberlerimiz ve podcastlerimiz.',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('neotiler_video_description', array(
		'label' => esc_html__('Description', 'neotiler-blog'),
		'section' => 'neotiler_video_section',
		'type' => 'text',
	));

	for ($i = 1; $i <= 6; $i++) {
		$wp_customize->add_setting("neotiler_video_url_{$i}", array(
			'default' => '',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control("neotiler_video_url_{$i}", array(
			'label' => sprintf(esc_html__('YouTube Video %d URL', 'neotiler-blog'), $i),
			'section' => 'neotiler_video_section',
			'type' => 'url',
		));
	}

	// ==========================
	// Footer Settings Paneli
	// ==========================
	$wp_customize->add_panel('neotiler_footer_panel', array(
		'priority' => 130,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => esc_html__('Footer Settings', 'neotiler-blog'),
		'description' => esc_html__('Configure the footer layout, colors, and content columns.', 'neotiler-blog'),
	));

	// -- 1. Footer Styling --
	$wp_customize->add_section('neotiler_footer_style', array(
		'title' => esc_html__('Footer Styling', 'neotiler-blog'),
		'panel' => 'neotiler_footer_panel',
		'priority' => 10,
	));

	$wp_customize->add_setting('footer_bg_color', array('default' => '#0f172a', 'sanitize_callback' => 'sanitize_hex_color'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_bg_color', array(
		'label' => esc_html__('Background Color', 'neotiler-blog'),
		'section' => 'neotiler_footer_style',
	)));

	$wp_customize->add_setting('footer_text_color', array('default' => '#cbd5e1', 'sanitize_callback' => 'sanitize_hex_color'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_text_color', array(
		'label' => esc_html__('Text Color', 'neotiler-blog'),
		'section' => 'neotiler_footer_style',
	)));

	$wp_customize->add_setting('footer_link_color', array('default' => '#94a3b8', 'sanitize_callback' => 'sanitize_hex_color'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_link_color', array(
		'label' => esc_html__('Link Color', 'neotiler-blog'),
		'section' => 'neotiler_footer_style',
	)));

	$wp_customize->add_setting('footer_heading_color', array('default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color'));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_heading_color', array(
		'label' => esc_html__('Heading Color', 'neotiler-blog'),
		'section' => 'neotiler_footer_style',
	)));

	$wp_customize->add_setting('footer_padding_y', array('default' => 4, 'sanitize_callback' => 'absint'));
	$wp_customize->add_control('footer_padding_y', array(
		'label' => esc_html__('Top/Bottom Padding (rem)', 'neotiler-blog'),
		'section' => 'neotiler_footer_style',
		'type' => 'number',
		'input_attrs' => array('min' => 1, 'max' => 10),
	));

	// -- 2. Column 1 (Brand) --
	$wp_customize->add_section('neotiler_footer_col1', array(
		'title' => esc_html__('Column 1 (Brand)', 'neotiler-blog'),
		'panel' => 'neotiler_footer_panel',
		'priority' => 20,
	));

	$wp_customize->add_setting('footer_show_logo', array('default' => true, 'sanitize_callback' => 'neotiler_sanitize_checkbox'));
	$wp_customize->add_control('footer_show_logo', array(
		'label' => esc_html__('Show Logo/Site Title', 'neotiler-blog'),
		'section' => 'neotiler_footer_col1',
		'type' => 'checkbox',
	));

	$wp_customize->add_setting('footer_brand_desc', array('default' => '', 'sanitize_callback' => 'wp_kses_post'));
	$wp_customize->add_control('footer_brand_desc', array(
		'label' => esc_html__('Brand Description (Leave empty for site tagline)', 'neotiler-blog'),
		'section' => 'neotiler_footer_col1',
		'type' => 'textarea',
	));

	$wp_customize->add_setting('footer_show_social', array('default' => true, 'sanitize_callback' => 'neotiler_sanitize_checkbox'));
	$wp_customize->add_control('footer_show_social', array(
		'label' => esc_html__('Show Social Links', 'neotiler-blog'),
		'section' => 'neotiler_footer_col1',
		'type' => 'checkbox',
	));

	// -- 3. Column 2 --
	$wp_customize->add_section('neotiler_footer_col2', array(
		'title' => esc_html__('Column 2', 'neotiler-blog'),
		'panel' => 'neotiler_footer_panel',
		'priority' => 30,
	));

	$wp_customize->add_setting('footer_col2_heading', array('default' => 'Categories', 'sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control('footer_col2_heading', array(
		'label' => esc_html__('Heading', 'neotiler-blog'),
		'section' => 'neotiler_footer_col2',
		'type' => 'text',
	));

	$wp_customize->add_setting('footer_col2_custom_html', array('default' => '', 'sanitize_callback' => 'wp_kses_post'));
	$wp_customize->add_control('footer_col2_custom_html', array(
		'label' => esc_html__('Custom HTML / Text (Overrides menu if filled)', 'neotiler-blog'),
		'section' => 'neotiler_footer_col2',
		'type' => 'textarea',
	));

	// -- 4. Column 3 --
	$wp_customize->add_section('neotiler_footer_col3', array(
		'title' => esc_html__('Column 3', 'neotiler-blog'),
		'panel' => 'neotiler_footer_panel',
		'priority' => 40,
	));

	$wp_customize->add_setting('footer_col3_heading', array('default' => 'Company', 'sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control('footer_col3_heading', array(
		'label' => esc_html__('Heading', 'neotiler-blog'),
		'section' => 'neotiler_footer_col3',
		'type' => 'text',
	));

	$wp_customize->add_setting('footer_col3_custom_html', array('default' => '', 'sanitize_callback' => 'wp_kses_post'));
	$wp_customize->add_control('footer_col3_custom_html', array(
		'label' => esc_html__('Custom HTML / Text (Overrides menu if filled)', 'neotiler-blog'),
		'section' => 'neotiler_footer_col3',
		'type' => 'textarea',
	));

	// -- 5. Column 4 (Newsletter) --
	$wp_customize->add_section('neotiler_footer_col4', array(
		'title' => esc_html__('Column 4 (Newsletter)', 'neotiler-blog'),
		'panel' => 'neotiler_footer_panel',
		'priority' => 50,
	));

	$wp_customize->add_setting('footer_col4_heading', array('default' => 'Subscribe', 'sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control('footer_col4_heading', array(
		'label' => esc_html__('Heading', 'neotiler-blog'),
		'section' => 'neotiler_footer_col4',
		'type' => 'text',
	));

	$wp_customize->add_setting('footer_col4_desc', array('default' => 'Get the latest news directly to your inbox. No spam, we promise.', 'sanitize_callback' => 'sanitize_textarea_field'));
	$wp_customize->add_control('footer_col4_desc', array(
		'label' => esc_html__('Description', 'neotiler-blog'),
		'section' => 'neotiler_footer_col4',
		'type' => 'textarea',
	));

	$wp_customize->add_setting('footer_show_newsletter', array('default' => true, 'sanitize_callback' => 'neotiler_sanitize_checkbox'));
	$wp_customize->add_control('footer_show_newsletter', array(
		'label' => esc_html__('Show Default Newsletter Form', 'neotiler-blog'),
		'section' => 'neotiler_footer_col4',
		'type' => 'checkbox',
	));

	$wp_customize->add_setting('footer_mailchimp_url', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
	$wp_customize->add_control('footer_mailchimp_url', array(
		'label' => esc_html__('Mailchimp Form Action URL', 'neotiler-blog'),
		'description' => esc_html__('Enter the form action URL from your Mailchimp embedded form code (usually starts with something like https://yourdomain.usX.list-manage.com/subscribe/post?u=...).', 'neotiler-blog'),
		'section' => 'neotiler_footer_col4',
		'type' => 'url',
	));

	$wp_customize->add_setting('footer_col4_custom_html', array('default' => '', 'sanitize_callback' => 'wp_kses_post'));
	$wp_customize->add_control('footer_col4_custom_html', array(
		'label' => esc_html__('Custom HTML / Shortcode (Replaces default form)', 'neotiler-blog'),
		'section' => 'neotiler_footer_col4',
		'type' => 'textarea',
	));

	// -- 6. Copyright Area --
	$wp_customize->add_section('neotiler_footer_copyright', array(
		'title' => esc_html__('Copyright Area', 'neotiler-blog'),
		'panel' => 'neotiler_footer_panel',
		'priority' => 60,
	));

	$wp_customize->add_setting('footer_copyright_text', array('default' => 'All rights reserved.', 'sanitize_callback' => 'wp_kses_post'));
	$wp_customize->add_control('footer_copyright_text', array(
		'label' => esc_html__('Copyright Text', 'neotiler-blog'),
		'section' => 'neotiler_footer_copyright',
		'type' => 'text',
	));

	$wp_customize->add_setting('footer_powered_by_text', array('default' => 'Powered by', 'sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control('footer_powered_by_text', array(
		'label' => esc_html__('Powered By Text', 'neotiler-blog'),
		'section' => 'neotiler_footer_copyright',
		'type' => 'text',
	));

	$wp_customize->add_setting('footer_powered_by_link_text', array('default' => '', 'sanitize_callback' => 'sanitize_text_field'));
	$wp_customize->add_control('footer_powered_by_link_text', array(
		'label' => esc_html__('Powered By Link Text', 'neotiler-blog'),
		'section' => 'neotiler_footer_copyright',
		'type' => 'text',
	));

	$wp_customize->add_setting('footer_powered_by_url', array('default' => '', 'sanitize_callback' => 'esc_url_raw'));
	$wp_customize->add_control('footer_powered_by_url', array(
		'label' => esc_html__('Powered By URL', 'neotiler-blog'),
		'section' => 'neotiler_footer_copyright',
		'type' => 'url',
	));

	// ==========================
	// Home Categories Section 
	// ==========================
	$wp_customize->add_section('neotiler_home_cats_section', array(
		'title' => esc_html__('Home Categories', 'neotiler-blog'),
		'description' => esc_html__('Select 3 categories to display below the video carousel.', 'neotiler-blog'),
		'priority' => 36,
	));

	$categories = get_categories(array('hide_empty' => 0));
	$cat_choices = array('' => esc_html__('&mdash; None &mdash;', 'neotiler-blog'));
	foreach ($categories as $category) {
		$cat_choices[$category->term_id] = $category->name;
	}

	for ($i = 1; $i <= 3; $i++) {
		$wp_customize->add_setting("neotiler_home_cat_{$i}", array(
			'default' => '',
			'sanitize_callback' => 'absint',
		));
		$wp_customize->add_control("neotiler_home_cat_{$i}", array(
			'label' => sprintf(esc_html__('Home Category %d', 'neotiler-blog'), $i),
			'section' => 'neotiler_home_cats_section',
			'type' => 'select',
			'choices' => $cat_choices,
		));
	}

	// ==========================
	// Advertisement Spaces
	// ==========================
	$wp_customize->add_section('neotiler_ads_section', array(
		'title' => esc_html__('Advertisement Areas', 'neotiler-blog'),
		'description' => esc_html__('Paste your AdSense or custom ad HTML/JS code here. Leave blank to hide.', 'neotiler-blog'),
		'priority' => 120,
	));

	// Ad Space 1: Above Most Popular (728x90)
	$wp_customize->add_setting('neotiler_ad_1', array(
		'default' => '',
	));
	$wp_customize->add_control('neotiler_ad_1', array(
		'label' => esc_html__('Ad Space 1 (Above MOST POPULAR)', 'neotiler-blog'),
		'description' => esc_html__('Recommended size: 728x90', 'neotiler-blog'),
		'section' => 'neotiler_ads_section',
		'type' => 'textarea',
	));

	// Ad Space 2: Above Categories (728x90)
	$wp_customize->add_setting('neotiler_ad_2', array(
		'default' => '',
	));
	$wp_customize->add_control('neotiler_ad_2', array(
		'label' => esc_html__('Ad Space 2 (Above Categories/Utilities)', 'neotiler-blog'),
		'description' => esc_html__('Recommended size: 728x90', 'neotiler-blog'),
		'section' => 'neotiler_ads_section',
		'type' => 'textarea',
	));

	// Ad Space 3: Above Sidebar Popular Posts
	$wp_customize->add_setting('neotiler_ad_3', array(
		'default' => '',
	));
	$wp_customize->add_control('neotiler_ad_3', array(
		'label' => esc_html__('Ad Space 3 (Sidebar above Popular Posts)', 'neotiler-blog'),
		'description' => esc_html__('Recommended size: 300x250 or 336x280', 'neotiler-blog'),
		'section' => 'neotiler_ads_section',
		'type' => 'textarea',
	));
}
add_action('customize_register', 'neotiler_blog_customize_register');

/**
 * Sanitize float values for customizer.
 */
function neotiler_sanitize_float($val)
{
	return floatval($val);
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function neotiler_blog_customize_partial_blogname()
{
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function neotiler_blog_customize_partial_blogdescription()
{
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function neotiler_blog_customize_preview_js()
{
	wp_enqueue_script('neotiler-blog-customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), _S_VERSION, true);
}
add_action('customize_preview_init', 'neotiler_blog_customize_preview_js');
