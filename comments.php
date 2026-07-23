<?php
/**
 * The template for displaying comments
 *
 * @package NeoTiler_Blog
 */

if (post_password_required()) {
	return;
}
?>

<div id="comments" class="comments-area mt-16 pt-12 border-t border-slate-100 dark:border-slate-800">


	<?php
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$aria_req = ($req ? " aria-required='true'" : '');

	// Modern Form Logic - ALWAYS AT THE TOP
	comment_form(array(
		'fields' => array(
			'author' => '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <input id="author" name="author" type="text" placeholder="' . esc_attr__('Name*', 'neotiler-blog') . '" value="' . esc_url($commenter['comment_author']) . '" size="30"' . $aria_req . ' class="w-full px-4 py-2.5 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm" />',
			'email' => '<input id="email" name="email" type="email" placeholder="' . esc_attr__('Email*', 'neotiler-blog') . '" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' class="w-full px-4 py-2.5 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm" />
                        </div>',
			'cookies' => '<div class="comment-form-cookies-consent flex items-center gap-2 mb-6">
                            <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary" />
                            <label for="wp-comment-cookies-consent" class="text-xs text-slate-500 dark:text-slate-400">' . esc_html__('Save my name, email, and website for the next time I comment.', 'neotiler-blog') . '</label>
                          </div>',
		),
		'comment_field' => '<div class="relative bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-200 dark:border-slate-800 p-2 focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary transition-all mb-4">
                                <textarea id="comment" name="comment" rows="3" placeholder="' . esc_attr__('Add comment...', 'neotiler-blog') . '" class="w-full bg-transparent border-none outline-none px-4 py-2 text-sm text-slate-900 dark:text-white placeholder-slate-400 resize-none"></textarea>
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-slate-200/60 dark:border-slate-800/60 mt-2 pt-2 px-2 pb-2">
                                    <div class="flex items-center gap-1 text-slate-500 dark:text-slate-400">
                                        <button type="button" id="btn-bold" title="Bold" class="w-8 h-8 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md cursor-pointer transition-colors"><span class="font-bold text-base">B</span></button>
                                        <button type="button" id="btn-italic" title="Italic" class="w-8 h-8 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md cursor-pointer transition-colors"><span class="italic text-base font-serif">I</span></button>
                                        <button type="button" id="btn-underline" title="Underline" class="w-8 h-8 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md cursor-pointer transition-colors"><span class="underline text-base">U</span></button>
                                        
                                        <div class="w-px h-4 bg-slate-200 dark:bg-slate-800 mx-1"></div>
                                        
                                        <button type="button" id="btn-link" title="Link" class="w-8 h-8 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md cursor-pointer transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg></button>
                                        <button type="button" id="btn-image" title="Insert Image URL" class="w-8 h-8 flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md cursor-pointer transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></button>
                                        <button type="button" id="btn-emoji" title="Emoji" class="hidden sm:flex w-8 h-8 items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 rounded-md cursor-pointer transition-colors relative">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <div id="emoji-picker-container" class="hidden absolute bottom-full left-0 mb-2 z-50 shadow-2xl rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 scale-90 origin-bottom-left transition-all">
                                                <emoji-picker></emoji-picker>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-2 w-full sm:w-auto">
                                        <button type="button" id="cancel-comment-reply-custom" class="hidden px-4 py-2 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 text-sm font-semibold transition-colors cursor-pointer">Cancel</button>
                                        <button name="submit" type="submit" id="submit" class="flex-1 sm:flex-none px-6 py-2 bg-slate-900 dark:bg-primary hover:bg-slate-800 dark:hover:bg-primary/90 text-white text-sm font-bold rounded-full transition-all shadow-md shadow-slate-200 dark:shadow-primary/10 cursor-pointer">Submit</button>
                                    </div>
                                </div>
                            </div>',
		'title_reply' => '<div id="reply-title-hidden" class="hidden">',
		'title_reply_to' => '<div id="reply-title-hidden" class="hidden">',
		'class_submit' => 'hidden',
		'submit_button' => '',
		'submit_field' => '%1$s %2$s',
	));
	?>

	<?php if (have_comments()): ?>
		<div class="flex items-center justify-between mt-12 mb-8 pt-12 border-t border-slate-100 dark:border-slate-800/60">
			<div class="flex items-center gap-3">
				<h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">
					<?php esc_html_e('Comments', 'neotiler-blog'); ?>
				</h2>
				<span
					class="inline-flex items-center justify-center px-2 py-0.5 bg-primary text-white text-[10px] font-bold rounded-full">
					<?php echo number_format_i18n(get_comments_number()); ?>
				</span>
			</div>

			<!-- Sorting Dropdown -->
			<?php
			$current_sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
			$sort_label = 'Most recent';
			if ($current_sort === 'oldest')
				$sort_label = 'Oldest';
			if ($current_sort === 'top')
				$sort_label = 'Top';
			?>
			<div class="relative group">
				<button type="button"
					class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400 cursor-pointer hover:text-slate-900 dark:hover:text-white transition-colors">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
					</svg>
					<span><?php echo esc_html($sort_label); ?></span>
					<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd"
							d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
							clip-rule="evenodd"></path>
					</svg>
				</button>
				<div class="absolute right-0 pt-2 w-32 hidden group-hover:block transition-all z-50">
					<div
						class="bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-100 dark:border-slate-800 py-2">
						<a href="?sort=newest#comments"
							class="block px-4 py-2 text-[10px] uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 <?php echo $current_sort === 'newest' ? 'font-bold text-primary ring-1 ring-inset ring-primary/20 rounded-md mx-1' : ''; ?>">Most
							recent</a>
						<a href="?sort=oldest#comments"
							class="block px-4 py-2 text-[10px] uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 <?php echo $current_sort === 'oldest' ? 'font-bold text-primary ring-1 ring-inset ring-primary/20 rounded-md mx-1' : ''; ?>">Oldest</a>
						<a href="?sort=top#comments"
							class="block px-4 py-2 text-[10px] uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 <?php echo $current_sort === 'top' ? 'font-bold text-primary ring-1 ring-inset ring-primary/20 rounded-md mx-1' : ''; ?>">Top</a>
					</div>
				</div>
			</div>
		</div>

		<ul class="comment-list">
			<?php
			wp_list_comments(array(
				'style' => 'ul',
				'short_ping' => true,
				'callback' => 'neotiler_blog_comment',
				'avatar_size' => 48,
			));
			?>
		</ul>

		<?php
		the_comments_navigation(array(
			'prev_text' => '<span class="px-4 py-2 bg-slate-50 dark:bg-slate-800 rounded-lg text-sm font-bold">' . esc_html__('Older Comments', 'neotiler-blog') . '</span>',
			'next_text' => '<span class="px-4 py-2 bg-slate-50 dark:bg-slate-800 rounded-lg text-sm font-bold">' . esc_html__('Newer Comments', 'neotiler-blog') . '</span>',
		));

		if (!comments_open()): ?>
			<p class="no-comments text-center py-6 text-slate-500 italic">
				<?php esc_html_e('Comments are closed.', 'neotiler-blog'); ?>
			</p>
		<?php endif; ?>

	<?php endif; ?>

	<!-- Rich Media Modal (Link/Image) -->
	<div id="media-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
		<div id="media-modal-backdrop" class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] transition-opacity">
		</div>

		<div class="relative bg-white dark:bg-slate-900 w-full max-w-md rounded-[24px] shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden transform transition-all scale-95 opacity-0"
			id="media-modal-card">
			<!-- Modal Header -->
			<div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800">
				<h3 id="modal-title" class="text-lg font-bold text-slate-900 dark:text-white">Add Link</h3>
				<button type="button" id="modal-close"
					class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
						</path>
					</svg>
				</button>
			</div>

			<!-- Modal Body -->
			<div class="p-6 space-y-4">
				<div id="modal-text-group">
					<label for="modal-input-text"
						class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">Text</label>
					<input type="text" id="modal-input-text" placeholder="Link text..."
						class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm dark:text-white" />
				</div>
				<div>
					<label for="modal-input-url" id="modal-url-label"
						class="block text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">Link*</label>
					<input type="url" id="modal-input-url" placeholder="https://..."
						class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm dark:text-white" />
				</div>
			</div>

			<!-- Modal Footer -->
			<div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-800/30 flex items-center justify-between gap-3">
				<button type="button" id="modal-cancel"
					class="flex-1 px-6 py-2.5 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-sm font-bold rounded-full transition-all">Cancel</button>
				<button type="button" id="modal-save"
					class="flex-1 px-6 py-2.5 bg-slate-900 dark:bg-primary hover:bg-slate-800 dark:hover:bg-primary/90 text-white text-sm font-bold rounded-full transition-all shadow-lg shadow-slate-200 dark:shadow-primary/20">Save</button>
			</div>
		</div>
	</div>

</div>