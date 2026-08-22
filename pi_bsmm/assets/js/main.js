document.addEventListener("DOMContentLoaded", () => {
    // Inisialisasi Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    const introOverlay = document.getElementById('intro-overlay');
    const introVideo = document.getElementById('intro-video');

    if (introOverlay) {
        if (sessionStorage.getItem('introSudahDiputar')) {
            introOverlay.style.display = 'none';
        } else {
            document.body.style.overflow = 'hidden';

            const tutupIntro = () => {
                introOverlay.classList.add('opacity-0');
                setTimeout(() => {
                    introOverlay.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }, 1000); 
                sessionStorage.setItem('introSudahDiputar', 'true');
            };

            if (introVideo) {
                // Tutup otomatis saat video selesai
                introVideo.addEventListener('ended', tutupIntro);
                introVideo.addEventListener('error', () => setTimeout(tutupIntro, 1000));
                
                // Tambahan: Izinkan user klik di mana saja pada layar untuk skip video
                introOverlay.addEventListener('click', tutupIntro);
                
                // Jaga-jaga jika video stuck, paksa tutup setelah 5 detik
                setTimeout(tutupIntro, 5000);
            } else {
                // Jika tag video tidak ditemukan, tutup otomatis setelah 4 detik
                setTimeout(tutupIntro, 4000);
            }
        }
    }

    const searchInput = document.getElementById('searchInput');
    const productCards = document.querySelectorAll('.product-card');
    const productCount = document.getElementById('productCount');
    const filterBtns = document.querySelectorAll('.filter-btn');

    if (searchInput && productCards.length > 0) {
        let currentSearchText = '';
        let currentFilterBtn = 'all';

        const filterProducts = () => {
            let visibleCount = 0;
            
            productCards.forEach(card => {
                const title = card.getAttribute('data-title');
                
                const matchText = title.includes(currentSearchText);
                const matchCategory = currentFilterBtn === 'all' || title.includes(currentFilterBtn);

                if (matchText && matchCategory) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if(productCount) {
                productCount.innerText = visibleCount;
            }
        };

        searchInput.addEventListener('input', (e) => {
            currentSearchText = e.target.value.toLowerCase();
            filterProducts();
        });

        filterBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                filterBtns.forEach(b => {
                    b.classList.remove('bg-purple-600', 'text-white', 'active');
                    b.classList.add('bg-gray-100', 'text-gray-600');
                });
                
                const clickedBtn = e.target;
                clickedBtn.classList.remove('bg-gray-100', 'text-gray-600');
                clickedBtn.classList.add('bg-purple-600', 'text-white', 'active');

                currentFilterBtn = clickedBtn.getAttribute('data-filter');
                filterProducts();
            });
        });
    }

    const heroCountdown = document.getElementById('hero-countdown');
    if (heroCountdown) {
        const updateHeroTimer = () => {
            let d = new Date();
            let hoursLeft = 23 - d.getHours();
            let minsLeft = 59 - d.getMinutes();
            heroCountdown.innerHTML = `${hoursLeft} Jam ${minsLeft} Menit`;
        };
        updateHeroTimer();
        setInterval(updateHeroTimer, 60000);
    }

    const fsHours = document.getElementById("fs-hours");
    if (fsHours) {
        let countDownDate = new Date().getTime() + (2 * 60 * 60 * 1000) + (15 * 60 * 1000);
        setInterval(() => {
            let now = new Date().getTime();
            let distance = countDownDate - now;

            if (distance < 0) {
                document.getElementById("fs-hours").innerHTML = "00";
                document.getElementById("fs-minutes").innerHTML = "00";
                document.getElementById("fs-seconds").innerHTML = "00";
                return;
            }

            document.getElementById("fs-hours").innerHTML = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
            document.getElementById("fs-minutes").innerHTML = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
            document.getElementById("fs-seconds").innerHTML = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');
        }, 1000);
    }

    const promoTimers = document.querySelectorAll('.promo-timer');
    if (promoTimers.length > 0) {
        setInterval(() => {
            const now = new Date().getTime();

            promoTimers.forEach(timer => {
                let endDateStr = timer.getAttribute('data-end').replace(' ', 'T');
                let countDownDate = new Date(endDateStr).getTime();
                let distance = countDownDate - now;

                if (distance < 0) {
                    timer.innerHTML = "Kedaluwarsa";
                } else {
                    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    timer.innerHTML = `${days}h ${hours}j ${minutes}m ${seconds}s`;
                }
            });
        }, 1000);
    }

    window.switchTab = function(tabId) {
        // 1. Kembalikan semua tombol menu sidebar ke gaya default (tidak aktif)
        document.querySelectorAll('.sidebar-menu').forEach(menu => {
            menu.classList.remove('border-purple-700', 'bg-purple-50', 'text-purple-700');
            menu.classList.add('border-transparent', 'text-gray-600');
        });

        // 2. Beri warna pada tombol menu sidebar yang sedang diklik
        const activeMenu = document.getElementById('menu-' + tabId);
        if(activeMenu) {
            activeMenu.classList.remove('border-transparent', 'text-gray-600');
            activeMenu.classList.add('border-purple-700', 'bg-purple-50', 'text-purple-700');
        }

        // 3. Sembunyikan semua konten tab
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });

        // 4. Tampilkan hanya konten tab yang dipilih
        const activeTab = document.getElementById('tab-' + tabId);
        if(activeTab) {
            activeTab.classList.add('active');
        }

        // 5. Ubah URL agar ketika direfresh tidak kembali ke tab awal
        window.history.pushState(null, '', '?tab=' + tabId);
    };

    window.copyCode = function(inputId, buttonElement) {
        const copyText = document.getElementById(inputId);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // Untuk perangkat mobile

        try {
            document.execCommand('copy');
            
            const originalHTML = buttonElement.innerHTML;
            buttonElement.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i> Disalin!';
            buttonElement.classList.add('copied');
            
            lucide.createIcons();

            setTimeout(() => {
                buttonElement.innerHTML = originalHTML;
                buttonElement.classList.remove('copied');
                lucide.createIcons();
            }, 2000);
        } catch (err) {
            console.error('Gagal menyalin teks', err);
        }
    }; // Akhir dari function copyCode yang sebelumnya error

}); // Kurung tutup yang benar untuk mengakhiri DOMContentLoaded