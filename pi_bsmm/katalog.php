<?php
require_once 'includes/header.php';

$query_products = "SELECT spareparts.*, categories.nama_kategori FROM spareparts LEFT JOIN categories ON spareparts.kategori_id = categories.id ORDER BY spareparts.id DESC";
$result_products = $pdo->query($query_products);
$total_produk = $result_products->rowCount();
?>

<main class="flex-grow container mx-auto px-4 py-8">
    
    <?php if(isset($_SESSION['pesan_keranjang'])): ?>
        <div id="alert-keranjang" class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3"><i data-lucide="check-circle" class="w-5 h-5"></i> <?= htmlspecialchars($_SESSION['pesan_keranjang']) ?></div>
            <button onclick="document.getElementById('alert-keranjang').style.display='none'"><i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    <?php unset($_SESSION['pesan_keranjang']); endif; ?>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Katalog Produk</h1>
        <p class="text-gray-500 text-sm flex items-center gap-2">
            <a href="index.php" class="hover:text-purple-600 transition">Beranda</a> 
            <i data-lucide="chevron-right" class="w-4 h-4"></i> 
            <span class="text-purple-700 font-medium">Katalog Semua Produk</span>
        </p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <aside class="lg:w-1/4 flex-shrink-0">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-28 custom-scrollbar max-h-[calc(100vh-120px)] overflow-y-auto">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2"><i data-lucide="filter" class="w-5 h-5 text-purple-600"></i> Filter</h3>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Tipe Motor</label>
                    <div class="flex flex-wrap gap-2" id="quickFilters">
                        <button class="filter-btn active bg-purple-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold transition" data-filter="all">Semua</button>
                        <button class="filter-btn bg-gray-100 text-gray-600 hover:bg-purple-100 hover:text-purple-700 px-3 py-1.5 rounded-lg text-xs font-bold transition" data-filter="matic">Matic</button>
                        <button class="filter-btn bg-gray-100 text-gray-600 hover:bg-purple-100 hover:text-purple-700 px-3 py-1.5 rounded-lg text-xs font-bold transition" data-filter="bebek">Bebek</button>
                        <button class="filter-btn bg-gray-100 text-gray-600 hover:bg-purple-100 hover:text-purple-700 px-3 py-1.5 rounded-lg text-xs font-bold transition" data-filter="batangan">Batangan</button>
                        <button class="filter-btn bg-gray-100 text-gray-600 hover:bg-purple-100 hover:text-purple-700 px-3 py-1.5 rounded-lg text-xs font-bold transition" data-filter="universal">Universal</button>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Sparepart</label>
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Ketik nama sparepart..." class="w-full bg-gray-50 border border-gray-200 px-4 py-2.5 rounded-lg text-sm outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition">
                        <i data-lucide="search" class="absolute right-3 top-2.5 w-4 h-4 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </aside>

        <div class="lg:w-3/4">
            <div class="flex flex-col sm:flex-row items-center justify-between bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 gap-4">
                <p class="text-gray-600 text-sm font-medium">Menampilkan <span id="productCount" class="text-gray-900 font-bold"><?= $total_produk ?></span> produk</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6" id="productGrid">
                <?php while ($product = $result_products->fetch(PDO::FETCH_ASSOC)): 
                    $img = !empty($product['image_url']) ? 'assets/img/' . $product['image_url'] : 'https://via.placeholder.com/400?text=No+Image';
                    if ($product['image_url'] == 'default.jpg' || filter_var($product['image_url'], FILTER_VALIDATE_URL)) {
                         $img = filter_var($product['image_url'], FILTER_VALIDATE_URL) ? $product['image_url'] : 'assets/img/default.jpg';
                    }
                    
                    $harga_format = number_format($product['harga_jual'], 0, ',', '.');
                    $nama_produk = $product['nama_sparepart'] . ' (' . $product['peruntukan_motor'] . ')';
                    $is_habis = $product['stok'] <= 0;
                    $kategori_nama = isset($product['nama_kategori']) ? $product['nama_kategori'] : '';
                    $peruntukan = isset($product['peruntukan_motor']) ? $product['peruntukan_motor'] : '';
                ?>
                <div class="product-card bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 group flex flex-col h-full relative" 
                     data-title="<?= htmlspecialchars(strtolower($nama_produk)) ?>" 
                     data-category="<?= htmlspecialchars(strtolower($kategori_nama)) ?>"
                     data-motor="<?= htmlspecialchars(strtolower($peruntukan)) ?>">
                    
                    <div class="absolute top-2 left-2 z-10 flex flex-col gap-1">
                        <span class="bg-purple-100 text-purple-700 text-[10px] font-bold px-2 py-1 rounded shadow-sm border border-purple-200 w-max">
                            <?= htmlspecialchars($kategori_nama ?: 'Tanpa Kategori') ?>
                        </span>
                        <span class="bg-white/90 backdrop-blur-sm text-gray-700 text-[10px] font-bold px-2 py-1 rounded shadow-sm border border-gray-100 w-max">
                            <?= htmlspecialchars($product['peruntukan_motor']) ?>
                        </span>
                        <?php if(isset($product['discount_label']) && !empty($product['discount_label']) && !$is_habis): ?>
                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm w-max">
                                <?= htmlspecialchars($product['discount_label']) ?>
                            </span>
                        <?php endif; ?>
                        <?php if($is_habis): ?>
                            <span class="bg-gray-800 text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm w-max">
                                STOK HABIS
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="bg-gray-100 rounded-xl aspect-square mb-4 overflow-hidden relative">
                        <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($nama_produk) ?>" class="w-full h-full object-cover <?= $is_habis ? 'grayscale opacity-60' : 'group-hover:scale-110' ?> transition duration-500">
                    </div>
                    
                    <div class="flex-grow flex flex-col mt-4">
                        <h4 class="font-semibold <?= $is_habis ? 'text-gray-400' : 'text-gray-800 hover:text-purple-700' ?> text-sm line-clamp-2 mb-1 cursor-pointer transition"><?= htmlspecialchars($nama_produk) ?></h4>
                        <p class="<?= $is_habis ? 'text-gray-400' : 'text-purple-700' ?> font-bold text-lg mt-auto">Rp <?= $harga_format ?></p>
                        <p class="text-xs text-gray-500 mt-1">Sisa Stok: <?= htmlspecialchars($product['stok']) ?></p>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-2 gap-2">
                        <?php if($is_habis): ?>
                            <button disabled class="w-full border border-gray-200 text-gray-400 bg-gray-50 text-xs font-bold py-2.5 rounded-lg cursor-not-allowed flex items-center justify-center gap-1 text-center">
                                <i data-lucide="shopping-cart" class="w-3.5 h-3.5"></i> Kosong
                            </button>
                            <button disabled class="w-full bg-gray-300 text-gray-500 text-xs font-bold py-2.5 rounded-lg cursor-not-allowed flex items-center justify-center gap-1 shadow-sm text-center">
                                Beli Cepat
                            </button>
                        <?php else: ?>
                            <a href="keranjang_aksi.php?action=add&id=<?= htmlspecialchars($product['id']) ?>&redirect=katalog.php" class="w-full border border-purple-200 text-purple-700 hover:bg-purple-50 text-xs font-bold py-2.5 rounded-lg transition flex items-center justify-center gap-1 text-center">
                                <i data-lucide="shopping-cart" class="w-3.5 h-3.5"></i> Keranjang
                            </a>
                            <a href="keranjang_aksi.php?action=add&id=<?= htmlspecialchars($product['id']) ?>&redirect=profil_akun.php?tab=keranjang" class="w-full bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold py-2.5 rounded-lg transition flex items-center justify-center gap-1 shadow-md text-center">
                                Beli Cepat
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchInput');
    const productCards = document.querySelectorAll('.product-card');
    const productCount = document.getElementById('productCount');
    let currentFilter = 'all';

    function filterProducts() {
        let count = 0;
        const searchTerm = searchInput.value.toLowerCase();

        productCards.forEach(card => {
            const title = card.getAttribute('data-title') || '';
            const category = card.getAttribute('data-category') || '';
            const motor = card.getAttribute('data-motor') || '';
            
            const matchesFilter = currentFilter === 'all' || 
                                  motor.includes(currentFilter) || 
                                  category.includes(currentFilter);
                                  
            const matchesSearch = searchTerm === '' || 
                                  title.includes(searchTerm) || 
                                  category.includes(searchTerm) || 
                                  motor.includes(searchTerm);

            if (matchesFilter && matchesSearch) {
                card.style.display = 'flex';
                count++;
            } else {
                card.style.display = 'none';
            }
        });

        productCount.textContent = count;
    }

    filterBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            filterBtns.forEach(b => {
                b.classList.remove('active', 'bg-purple-600', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-600');
            });
            e.target.classList.remove('bg-gray-100', 'text-gray-600');
            e.target.classList.add('active', 'bg-purple-600', 'text-white');
            
            currentFilter = e.target.getAttribute('data-filter');
            filterProducts();
        });
    });

    if(searchInput) {
        searchInput.addEventListener('input', filterProducts);
    }
});
</script>

<?php
require_once 'includes/footer.php';
?>