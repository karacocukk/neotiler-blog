<?php
/**
 * The front page template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NeoTiler_Blog
 */

get_header();
?>

<div class="container mx-auto px-4 max-w-[1200px] pt-8 pb-16 space-y-16">

    <!-- HERO SECTION -->
    <section aria-label="Hero Section" class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-6">
        <?php
        // Tek ve optimize edilmiş Hero Sorgusu (7 Yazı çekiyoruz)
        $hero_query = new WP_Query(array(
            'posts_per_page' => 7,
            'ignore_sticky_posts' => 1
        ));

        $hero_posts = $hero_query->posts;
        wp_reset_postdata();

        // Gösterim Düzeni:
        // [0] -> Orta Sütun (Büyük, Siyah Arka Plan)
        // [1] -> Sol Sütun Üst (Beyaz Kart)
        // [2] -> Sağ Sütun Üst (Beyaz Kart)
        // [3,4] -> Sol Sütun Alt (Liste)
        // [5,6] -> Sağ Sütun Alt (Liste)
        $main_post = isset($hero_posts[0]) ? $hero_posts[0] : null;
        $left_post = isset($hero_posts[1]) ? $hero_posts[1] : null;
        $right_post = isset($hero_posts[2]) ? $hero_posts[2] : null;
        $left_list = array_slice($hero_posts, 3, 2);
        $right_list = array_slice($hero_posts, 5, 2);

        // Yardımcı Fonksiyonlar (Aynı kodları tekrar yazmamak için)
        if (!function_exists('neotiler_render_clean_card')) {
            function neotiler_render_clean_card($p)
            {
                if (!$p)
                    return;
                $thumb = get_the_post_thumbnail_url($p, 'medium_large') ?: 'https://via.placeholder.com/600x400';
                $cat = get_the_category($p->ID);
                $cat_name = !empty($cat) ? $cat[0]->name : '';
                ?>
                <article class="group cursor-pointer">
                    <a href="<?php echo esc_url(get_permalink($p)); ?>"
                        class="block overflow-hidden mb-5 relative aspect-[4/3] bg-slate-100 dark:bg-slate-800">
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($p)); ?>"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                    </a>
                    <h3 class="font-black leading-tight text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors line-clamp-5"
                        style="font-size: 26px;">
                        <a href="<?php echo esc_url(get_permalink($p)); ?>"><?php echo esc_html(get_the_title($p)); ?></a>
                    </h3>
                    <div
                        class="flex items-center text-[10px] lg:text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                        <?php if ($cat_name): ?><span
                                class="text-slate-900 dark:text-slate-200 mr-2"><?php echo esc_html($cat_name); ?></span> &bull;
                        <?php endif; ?>
                        <span class="ml-2"><?php echo get_the_date('j F Y', $p); ?></span>
                    </div>
                </article>
                <?php
            }
        }

        if (!function_exists('neotiler_render_small_list_item')) {
            function neotiler_render_small_list_item($p)
            {
                if (!$p)
                    return;
                $thumb = get_the_post_thumbnail_url($p, 'medium_large') ?: 'https://via.placeholder.com/300';
                ?>
                <a href="<?php echo esc_url(get_permalink($p)); ?>" class="group flex gap-4 items-center mb-6 last:mb-0">
                    <div class="w-20 h-20 overflow-hidden flex-shrink-0 bg-slate-100 dark:bg-slate-800 relative">
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($p)); ?>"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="flex-1">
                        <h4
                            class="text-[15px] font-bold text-slate-900 dark:text-white leading-snug group-hover:text-primary transition-colors line-clamp-5 mb-2">
                            <?php echo esc_html(get_the_title($p)); ?>
                        </h4>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                            <?php echo get_the_date('j M Y', $p); ?>
                        </span>
                    </div>
                </a>
                <?php
            }
        }
        ?>

        <!-- Sol Sütun (3 Birim) -->
        <div
            class="lg:col-span-3 flex flex-col gap-8 lg:pr-6 border-b lg:border-b-0 lg:border-r border-slate-200 dark:border-slate-800 pb-8 lg:pb-0">
            <?php neotiler_render_clean_card($left_post); ?>
            <div class="hidden lg:block w-full h-px bg-slate-200 dark:bg-slate-800"></div>
            <div class="flex flex-col">
                <?php foreach ($left_list as $p) {
                    neotiler_render_small_list_item($p);
                } ?>
            </div>
        </div>

        <!-- Orta Sütun (6 Birim - Ana Haber) -->
        <div class="lg:col-span-6 relative group overflow-hidden bg-black min-h-[450px] lg:min-h-[600px] shadow-xl">
            <?php if ($main_post):
                $thumb = get_the_post_thumbnail_url($main_post, 'large') ?: 'https://via.placeholder.com/1000x800';
                $cat = get_the_category($main_post->ID);
                $cat_name = !empty($cat) ? $cat[0]->name : '';
                ?>
                <a href="<?php echo esc_url(get_permalink($main_post)); ?>" class="block w-full h-full absolute inset-0">
                    <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($main_post)); ?>"
                        class="absolute inset-0 w-full h-full object-cover opacity-70 group-hover:opacity-50 group-hover:scale-105 transition-all duration-700 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>

                    <div class="absolute bottom-0 w-full p-8 lg:p-12 text-center lg:text-left">
                        <h2
                            class="text-3xl lg:text-[2.75rem] font-black text-white leading-[1.1] tracking-tight mb-5 group-hover:text-amber-400 transition-colors">
                            <?php echo esc_html(get_the_title($main_post)); ?>
                        </h2>
                        <div
                            class="flex items-center justify-center lg:justify-start gap-3 text-xs font-bold uppercase tracking-widest text-slate-300">
                            <?php if ($cat_name): ?><span class="text-white"><?php echo esc_html($cat_name); ?></span>
                                &bull;
                            <?php endif; ?>
                            <span><?php echo get_the_date('j F Y', $main_post); ?></span>
                        </div>
                    </div>
                </a>
            <?php endif; ?>
        </div>

        <!-- Sağ Sütun (3 Birim) -->
        <div
            class="lg:col-span-3 flex flex-col gap-8 lg:pl-6 border-t lg:border-t-0 lg:border-l border-slate-200 dark:border-slate-800 pt-8 lg:pt-0">
            <?php neotiler_render_clean_card($right_post); ?>
            <div class="hidden lg:block w-full h-px bg-slate-200 dark:bg-slate-800"></div>
            <div class="flex flex-col">
                <?php foreach ($right_list as $p) {
                    neotiler_render_small_list_item($p);
                } ?>
            </div>
        </div>
    </section>


    <?php 
    $ad_1 = get_theme_mod('neotiler_ad_1', '');
    if (!empty($ad_1)) : 
    ?>
    <div class="container mx-auto px-4 max-w-[1200px] flex justify-center overflow-hidden">
        <div class="w-full text-center">
            <?php echo do_shortcode($ad_1); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- EN POPULER YAZILAR -->
    <section aria-label="<?php esc_attr_e('Most Popular Posts', 'neotiler-blog'); ?>" class="pt-4">
        <h2
            class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-wider mb-8 text-center flex items-center justify-center gap-4">
            <span class="h-px flex-1 bg-slate-200 dark:bg-slate-800"></span>
            <?php esc_html_e('MOST POPULAR', 'neotiler-blog'); ?>
            <span class="h-px flex-1 bg-slate-200 dark:bg-slate-800"></span>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-1">
            <?php
            $trending_ids = neotiler_get_trending_post_ids(6);
            if (!empty($trending_ids)) {
                $popular_query = new WP_Query(array(
                    'post__in' => $trending_ids,
                    'posts_per_page' => 6,
                    'orderby' => 'post__in',
                    'ignore_sticky_posts' => 1,
                ));
            } else {
                // Henüz veri yoksa fallback: en son yazılar
                $popular_query = new WP_Query(array(
                    'posts_per_page' => 6,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'ignore_sticky_posts' => 1,
                ));
            }
            $popular_index = 1;
            if ($popular_query->have_posts()):
                while ($popular_query->have_posts()):
                    $popular_query->the_post();
                    $thumb = get_the_post_thumbnail_url(null, 'medium_large') ?: 'https://via.placeholder.com/300';
                    ?>
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="group flex items-center gap-3 md:gap-5 py-5 px-2">
                        <!-- Daire Görsel -->
                        <div
                            class="popular-circle w-[104px] h-[104px] md:w-[120px] md:h-[120px] relative flex-shrink-0 rounded-full overflow-hidden bg-slate-200 dark:bg-slate-700 shadow">
                            <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <!-- Numara (mobilde gizli) -->
                        <span
                            class="hidden md:block text-5xl font-black text-slate-200 dark:text-slate-700 tabular-nums flex-shrink-0 leading-none mt-2">
                            <?php echo $popular_index++; ?>
                        </span>
                        <!-- Metin -->
                        <div class="flex-1 min-w-0">
                            <h3
                                class="text-[18px] md:text-[22px] font-bold text-slate-900 dark:text-white leading-snug group-hover:text-primary transition-colors line-clamp-4 mb-2">
                                <?php the_title(); ?>
                            </h3>
                            <div
                                class="flex flex-wrap items-center gap-1 md:gap-2 text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-slate-400">
                                <span><?php echo get_the_date('j M Y'); ?></span>
                                <span class="text-slate-300 dark:text-slate-600">•</span>
                                <span class="text-slate-500">
                                    <?php
                                    $comments_number = get_comments_number();
                                    if ($comments_number == 0) {
                                        esc_html_e('NO COMMENTS', 'neotiler-blog');
                                    } elseif ($comments_number == 1) {
                                        esc_html_e('1 COMMENT', 'neotiler-blog');
                                    } else {
                                        echo esc_html(sprintf(__('%s COMMENTS', 'neotiler-blog'), $comments_number));
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>
                    </a>
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- VIDEO CAROUSEL (Full Width) -->
    <?php
    $video_urls = array();
    for ($i = 1; $i <= 6; $i++) {
        $url = get_theme_mod("neotiler_video_url_{$i}", '');
        if (!empty($url)) {
            preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]{11})/', $url, $matches);
            if (!empty($matches[1])) {
                $video_urls[] = $matches[1];
            }
        }
    }

    if (!empty($video_urls)):
        $video_title = get_theme_mod('neotiler_video_title', 'İzlemeden Geçme!');
        $video_desc = get_theme_mod('neotiler_video_description', 'Güncel video incelemelerimiz, rehberlerimiz ve podcastlerimiz.');
        ?>
    </div> <!-- Gecici Container Kapanisi -->

    <section aria-label="Video Carousel"
        class="w-full pt-8 pb-12 overflow-hidden bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200 dark:border-slate-800">
        <!-- Header (Container icinde) -->
        <div class="container mx-auto px-4 max-w-[1200px]">
            <h2
                class="text-2xl lg:text-3xl font-black text-slate-900 dark:text-white uppercase tracking-wider mb-8 text-center flex items-center justify-center gap-4">
                <span class="h-px flex-1 bg-slate-200 dark:bg-slate-800"></span>
                <?php echo esc_html($video_title); ?>
                <span class="h-px flex-1 bg-slate-200 dark:bg-slate-800"></span>
            </h2>
            <?php if ($video_desc): ?>
                <p class="text-center text-slate-500 mb-8 max-w-2xl mx-auto"><?php echo esc_html($video_desc); ?></p>
            <?php endif; ?>
        </div>

        <!-- Slider Wrapper (Full Width) -->
        <div class="relative w-full group/slider max-w-[1920px] mx-auto">
            <!-- Navigation Arrows -->
            <button id="video-prev" aria-label="Previous"
                class="absolute left-2 lg:left-8 xl:left-12 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-black/50 hover:bg-black/80 text-white rounded-full flex items-center justify-center opacity-0 group-hover/slider:opacity-100 transition-opacity disabled:opacity-0 disabled:cursor-not-allowed hidden md:flex">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button id="video-next" aria-label="Next"
                class="absolute right-2 lg:right-8 xl:right-12 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-black/50 hover:bg-black/80 text-white rounded-full flex items-center justify-center opacity-0 group-hover/slider:opacity-100 transition-opacity disabled:opacity-0 disabled:cursor-not-allowed hidden md:flex">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Video Slider Container -->
            <div id="video-slider"
                class="flex gap-4 lg:gap-8 overflow-x-auto snap-x snap-mandatory pb-8 px-4 lg:px-[calc(50vw-550px)] [&::-webkit-scrollbar]:hidden"
                style="scrollbar-width: none;">
                <?php foreach ($video_urls as $vid): ?>
                    <div class="video-slide snap-center flex-shrink-0 w-[calc(100vw-2rem)] lg:w-[1100px]">
                        <div class="relative h-[280px] md:h-[400px] lg:h-[600px] bg-black overflow-hidden shadow-2xl group cursor-pointer"
                            data-video-id="<?php echo esc_attr($vid); ?>">
                            <img src="https://i.ytimg.com/vi_webp/<?php echo esc_attr($vid); ?>/maxresdefault.webp"
                                alt="Video Thumbnail" loading="lazy"
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">

                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                            <!-- Play Icon & Fake Title/Button Area -->
                            <div class="absolute inset-0 flex flex-col justify-between p-6 md:p-10">
                                <div class="flex-1 flex items-center justify-center">
                                    <div
                                        class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white group-hover:bg-red-600 transition-colors shadow-lg">
                                        <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-auto flex justify-start">
                                    <span
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-black text-xs md:text-sm uppercase tracking-wider px-6 py-2 md:py-3 transition-colors shadow-lg shadow-blue-600/20">
                                        WATCH ON YOUTUBE
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pagination Dots -->
        <div id="video-dots" class="flex items-center justify-center gap-3 mt-6 pb-2">
            <?php foreach ($video_urls as $i => $vid): ?>
                <button class="video-dot rounded-full transition-all duration-300"
                    style="width: <?php echo $i === 0 ? '24px' : '10px'; ?>; height: 10px; background: <?php echo $i === 0 ? '#2563eb' : '#cbd5e1'; ?>; border: none; cursor: pointer; padding: 0;"
                    data-index="<?php echo $i; ?>" aria-label="Video <?php echo $i + 1; ?>"></button>
            <?php endforeach; ?>
        </div>
        </div>

        <script>
            (function () {
                var slider = document.getElementById('video-slider');
                var dots = document.querySelectorAll('.video-dot');
                if (!slider || !dots.length) return;

                function setActive(idx) {
                    dots.forEach(function (d, i) {
                        d.style.width = (i === idx) ? '24px' : '10px';
                        d.style.background = (i === idx) ? '#2563eb' : '#cbd5e1';
                    });
                }

                dots.forEach(function (dot) {
                    dot.addEventListener('click', function () {
                        var idx = parseInt(dot.dataset.index);
                        var slides = slider.querySelectorAll('.video-slide');
                        var hasClones = slides.length > dots.length;
                        var targetIdx = hasClones ? idx + 1 : idx;

                        if (slides[targetIdx]) {
                            slides[targetIdx].scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                        }
                    });
                });

                var t;
                slider.addEventListener('scroll', function () {
                    clearTimeout(t);
                    t = setTimeout(function () {
                        var slides = slider.querySelectorAll('.video-slide');
                        var hasClones = slides.length > dots.length;

                        var center = slider.scrollLeft + slider.clientWidth / 2;
                        var closest = 0, best = Infinity;
                        slides.forEach(function (s, i) {
                            var d = Math.abs(s.offsetLeft - slider.offsetLeft + s.offsetWidth / 2 - center);
                            if (d < best) { best = d; closest = i; }
                        });

                        var dotIndex = hasClones ? closest - 1 : closest;
                        // Handle edge cases if bouncing on clones
                        if (dotIndex < 0) dotIndex = dots.length - 1;
                        if (dotIndex >= dots.length) dotIndex = 0;

                        setActive(dotIndex);
                    }, 50);
                });
            })();
        </script>
    </section>

    <!-- Container Yeniden Acilis -->
    <div class="container mx-auto px-4 max-w-[1200px] pt-8 space-y-16">
    <?php endif; ?>




    <!-- CATEGORY GRIDS (Customizer) -->
    <?php
    for ($i = 1; $i <= 3; $i++) {
        
        // Sadece 2. kategori (Utilities) alanından önce reklamı göster
        if ($i === 2) {
            $ad_2 = get_theme_mod('neotiler_ad_2', '');
            if (!empty($ad_2)) {
                echo '<div class="w-full flex justify-center mb-6 overflow-hidden"><div class="w-full text-center">' . do_shortcode($ad_2) . '</div></div>';
            }
        }

        $cat_id = get_theme_mod("neotiler_home_cat_{$i}", '');
        if ($cat_id) {
            $cat_info = get_category($cat_id);
            if ($cat_info && !is_wp_error($cat_info)) {
                $cat_link = get_category_link($cat_id);
                // Kategori için 6 yazı çekiyoruz (2 büyük + 4 küçük)
                $cat_query = new WP_Query(array(
                    'cat' => $cat_id,
                    'posts_per_page' => 6,
                    'ignore_sticky_posts' => 1
                ));
                
                if ($cat_query->have_posts()) {
                    ?>
                    <section aria-label="<?php echo esc_attr($cat_info->name); ?>" class="mb-12">
                        <!-- Kategori Başlığı ve Yan Çizgiler (Üst: 35px, Alt: 25px) -->
                        <h2 class="text-lg md:text-xl font-black text-slate-900 dark:text-white uppercase tracking-widest flex items-center justify-center gap-4 text-center" style="margin-top: 35px; margin-bottom: 25px;">
                            <span class="h-px flex-1 bg-slate-200 dark:bg-slate-800"></span>
                            <a href="<?php echo esc_url($cat_link); ?>" class="hover:text-primary transition-colors"><?php echo esc_html($cat_info->name); ?></a>
                            <span class="h-px flex-1 bg-slate-200 dark:bg-slate-800"></span>
                        </h2>
                        
                        <?php if ($i % 2 !== 0) : ?>
                            <!-- Layout A (Tek sayılar 1 ve 3): Oyun kategorisindeki gibi -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-8 mb-10">
                                <?php 
                                $count = 0;
                                while($cat_query->have_posts() && $count < 2) : $cat_query->the_post(); 
                                    $thumb = get_the_post_thumbnail_url(null, 'large') ?: get_template_directory_uri() . '/assets/placeholder.jpg';
                                    ?>
                                    <article class="group flex flex-col">
                                        <!-- Görsel (16:10 Oran) -->
                                        <a href="<?php echo esc_url(get_permalink()); ?>" class="block overflow-hidden mb-4 relative aspect-[16/10] bg-slate-100 dark:bg-slate-800">
                                            <?php if(has_post_thumbnail()) : ?>
                                                <img src="<?php echo esc_url($thumb); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                            <?php else: ?>
                                                <div class="absolute inset-0 w-full h-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:scale-105 transition-transform duration-700 ease-out">
                                                    <svg class="w-12 h-12 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                                </div>
                                            <?php endif; ?>
                                        </a>
                                        <!-- Başlık (26px font-bold) -->
                                        <h3 class="font-bold leading-snug text-slate-900 dark:text-white mb-2.5 group-hover:text-primary transition-colors line-clamp-5" style="font-size: 26px;">
                                            <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <!-- Yazar & Tarih -->
                                        <div class="text-[10px] lg:text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest flex gap-2 items-center">
                                            <span class="text-slate-900 dark:text-slate-200 font-bold"><?php echo get_the_author(); ?></span>
                                            <span>&bull;</span>
                                            <span><?php echo get_the_date('j F Y'); ?></span>
                                        </div>
                                    </article>
                                <?php 
                                $count++;
                                endwhile; 
                                ?>
                            </div>

                            <!-- Alt 4 Küçük Kart (2x2 Grid - Most Popular ile Birebir Aynı: text-[18px] md:text-[22px] font-bold leading-snug) -->
                            <?php if ($cat_query->post_count > 2) : ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                                    <?php 
                                    while($cat_query->have_posts()) : $cat_query->the_post(); 
                                        $thumb = get_the_post_thumbnail_url(null, 'medium') ?: get_template_directory_uri() . '/assets/placeholder.jpg';
                                        ?>
                                        <article class="group flex gap-4 items-center">
                                            <!-- Küçük Görsel (135x125px) -->
                                            <a href="<?php echo esc_url(get_permalink()); ?>" class="block flex-shrink-0 relative bg-slate-100 dark:bg-slate-800 overflow-hidden" style="width: 135px; height: 125px;">
                                                <?php if(has_post_thumbnail()) : ?>
                                                    <img src="<?php echo esc_url($thumb); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                <?php else: ?>
                                                    <div class="absolute inset-0 w-full h-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:scale-105 transition-transform duration-700 ease-out">
                                                        <svg class="w-8 h-8 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </a>
                                            <!-- Metin Alanı -->
                                            <div class="flex-1 min-w-0 flex flex-col justify-center">
                                                <h4 class="text-[18px] md:text-[22px] font-bold text-slate-900 dark:text-white leading-snug group-hover:text-primary transition-colors line-clamp-5 mb-2">
                                                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
                                                </h4>
                                                <div class="text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-slate-400 flex gap-1.5 items-center">
                                                    <span class="text-slate-900 dark:text-slate-200 font-bold"><?php echo get_the_author(); ?></span>
                                                    <span>&bull;</span>
                                                    <span><?php echo get_the_date('j F Y'); ?></span>
                                                </div>
                                            </div>
                                        </article>
                                    <?php endwhile; ?>
                                </div>
                            <?php endif; ?>

                        <?php else : ?>
                            <!-- Layout B (Çift sayılar 2): Yapay Zeka / Tech News (Ferah & Beyaz Zeminli) -->
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                                <!-- Sol taraf: Büyük 1 adet (Temiz, Yazı Görselin Altında) -->
                                <div class="lg:col-span-7">
                                    <?php 
                                    if($cat_query->have_posts()) : $cat_query->the_post(); 
                                        $thumb = get_the_post_thumbnail_url(null, 'large') ?: get_template_directory_uri() . '/assets/placeholder.jpg';
                                        ?>
                                        <article class="group flex flex-col h-full">
                                            <a href="<?php echo esc_url(get_permalink()); ?>" class="block overflow-hidden mb-4 relative aspect-[16/10] bg-slate-100 dark:bg-slate-800">
                                                <?php if(has_post_thumbnail()) : ?>
                                                    <img src="<?php echo esc_url($thumb); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                                <?php else: ?>
                                                    <div class="absolute inset-0 w-full h-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:scale-105 transition-transform duration-700 ease-out">
                                                        <svg class="w-12 h-12 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </a>
                                            <h3 class="font-bold leading-snug text-slate-900 dark:text-white mb-2.5 group-hover:text-primary transition-colors line-clamp-5" style="font-size: 26px;">
                                                <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <!-- mt-auto pushes meta to the very bottom if there's extra space -->
                                            <div class="text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-slate-400 flex gap-2 items-center mt-auto">
                                                <span class="text-slate-900 dark:text-slate-200 font-bold"><?php echo get_the_author(); ?></span> &bull; <span><?php echo get_the_date('j F Y'); ?></span>
                                            </div>
                                        </article>
                                    <?php endif; ?>
                                </div>
                                <!-- Sağ taraf: Küçük 4 adet (Sol Kartla İp Gibi Hizalı) -->
                                <div class="lg:col-span-5 flex flex-col justify-between gap-y-4 lg:gap-y-0">
                                    <?php 
                                    $b_count = 0;
                                    while($cat_query->have_posts() && $b_count < 4) : $cat_query->the_post(); 
                                        $thumb = get_the_post_thumbnail_url(null, 'medium') ?: get_template_directory_uri() . '/assets/placeholder.jpg';
                                        ?>
                                        <article class="group flex gap-4 items-center">
                                            <a href="<?php echo esc_url(get_permalink()); ?>" class="block flex-shrink-0 relative overflow-hidden bg-slate-100 dark:bg-slate-800" style="width: 135px; height: 110px;">
                                                <?php if(has_post_thumbnail()) : ?>
                                                    <img src="<?php echo esc_url($thumb); ?>" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                <?php else: ?>
                                                    <div class="absolute inset-0 w-full h-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:scale-105 transition-transform duration-700 ease-out">
                                                        <svg class="w-8 h-8 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </a>
                                            <div class="flex-1 min-w-0 flex flex-col justify-center">
                                                <h4 class="text-[18px] md:text-[22px] font-bold text-slate-900 dark:text-white leading-snug group-hover:text-primary transition-colors line-clamp-5 mb-1.5">
                                                    <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
                                                </h4>
                                                <div class="text-[10px] md:text-[11px] font-bold uppercase tracking-widest text-slate-400 flex gap-1.5 items-center">
                                                    <span class="text-slate-900 dark:text-slate-200 font-bold"><?php echo get_the_author(); ?></span>
                                                    <span>&bull;</span>
                                                    <span><?php echo get_the_date('j F Y'); ?></span>
                                                </div>
                                            </div>
                                        </article>
                                    <?php 
                                    $b_count++;
                                    endwhile; 
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </section>
                    <?php
                }
                wp_reset_postdata();
            }
        }
    }
    
    // Mobil için 3. Reklam Alanı (Sidebar mobilde gizli olduğu için buraya ekliyoruz)
    $ad_3 = get_theme_mod('neotiler_ad_3', '');
    if (!empty($ad_3)) : 
    ?>
    <div class="block lg:hidden w-full flex justify-center mb-6 overflow-hidden">
        <div class="w-full text-center">
            <?php echo do_shortcode($ad_3); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- LOAD MORE & STICKY SIDEBAR SECTION -->
    <section aria-label="More Popular Posts" class="pt-8 mb-16 border-t border-slate-200 dark:border-slate-800">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left Column: Posts & Load More -->
            <div class="lg:col-span-8">
                <div id="latest-posts-container">
                    <?php
                    // Display all posts from the newest downwards (9 Posts)
                    $loadmore_query = new WP_Query(array(
                        'posts_per_page' => 9,
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'orderby' => 'date',
                        'order' => 'DESC',
                    ));

                    if ($loadmore_query->have_posts()):
                        while ($loadmore_query->have_posts()):
                            $loadmore_query->the_post();
                            $thumbnail_url = get_the_post_thumbnail_url(null, 'medium_large') ?: 'https://via.placeholder.com/600x400';
                            $categories = get_the_category();
                            $cat_name = !empty($categories) ? $categories[0]->name : '';
                            ?>
                            <article class="flex flex-col md:flex-row gap-6 mb-10 group">
                                <a href="<?php echo esc_url(get_permalink()); ?>"
                                    class="block w-full md:w-2/5 flex-shrink-0 relative overflow-hidden aspect-[16/10] bg-slate-100 dark:bg-slate-800">
                                    <img src="<?php echo esc_url($thumbnail_url); ?>"
                                        alt="<?php echo esc_attr(get_the_title()); ?>"
                                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                </a>
                                <div class="flex flex-col flex-1 justify-center py-2">
                                    <div
                                        class="flex items-center gap-3 text-[10px] lg:text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">
                                        <?php if ($cat_name): ?>
                                            <span class="text-primary">
                                                <?php echo esc_html($cat_name); ?>
                                            </span> &bull;
                                        <?php endif; ?>
                                        <span>
                                            <?php echo get_the_date('j F Y'); ?>
                                        </span>
                                    </div>
                                    <h3
                                        class="text-xl md:text-2xl font-black leading-tight text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors line-clamp-3">
                                        <a href="<?php echo esc_url(get_permalink()); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 md:line-clamp-3 mb-4">
                                        <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                                    </p>
                                    <div
                                        class="mt-auto flex items-center gap-2 text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 24, '', '', array('class' => 'rounded-full')); ?>
                                        <span class="ml-2">
                                            <?php the_author(); ?>
                                        </span>
                                    </div>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <div class="mt-12 text-center lg:text-left">
                    <button id="load-more-btn" data-offset="9"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-black text-sm uppercase tracking-wider px-8 py-4 transition-colors w-full md:w-auto min-w-[200px] shadow-lg shadow-blue-600/20">
                        <?php esc_html_e('LOAD MORE', 'neotiler-blog'); ?>
                    </button>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div
                class="hidden lg:block lg:col-span-4 relative border-l border-slate-100 dark:border-slate-800 lg:pl-12 pt-8 lg:pt-0">
                
                <?php 
                $ad_3 = get_theme_mod('neotiler_ad_3', '');
                if (!empty($ad_3)) : 
                ?>
                <!-- Static Ad Area (Does not stick) -->
                <div class="w-full flex justify-center mb-6 overflow-hidden">
                    <div class="w-full text-center">
                        <?php echo do_shortcode($ad_3); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Sticky Popular Posts (Slides down with user) -->
                <aside class="sticky top-8">
                    <h2
                        class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-wider mb-6 flex items-center gap-4">
                        <?php esc_html_e('POPULAR POSTS', 'neotiler-blog'); ?>
                        <span class="h-px flex-1 bg-slate-200 dark:bg-slate-800"></span>
                    </h2>

                    <div class="flex flex-col gap-y-1">
                        <?php
                        // Right column popular posts (5 Posts - Original count)
                        $sidebar_query = new WP_Query(array(
                            'posts_per_page' => 5,
                            'offset' => 12,
                            'post_status' => 'publish',
                            'ignore_sticky_posts' => 1,
                            'meta_key' => 'neotiler_post_views',
                            'orderby' => 'meta_value_num date',
                            'order' => 'DESC',
                        ));

                        if ($sidebar_query->post_count < 5) {
                            wp_reset_postdata();
                            $sidebar_query = new WP_Query(array(
                                'posts_per_page' => 5,
                                'offset' => 0,
                                'post_status' => 'publish',
                                'ignore_sticky_posts' => 1,
                                'meta_key' => 'neotiler_post_views',
                                'orderby' => 'meta_value_num date',
                                'order' => 'DESC',
                            ));
                        }

                        if (!$sidebar_query->have_posts()) {
                            wp_reset_postdata();
                            $sidebar_query = new WP_Query(array(
                                'posts_per_page' => 5,
                                'offset' => 0,
                                'post_status' => 'publish',
                                'ignore_sticky_posts' => 1,
                                'orderby' => 'date',
                                'order' => 'DESC',
                            ));
                        }

                        $popular_index = 1;
                        if ($sidebar_query->have_posts()):
                            while ($sidebar_query->have_posts()):
                                $sidebar_query->the_post();
                                $thumb = get_the_post_thumbnail_url(null, 'medium_large') ?: 'https://via.placeholder.com/300';
                                ?>
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="group flex items-center gap-4 py-3">
                                    <div class="relative flex-shrink-0">
                                        <div
                                            class="w-[95px] h-[95px] rounded-full overflow-hidden bg-slate-200 dark:bg-slate-700 shadow border-2 border-transparent group-hover:border-blue-500 transition-colors">
                                            <img src="<?php echo esc_url($thumb); ?>"
                                                alt="<?php echo esc_attr(get_the_title()); ?>"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        </div>
                                        <div
                                            class="absolute top-0 left-0 w-7 h-7 bg-blue-600 text-white text-xs font-black flex items-center justify-center rounded-full shadow-md z-10 ring-[3px] ring-white dark:ring-slate-900">
                                            <?php echo $popular_index++; ?>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3
                                            class="text-[13px] md:text-sm font-bold text-slate-900 dark:text-white leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-3">
                                            <?php the_title(); ?>
                                        </h3>
                                    </div>
                                </a>
                                <?php
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </aside>
            </div>
        </div>
    </section>

</div>

<?php
get_footer();
