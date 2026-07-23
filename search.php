<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package NeoTiler_Blog
 */

get_header();
?>

<div class="container mx-auto px-4 max-w-[1200px] pt-8 pb-16">

	<?php if (have_posts()): ?>

		<!-- Search Header -->
		<header class="mb-12 border-b border-slate-200 dark:border-slate-800 pb-8">
			<h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white tracking-tight">
				<?php
				/* translators: %s: search query. */
				printf(esc_html__('Search Results for: %s', 'neotiler-blog'), '<span class="text-primary">' . get_search_query() . '</span>');
				?>
			</h1>
		</header>

		<!-- Posts Grid -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			while (have_posts()):
				the_post();
				$thumbnail_url = get_the_post_thumbnail_url(null, 'medium_large') ?: 'https://via.placeholder.com/600x400';
				$categories = get_the_category();
				?>
				<article class="group flex flex-col">
					<a href="<?php echo esc_url(get_permalink()); ?>"
						class="block overflow-hidden relative aspect-[4/3] bg-slate-100 dark:bg-slate-800 mb-5">
						<img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
							class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
						<div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
					</a>

					<div class="flex flex-col flex-1">
						<?php if (!empty($categories)): ?>
							<span class="text-[10px] font-bold text-primary uppercase tracking-widest mb-2">
								<?php echo esc_html($categories[0]->name); ?>
							</span>
						<?php endif; ?>

						<h2
							class="text-lg font-bold text-slate-900 dark:text-white leading-snug mb-3 group-hover:text-primary transition-colors line-clamp-2">
							<a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
						</h2>

						<p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 mb-4">
							<?php echo esc_html(wp_trim_words(get_the_excerpt(), 20, '...')); ?>
						</p>

						<div class="mt-auto flex items-center gap-3 text-xs text-slate-400">
							<?php echo get_avatar(get_the_author_meta('ID'), 24, '', '', array('class' => 'w-6 h-6 object-cover flex-shrink-0')); ?>
							<span class="font-semibold text-slate-600 dark:text-slate-300"><?php the_author(); ?></span>
							<span>&bull;</span>
							<span><?php echo get_the_date('j M Y'); ?></span>
						</div>
					</div>
				</article>
			<?php endwhile; ?>
		</div>

		<!-- Pagination -->
		<nav class="mt-16 flex items-center justify-center gap-2">
			<?php
			the_posts_pagination(array(
				'mid_size' => 2,
				'prev_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>',
				'next_text' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
				'class' => 'pagination-wrapper',
			));
			?>
		</nav>

	<?php else: ?>

		<div class="text-center py-20">
			<h1 class="text-3xl font-black text-slate-900 dark:text-white mb-4">
				<?php esc_html_e('No Results Found', 'neotiler-blog'); ?></h1>
			<p class="text-slate-500 dark:text-slate-400 text-lg mb-8">
				<?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'neotiler-blog'); ?>
			</p>

			<div class="max-w-md mx-auto relative text-left">
				<?php get_search_form(); ?>
			</div>
		</div>

	<?php endif; ?>

</div>

<?php
get_footer();
