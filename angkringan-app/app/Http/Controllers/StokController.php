<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokHarian;
use App\Models\Menu;

class StokController extends Controller
{
    public function index()
    {
        $menu = Menu::join('kategori', 'menu.id_kategori', '=', 'kategori.id_kategori')
            ->select('menu.id_menu', 'menu.nama_menu', 'kategori.nama_kategori')
            ->where('menu.ketersediaan', 'Tersedia')
            ->orderBy('kategori.id_kategori', 'ASC')
            ->orderBy('menu.nama_menu', 'ASC')
            ->get();

        return view('input_stok', compact('menu'));
    }

    public function simpan(Request $request)
    {
        $tanggal = $request->input('tanggal');
        
        // Looping semua data yang diinput dari form[cite: 3]
        if ($request->has('stok_awal')) {
            foreach ($request->input('stok_awal') as $id_menu => $stok_awal) {
                $sisa_stok = $request->input('sisa_stok')[$id_menu] ?? 0;
                
                // Hanya simpan jika stok_awal atau sisa_stok diisi lebih dari 0[cite: 3]
                if ($stok_awal > 0 || $sisa_stok > 0) {
                    
                    // updateOrCreate akan otomatis melakukan Insert atau Update[cite: 3]
                    StokHarian::updateOrCreate(
                        ['tanggal' => $tanggal, 'id_menu' => $id_menu], // Kondisi pencarian
                        ['stok_awal' => $stok_awal, 'sisa_stok' => $sisa_stok] // Data yang diupdate/disimpan
                    );
                }
            }
        }

        // Redirect kembali dengan pesan sukses (menggunakan session flash Laravel)
        return redirect()->back()->with('success', 'Data stok untuk tanggal ' . date('d-m-Y', strtotime($tanggal)) . ' berhasil disimpan!');
    }
}