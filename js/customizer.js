/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * — Gelişmiş Tipografi Sistemi: Tüm font, size, weight, line-height,
 *   letter-spacing, meta ve buton ayarları canlı önizleme ile güncellenir.
 */

(function ($) {

	// ─── Yardımcı: CSS Custom Property Güncelle ───
	function setCSSVar(name, value) {
		document.documentElement.style.setProperty(name, value);
	}

	// ─── Yardımcı: Google Fonts <link> Tag'ini Dinamik Güncelle ───
	function updateGoogleFontsLink() {
		var bodyFont = wp.customize('neotiler_body_font')();
		var headingFont = wp.customize('neotiler_heading_font')();
		var navFont = wp.customize('neotiler_nav_font')();

		var fonts = [];
		var seen = {};
		[bodyFont, headingFont, navFont].forEach(function (f) {
			if (f && !seen[f]) {
				seen[f] = true;
				fonts.push('family=' + f.replace(/ /g, '+') + ':wght@100;200;300;400;500;600;700;800;900');
			}
		});

		var url = 'https://fonts.googleapis.com/css2?' + fonts.join('&') + '&display=swap';

		// Mevcut Google Fonts link'ini güncelle veya yeni ekle
		var $link = $('#neotiler-google-fonts-preview');
		if ($link.length) {
			$link.attr('href', url);
		} else {
			$('head').append('<link id="neotiler-google-fonts-preview" rel="stylesheet" href="' + url + '">');
		}
	}

	// ═══════════════════════════════════════
	// Temel WordPress Ayarları
	// ═══════════════════════════════════════

	// Site title
	wp.customize('blogname', function (value) {
		value.bind(function (to) {
			$('.site-title a').text(to);
		});
	});

	// Site description
	wp.customize('blogdescription', function (value) {
		value.bind(function (to) {
			$('.site-description').text(to);
		});
	});

	// Header text color
	wp.customize('header_textcolor', function (value) {
		value.bind(function (to) {
			if ('blank' === to) {
				$('.site-title, .site-description').css({
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				});
			} else {
				$('.site-title, .site-description').css({
					clip: 'auto',
					position: 'relative',
				});
				$('.site-title a, .site-description').css({
					color: to,
				});
			}
		});
	});

	// ═══════════════════════════════════════
	// Logo Boyutları
	// ═══════════════════════════════════════

	function updateLogoSizing() {
		var desktop_h = parseInt(wp.customize('neotiler_logo_height')(), 10) || 40;
		if (desktop_h < 10) desktop_h = 40;
		var desktop_w = parseInt(wp.customize('neotiler_logo_width')(), 10) || 0;
		var mobile_h = parseInt(wp.customize('neotiler_mobile_logo_height')(), 10) || 0;
		var mobile_w = parseInt(wp.customize('neotiler_mobile_logo_width')(), 10) || 0;

		var css = '.site-header .custom-logo, .site-branding .custom-logo-link img {\n' +
			'height: ' + desktop_h + 'px !important;\n' +
			(desktop_w > 0 ? 'width: ' + desktop_w + 'px !important;\n' : 'width: auto !important;\n') +
			'}';

		if (mobile_h > 0 || mobile_w > 0) {
			css += '\n@media (max-width: 1023px) {\n' +
				'.site-header .custom-logo, .site-branding .custom-logo-link img {\n' +
				(mobile_h > 0 ? 'height: ' + mobile_h + 'px !important;\n' : '') +
				(mobile_w > 0 ? 'width: ' + mobile_w + 'px !important;\n' : '') +
				'}\n}';
		}

		var $style = $('#neotiler-logo-live-css');
		if ($style.length) {
			$style.text(css);
		} else {
			$('head').append('<style id="neotiler-logo-live-css">' + css + '</style>');
		}

		// Reset inline styles that might have been applied previously by old JS
		$('.site-header .custom-logo, .site-branding .custom-logo-link img').css({ 'height': '', 'width': '' });
	}

	wp.customize('neotiler_logo_height', function (value) { value.bind(updateLogoSizing); });
	wp.customize('neotiler_logo_width', function (value) { value.bind(updateLogoSizing); });
	wp.customize('neotiler_mobile_logo_height', function (value) { value.bind(updateLogoSizing); });
	wp.customize('neotiler_mobile_logo_width', function (value) { value.bind(updateLogoSizing); });

	// ═══════════════════════════════════════
	// FONT FAMILY — Canlı Önizleme
	// ═══════════════════════════════════════

	// Body Font
	wp.customize('neotiler_body_font', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-body', "'" + to + "', system-ui, -apple-system, sans-serif");
			updateGoogleFontsLink();
		});
	});

	// Heading Font
	wp.customize('neotiler_heading_font', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-heading', "'" + to + "', system-ui, -apple-system, sans-serif");
			updateGoogleFontsLink();
		});
	});

	// Navigation Font
	wp.customize('neotiler_nav_font', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-nav', "'" + to + "', system-ui, -apple-system, sans-serif");
			updateGoogleFontsLink();
		});
	});

	// ═══════════════════════════════════════
	// FONT SIZE — Canlı Önizleme
	// ═══════════════════════════════════════

	// Body Font Size
	wp.customize('neotiler_body_font_size', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-body-size', parseFloat(to) + 'rem');
		});
	});

	// H1 Font Size
	wp.customize('neotiler_h1_font_size', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-h1-size', parseFloat(to) + 'rem');
		});
	});

	// H2 Font Size
	wp.customize('neotiler_h2_font_size', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-h2-size', parseFloat(to) + 'rem');
		});
	});

	// H3 Font Size
	wp.customize('neotiler_h3_font_size', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-h3-size', parseFloat(to) + 'rem');
		});
	});

	// Nav Font Size
	wp.customize('neotiler_nav_font_size', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-nav-size', parseFloat(to) + 'rem');
		});
	});

	// Meta Font Size
	wp.customize('neotiler_meta_font_size', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-meta-size', parseFloat(to) + 'rem');
		});
	});

	// ═══════════════════════════════════════
	// FONT WEIGHT — Canlı Önizleme
	// ═══════════════════════════════════════

	// Body Font Weight
	wp.customize('neotiler_body_font_weight', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-body-weight', to);
		});
	});

	// Heading Font Weight
	wp.customize('neotiler_heading_font_weight', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-heading-weight', to);
		});
	});

	// Nav Font Weight
	wp.customize('neotiler_nav_font_weight', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-nav-weight', to);
		});
	});

	// ═══════════════════════════════════════
	// DİĞER TİPOGRAFİ AYARLARI
	// ═══════════════════════════════════════

	// Body Line Height
	wp.customize('neotiler_body_line_height', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-body-line-height', parseFloat(to));
		});
	});

	// Heading Letter Spacing
	wp.customize('neotiler_heading_letter_spacing', function (value) {
		value.bind(function (to) {
			setCSSVar('--font-heading-letter-spacing', parseFloat(to) + 'em');
		});
	});

	// Button Border Radius
	wp.customize('neotiler_btn_border_radius', function (value) {
		value.bind(function (to) {
			setCSSVar('--btn-border-radius', parseInt(to, 10) + 'px');
		});
	});

}(jQuery));
