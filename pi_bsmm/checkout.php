<?php
session_start();
require_once 'config/koneksi.php';

if(!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['customer_id'];

$stmt_user = $pdo->prepare("SELECT * FROM customers WHERE id=?");
$stmt_user->execute([$user_id]);
$user = $stmt_user->fetch();

$stmt_keranjang = $pdo->prepare("
    SELECT k.qty, s.id as prod_id, s.nama_sparepart, s.peruntukan_motor, s.harga_jual, s.image_url, s.stok 
    FROM keranjang k 
    JOIN spareparts s ON k.sparepart_id = s.id 
    WHERE k.customer_id = ?
");
$stmt_keranjang->execute([$user_id]);
$keranjang_items = $stmt_keranjang->fetchAll();

if(count($keranjang_items) == 0) {
    header("Location: profil_akun.php?tab=keranjang");
    exit;
}

$sub_total = 0;
$items = [];
foreach($keranjang_items as $row){
    $items[] = $row;
    $sub_total += ($row['harga_jual'] * $row['qty']);
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buat_pesanan'])) {
    $alamat_pengiriman = trim($_POST['alamat']);
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $ongkir = (int)$_POST['opsi_pengiriman']; 
    
    $grand_total = $sub_total + $ongkir; 
    $invoice = "INV-" . date("Ymd") . "-" . strtoupper(substr(uniqid(), -4));

    try {
        $pdo->beginTransaction();

        $stmt_transaksi = $pdo->prepare("INSERT INTO transaksi (invoice, customer_id, total_tagihan, metode_pembayaran, alamat_pengiriman) VALUES (?, ?, ?, ?, ?)");
        $stmt_transaksi->execute([$invoice, $user_id, $grand_total, $metode_pembayaran, $alamat_pengiriman]);
        $transaksi_id = $pdo->lastInsertId();

        $stmt_detail = $pdo->prepare("INSERT INTO transaksi_detail (transaksi_id, sparepart_id, qty, harga_satuan) VALUES (?, ?, ?, ?)");
        $stmt_stok = $pdo->prepare("UPDATE spareparts SET stok = stok - ? WHERE id = ?");
        
        foreach($items as $item) {
            $stmt_detail->execute([$transaksi_id, $item['prod_id'], $item['qty'], $item['harga_jual']]);
            $stmt_stok->execute([$item['qty'], $item['prod_id']]);
        }

        $stmt_hapus_keranjang = $pdo->prepare("DELETE FROM keranjang WHERE customer_id=?");
        $stmt_hapus_keranjang->execute([$user_id]);

        $pdo->commit();

        header("Location: pesanan_sukses.php?invoice=$invoice");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Terjadi kesalahan sistem saat membuat pesanan: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pembayaran - Siska Maju Motor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="flex flex-col min-h-screen bg-gray-50">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="profil_akun.php?tab=keranjang" class="flex items-center gap-3 text-gray-500 font-semibold hover:text-purple-700 transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i> Kembali ke Keranjang
            </a>
            <h1 class="text-xl font-bold text-gray-800">Checkout <span class="text-purple-700">Aman</span></h1>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 py-8 max-w-5xl">
        <form action="" method="POST" class="flex flex-col lg:flex-row gap-8" id="checkoutForm">
            
            <div class="lg:w-2/3 space-y-6">
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="map-pin" class="text-purple-600"></i> Alamat Pengiriman
                    </h3>
                    <div class="bg-purple-50 p-4 rounded-xl border border-purple-100 mb-4">
                        <p class="font-bold text-gray-800"><?= htmlspecialchars($user['nama_lengkap']) ?> <span class="font-normal text-gray-500">(<?= htmlspecialchars($user['no_telp']) ?>)</span></p>
                    </div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Detail Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 p-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500"><?= htmlspecialchars($user['alamat_pengiriman'] ?? $user['alamat_lengkap']) ?></textarea>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="truck" class="text-purple-600"></i> Pilih Pengiriman
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="cursor-pointer h-full">
                            <input type="radio" name="opsi_pengiriman" value="15000" checked onchange="updateTotal()" class="peer hidden">
                            <div class="border border-gray-200 rounded-xl p-4 peer-checked:border-purple-600 peer-checked:bg-purple-50 transition flex justify-between items-center h-full">
                                <div>
                                    <div class="font-bold text-gray-800">Reguler (JNE/J&T)</div>
                                    <div class="text-sm text-gray-500">Estimasi 2-3 Hari</div>
                                </div>
                                <div class="font-bold text-gray-800">Rp 15.000</div>
                            </div>
                        </label>
                        <label class="cursor-pointer h-full">
                            <input type="radio" name="opsi_pengiriman" value="25000" onchange="updateTotal()" class="peer hidden">
                            <div class="border border-gray-200 rounded-xl p-4 peer-checked:border-purple-600 peer-checked:bg-purple-50 transition flex justify-between items-center h-full">
                                <div>
                                    <div class="font-bold text-gray-800">Kargo/Express</div>
                                    <div class="text-sm text-gray-500">Estimasi 1-2 Hari</div>
                                </div>
                                <div class="font-bold text-gray-800">Rp 25.000</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="credit-card" class="text-purple-600"></i> Pilih Metode Pembayaran
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="cursor-pointer flex flex-col h-full">
                            <input type="radio" name="metode_pembayaran" value="Virtual Account BCA" required class="peer hidden">
                            <div class="border border-gray-200 rounded-xl p-4 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition flex flex-col h-full">
                                <div class="flex items-center gap-3 mb-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" class="h-6 object-contain">
                                    <div class="font-bold text-gray-800 leading-tight">BCA Virtual Account</div>
                                </div>
                                <div class="text-sm text-gray-500 mt-auto">Verifikasi otomatis 10 menit</div>
                            </div>
                        </label>
                        <label class="cursor-pointer flex flex-col h-full">
                            <input type="radio" name="metode_pembayaran" value="QRIS" class="peer hidden">
                            <div class="border border-gray-200 rounded-xl p-4 peer-checked:border-red-500 peer-checked:bg-red-50 transition flex flex-col h-full">
                                <div class="flex items-center gap-3 mb-2">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg" class="h-6 object-contain">
                                    <div class="font-bold text-gray-800 leading-tight">QRIS (Gopay/OVO/Dana)</div>
                                </div>
                                <div class="text-sm text-gray-500 mt-auto">Scan barcode, langsung lunas</div>
                            </div>
                        </label>
                        <label class="cursor-pointer md:col-span-2">
                            <input type="radio" name="metode_pembayaran" value="COD" class="peer hidden">
                            <div class="border border-gray-200 rounded-xl p-4 peer-checked:border-gray-800 peer-checked:bg-gray-100 transition">
                                <div class="font-bold text-gray-800">Bayar di Tempat (COD)</div>
                                <div class="text-sm text-gray-500 mt-1">Siapkan uang tunai saat kurir datang. Dikenakan biaya penanganan 2%.</div>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            <div class="lg:w-1/3">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="shopping-bag" class="text-purple-600"></i> Ringkasan Belanja
                    </h3>
                    
                    <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                        <?php foreach($items as $item): 
                            $img = !empty($item['image_url']) ? 'assets/img/' . $item['image_url'] : 'https://via.placeholder.com/400?text=No+Image';
                        ?>
                        <div class="flex gap-3 items-center border-b border-gray-50 pb-3">
                            <img src="<?= $img ?>" class="w-12 h-12 object-cover rounded bg-gray-100 border border-gray-200">
                            <div class="flex-grow">
                                <h4 class="text-sm font-bold text-gray-800 line-clamp-1"><?= htmlspecialchars($item['nama_sparepart']) ?></h4>
                                <p class="text-xs text-gray-500"><?= $item['qty'] ?> x Rp <?= number_format($item['harga_jual'], 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <input type="hidden" id="sub_total" value="<?= $sub_total ?>">

                    <div class="border-t border-gray-200 pt-4 space-y-2 mb-6">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Total Harga Produk</span>
                            <span>Rp <?= number_format($sub_total, 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Total Ongkos Kirim</span>
                            <span id="display_ongkir">Rp 15.000</span>
                        </div>
                    </div>

                    <div class="flex justify-between text-lg font-black text-gray-800 mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <span>Total Belanja</span>
                        <span class="text-purple-700" id="display_grand_total">Rp <?= number_format($sub_total + 15000, 0, ',', '.') ?></span>
                    </div>

                    <button type="submit" name="buat_pesanan" class="w-full bg-purple-700 hover:bg-purple-800 text-white font-bold py-4 rounded-xl shadow-lg transition transform hover:-translate-y-1 text-lg flex justify-center items-center gap-2">
                        Bayar Sekarang <i data-lucide="shield-check"></i>
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-3 flex items-center justify-center gap-1">
                        <i data-lucide="lock" class="w-3 h-3"></i> Checkout dilindungi enkripsi SSL
                    </p>
                </div>
            </div>

        </form>
    </main>

    <script src="assets/js/main.js"></script>
    <script>
        lucide.createIcons();

        function updateTotal() {
            const subTotal = parseInt(document.getElementById('sub_total').value);
            const ongkirInput = document.querySelector('input[name="opsi_pengiriman"]:checked');
            const ongkir = ongkirInput ? parseInt(ongkirInput.value) : 0;
            
            const grandTotal = subTotal + ongkir;
            
            document.getElementById('display_ongkir').innerText = 'Rp ' + ongkir.toLocaleString('id-ID');
            document.getElementById('display_grand_total').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }
    </script>
</body>
</html>