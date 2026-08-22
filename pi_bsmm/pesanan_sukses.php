<?php
session_start();
require_once 'config/koneksi.php';

if(!isset($_GET['invoice'])) {
    header("Location: index.php");
    exit;
}

$invoice = trim($_GET['invoice']);
$user_id = $_SESSION['customer_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simulasi_bayar'])) {
    try {
        $stmt = $pdo->prepare("UPDATE transaksi SET status = 'Diproses' WHERE invoice = ? AND customer_id = ?");
        $stmt->execute([$invoice, $user_id]);
    } catch (Exception $e) {}
    $_SESSION['status_lunas_' . $invoice] = true;
    header("Location: pesanan_sukses.php?invoice=$invoice");
    exit;
}

$stmt = $pdo->prepare("SELECT t.*, c.nama_lengkap, c.no_telp FROM transaksi t JOIN customers c ON t.customer_id = c.id WHERE t.invoice=? AND t.customer_id=?");
$stmt->execute([$invoice, $user_id]);

if($stmt->rowCount() == 0) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

$transaksi = $stmt->fetch();

$stmt_detail = $pdo->prepare("SELECT td.qty, td.harga_satuan, s.nama_sparepart FROM transaksi_detail td JOIN spareparts s ON td.sparepart_id = s.id WHERE td.transaksi_id = ?");
$stmt_detail->execute([$transaksi['id']]);
$details = $stmt_detail->fetchAll();

$is_lunas = isset($_SESSION['status_lunas_' . $invoice]) ? true : false;
if (isset($transaksi['status']) && in_array(strtolower($transaksi['status']), ['diproses', 'lunas', 'dikirim', 'selesai'])) {
    $is_lunas = true;
}

$waktu_batas_bayar = date('d M Y, H:i', strtotime($transaksi['created_at'] . ' +24 hours'));
$metode = $transaksi['metode_pembayaran'];
$nomor_va = "8077" . substr(preg_replace('/[^0-9]/', '', $transaksi['invoice']), -8);
$total_rp = number_format($transaksi['total_tagihan'], 0, ',', '.');
$pesan_wa = "Halo Bantuan Siska, saya butuh bantuan terkait pesanan saya dengan Invoice: " . $transaksi['invoice'];
$link_wa = "https://wa.me/6282122707303?text=" . urlencode($pesan_wa);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Siska Maju Motor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .dashed-border { border: 2px dashed #e5e7eb; }
        @media print {
            body { background: white !important; margin: 0; padding: 0; }
            .no-print { display: none !important; }
            .print-area { box-shadow: none !important; border: none !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .bg-gray-50 { background: transparent !important; }
            * { print-color-adjust: exact !important; -webkit-print-color-adjust: exact !important; }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-8 px-4">

    <div class="print-area bg-white max-w-2xl w-full rounded-3xl shadow-xl overflow-hidden border border-gray-100 relative">
        
        <div class="no-print">
            <?php if(!$is_lunas && strpos($metode, 'COD') === false): ?>
            <div class="bg-yellow-50 p-6 text-center border-b border-yellow-100">
                <h1 class="text-xl font-bold text-gray-800">Menunggu Pembayaran</h1>
                <p class="text-sm text-gray-500 mt-1">Selesaikan pembayaran sebelum:</p>
                <p class="text-lg font-black text-red-600 mt-2 flex items-center justify-center gap-2">
                    <i data-lucide="clock" class="w-5 h-5"></i> <?= $waktu_batas_bayar ?> WIB
                </p>
            </div>
            <?php elseif($is_lunas || strpos($metode, 'COD') !== false): ?>
            <div class="bg-green-50 p-8 text-center border-b border-green-100">
                <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-200">
                    <i data-lucide="check" class="w-8 h-8 text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Pesanan Dikonfirmasi</h1>
                <p class="text-sm text-gray-600 mt-2">Terima kasih atas pesanan Anda.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="p-6 md:p-10">
            <div class="flex justify-between items-start border-b border-gray-200 pb-6 mb-6">
                <div>
                    <img src="assets/img/logo_web.png" class="h-8 mb-2 no-print" alt="Logo" onerror="this.style.display='none'">
                    <h2 class="text-2xl font-black text-gray-800 tracking-tight">INVOICE</h2>
                    <p class="text-gray-500 text-sm mt-1"><?= $transaksi['invoice'] ?></p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-800">Siska Maju Motor</p>
                    <p class="text-xs text-gray-500 mt-1">Jl. Otomotif Raya No. 99<br>Jakarta Timur</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between mb-8 gap-4">
                <div>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Diterbitkan untuk:</p>
                    <p class="text-sm font-bold text-gray-800"><?= htmlspecialchars($transaksi['nama_lengkap']) ?></p>
                    <p class="text-sm text-gray-600"><?= htmlspecialchars($transaksi['no_telp']) ?></p>
                    <p class="text-sm text-gray-600 max-w-[200px] mt-1"><?= htmlspecialchars($transaksi['alamat_pengiriman']) ?></p>
                </div>
                <div class="sm:text-right">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">Tanggal Pesanan:</p>
                    <p class="text-sm font-bold text-gray-800"><?= date('d F Y', strtotime($transaksi['created_at'])) ?></p>
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-4 mb-1">Metode Bayar:</p>
                    <p class="text-sm font-bold text-purple-700"><?= $transaksi['metode_pembayaran'] ?></p>
                </div>
            </div>

            <table class="w-full text-left border-collapse mb-6">
                <thead>
                    <tr class="border-y border-gray-200 bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="py-3 px-2 font-bold">Produk</th>
                        <th class="py-3 px-2 font-bold text-center">Qty</th>
                        <th class="py-3 px-2 font-bold text-right">Harga</th>
                        <th class="py-3 px-2 font-bold text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100">
                    <?php 
                    $total_barang = 0;
                    foreach($details as $d): 
                        $sub = $d['qty'] * $d['harga_satuan'];
                        $total_barang += $sub;
                    ?>
                    <tr>
                        <td class="py-3 px-2 font-medium text-gray-800"><?= htmlspecialchars($d['nama_sparepart']) ?></td>
                        <td class="py-3 px-2 text-center text-gray-600"><?= $d['qty'] ?></td>
                        <td class="py-3 px-2 text-right text-gray-600"><?= number_format($d['harga_satuan'], 0, ',', '.') ?></td>
                        <td class="py-3 px-2 text-right font-bold text-gray-800"><?= number_format($sub, 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="flex justify-end border-t border-gray-200 pt-4">
                <div class="w-full sm:w-1/2">
                    <div class="flex justify-between text-sm mb-2 text-gray-600">
                        <span>Total Harga Produk</span>
                        <span>Rp <?= number_format($total_barang, 0, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-sm mb-4 text-gray-600">
                        <span>Ongkos Kirim / Lainnya</span>
                        <span>Rp <?= number_format($transaksi['total_tagihan'] - $total_barang, 0, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between text-lg font-black text-purple-700 bg-purple-50 p-3 rounded-lg">
                        <span>Total Tagihan</span>
                        <span>Rp <?= $total_rp ?></span>
                    </div>
                </div>
            </div>

            <div class="no-print mt-10">
                <?php if(!$is_lunas): ?>
                    <?php if(strpos($metode, 'Virtual Account') !== false): ?>
                        <div class="mb-8 text-center bg-blue-50 p-6 rounded-2xl border border-blue-100">
                            <p class="text-sm text-gray-600 mb-2">Transfer tepat hingga 3 digit terakhir ke Nomor Virtual Account BCA Anda:</p>
                            <div class="flex items-center justify-center gap-3 bg-white py-3 px-4 rounded-xl border border-gray-200 w-max mx-auto shadow-sm">
                                <span class="text-2xl font-black tracking-widest text-gray-800" id="va_number"><?= $nomor_va ?></span>
                                <button onclick="copyToClipboard('va_number', this)" class="text-blue-600 hover:text-blue-800 transition">
                                    <i data-lucide="copy" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    <?php elseif(strpos($metode, 'QRIS') !== false): ?>
                        <div class="mb-8 text-center bg-red-50 p-6 rounded-2xl border border-red-100">
                            <p class="text-sm text-gray-600 mb-4">Scan QR Code di bawah menggunakan e-Wallet / M-Banking</p>
                            <div class="dashed-border p-4 rounded-xl w-40 h-40 mx-auto bg-white shadow-sm flex items-center justify-center">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=Pembayaran+SiskaMotor+<?= $invoice ?>" alt="QRIS Code">
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php if(!$is_lunas && strpos($metode, 'COD') === false): ?>
                    <form action="" method="POST" class="w-full sm:col-span-2">
                        <button type="submit" name="simulasi_bayar" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition shadow text-center flex items-center justify-center gap-2">
                            <i data-lucide="refresh-cw" class="w-5 h-5"></i> Simulasikan Pembayaran Berhasil
                        </button>
                    </form>
                    <?php endif; ?>
                    
                    <button onclick="window.print()" class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3.5 rounded-xl transition flex items-center justify-center gap-2 shadow">
                        <i data-lucide="printer" class="w-4 h-4"></i> Cetak PDF
                    </button>
                    
                    <a href="profil_akun.php?tab=pesanan" class="w-full bg-purple-100 hover:bg-purple-200 text-purple-700 font-bold py-3.5 rounded-xl transition flex items-center justify-center gap-2 shadow-sm border border-purple-200">
                        <i data-lucide="package" class="w-4 h-4"></i> Lacak Pesanan
                    </a>
                </div>

                <div class="mt-8 text-center">
                    <a href="<?= $link_wa ?>" target="_blank" class="inline-flex items-center gap-2 text-sm text-[#25D366] font-semibold hover:underline">
                        <i data-lucide="message-circle" class="w-4 h-4"></i> Kendala? Hubungi Bantuan Siska
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script src="assets/js/main.js"></script>
    <script>
        lucide.createIcons();

        function copyToClipboard(elementId, btn) {
            var text = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(text).then(function() {
                let icon = btn.innerHTML;
                btn.innerHTML = '<i data-lucide="check" class="w-5 h-5 text-green-600"></i>';
                lucide.createIcons();
                setTimeout(() => {
                    btn.innerHTML = icon;
                    lucide.createIcons();
                }, 2000);
            });
        }
    </script>
</body>
</html>