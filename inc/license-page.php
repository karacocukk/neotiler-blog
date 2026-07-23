<?php
/**
 * NeoTiler Lisans Sayfası — Appearance → NeoTiler Lisansı
 */

if (!defined('ABSPATH')) exit;

// ─── Admin Menüsüne Ekle ─────────────────────────────────────────────────────

function neotiler_register_license_page() {
    add_theme_page(
        'NeoTiler Lisansı',       // Sayfa başlığı
        'NeoTiler Lisansı',       // Menü başlığı
        'manage_options',         // Yetki
        'neotiler-license',       // Slug
        'neotiler_license_page_html' // Callback
    );
}
add_action('admin_menu', 'neotiler_register_license_page');

// ─── Form İşleme ─────────────────────────────────────────────────────────────

function neotiler_license_handle_form() {
    if (!isset($_POST['neotiler_license_action'])) return;
    if (!check_admin_referer('neotiler_license_nonce')) return;
    if (!current_user_can('manage_options')) return;

    $action = sanitize_text_field($_POST['neotiler_license_action']);

    if ($action === 'activate') {
        $key    = sanitize_text_field($_POST['neotiler_license_key'] ?? '');
        $result = neotiler_activate_license($key);
        set_transient('neotiler_license_notice', $result, 30);
    }

    if ($action === 'deactivate') {
        $result = neotiler_deactivate_license();
        set_transient('neotiler_license_notice', $result, 30);
    }

    wp_redirect(admin_url('themes.php?page=neotiler-license'));
    exit;
}
add_action('admin_init', 'neotiler_license_handle_form');

// ─── Sayfa HTML ──────────────────────────────────────────────────────────────

function neotiler_license_page_html() {
    $status      = get_option('neotiler_license_status', 'trial');
    $key         = get_option('neotiler_license_key', '');
    $days_left   = neotiler_trial_days_remaining();
    $is_active   = ($status === 'active');
    $notice      = get_transient('neotiler_license_notice');
    delete_transient('neotiler_license_notice');

    // Durum etiketi
    $badge_color = $is_active ? '#16a34a' : ($days_left > 0 ? '#d97706' : '#dc2626');
    $badge_text  = $is_active ? '✅ Aktif' : ($days_left > 0 ? '⏳ Deneme' : '❌ Süresi Doldu');
    ?>
    <div class="wrap" style="max-width: 640px;">
        <h1 style="display:flex; align-items:center; gap:12px;">
            🔑 NeoTiler Blog Lisansı
            <span style="
                font-size: 13px;
                background: <?php echo $badge_color; ?>;
                color: white;
                padding: 4px 12px;
                border-radius: 999px;
                font-weight: 600;
            "><?php echo $badge_text; ?></span>
        </h1>

        <?php if ($notice): ?>
            <div class="notice <?php echo $notice['success'] ? 'notice-success' : 'notice-error'; ?> is-dismissible">
                <p><?php echo esc_html($notice['message']); ?></p>
            </div>
        <?php endif; ?>

        <!-- Durum Kartı -->
        <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 24px; margin: 20px 0;">
            <?php if ($is_active): ?>
                <p>✅ Lisansınız aktif. Bu sitede tam erişime sahipsiniz.</p>
                <?php if ($key): ?>
                    <p style="color: #6b7280; font-size: 13px;">
                        Aktif Anahtar: <code><?php echo esc_html(substr($key, 0, 8) . '••••••••••••••••'); ?></code>
                    </p>
                <?php endif; ?>

                <form method="post" style="margin-top: 16px;">
                    <?php wp_nonce_field('neotiler_license_nonce'); ?>
                    <input type="hidden" name="neotiler_license_action" value="deactivate">
                    <button type="submit" class="button button-secondary"
                        onclick="return confirm('Bu siteden lisansı kaldırmak istediğinize emin misiniz? Lisans anahtarınız başka bir sitede kullanılabilir hale gelecektir.')">
                        Bu Siteden Lisansı Kaldır
                    </button>
                </form>

            <?php else: ?>
                <?php if ($days_left > 0): ?>
                    <p>⏳ Deneme sürümü kullanıyorsunuz. <strong><?php echo $days_left; ?> gün</strong> kaldı.</p>
                <?php else: ?>
                    <p style="color: #dc2626; font-weight: 600;">❌ Deneme süreniz doldu. Siteye erişim kısıtlanmıştır.</p>
                <?php endif; ?>

                <p style="color: #374151; margin-top: 12px;">
                    Devam etmek için Lemon Squeezy üzerinden <a href="https://neotools.lemonsqueezy.com/checkout/buy/5c3d908d-b448-4e3a-bfae-6b5feff9e3c8" target="_blank">NeoTiler Blog lisansı satın alın</a>
                    ve lisans anahtarınızı aşağıya girin.
                </p>

                <form method="post" style="margin-top: 16px;">
                    <?php wp_nonce_field('neotiler_license_nonce'); ?>
                    <input type="hidden" name="neotiler_license_action" value="activate">
                    <table class="form-table" style="margin: 0;">
                        <tr>
                            <th style="padding: 0 0 12px 0; font-weight: 600;">Lisans Anahtarı</th>
                            <td style="padding: 0 0 12px 0;">
                                <input
                                    type="text"
                                    name="neotiler_license_key"
                                    placeholder="XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX"
                                    value="<?php echo esc_attr($key); ?>"
                                    class="regular-text"
                                    style="font-family: monospace;"
                                >
                            </td>
                        </tr>
                    </table>
                    <button type="submit" class="button button-primary">Lisansı Aktive Et</button>
                </form>
            <?php endif; ?>
        </div>

        <!-- Bilgi Kutusu -->
        <div style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 16px; font-size: 13px; color: #0c4a6e;">
            <strong>ℹ️ Lisans Bilgileri:</strong>
            <ul style="margin: 8px 0 0 16px; list-style: disc;">
                <li>Her lisans anahtarı maksimum <strong>3 farklı sitede</strong> kullanılabilir.</li>
                <li>Farklı bir sitede kullanmak için önce "Bu Siteden Lisansı Kaldır" demeniz gerekir.</li>
                <li>Kullandığınız lisans <strong>ömür boyu (lifetime)</strong> geçerlidir.</li>
            </ul>
        </div>
    </div>
    <?php
}
