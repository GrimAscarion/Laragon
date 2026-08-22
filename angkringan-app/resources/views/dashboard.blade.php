@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
<style>
    .top-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; gap: 30px; }
    .info-text { flex: 1; }
    .info-text h1 { font-size: 24px; font-weight: 600; margin: 0 0 10px 0; color: #4a4a4a; }
    .highlight-data { font-size: 16px; padding: 10px 15px; border-radius: 8px; display: inline-block; margin-top: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);}
    .aset-box { background: #eaddf3; color: #5a3b75; }
    .omset-box { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .filter-form { display: flex; gap: 10px; align-items: center; margin: 15px 0; background: #fff; padding: 10px 15px; border-radius: 10px; display: inline-flex; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .filter-form input { padding: 8px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit; }
    .filter-form button { padding: 8px 15px; background: #a280c4; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 500; transition: 0.3s; }
    .filter-form button:hover { background: #8e6eb0; }
    .chart-container { flex: 0 0 250px; height: 250px; position: relative; }
    .bottom-section { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .search-bar { width: 100%; padding: 12px 20px; border-radius: 25px; border: 1px solid #ddd; background-color: #e8eaed; margin-bottom: 25px; font-family: inherit; box-sizing: border-box; }
    .stock-list { display: flex; flex-direction: column; gap: 15px; max-height: 500px; overflow-y: auto; padding-right: 5px; }
    .stock-item { background-color: #fff; padding: 15px 20px; border-radius: 15px; font-weight: 500; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: transform 0.2s; }
    .stock-item:hover { transform: translateX(5px); }
    .stock-item .category-tag { font-size: 12px; color: #777; font-weight: 400; }
    .stock-count { background: #f4f6f9; padding: 5px 15px; border-radius: 15px; font-weight: 600; color: #5a3b75; border: 1px solid #eee;}
    .placeholder-box { background-color: #fff; border-radius: 25px; padding: 30px; display: flex; flex-direction: column; min-height: 300px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .placeholder-box h2 { margin-top: 0; color: #d9534f; font-size: 20px; display: flex; align-items: center; gap: 10px; }
    .restock-list { list-style-type: none; padding: 0; margin: 0; width: 100%; }
    .restock-list li { padding: 12px 0; border-bottom: 1px solid #f1f1f1; font-size: 16px; display: flex; justify-content: space-between; }
    .sisa-merah { color: #d9534f; font-weight: bold; background: #fdf2f2; padding: 2px 8px; border-radius: 5px; }
</style>
@endpush

@section('content')
<section class="top-section">
    <div class="info-text">
        <h1>Laporan Penjualan & Stok</h1>
        
        <form method="GET" action="{{ route('dashboard') }}" class="filter-form">
            <label for="filter_tanggal">Pilih Tanggal:</label>
            <input type="date" id="filter_tanggal" name="filter_tanggal" value="{{ $tanggalTerbaru }}">
            <button type="submit">Filter Data</button>
        </form>

        <p>Menampilkan data untuk tanggal: <strong>{{ \Carbon\Carbon::parse($tanggalTerbaru)->locale('id')->translatedFormat('l, d F Y') }}</strong></p>
        
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <div class="highlight-data aset-box">
                Estimasi Aset Sisa Stok: <br><strong>Rp {{ number_format($totalAsetStok, 0, ',', '.') }}</strong>
            </div>
            <div class="highlight-data omset-box">
                Total Omset Penjualan: <br><strong>Rp {{ number_format($totalOmset, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>
    
    <div class="chart-container">
        <canvas id="stockPieChart"></canvas>
    </div>
</section>

<section class="bottom-section">
    <div class="left-column">
        <input type="text" class="search-bar" placeholder="Pencarian data stok/produk...">
        <div class="stock-list">
            @forelse ($dataSemuaStok as $item)
                <div class="stock-item">
                    <div>
                        {{ $item->nama_menu }}<br>
                        <span class="category-tag">{{ $item->nama_kategori }} | Laku: {{ $item->stok_awal - $item->sisa_stok }} pcs</span>
                    </div>
                    <div class="stock-count">Sisa: {{ $item->sisa_stok }}</div>
                </div>
            @empty
                <p style="text-align:center; color:#888; margin-top:20px;">Tidak ada data stok untuk tanggal ini.</p>
            @endforelse
        </div>
    </div>

    <div class="right-column">
        <div class="placeholder-box">
            <h2>⚠️ Peringatan Restock (Sisa <= {{ $batasRestock }})</h2>
            @if (count($dataRestock) > 0)
                <ul class="restock-list">
                    @foreach ($dataRestock as $alertItem)
                        <li>
                            {{ $alertItem->nama_menu }}
                            <span class="sisa-merah">Sisa: {{ $alertItem->sisa_stok }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p style="text-align:center; margin-top: 50px;">Aman! Stok semua item masih mencukupi.</p>
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Konversi array PHP (dari DashboardController) menjadi variabel JavaScript
    const chartLabels = @json(array_keys($stokPerKategori));
    const chartData = @json(array_values($stokPerKategori));
    const ctx = document.getElementById('stockPieChart').getContext('2d');
    const calmColors = ['#a280c4', '#f0d97f', '#81c784', '#64b5f6', '#ff8a65', '#ba68c8'];
    
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: chartLabels,
            datasets: [{ data: chartData, backgroundColor: calmColors, borderColor: '#ffffff', borderWidth: 2 }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15, font: { size: 11 } } },
                title: { display: true, text: 'Komposisi Sisa Stok per Kategori', font: { size: 14, weight: 'normal' }, color: '#666', padding: { bottom: 20 } }
            }
        }
    });
</script>
@endpush