<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package NeoTiler_Blog
 */

get_header();
?>

<div class="container mx-auto px-4 max-w-[1200px] pt-8 pb-16">

	<?php
	while (have_posts()):
		the_post();

		$categories = get_the_category();
		$thumbnail_url = get_the_post_thumbnail_url(null, 'full');
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('space-y-8'); ?>>

			<!-- Category Badge + Title -->
			<header class="space-y-5">
				<?php if (!empty($categories)): ?>
					<div class="flex items-center gap-3">
						<?php foreach (array_slice($categories, 0, 3) as $cat): ?>
							<a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"
								class="inline-block text-slate-900 dark:text-slate-200 text-[11px] font-bold uppercase tracking-widest px-0 py-1 hover:text-slate-900 dark:hover:text-amber-400 transition-colors">
								<?php echo esc_html($cat->name); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<h1
					class="text-3xl md:text-4xl lg:text-[46px] font-black text-slate-900 dark:text-white leading-[1.15] tracking-tight">
					<?php the_title(); ?>
				</h1>

				<!-- Author & Meta Row -->
				<div
					class="flex flex-wrap items-center gap-4 text-sm text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800 pb-6">
					<div class="flex items-center gap-3">
						<?php echo get_avatar(get_the_author_meta('ID'), 40, '', '', array('class' => 'w-10 h-10 rounded-full object-cover')); ?>
						<div>
							<span
								class="block font-bold text-slate-900 dark:text-white text-sm"><?php the_author(); ?></span>
							<span class="text-xs text-slate-400"><?php echo get_the_date('j F Y'); ?></span>
						</div>
					</div>
					<span class="hidden sm:inline text-slate-300 dark:text-slate-700">|</span>
					<span class="flex items-center gap-1 text-xs">
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
						</svg>
						<?php
						$content = get_the_content();
						$word_count = str_word_count(strip_tags($content));
						$reading_time = max(1, ceil($word_count / 200));
						echo $reading_time . ' ' . esc_html__('min read', 'neotiler-blog');
						?>
					</span>
					<?php if (get_comments_number() > 0): ?>
						<span class="flex items-center gap-1 text-xs">
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
								</path>
							</svg>
							<?php echo get_comments_number(); ?>
						</span>
					<?php endif; ?>
				</div>
			</header>

			<!-- Featured Image -->
			<?php if ($thumbnail_url): ?>
				<figure class="relative overflow-hidden bg-slate-100 dark:bg-slate-800 aspect-video">
					<img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
						class="w-full h-full object-cover">
					<?php if (get_the_post_thumbnail_caption()): ?>
						<figcaption class="mt-3 text-xs text-slate-400 italic text-center">
							<?php echo esc_html(get_the_post_thumbnail_caption()); ?>
						</figcaption>
					<?php endif; ?>
				</figure>
			<?php endif; ?>

			<!-- Alttaki metin ve yorum kısımlarını eski dar halinde bırakmak ve ortalamak için wrapper -->
			<div class="w-full max-w-4xl mx-auto">

				<!-- Article Content -->
				<div class="entry-content prose prose-lg dark:prose-invert max-w-none
				prose-headings:font-black prose-headings:tracking-tight
				prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:font-bold prose-a:no-underline hover:prose-a:underline
				prose-img:w-full prose-img:object-cover
				prose-blockquote:border-l-blue-600 prose-blockquote:border-l-4 prose-blockquote:bg-blue-50/50 prose-blockquote:dark:bg-blue-900/20 prose-blockquote:py-4 prose-blockquote:px-6
				prose-code:bg-slate-100 prose-code:dark:bg-slate-800 prose-code:px-1.5 prose-code:py-0.5 prose-code:text-sm prose-code:font-mono
				prose-pre:bg-slate-900 prose-pre:dark:bg-black">
					<?php
					the_content();

					wp_link_pages(array(
						'before' => '<div class="page-links flex items-center gap-2 mt-8 text-sm font-bold">' . esc_html__('Pages:', 'neotiler-blog'),
						'after' => '</div>',
					));
					?>
				</div>

				<!-- Tags -->
				<?php
				$tags = get_the_tags();
				if ($tags): ?>
					<div class="flex flex-wrap items-center gap-2 pt-6 border-t border-slate-200 dark:border-slate-800">
						<span class="text-xs font-bold uppercase tracking-widest text-slate-400 mr-2">Tags:</span>
						<?php foreach ($tags as $tag): ?>
							<a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
								class="text-xs font-semibold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 hover:bg-primary hover:text-black transition-colors">
								<?php echo esc_html($tag->name); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<!-- Share Buttons -->
				<div class="flex items-center gap-4 py-6 border-t border-b border-slate-200 dark:border-slate-800">
					<span class="text-xs font-bold uppercase tracking-widest text-slate-400">Share:</span>
					<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
						target="_blank" rel="noopener noreferrer"
						class="w-9 h-9 bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-sky-500 hover:text-white transition-colors">
						<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
							<path
								d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
						</svg>
					</a>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
						target="_blank" rel="noopener noreferrer"
						class="w-9 h-9 bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-blue-600 hover:text-white transition-colors">
						<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
							<path
								d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z" />
						</svg>
					</a>
					<a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>"
						target="_blank" rel="noopener noreferrer"
						class="w-9 h-9 bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-green-500 hover:text-white transition-colors">
						<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
							<path
								d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
						</svg>
					</a>
					<button onclick="navigator.clipboard.writeText('<?php echo esc_url(get_permalink()); ?>')"
						class="w-9 h-9 bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:bg-slate-900 hover:text-white dark:hover:bg-white dark:hover:text-slate-900 transition-colors"
						title="Copy Link">
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
							</path>
						</svg>
					</button>
				</div>

				<!-- Author Box -->
				<div
					class="mt-12 bg-white dark:bg-slate-900 rounded-2xl p-8 shadow-sm border border-slate-200/60 dark:border-slate-800 flex flex-col md:flex-row items-center md:items-start gap-6 relative overflow-hidden group">
					<!-- Decorative Background Blob -->
					<div
						class="absolute -top-12 -right-12 w-32 h-32 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors duration-500">
					</div>

					<?php echo get_avatar(get_the_author_meta('ID'), 96, '', '', array('class' => 'w-20 h-20 md:w-24 md:h-24 rounded-full object-cover flex-shrink-0 shadow-md border-2 border-white dark:border-slate-800 z-10')); ?>

					<div class="text-center md:text-left z-10 flex-1">
						<span
							class="inline-block px-2.5 py-1 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-widest rounded-full mb-3">Author</span>
						<h3 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white mb-2">
							<?php the_author(); ?>
						</h3>
						<p class="text-sm md:text-base text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
							<?php
							$author_desc = get_the_author_meta('description');
							echo !empty($author_desc) ? esc_html($author_desc) : __('No biography has been entered for this author yet.', 'neotiler-blog');
							?>
						</p>
						<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
							class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:text-blue-700 dark:hover:text-blue-400 transition-colors">
							See all posts
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
									d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
							</svg>
						</a>
					</div>
				</div>

				<!-- Recommended Articles (Önerilen Yazılar) -->
				<div class="mt-8 md:mt-12">
					<div class="flex items-center justify-between mb-6">
						<h3 class="text-2xl font-black text-slate-900 dark:text-white">Related Posts</h3>
					</div>

					<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
						<?php
						$categories = get_the_category();
						$category_ids = array();
						if ($categories) {
							foreach ($categories as $category) {
								$category_ids[] = $category->term_id;
							}
						}

						$args = array(
							'category__in' => $category_ids,
							'post__not_in' => array(get_the_ID()),
							'posts_per_page' => 2,
							'orderby' => 'rand'
						);
						$my_query = new WP_Query($args);

						if ($my_query->have_posts()) {
							while ($my_query->have_posts()):
								$my_query->the_post();
								$rec_thumb = get_the_post_thumbnail_url(null, 'medium_large') ?: 'https://via.placeholder.com/600x400';
								$rec_cat = get_the_category();
								$rec_cat_name = !empty($rec_cat) ? $rec_cat[0]->name : '';
								?>
								<a href="<?php echo esc_url(get_permalink()); ?>"
									class="group block bg-white dark:bg-slate-900 rounded-2xl overflow-hidden border border-slate-200/50 dark:border-slate-800 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
									<div class="relative aspect-[16/9] overflow-hidden bg-slate-100 dark:bg-slate-800">
										<img src="<?php echo esc_url($rec_thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
											class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
										<?php if ($rec_cat_name): ?>
											<div
												class="absolute top-4 left-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider text-slate-900 dark:text-white shadow-sm">
												<?php echo esc_html($rec_cat_name); ?>
											</div>
										<?php endif; ?>
									</div>
									<div class="p-6">
										<h4
											class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-4 mb-3">
											<?php the_title(); ?>
										</h4>
										<div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400 font-medium">
											<span><?php echo get_the_date('j M, Y'); ?></span>
											<span>•</span>
											<span><?php echo get_avatar(get_the_author_meta('ID'), 20, '', '', array('class' => 'inline-block w-5 h-5 rounded-full mr-1.5 object-cover')); ?>
												<?php the_author(); ?></span>
										</div>
									</div>
								</a>
								<?php
							endwhile;
							wp_reset_postdata();
						} else {
							echo '<p class="text-slate-500 text-sm">' . __('No suggestions found.', 'neotiler-blog') . '</p>';
						}
						?>
					</div>
				</div>

			</div> <!-- wrapper bitişi -->
		</article>

		<!-- Comments -->
		<div class="w-full max-w-4xl mx-auto">
			<?php
			if (comments_open() || get_comments_number()):
				comments_template();
			endif;
			?>
		</div>

	<?php endwhile; ?>

</div>

<?php
get_footer();
