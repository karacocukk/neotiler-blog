/**
 * NeoTiler Blog - Theme JavaScript
 * Search overlay, dark mode toggle, mobile drawer menu
 */
(function () {
    'use strict';

    // ==========================
    // Dark Mode Toggle
    // ==========================
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;

    if (localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });
    }

    // ==========================
    // Search Overlay
    // ==========================
    const searchBtn = document.getElementById('search-toggle');
    const searchOverlay = document.getElementById('search-overlay');
    const searchClose = document.getElementById('search-close');
    const searchInput = document.getElementById('search-input');

    if (searchBtn && searchOverlay) {
        searchBtn.addEventListener('click', function () {
            searchOverlay.classList.remove('hidden');
            searchOverlay.classList.add('flex');
            if (searchInput) searchInput.focus();
            document.body.style.overflow = 'hidden';
        });
    }

    if (searchClose && searchOverlay) {
        searchClose.addEventListener('click', function () {
            searchOverlay.classList.add('hidden');
            searchOverlay.classList.remove('flex');
            document.body.style.overflow = '';
        });
    }

    if (searchOverlay) {
        searchOverlay.addEventListener('click', function (e) {
            if (e.target === searchOverlay) {
                searchOverlay.classList.add('hidden');
                searchOverlay.classList.remove('flex');
                document.body.style.overflow = '';
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !searchOverlay.classList.contains('hidden')) {
                searchOverlay.classList.add('hidden');
                searchOverlay.classList.remove('flex');
                document.body.style.overflow = '';
            }
        });
    }

    // ==========================
    // Mobile Drawer Menu
    // ==========================
    const menuToggle = document.querySelector('.menu-toggle');
    const drawer = document.getElementById('mobile-drawer');
    const drawerOverlay = document.getElementById('mobile-drawer-overlay');
    const drawerClose = document.getElementById('drawer-close');

    function openDrawer() {
        if (!drawer || !drawerOverlay) return;
        drawerOverlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Trigger reflow for animation
        requestAnimationFrame(function () {
            drawerOverlay.classList.remove('opacity-0');
            drawerOverlay.classList.add('opacity-100');
            drawer.classList.remove('-translate-x-full');
            drawer.classList.add('translate-x-0');
        });
        if (menuToggle) menuToggle.setAttribute('aria-expanded', 'true');
    }

    function closeDrawer() {
        if (!drawer || !drawerOverlay) return;
        drawerOverlay.classList.remove('opacity-100');
        drawerOverlay.classList.add('opacity-0');
        drawer.classList.remove('translate-x-0');
        drawer.classList.add('-translate-x-full');
        document.body.style.overflow = '';
        if (menuToggle) menuToggle.setAttribute('aria-expanded', 'false');
        // Hide overlay after animation
        setTimeout(function () {
            drawerOverlay.classList.add('hidden');
        }, 300);
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', openDrawer);
    }

    if (drawerClose) {
        drawerClose.addEventListener('click', closeDrawer);
    }

    if (drawerOverlay) {
        drawerOverlay.addEventListener('click', closeDrawer);
    }

    // ESC ile drawer kapat
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && drawer && !drawer.classList.contains('-translate-x-full')) {
            closeDrawer();
        }
    });

    // ==========================
    // Video Carousel (Infinite Wheel Loop)
    // ==========================
    var slider = document.getElementById('video-slider');
    var prevBtn = document.getElementById('video-prev');
    var nextBtn = document.getElementById('video-next');

    if (slider && prevBtn && nextBtn) {
        var originalSlides = Array.from(slider.querySelectorAll('.video-slide'));
        var totalOriginals = originalSlides.length;

        if (totalOriginals > 1) {
            // 1. Clone First & Last for Seamless Loop
            var firstClone = originalSlides[0].cloneNode(true);
            var lastClone = originalSlides[totalOriginals - 1].cloneNode(true);

            // Mark clones so we don't re-clone or confuse them
            firstClone.classList.add('clone');
            lastClone.classList.add('clone');

            slider.appendChild(firstClone);
            slider.insertBefore(lastClone, originalSlides[0]);

            var allSlides = slider.querySelectorAll('.video-slide');
            var currentIndex = 1; // Start at the first "real" slide (index 1 because index 0 is the lastClone)
            var isScrolling = false;

            function getSlideWidth() {
                var slide = slider.querySelector('.video-slide');
                if (!slide) return 0;
                var style = window.getComputedStyle(slider);
                var gap = parseInt(style.gap) || 32;
                return slide.offsetWidth + gap;
            }

            function scrollToIndex(index, animate) {
                if (isScrolling && animate) return;
                if (animate) isScrolling = true;

                var slideWidth = getSlideWidth();

                if (!animate) {
                    slider.style.scrollSnapType = 'none';
                }

                slider.scrollTo({
                    left: index * slideWidth,
                    behavior: animate ? 'smooth' : 'auto'
                });

                if (!animate) {
                    setTimeout(function () {
                        slider.style.scrollSnapType = '';
                    }, 50);
                }

                if (animate) {
                    // Reset scrolling flag after animation
                    setTimeout(function () {
                        isScrolling = false;
                        checkLoopBoundary();
                    }, 600); // Should match CSS transition or scroll behavior duration
                }
            }

            function checkLoopBoundary() {
                // If we are on the firstClone (the very end), jump to the first original (index 1)
                if (currentIndex >= allSlides.length - 1) {
                    currentIndex = 1;
                    scrollToIndex(currentIndex, false);
                }
                // If we are on the lastClone (the very start), jump to the last original
                else if (currentIndex <= 0) {
                    currentIndex = allSlides.length - 2;
                    scrollToIndex(currentIndex, false);
                }
            }

            // Initial Position
            setTimeout(function () {
                scrollToIndex(currentIndex, false);
            }, 100);

            nextBtn.addEventListener('click', function () {
                if (isScrolling) return;
                currentIndex++;
                scrollToIndex(currentIndex, true);
            });

            prevBtn.addEventListener('click', function () {
                if (isScrolling) return;
                currentIndex--;
                scrollToIndex(currentIndex, true);
            });

            // Handle manual scrolling jumps
            var scrollTimeout;
            slider.addEventListener('scroll', function () {
                if (isScrolling) return;
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(function () {
                    var slideWidth = getSlideWidth();
                    var newIndex = Math.round(slider.scrollLeft / slideWidth);
                    if (newIndex !== currentIndex) {
                        currentIndex = newIndex;
                        checkLoopBoundary();
                    }
                }, 100);
            }, { passive: true });
        }
    }

    // ==========================
    // YouTube Video Embed on Click
    // ==========================
    // Load YouTube IFrame API once
    if (!window.YT) {
        var tag = document.createElement('script');
        tag.src = 'https://www.youtube.com/iframe_api';
        document.head.appendChild(tag);
    }

    document.querySelectorAll('[data-video-id]').forEach(function (el) {
        el.addEventListener('click', function () {
            var videoId = el.getAttribute('data-video-id');
            var playerId = 'yt-player-' + videoId + '-' + Date.now();
            var playerDiv = document.createElement('div');
            playerDiv.id = playerId;
            playerDiv.className = 'absolute inset-0 w-full h-full';
            el.innerHTML = '';
            el.appendChild(playerDiv);
            el.style.cursor = 'default';

            function createPlayer() {
                new YT.Player(playerId, {
                    videoId: videoId,
                    playerVars: { autoplay: 1, rel: 0 },
                    events: {
                        onReady: function (e) {
                            e.target.setVolume(50);
                        }
                    }
                });
            }

            if (window.YT && window.YT.Player) {
                createPlayer();
            } else {
                window.onYouTubeIframeAPIReady = createPlayer;
            }
        });
    });

    // ==========================
    // Load More Posts (AJAX)
    // ==========================
    const loadMoreBtn = document.getElementById('load-more-btn');
    if (loadMoreBtn && typeof neotiler_ajax !== 'undefined') {
        loadMoreBtn.addEventListener('click', function () {
            const btn = this;
            const originalText = btn.innerHTML;
            const offset = parseInt(btn.getAttribute('data-offset'), 10);

            btn.innerHTML = '<svg class="animate-spin h-5 w-5 text-white mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            btn.disabled = true;

            const formData = new URLSearchParams();
            formData.append('action', 'load_more_posts');
            formData.append('offset', offset);
            formData.append('posts_per_page', 6);

            fetch(neotiler_ajax.ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData.toString()
            })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === '') {
                        btn.innerHTML = 'NO MORE POSTS';
                        btn.disabled = true;
                        btn.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'text-white');
                        btn.classList.add('bg-slate-200', 'dark:bg-slate-700', 'cursor-not-allowed', 'text-slate-600', 'dark:text-slate-500');
                    } else {
                        const container = document.getElementById('latest-posts-container');
                        container.insertAdjacentHTML('beforeend', data);
                        btn.setAttribute('data-offset', offset + 6);
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error loading posts:', error);
                    btn.innerHTML = 'ERROR! TRY AGAIN';
                    btn.disabled = false;
                });
        });
    }

    // ==========================
    // Comment Form Validation & AJAX Submission
    // ==========================
    const commentForm = document.getElementById('commentform');
    if (commentForm) {
        commentForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const commentField = document.getElementById('comment');
            if (commentField && !commentField.value.trim()) {
                // Remove existing alert if any
                const existingAlert = document.getElementById('comment-alert');
                if (existingAlert) existingAlert.remove();

                // Create modern "balloon" alert
                const alert = document.createElement('div');
                alert.id = 'comment-alert';
                alert.className = 'absolute -top-12 left-0 right-0 mx-auto w-max px-4 py-2 bg-red-500 text-white text-xs font-bold rounded-lg shadow-xl animate-bounce z-50';
                alert.innerHTML = 'Please write a comment before submitting!';

                commentField.parentElement.style.position = 'relative';
                commentField.parentElement.appendChild(alert);

                setTimeout(() => {
                    alert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                    setTimeout(() => alert.remove(), 500);
                }, 3000);

                commentField.focus();
                return;
            }

            const submitBtn = document.getElementById('submit');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Submitting...';
            submitBtn.disabled = true;

            const formData = new FormData(commentForm);
            formData.append('action', 'submit_ajax_comment');

            // Add comment_post_ID explicitly if missing in some setups (it's usually standard)
            if (!formData.has('comment_post_ID')) {
                const post_id = document.getElementById('comment_post_ID')?.value;
                if (post_id) formData.append('comment_post_ID', post_id);
            }

            fetch(neotiler_ajax.ajaxurl, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const commentList = document.querySelector('.comment-list');
                        const parentId = formData.get('comment_parent');

                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = data.data.comment_html;
                        const newCommentNode = tempDiv.firstElementChild;

                        if (parentId && parentId !== '0') {
                            // It's a reply
                            const parentComment = document.getElementById('comment-' + parentId);
                            if (parentComment) {
                                let childrenList = parentComment.querySelector('.children');
                                if (!childrenList) {
                                    childrenList = document.createElement('ul');
                                    childrenList.className = 'children';
                                    parentComment.appendChild(childrenList);
                                    parentComment.classList.add('parent');
                                }
                                childrenList.appendChild(newCommentNode);
                            }
                        } else {
                            // Top level comment
                            if (commentList) {
                                commentList.appendChild(newCommentNode);
                            } else {
                                // If no comments list existed, reload to show the new structure, or create it dynamically
                                location.reload();
                                return;
                            }
                        }

                        // Remove "No comments" message if present
                        const noCommentsMsg = document.querySelector('.no-comments');
                        if (noCommentsMsg) noCommentsMsg.remove();

                        // Reset form
                        commentField.value = '';
                        const cancelReplyLink = document.getElementById('cancel-comment-reply-link');
                        if (cancelReplyLink && cancelReplyLink.style.display !== 'none') {
                            cancelReplyLink.click();
                        }
                    } else {
                        alert(data.data || 'Error submitting comment.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('A network error occurred.');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                });
        });
    }

    // ==========================
    // Comment Form Rich Text & Emojis
    // ==========================
    const commentTextArea = document.getElementById('comment');
    const boldBtn = document.getElementById('btn-bold');
    const italicBtn = document.getElementById('btn-italic');
    const underlineBtn = document.getElementById('btn-underline');
    const linkBtn = document.getElementById('btn-link');
    const imageBtn = document.getElementById('btn-image');
    const emojiBtn = document.getElementById('btn-emoji');
    const emojiContainer = document.getElementById('emoji-picker-container');
    const picker = document.querySelector('emoji-picker');
    const mediaModal = document.getElementById('media-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalInputText = document.getElementById('modal-input-text');
    const modalInputUrl = document.getElementById('modal-input-url');
    const modalTextGroup = document.getElementById('modal-text-group');
    const modalUrlLabel = document.getElementById('modal-url-label');
    const modalSaveBtn = document.getElementById('modal-save');
    const modalCancelBtn = document.getElementById('modal-cancel');
    const modalCloseBtn = document.getElementById('modal-close');
    const modalBackdrop = document.getElementById('media-modal-backdrop');
    const modalCard = document.getElementById('media-modal-card');

    let currentModalType = 'link'; // 'link' or 'image'

    function openMediaModal(type) {
        currentModalType = type;
        mediaModal.classList.remove('hidden');

        // Reset inputs
        modalInputText.value = '';
        modalInputUrl.value = '';

        if (type === 'link') {
            modalTitle.textContent = 'Add Link';
            modalTextGroup.classList.remove('hidden');
            modalUrlLabel.textContent = 'Link*';
            modalInputUrl.placeholder = 'https://...';

            // If text is selected, pre-fill it
            if (commentTextArea) {
                const start = commentTextArea.selectionStart;
                const end = commentTextArea.selectionEnd;
                if (start !== end) {
                    modalInputText.value = commentTextArea.value.substring(start, end);
                }
            }
        } else {
            modalTitle.textContent = 'Add Image';
            modalTextGroup.classList.add('hidden');
            modalUrlLabel.textContent = 'Image URL*';
            modalInputUrl.placeholder = 'https://example.com/image.jpg';
        }

        // Trigger animation
        requestAnimationFrame(() => {
            mediaModal.classList.add('show');
            modalInputUrl.focus();
        });
    }

    function closeMediaModal() {
        mediaModal.classList.remove('show');
        setTimeout(() => {
            mediaModal.classList.add('hidden');
        }, 300);
    }

    if (linkBtn) linkBtn.addEventListener('click', () => openMediaModal('link'));
    if (imageBtn) imageBtn.addEventListener('click', () => openMediaModal('image'));

    if (modalSaveBtn) {
        modalSaveBtn.addEventListener('click', () => {
            const url = modalInputUrl.value.trim();
            const text = modalInputText.value.trim();

            if (!url) {
                modalInputUrl.focus();
                return;
            }

            if (!commentTextArea) return;

            const start = commentTextArea.selectionStart;
            const end = commentTextArea.selectionEnd;
            const currentVal = commentTextArea.value;
            let insertText = '';

            if (currentModalType === 'link') {
                const linkText = text || url;
                insertText = `<a href="${url}">${linkText}</a>`;
            } else {
                insertText = `<img src="${url}" alt="Comment Image" class="comment-img" />`;
            }

            commentTextArea.value = currentVal.substring(0, start) + insertText + currentVal.substring(end);
            commentTextArea.focus();

            const newPos = start + insertText.length;
            commentTextArea.setSelectionRange(newPos, newPos);

            closeMediaModal();
        });
    }

    if (modalCancelBtn) modalCancelBtn.addEventListener('click', closeMediaModal);
    if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeMediaModal);
    if (modalBackdrop) modalBackdrop.addEventListener('click', closeMediaModal);

    // Support ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (!mediaModal.classList.contains('hidden')) closeMediaModal();
            const lightbox = document.getElementById('lightbox-overlay');
            if (lightbox && lightbox.classList.contains('show')) closeLightbox();
        }
    });

    // Lightbox Logic
    function showLightbox(src) {
        let overlay = document.getElementById('lightbox-overlay');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'lightbox-overlay';
            overlay.innerHTML = '<img id="lightbox-img" src="" alt="Enlarged Image" />';
            document.body.appendChild(overlay);

            overlay.addEventListener('click', closeLightbox);
        }

        const img = overlay.querySelector('img');
        img.src = src;

        overlay.style.display = 'flex';
        requestAnimationFrame(() => {
            overlay.classList.add('show');
        });
    }

    function closeLightbox() {
        const overlay = document.getElementById('lightbox-overlay');
        if (overlay) {
            overlay.classList.remove('show');
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 300);
        }
    }

    // Global listener for comment images
    document.addEventListener('click', (e) => {
        // Target images inside comments or images with our specific class
        const target = e.target;
        if (target.tagName === 'IMG' && (target.closest('.comment-content') || target.classList.contains('comment-img'))) {
            showLightbox(target.src);
        }
    });

    // Emoji Picker Logic
    if (emojiBtn && emojiContainer) {
        emojiBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = emojiContainer.classList.toggle('hidden');
            if (!isHidden) {
                emojiContainer.classList.add('scale-100', 'opacity-100');
                emojiContainer.classList.remove('scale-90', 'opacity-0');
            } else {
                emojiContainer.classList.remove('scale-100', 'opacity-100');
                emojiContainer.classList.add('scale-90', 'opacity-0');
            }
        });

        if (picker) {
            picker.addEventListener('emoji-click', event => {
                const emoji = event.detail.unicode;
                const start = commentTextArea.selectionStart;
                const end = commentTextArea.selectionEnd;
                const text = commentTextArea.value;
                commentTextArea.value = text.substring(0, start) + emoji + text.substring(end);
                commentTextArea.focus();
                commentTextArea.setSelectionRange(start + emoji.length, start + emoji.length);
            });
        }

        document.addEventListener('click', (e) => {
            const path = e.composedPath();
            if (!path.includes(emojiBtn) && !path.includes(emojiContainer)) {
                emojiContainer.classList.add('hidden');
                emojiContainer.classList.remove('scale-100', 'opacity-100');
                emojiContainer.classList.add('scale-90', 'opacity-0');
            }
        });
    }

    // Comment Voting Logic
    document.addEventListener('click', (e) => {
        const voteBtn = e.target.closest('.vote-btn');
        if (!voteBtn) return;

        e.preventDefault();
        const commentId = voteBtn.dataset.id;
        const voteType = voteBtn.dataset.type;
        const countSpan = voteBtn.closest('.flex').querySelector('.vote-count');

        // Visual feedback - temporary disable
        voteBtn.style.pointerEvents = 'none';
        voteBtn.style.opacity = '0.5';

        const formData = new FormData();
        formData.append('action', 'comment_vote');
        formData.append('comment_id', commentId);
        formData.append('vote_type', voteType);

        fetch(neotiler_ajax.ajaxurl, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (countSpan) {
                        countSpan.textContent = data.data.score;
                    }
                    // Highlighting the voted button
                    if (voteType === 'upvote') {
                        voteBtn.classList.add('text-primary');
                    } else {
                        voteBtn.classList.add('text-red-500');
                    }
                } else {
                    // Already voted or error
                    const originalColor = voteBtn.style.color;
                    voteBtn.style.color = '#ef4444';
                    setTimeout(() => { voteBtn.style.color = originalColor; }, 500);
                    console.log('Vote error:', data.data);
                }
            })
            .catch(error => console.error('Error:', error))
            .finally(() => {
                voteBtn.style.pointerEvents = 'auto';
                voteBtn.style.opacity = '1';
            });
    });

    // Reply Form UX: Sync custom cancel button with WordPress reply logic
    const customCancelBtn = document.getElementById('cancel-comment-reply-custom');
    const realCancelLink = document.getElementById('cancel-comment-reply-link');

    if (customCancelBtn && realCancelLink) {
        // Observer to watch when WordPress toggles visibility on the real cancel link
        const observer = new MutationObserver(() => {
            if (realCancelLink.style.display !== 'none') {
                customCancelBtn.classList.remove('hidden');
            } else {
                customCancelBtn.classList.add('hidden');
            }
        });

        observer.observe(realCancelLink, { attributes: true, attributeFilter: ['style'] });

        // When custom button is clicked, trigger the real one
        customCancelBtn.addEventListener('click', () => {
            realCancelLink.click();
        });
    }

})();

