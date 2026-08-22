<?php
require_once 'includes/header.php';

/** 
 * @var PDOStatement $result_products
 * @var PDOStatement $result_categories
 */
?>

    <main class="flex-grow container mx-auto px-4 py-8">
        
        <section class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-10">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-bold px-3 py-1 rounded-full w-max mb-4">Promo Spesial Bulan Ini!</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 leading-tight">
                        Sambut Flash Sale <br><span class="text-purple-700">Pusat Oli Siska Maju Motor</span>
                    </h2>
                    <p class="text-gray-600 mb-6 text-lg">
                        Temukan penawaran terbaik untuk berbagai merk oli mesin berkualitas. Apapun jenis motor Anda—Matic, Manual, atau Sport—kami siapkan pelumas maksimal untuk menjaga performa mesinnya. Diskon berlaku hingga waktu yang ditentukan admin!
                    </p>
                    <div class="flex gap-4">
                        <a href="promo.php" class="bg-purple-700 hover:bg-purple-800 text-white px-6 py-3 rounded-lg font-semibold transition shadow-lg flex items-center gap-2">
                            Lihat Promo Oli <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>
                <div class="relative h-64 md:h-auto">
                    <img src="assets/img/dashboard.png" alt="Banner Oli Mesin" class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-white via-transparent to-transparent"></div>
                </div>
            </div>
        </section>

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-3/4">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <i data-lucide="shopping-bag" class="text-purple-600"></i> Etalase Produk
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php while ($product = $result_products->fetch()):
                        $img = !empty($product['image_url']) ? 'assets/img/' . $product['image_url'] : 'https://via.placeholder.com/400?text=No+Image';
                        if ($product['image_url'] == 'default.jpg' || filter_var($product['image_url'], FILTER_VALIDATE_URL)) {
                             $img = filter_var($product['image_url'], FILTER_VALIDATE_URL) ? $product['image_url'] : 'assets/img/default.jpg';
                        }
                        
                        $harga = 'Rp ' . number_format($product['harga_jual'], 0, ',', '.');
                        
                        $nama_produk = $product['nama_sparepart'] . ' (' . $product['peruntukan_motor'] . ')';
                        $is_habis = $product['stok'] <= 0;
                    ?>
                    
                    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group flex flex-col h-full relative">
                        
                        <div class="absolute top-2 left-2 z-10 flex flex-col gap-1">
                            <?php if(isset($product['discount_label']) && !empty($product['discount_label']) && !$is_habis): ?>
                                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm w-max">
                                    <?= $product['discount_label'] ?>
                                </span>
                            <?php endif; ?>
                            <?php if($is_habis): ?>
                                <span class="bg-gray-800 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm w-max">
                                    STOK HABIS
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="bg-gray-100 rounded-xl aspect-square mb-4 overflow-hidden relative">
                            <img src="<?= $img ?>" alt="<?= $nama_produk ?>" class="w-full h-full object-cover <?= $is_habis ? 'grayscale opacity-60' : 'group-hover:scale-110' ?> transition duration-500">
                        </div>
                        
                        <div class="flex-grow flex flex-col">
                            <h4 class="font-semibold <?= $is_habis ? 'text-gray-400' : 'text-gray-800' ?> text-sm line-clamp-2 mb-1"><?= $nama_produk ?></h4>
                            <p class="<?= $is_habis ? 'text-gray-400' : 'text-purple-700' ?> font-bold text-lg mt-auto"><?= $harga ?></p>
                        </div>
                        
                        <div class="mt-4 space-y-2">
                            <?php if($is_habis): ?>
                                <button disabled class="w-full border-2 border-gray-200 text-gray-400 bg-gray-50 font-semibold py-2 rounded-lg cursor-not-allowed flex items-center justify-center gap-2">Kosong</button>
                            <?php else: ?>
                                <a href="keranjang_aksi.php?action=add&id=<?= $product['id'] ?>&redirect=index.php" class="w-full border-2 border-purple-600 text-purple-600 hover:bg-purple-50 font-semibold py-2 rounded-lg transition flex items-center justify-center gap-2">
                                    <i data-lucide="shopping-cart" class="w-4 h-4"></i> Keranjang
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>

                <div class="mt-8 flex justify-center">
                    <a href="katalog.php" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-3 px-8 rounded-full shadow-lg transition-transform hover:scale-105 flex items-center gap-2">
                        Lihat Semua Katalog Produk <i data-lucide="layout-grid" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>

            <div class="lg:w-1/4 space-y-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-28">
                    <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i data-lucide="list" class="w-5 h-5 text-gray-500"></i> Kategori Populer
                    </h4>
                    <div class="space-y-3">
                        <?php while ($cat = $result_categories->fetch()): ?>
                            <a href="katalog.php?kategori=<?= $cat['id'] ?>" class="block w-full bg-gray-100 hover:bg-yellow-100 hover:text-yellow-800 text-gray-600 text-center py-3 rounded-xl font-medium transition duration-300">
                                <?= $cat['nama_kategori'] ?>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

        </div>
    </main>

<?php
require_once 'includes/footer.php';
?>