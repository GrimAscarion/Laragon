<?php
session_start();

if(!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../config/koneksi.php';

$query_products = "SELECT * FROM spareparts ORDER BY id DESC LIMIT 16";
$result_products = $pdo->query($query_products);

$query_categories = "SELECT * FROM categories LIMIT 5";
$result_categories = $pdo->query($query_categories);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Oli Mesin - Siska Maju Motor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <div id="intro-overlay" class="fixed inset-0 z-[100] bg-black flex items-center justify-center transition-opacity duration-1000">
        <video id="intro-video" class="w-full h-full object-cover" autoplay muted playsinline>
            <source src="assets/video/intro_index.mp4" type="video/mp4">
            Maaf, browser Anda tidak mendukung pemutaran video.
        </video>
    </div>

    <header class="bg-gradient-to-r from-purple-700 via-yellow-400 to-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">

            <a href="index.php" class="bg-white px-3 py-1.5 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 inline-flex items-center cursor-pointer">
                <img src="assets/img/logo_web.png" alt="Logo Siska Maju Motor" class="h-10 md:h-12 w-auto object-contain">
            </a>
            
            <?php 
                // Logika mendeteksi halaman saat ini yang sedang dibuka
                $current_page = basename($_SERVER['PHP_SELF']); 
                
                // Daftar menu navigasi
                $nav_items = [
                    'index.php' => 'Beranda',
                    'katalog.php' => 'Katalog',
                    'promo.php' => 'Promo',
                    'kontak.php' => 'Kontak Kami'
                ];
            ?>
            <nav class="hidden md:flex gap-6 font-semibold items-center">
                <?php foreach($nav_items as $url => $label): ?>
                    <?php if($current_page == $url): ?>
                        <!-- Menu Aktif: Teks tebal ungu gelap dengan garis bawah penuh yang tebal -->
                        <a href="<?= $url ?>" class="relative py-1 text-purple-900 font-extrabold after:content-[''] after:absolute after:w-full after:h-[3px] after:bg-purple-900 after:bottom-0 after:left-0 after:rounded-full">
                            <?= $label ?>
                        </a>
                    <?php else: ?>
                        <!-- Menu Tidak Aktif: Teks abu dengan animasi garis ungu meluncur dari kanan ke kiri saat di-hover -->
                        <a href="<?= $url ?>" class="relative py-1 text-gray-700 hover:text-purple-800 after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-[3px] after:bg-purple-600 after:bottom-0 after:left-0 after:origin-bottom-right after:transition-transform after:duration-300 hover:after:scale-x-100 hover:after:origin-bottom-left after:rounded-full">
                            <?= $label ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
                
                <div class="ml-4 flex items-center gap-3 border-l-2 border-gray-300 pl-6">
                    <a href="profil_akun.php" class="flex items-center gap-2 bg-purple-100 text-purple-800 px-4 py-2 rounded-full hover:bg-purple-200 hover:shadow-md transition font-bold text-sm">
                        <i data-lucide="user" class="w-4 h-4"></i> Profil Akun
                    </a>
                    <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')" class="flex items-center gap-2 bg-red-100 text-red-600 px-4 py-2 rounded-full hover:bg-red-600 hover:text-white transition font-bold text-sm shadow-sm">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                    </a>
                </div>
            </nav>

            <div class="md:hidden flex items-center gap-4 text-gray-800">
                <a href="profil_akun.php" class="text-purple-700 bg-purple-100 p-2 rounded-full"><i data-lucide="user" class="w-5 h-5"></i></a>
                <a href="logout.php" onclick="return confirm('Keluar dari akun?')" class="text-red-500 bg-red-50 p-2 rounded-full"><i data-lucide="log-out" class="w-5 h-5"></i></a>
                <button><i data-lucide="menu" class="w-6 h-6"></i></button>
            </div>
        </div>
    </header>