<?php
/**
 * The template for displaying all pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NeoTiler_Blog
 */

get_header();
?>

<div class="container mx-auto px-4 max-w-4xl pt-8 pb-16">

	<?php
	while (have_posts()):
		the_post();
		$thumbnail_url = get_the_post_thumbnail_url(null, 'full');
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('space-y-8'); ?>>

			<header class="space-y-4 mb-8 border-b border-slate-200 dark:border-slate-800 pb-8">
				<h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
					<?php the_title(); ?>
				</h1>
			</header>

			<?php if ($thumbnail_url): ?>
				<figure class="overflow-hidden bg-slate-100 dark:bg-slate-800 aspect-video mb-8">
					<img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
						class="w-full h-full object-cover">
				</figure>
			<?php endif; ?>

			<div class="entry-content prose prose-lg dark:prose-invert max-w-none
				prose-headings:font-black prose-headings:tracking-tight
				prose-a:text-primary prose-a:no-underline hover:prose-a:underline
				prose-img:w-full prose-img:object-cover
				prose-blockquote:border-l-primary prose-blockquote:border-l-4">
				<?php
				the_content();

				wp_link_pages(array(
					'before' => '<div class="page-links flex items-center gap-2 mt-8 text-sm font-bold">' . esc_html__('Pages:', 'neotiler-blog'),
					'after' => '</div>',
				));
				?>
			</div>

		</article>

		<?php
		if (comments_open() || get_comments_number()):
			comments_template();
		endif;

	endwhile;
	?>

</div>

<?php
get_footer();
