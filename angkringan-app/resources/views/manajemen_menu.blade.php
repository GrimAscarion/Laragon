@extends('layouts.app')
@section('title', 'Manajemen Menu')

@push('styles')
<style>
    .flex-container { display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start; }
    .col-kategori { flex: 1; min-width: 300px; }
    .col-menu { flex: 2; min-width: 500px; }
    h3 { color: #5a3b75; margin-top: 0; border-bottom: 2px solid #f4f6f9; padding-bottom: 10px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-weight: 500; margin-bottom: 5px; font-size: 14px; }
    .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit; box-sizing: border-box; }
    .btn { padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-family: inherit; }
    .btn-primary { background: #a280c4; color: white; }
    .btn-primary:hover { background: #8e6eb0; }
    .btn-danger { background: #d9534f; color: white; padding: 5px 10px; font-size: 12px; text-decoration: none; border-radius: 5px; }
    .btn-warning { background: #f0ad4e; color: white; padding: 5px 10px; font-size: 12px; text-decoration: none; border-radius: 5px; }
    .status-tersedia { color: green; }
    .status-habis { color: red; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
    th, td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
    th { background-color: #f8f9fa; }
</style>
@endpush

@section('content')
<div class="flex-container">
    <div class="card col-kategori">
        <h3>Manajemen Kategori</h3>
        <form method="POST" action="{{ route('kategori.simpan') }}">
            @csrf
            <div class="form-group">
                <label>Nama Kategori Baru</label>
                <input type="text" name="nama_kategori" required placeholder="Contoh: Gorengan">
            </div>
            <button type="submit" class="btn btn-primary">Tambah Kategori</button>
        </form>

        <table>
            <tr><th>Nama Kategori</th><th>Aksi</th></tr>
            @foreach ($kategoris as $k)
            <tr>
                <td>{{ $k->nama_kategori }}</td>
                <td>
                    <a href="{{ route('kategori.hapus', $k->id_kategori) }}" class="btn-danger" onclick="return confirm('Yakin hapus? Menu di dalamnya juga akan terhapus!');">Hapus</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="card col-menu">
        <h3>{{ $editMenu ? 'Edit Menu' : 'Tambah Menu Baru' }}</h3>
        <form method="POST" action="{{ route('menu.simpan') }}">
            @csrf
            <input type="hidden" name="id_menu" value="{{ $editMenu ? $editMenu->id_menu : '' }}">
            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex:1;">
                    <label>Pilih Kategori</label>
                    <select name="id_kategori" required>
                        <option value="">-- Pilih --</option>
                        @foreach ($kategoris as $k)
                            <option value="{{ $k->id_kategori }}" {{ ($editMenu && $editMenu->id_kategori == $k->id_kategori) ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="flex:2;">
                    <label>Nama Menu</label>
                    <input type="text" name="nama_menu" required value="{{ $editMenu ? $editMenu->nama_menu : '' }}">
                </div>
            </div>
            
            <div style="display: flex; gap: 15px;">
                <div class="form-group" style="flex:1;">
                    <label>Harga (Rp)</label>
                    <input type="number" name="harga" required value="{{ $editMenu ? $editMenu->harga : '' }}">
                </div>
                <div class="form-group" style="flex:1;">
                    <label>Ketersediaan</label>
                    <select name="ketersediaan">
                        <option value="Tersedia" {{ ($editMenu && $editMenu->ketersediaan == 'Tersedia') ? 'selected' : '' }}>Tersedia</option>
                        <option value="Habis" {{ ($editMenu && $editMenu->ketersediaan == 'Habis') ? 'selected' : '' }}>Habis</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                {{ $editMenu ? 'Simpan Perubahan' : 'Tambahkan Menu' }}
            </button>
            @if ($editMenu)
                <a href="{{ route('manajemen.menu') }}" class="btn" style="background:#eee; text-decoration:none; color:#333; margin-left:10px;">Batal Edit</a>
            @endif
        </form>

        <table style="margin-top:30px;">
            <tr>
                <th>Kategori</th>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            @foreach ($menu as $m)
            <tr>
                <td>{{ $m->nama_kategori }}</td>
                <td>{{ $m->nama_menu }}</td>
                <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                <td>
                    <span class="{{ $m->ketersediaan == 'Tersedia' ? 'status-tersedia' : 'status-habis' }}">
                        {{ $m->ketersediaan }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('manajemen.menu', ['edit_menu' => $m->id_menu]) }}" class="btn-warning">Edit</a>
                    <a href="{{ route('menu.hapus', $m->id_menu) }}" class="btn-danger" onclick="return confirm('Hapus menu ini?');">Hapus</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection