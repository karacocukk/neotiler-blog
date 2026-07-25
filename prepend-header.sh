#!/bin/bash
# Prepend WordPress theme header to style.css after Tailwind build
HEADER='/*
Theme Name: NeoTiler Blog
Theme URI: https://getneotiler.com
Author: Veysel Okatan
Author URI: https://getneotiler.com
Description: Custom Tailwind CSS based highly-performant tech blog theme
Version: 1.0.2
Tested up to: 6.7
Requires PHP: 8.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: neotiler-blog
Tags: custom-background, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready
*/
'
echo "$HEADER" | cat - style.css > /tmp/style_with_header.css && mv /tmp/style_with_header.css style.css
echo "✅ WordPress theme header prepended to style.css"
