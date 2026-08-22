<?php
require_once 'includes/header.php';
?>

    <main class="flex-grow container mx-auto px-4 py-12 md:py-20 flex items-center justify-center">
        
        <div class="w-full max-w-5xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Hubungi Tim Kami</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Pilih divisi yang ingin Anda hubungi. Kami siap membantu segala kebutuhan Anda mulai dari urusan teknis website hingga informasi stok oli.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="w-32 h-32 rounded-full overflow-hidden mb-6 border-4 border-purple-100 group-hover:border-purple-300 transition duration-300">
                        <img src="assets/img/agp.jpeg" alt="Profil Developer" class="w-full h-full object-cover">
                    </div>
                    
                    <h3 class="text-3xl font-bold text-gray-800 mb-2">Angga</h3>
                    <span class="text-sm font-bold text-purple-700 bg-purple-50 border border-purple-200 px-4 py-1.5 rounded-full mb-6 shadow-sm">
                        Lead Web Developer & IT Support
                    </span>
                    
                    <p class="text-gray-600 mb-8 flex-grow leading-relaxed">
                        Menemukan error pada website? Ingin memberikan saran fitur baru? Atau ada penawaran kerja sama di bidang IT? Silakan hubungi saya untuk urusan teknis web Siska Maju Motor.
                    </p>
                    
                    <a href="https://www.instagram.com/agpivt?igsh=MW50NXJleHp6cjc1ZA==" target="_blank" rel="noopener noreferrer" class="w-full bg-gradient-to-r from-purple-600 to-purple-800 hover:from-purple-700 hover:to-purple-900 text-white font-bold py-4 rounded-2xl transition flex items-center justify-center gap-3 shadow-lg hover:shadow-xl text-lg">
                        <i data-lucide="instagram" class="w-6 h-6"></i> DM Instagram
                    </a>
                </div>

                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-10 flex flex-col items-center text-center hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="w-32 h-32 rounded-full overflow-hidden mb-6 border-4 border-yellow-100 group-hover:border-yellow-400 transition duration-300">
                        <img src="assets/img/siska.jpeg" alt="Profil Admin" class="w-full h-full object-cover">
                    </div>
                    
                    <h3 class="text-3xl font-bold text-gray-800 mb-2">Siska</h3>
                    <span class="text-sm font-bold text-yellow-700 bg-yellow-50 border border-yellow-200 px-4 py-1.5 rounded-full mb-6 shadow-sm">
                        Head Admin & Customer Service
                    </span>
                    
                    <p class="text-gray-600 mb-8 flex-grow leading-relaxed">
                        Punya pertanyaan seputar rekomendasi oli yang cocok untuk motormu? Ingin cek ketersediaan stok atau konfirmasi pengiriman barang? Jangan sungkan hubungi admin Siska!
                    </p>
                    
                    <a href="https://www.instagram.com/siska.njln_?igsh=MTBqcHJzamFycnlqeA==" target="_blank" rel="noopener noreferrer" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold py-4 rounded-2xl transition flex items-center justify-center gap-3 shadow-lg hover:shadow-xl text-lg">
                        <i data-lucide="instagram" class="w-6 h-6"></i> DM Instagram
                    </a>
                </div>

            </div>
        </div>

    </main>

<?php
require_once 'includes/footer.php';
?>