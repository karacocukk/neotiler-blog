<?php
/**
 * NeoTiler Lisans Yönetim Sistemi
 * Lemon Squeezy License API entegrasyonu
 */

if (!defined('ABSPATH')) exit;

// ─── Sabitler ───────────────────────────────────────────────────────────────
define('NEOTILER_LS_API_URL', 'https://api.lemonsqueezy.com/v1/licenses/');
define('NEOTILER_TRIAL_DAYS', 7);

// ─── Deneme Sistemi ─────────────────────────────────────────────────────────

/**
 * Temayı ilk kez yükleyince deneme başlangıç tarihini kaydet.
 */
function neotiler_init_trial() {
    if (!get_option('neotiler_trial_started_at')) {
        update_option('neotiler_trial_started_at', time());
    }
}
add_action('after_setup_theme', 'neotiler_init_trial');

/**
 * Deneme süresi kaç gün kaldı?
 * @return int Negatif = süresi dolmuş
 */
function neotiler_trial_days_remaining() {
    $started = (int) get_option('neotiler_trial_started_at', time());
    $expires = $started + (NEOTILER_TRIAL_DAYS * DAY_IN_SECONDS);
    return (int) ceil(($expires - time()) / DAY_IN_SECONDS);
}

/**
 * Deneme süresi hala geçerli mi?
 */
function neotiler_is_trial_valid() {
    return neotiler_trial_days_remaining() > 0;
}

// ─── Lisans Kontrolü ────────────────────────────────────────────────────────

/**
 * Tema şu an kullanılabilir mi? (Trial ya da aktif lisans)
 * Bu fonksiyon "geçit" olarak her yerde kullanılır.
 */
function neotiler_is_licensed() {
    $status = get_option('neotiler_license_status', 'trial');

    if ($status === 'active') {
        return true;
    }

    // Trial modunda ise süreyi kontrol et
    return neotiler_is_trial_valid();
}

/**
 * Lisansın güncel durumunu Lemon Squeezy API'ye sorarak doğrula.
 * Performans için 12 saatlik transient cache kullanır.
 */
function neotiler_validate_license_remote() {
    $key = get_option('neotiler_license_key');
    if (!$key) return false;

    $cached = get_transient('neotiler_license_valid');
    if ($cached !== false) return $cached === 'yes';

    $instance_id = get_option('neotiler_license_instance_id');
    $response = wp_remote_post(NEOTILER_LS_API_URL . 'validate', [
        'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json'],
        'body'    => json_encode([
            'license_key'  => $key,
            'instance_id'  => $instance_id,
        ]),
        'timeout' => 10,
    ]);

    if (is_wp_error($response)) return false;

    $body = json_decode(wp_remote_retrieve_body($response), true);
    $valid = isset($body['valid']) && $body['valid'] === true;

    set_transient('neotiler_license_valid', $valid ? 'yes' : 'no', 12 * HOUR_IN_SECONDS);

    if ($valid) {
        update_option('neotiler_license_status', 'active');
    } else {
        update_option('neotiler_license_status', 'inactive');
    }

    return $valid;
}

// ─── Cihaz Bilgisi ──────────────────────────────────────────────────────────

/**
 * Aktivasyon sırasında gönderilecek cihaz/sunucu bilgilerini topla.
 * Lemon Squeezy bu bilgiyi instance_name olarak kaydeder.
 */
function neotiler_get_device_info() {
    global $wp_version;
    $theme = wp_get_theme();

    return implode(' | ', [
        'Site: ' . home_url(),
        'IP: ' . ($_SERVER['SERVER_ADDR'] ?? 'bilinmiyor'),
        'PHP: ' . phpversion(),
        'WP: ' . $wp_version,
        'Tema: ' . $theme->get('Name') . ' v' . $theme->get('Version'),
        'Sunucu: ' . ($_SERVER['SERVER_SOFTWARE'] ?? 'bilinmiyor'),
    ]);
}

// ─── Slot Kontrolü ──────────────────────────────────────────────────────────

/**
 * Lisansın geçerli olup olmadığını ve boş slot olup olmadığını kontrol et.
 * @param string $key
 * @return array ['valid' => bool, 'usage' => int, 'limit' => int, 'message' => string]
 */
function neotiler_check_license_slots($key) {
    $response = wp_remote_post(NEOTILER_LS_API_URL . 'validate', [
        'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json'],
        'body'    => json_encode(['license_key' => $key]),
        'timeout' => 10,
    ]);

    if (is_wp_error($response)) {
        return ['valid' => false, 'usage' => 0, 'limit' => 0, 'message' => 'Sunucuya bağlanılamadı.'];
    }

    $body  = json_decode(wp_remote_retrieve_body($response), true);
    $valid = isset($body['valid']) && $body['valid'] === true;
    $usage = (int) ($body['license_key']['activation_usage'] ?? 0);
    $limit = (int) ($body['license_key']['activation_limit'] ?? 3);

    if (!$valid) {
        return ['valid' => false, 'usage' => $usage, 'limit' => $limit, 'message' => 'Bu lisans anahtarı geçersiz.'];
    }

    if ($usage >= $limit) {
        return [
            'valid'   => true,
            'usage'   => $usage,
            'limit'   => $limit,
            'message' => sprintf('Aktivasyon limiti doldu (%d/%d site). Önce bir siteden lisansı kaldırın.', $usage, $limit),
        ];
    }

    return [
        'valid'   => true,
        'usage'   => $usage,
        'limit'   => $limit,
        'message' => sprintf('Lisans geçerli. Kullanım: %d/%d site.', $usage, $limit),
    ];
}

// ─── Aktivasyon / Deaktivasyon ──────────────────────────────────────────────

/**
 * Lisans anahtarını aktive et.
 * Önce slot kontrolü yapar, sonra cihaz bilgileriyle birlikte aktivasyon isteği atar.
 * @param string $key
 * @return array ['success' => bool, 'message' => string]
 */
function neotiler_activate_license($key) {
    $key = sanitize_text_field(trim($key));
    if (empty($key)) {
        return ['success' => false, 'message' => 'Lütfen bir lisans anahtarı girin.'];
    }

    // 1. Önce lisansı kontrol et ve boş slot var mı bak
    $slot_check = neotiler_check_license_slots($key);
    if (!$slot_check['valid']) {
        return ['success' => false, 'message' => '❌ ' . $slot_check['message']];
    }
    if ($slot_check['usage'] >= $slot_check['limit']) {
        return ['success' => false, 'message' => '❌ ' . $slot_check['message']];
    }

    // 2. Cihaz bilgilerini topla ve aktivasyonu gönder
    $device_info = neotiler_get_device_info();

    $response = wp_remote_post(NEOTILER_LS_API_URL . 'activate', [
        'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json'],
        'body'    => json_encode([
            'license_key'   => $key,
            'instance_name' => $device_info,
        ]),
        'timeout' => 15,
    ]);

    if (is_wp_error($response)) {
        return ['success' => false, 'message' => 'Sunucuya bağlanılamadı. Lütfen tekrar deneyin.'];
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    if (!empty($body['activated']) && $body['activated'] === true) {
        update_option('neotiler_license_key', $key);
        update_option('neotiler_license_instance_id', $body['instance']['id'] ?? '');
        update_option('neotiler_license_status', 'active');
        delete_transient('neotiler_license_valid');
        return [
            'success' => true,
            'message' => sprintf('✅ Lisans başarıyla aktive edildi! (Kullanım: %d/%d site)', $slot_check['usage'] + 1, $slot_check['limit']),
        ];
    }

    $error = $body['error'] ?? 'Lisans geçersiz veya bu domain için zaten kullanılıyor.';
    return ['success' => false, 'message' => '❌ ' . $error];
}

/**
 * Mevcut sitedeki lisansı deaktive et.
 * @return array ['success' => bool, 'message' => string]
 */
function neotiler_deactivate_license() {
    $key         = get_option('neotiler_license_key');
    $instance_id = get_option('neotiler_license_instance_id');

    if (!$key || !$instance_id) {
        return ['success' => false, 'message' => 'Aktif bir lisans bulunamadı.'];
    }

    $response = wp_remote_post(NEOTILER_LS_API_URL . 'deactivate', [
        'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json'],
        'body'    => json_encode([
            'license_key'  => $key,
            'instance_id'  => $instance_id,
        ]),
        'timeout' => 15,
    ]);

    if (is_wp_error($response)) {
        return ['success' => false, 'message' => 'Sunucuya bağlanılamadı.'];
    }

    // Yerel kaydı her zaman temizle (API hata verse bile)
    delete_option('neotiler_license_key');
    delete_option('neotiler_license_instance_id');
    update_option('neotiler_license_status', 'inactive');
    delete_transient('neotiler_license_valid');

    return ['success' => true, 'message' => 'Lisans bu siteden kaldırıldı.'];
}

// ─── Frontend Banner ─────────────────────────────────────────────────────────

/**
 * Lisans/trial geçersizse sitenin en üstüne uyarı banner ekle.
 */
function neotiler_license_banner() {
    if (is_admin()) return;
    if (neotiler_is_licensed()) return;

    $days_left = neotiler_trial_days_remaining();
    $is_expired_trial = ($days_left <= 0 && get_option('neotiler_license_status', 'trial') !== 'active');

    if (!$is_expired_trial) return;

    ?>
    <div id="neotiler-license-banner" style="
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 999999;
        background: linear-gradient(90deg, #e11d48, #9f1239);
        color: #ffffff;
        text-align: center;
        padding: 10px 20px;
        font-family: system-ui, -apple-system, sans-serif;
        font-size: 14px;
        font-weight: 600;
        letter-spacing: 0.02em;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    ">
        ⚠️ NeoTiler Blog temasının deneme süresi doldu. Tüm özelliklere erişmeye devam etmek için
        <a href="<?php echo esc_url(admin_url('themes.php?page=neotiler-license')); ?>"
           style="color: #fde68a; text-decoration: underline; margin-left: 4px;">
            lisans anahtarı girin
        </a>.
    </div>
    <style>body { margin-top: 44px !important; }</style>
    <?php
}
add_action('wp_body_open', 'neotiler_license_banner');

// ─── Admin Notice ─────────────────────────────────────────────────────────────

function neotiler_admin_license_notice() {
    if (neotiler_is_licensed()) return;
    $days_left = neotiler_trial_days_remaining();
    $screen = get_current_screen();

    // Lisans sayfasında gösterme
    if ($screen && $screen->id === 'appearance_page_neotiler-license') return;

    if ($days_left > 0) {
        $cls  = 'notice-warning';
        $msg  = sprintf('NeoTiler Blog: Deneme sürenizin bitmesine <strong>%d gün</strong> kaldı.', $days_left);
    } else {
        $cls  = 'notice-error';
        $msg  = 'NeoTiler Blog: Deneme süreniz doldu!';
    }

    printf(
        '<div class="notice %s"><p>%s <a href="%s">Lisansı Aktive Et →</a></p></div>',
        esc_attr($cls),
        $msg,
        esc_url(admin_url('themes.php?page=neotiler-license'))
    );
}
add_action('admin_notices', 'neotiler_admin_license_notice');
