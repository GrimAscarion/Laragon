@extends('layouts.app')
@section('title', 'Input Stok')

@push('styles')
<style>
    .alert-success { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: 500; }
    input[type="date"] { padding: 10px 15px; border: 1px solid #ddd; border-radius: 10px; font-family: inherit; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
    th { background-color: #f8f9fa; color: #555; }
    .kategori-row td { background-color: #eaddf3; font-weight: 600; color: #5a3b75; text-align: center; }
    input[type="number"] { width: 80px; padding: 8px; border: 1px solid #ccc; border-radius: 8px; text-align: center; }
    .btn-submit { background: #a280c4; color: white; border: none; padding: 12px 30px; font-size: 16px; border-radius: 25px; cursor: pointer; margin-top: 30px; width: 100%; font-weight: 600; transition: 0.3s; }
    .btn-submit:hover { background: #8e6eb0; box-shadow: 0 4px 10px rgba(162, 128, 196, 0.4); }
</style>
@endpush

@section('content')
<div class="card" style="max-width: 900px; margin: 0 auto;">
    <h2 style="color: #5a3b75; margin-top: 0;">Input Stok Harian</h2>
    <p style="color: #666; margin-bottom: 30px;">Masukkan jumlah barang yang dibawa (Stok Awal) dan sisanya saat warung tutup (Sisa Stok).</p>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('stok.simpan') }}">
        @csrf
        <div class="form-group">
            <label for="tanggal">Tanggal Jualan:</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th style="text-align: center;">Stok Awal (Bawa)</th>
                    <th style="text-align: center;">Sisa Stok (Sisa)</th>
                </tr>
            </thead>
            <tbody>
                @php $current_kategori = ""; @endphp
                
                @forelse ($menu as $menu)
                    @if ($current_kategori != $menu->nama_kategori)
                        @php $current_kategori = $menu->nama_kategori; @endphp
                        <tr class='kategori-row'>
                            <td colspan='3'>Kategori: {{ $current_kategori }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>{{ $menu->nama_menu }}</td>
                        <td style="text-align: center;">
                            <input type="number" name="stok_awal[{{ $menu->id_menu }}]" min="0" placeholder="0">
                        </td>
                        <td style="text-align: center;">
                            <input type="number" name="sisa_stok[{{ $menu->id_menu }}]" min="0" placeholder="0">
                        </td>
                    </tr>
                @empty
                    <tr><td colspan='3'>Tidak ada menu tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>

        <button type="submit" class="btn-submit">💾 Simpan Data Stok</button>
    </form>
</div>
@endsection