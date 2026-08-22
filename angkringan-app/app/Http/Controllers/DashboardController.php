<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokHarian;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Fitur Filter Tanggal atau ambil tanggal terbaru[cite: 2]
        $tanggalTerbaru = $request->input('filter_tanggal');
        if (!$tanggalTerbaru) {
            $tanggalTerbaru = StokHarian::max('tanggal') ?? date('Y-m-d');
        }

        // Ambil Data Stok Lengkap menggunakan Query Builder Join
        $dataSemuaStok = StokHarian::select('stok_harian.*', 'menu.nama_menu', 'menu.harga', 'kategori.nama_kategori')
            ->join('menu', 'stok_harian.id_menu', '=', 'menu.id_menu')
            ->join('kategori', 'menu.id_kategori', '=', 'kategori.id_kategori')
            ->where('stok_harian.tanggal', $tanggalTerbaru)
            ->orderBy('kategori.nama_kategori', 'ASC')
            ->orderBy('menu.nama_menu', 'ASC')
            ->get();

        // Variabel untuk perhitungan data[cite: 2]
        $stokPerKategori = [];
        $dataRestock = [];
        $totalAsetStok = 0; 
        $totalOmset = 0; 
        $batasRestock = 5; 

        foreach ($dataSemuaStok as $row) {
            // Data Chart per kategori[cite: 2]
            $kat = $row->nama_kategori;
            if (!isset($stokPerKategori[$kat])) {
                $stokPerKategori[$kat] = 0;
            }
            $stokPerKategori[$kat] += $row->sisa_stok;

            // Peringatan Restock[cite: 2]
            if ($row->sisa_stok <= $batasRestock) {
                $dataRestock[] = $row;
            }

            // Hitung Aset Sisa[cite: 2]
            $totalAsetStok += ($row->sisa_stok * $row->harga);

            // Hitung Omset Penjualan[cite: 2]
            $terjual = $row->stok_awal - $row->sisa_stok;
            if ($terjual > 0) {
                $totalOmset += ($terjual * $row->harga);
            }
        }

        // Kembalikan data ke View (Blade)
        return view('dashboard', compact(
            'tanggalTerbaru', 'dataSemuaStok', 'stokPerKategori', 
            'dataRestock', 'totalAsetStok', 'totalOmset', 'batasRestock'
        ));
    }
}