<?php
require_once 'includes/header.php';

$promos = [
    [
        'id' => 1,
        'title' => 'Ganti Oli & Servis Ringan',
        'discount' => 'Diskon 20%',
        'description' => 'Berlaku untuk semua jenis motor matic. Termasuk pengecekan CVT dan pembersihan injektor.',
        'code' => 'MATIC20',
        'end_date' => '2026-07-15 23:59:59',
        'image' => 'assets/img/matic20.png',
        'color' => 'from-orange-500 to-red-500'
    ],
    [
        'id' => 2,
        'title' => 'Promo Beli 2 Gratis 1 Oli Gardan',
        'discount' => 'Beli 2 Gratis 1',
        'description' => 'Khusus pembelian oli gardan merk Yamalube. Tidak dapat digabung dengan promo lain.',
        'code' => 'YAMALUBE3',
        'end_date' => '2026-07-10 23:59:59',
        'image' => 'assets/img/yamalube3.png',
        'color' => 'from-blue-500 to-indigo-600'
    ],
    [
        'id' => 3,
        'title' => 'Cashback Pelanggan Baru',
        'discount' => 'Cashback Rp 50.000',
        'description' => 'Dapatkan cashback langsung untuk transaksi pertama Anda di website Siska Maju Motor. Min. transaksi Rp 200.000.',
        'code' => 'NEWCUST50',
        'end_date' => '2026-07-31 23:59:59',
        'image' => 'assets/img/newcust50.png',
        'color' => 'from-emerald-500 to-teal-600'
    ]
];

$flash_sale_products = [
    [
        'id' => 1,
        'name' => 'Oli Yamalube Super Matic 1L',
        'price_normal' => 'Rp 95.000',
        'price_promo' => 'Rp 75.000',
        'discount_label' => 'Hemat Rp 20rb',
        'image' => 'assets/img/yamalube_super_matic.jpg',
        'stock' => 15
    ],
    [
        'id' => 3,
        'name' => 'Enduro Matic V 10W-40 1L',
        'price_normal' => 'Rp 65.000',
        'price_promo' => 'Rp 55.000',
        'discount_label' => 'Hemat Rp 10rb',
        'image' => 'assets/img/enduro_matic_v.jpg',
        'stock' => 8
    ]
];
?>

    <main class="flex-grow">
        <section class="relative bg-gradient-to-br from-red-600 via-pink-600 to-purple-800 animate-bg-pan py-16 lg:py-24 overflow-hidden shadow-inner">
            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'#ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            
            <div class="container mx-auto px-4 relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="md:w-1/2 text-center md:text-left">
                    <span class="inline-block py-1 px-3 rounded-full bg-yellow-400 text-red-900 text-sm font-bold uppercase tracking-wider mb-4 shadow-sm animate-pulse">
                        Penawaran Terbatas
                    </span>
                    <h1 class="text-4xl md:text-6xl font-black text-white mb-4 leading-tight drop-shadow-md">
                        PESTA DISKON <br> <span class="text-yellow-400">TENGAH TAHUN</span>
                    </h1>
                    <p class="text-lg text-white/90 mb-8 max-w-lg mx-auto md:mx-0 font-medium">
                        Jangan lewatkan kesempatan untuk merawat motor kesayangan Anda dengan harga super hemat. Klaim vouchernya sekarang!
                    </p>
                    <a href="#daftar-voucher" class="bg-white text-red-600 hover:bg-gray-100 font-bold py-3 px-8 rounded-full shadow-lg transition-transform transform hover:-translate-y-1 inline-flex items-center gap-2">
                        Lihat Semua Promo <i data-lucide="arrow-down-circle" class="w-5 h-5"></i>
                    </a>
                </div>
                
                <div class="md:w-1/2 flex justify-center">
                    <div class="bg-white p-6 rounded-2xl shadow-2xl transform rotate-3 hover:rotate-0 transition-all duration-300 w-full max-w-sm border-l-8 border-yellow-400 relative">
                        <div class="absolute -top-4 -right-4 bg-red-500 text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg shadow-md">
                            -50%
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">MEGA SALE</h3>
                        <p class="text-gray-600 mb-4 text-sm">Diskon s/d 50% untuk servis lengkap & ganti oli premium.</p>
                        <div class="bg-gray-100 border border-dashed border-gray-400 p-3 rounded text-center mb-4">
                            <span class="font-mono text-xl font-bold text-purple-700 tracking-widest">MEGASISKA</span>
                        </div>
                        <p class="text-xs text-center text-red-500 font-semibold">*Berakhir dalam <span id="hero-countdown">...</span></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 bg-white border-b border-gray-100">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-red-100 p-3 rounded-xl text-red-600">
                            <i data-lucide="zap" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Kejar Diskon <span class="text-red-600">Flash Sale!</span></h2>
                            <p class="text-gray-500 text-sm">Stok terbatas, siapa cepat dia dapat.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2 bg-gray-900 p-2.5 rounded-lg text-white font-mono text-lg shadow-inner">
                        <div class="bg-gray-800 px-2 py-1 rounded" id="fs-hours">00</div><span class="text-gray-400">:</span>
                        <div class="bg-gray-800 px-2 py-1 rounded" id="fs-minutes">00</div><span class="text-gray-400">:</span>
                        <div class="bg-red-600 px-2 py-1 rounded animate-pulse" id="fs-seconds">00</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($flash_sale_products as $fs): ?>
                    <div class="bg-white border border-gray-200 rounded-2xl p-4 hover:shadow-xl transition-shadow relative overflow-hidden group">
                        <div class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded z-10 shadow-sm">
                            <?= $fs['discount_label'] ?>
                        </div>

                        <div class="bg-gray-50 rounded-xl mb-4 p-2 relative">
                            <img src="<?= $fs['image'] ?>" alt="<?= $fs['name'] ?>" class="w-full h-48 object-contain group-hover:scale-105 transition duration-300">
                        </div>

                        <h4 class="font-semibold text-gray-800 text-sm line-clamp-2 mb-2"><?= $fs['name'] ?></h4>
                        
                        <div class="flex items-baseline gap-2 mb-3">
                            <span class="text-xl font-bold text-red-600"><?= $fs['price_promo'] ?></span>
                            <span class="text-sm text-gray-400 line-through"><?= $fs['price_normal'] ?></span>
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-500">Sisa Stok</span>
                                <span class="font-bold text-red-500"><?= $fs['stock'] ?> pcs</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: <?= ($fs['stock'] / 50) * 100 ?>%"></div>
                            </div>
                        </div>

                        <a href="keranjang_aksi.php?action=add&id=<?= $fs['id'] ?>&redirect=promo.php" class="w-full bg-gray-900 hover:bg-red-600 text-white font-bold py-2.5 rounded-lg transition-colors flex justify-center items-center gap-2 text-sm shadow-md">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i> Masukkan Keranjang
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="daftar-voucher" class="py-16 container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Voucher & Diskon Menarik</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Klaim voucher di bawah ini dan gunakan kodenya pada saat pembayaran untuk mendapatkan potongan harga langsung.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($promos as $promo): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-lg transition-shadow">
                    
                    <div class="h-40 relative">
                        <img src="<?= $promo['image'] ?>" alt="<?= $promo['title'] ?>" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <span class="bg-white text-gray-900 text-xs font-extrabold px-2 py-1 rounded uppercase tracking-wider mb-2 inline-block">
                                <?= $promo['discount'] ?>
                            </span>
                            <h3 class="text-white font-bold text-lg leading-tight truncate-2-lines"><?= $promo['title'] ?></h3>
                        </div>
                    </div>

                    <div class="p-5 flex-grow flex flex-col">
                        <p class="text-gray-600 text-sm mb-4 flex-grow"><?= $promo['description'] ?></p>
                        
                        <div class="flex items-center gap-2 text-xs text-red-500 font-medium mb-4 bg-red-50 p-2 rounded-lg">
                            <i data-lucide="clock" class="w-4 h-4"></i>
                            <span>Berakhir: <span class="promo-timer" data-end="<?= $promo['end_date'] ?>">Menghitung...</span></span>
                        </div>

                        <div class="mt-auto">
                            <p class="text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Kode Voucher</p>
                            <div class="flex relative">
                                <input type="text" value="<?= $promo['code'] ?>" readonly 
                                    class="w-full bg-gray-50 border border-gray-200 border-r-0 rounded-l-lg p-3 text-gray-800 font-mono font-bold tracking-widest text-center focus:outline-none"
                                    id="code-<?= $promo['id'] ?>">
                                
                                <button onclick="copyCode('code-<?= $promo['id'] ?>', this)" 
                                    class="bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 px-4 rounded-r-lg font-semibold text-sm transition-colors flex items-center gap-2 group">
                                    <i data-lucide="copy" class="w-4 h-4 group-hover:scale-110 transition-transform"></i> <span class="copy-text">Salin</span>
                                </button>
                            </div>
                            
                            <a href="katalog.php" class="mt-3 block w-full text-center text-sm bg-purple-50 hover:bg-purple-100 text-purple-700 font-bold py-2.5 rounded-lg transition border border-purple-200">
                                Mulai Belanja Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-16 bg-blue-50 border border-blue-100 rounded-2xl p-6 md:p-8">
                <h4 class="font-bold text-blue-900 mb-4 flex items-center gap-2">
                    <i data-lucide="info" class="w-5 h-5"></i> Syarat & Ketentuan Umum Promo
                </h4>
                <ul class="list-disc list-inside text-sm text-blue-800/80 space-y-2">
                    <li>Promo tidak dapat digabungkan dengan promo lainnya kecuali dinyatakan lain.</li>
                    <li>Voucher hanya berlaku untuk transaksi online melalui website Siska Maju Motor.</li>
                    <li>Pihak Siska Maju Motor berhak membatalkan pesanan apabila ditemukan indikasi kecurangan.</li>
                    <li>Masa berlaku voucher sesuai dengan yang tertera pada masing-masing banner promo.</li>
                </ul>
            </div>
        </section>
    </main>

    <script>
        function copyCode(inputId, button) {
            var copyText = document.getElementById(inputId);
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            
            var spanText = button.querySelector('.copy-text');
            var originalText = spanText.innerText;
            spanText.innerText = "Tersalin!";
            button.classList.add('bg-green-50', 'text-green-600', 'border-green-200');
            
            setTimeout(function() {
                spanText.innerText = originalText;
                button.classList.remove('bg-green-50', 'text-green-600', 'border-green-200');
            }, 2000);
        }

        let flashSaleTime = 2 * 60 * 60; 
        setInterval(() => {
            let h = Math.floor(flashSaleTime / 3600);
            let m = Math.floor((flashSaleTime % 3600) / 60);
            let s = flashSaleTime % 60;
            
            if(document.getElementById('fs-hours')) document.getElementById('fs-hours').innerText = h.toString().padStart(2, '0');
            if(document.getElementById('fs-minutes')) document.getElementById('fs-minutes').innerText = m.toString().padStart(2, '0');
            if(document.getElementById('fs-seconds')) document.getElementById('fs-seconds').innerText = s.toString().padStart(2, '0');
            
            if(flashSaleTime > 0) flashSaleTime--;
        }, 1000);
    </script>

<?php
require_once 'includes/footer.php';
?>