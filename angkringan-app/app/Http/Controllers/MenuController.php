<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Tarik data kategori dan menu untuk tabel[cite: 6]
        $kategoris = Kategori::orderBy('nama_kategori', 'ASC')->get();
        
        $menu = Menu::join('kategori', 'menu.id_kategori', '=', 'kategori.id_kategori')
            ->select('menu.*', 'kategori.nama_kategori')
            ->orderBy('kategori.nama_kategori', 'ASC')
            ->orderBy('menu.nama_menu', 'ASC')
            ->get();
            
        // Jika sedang dalam mode edit menu[cite: 6]
        $editMenu = null;
        if ($request->has('edit_menu')) {
            $editMenu = Menu::where('id_menu', $request->input('edit_menu'))->first();
        }

        return view('manajemen_menu', compact('kategoris', 'menu', 'editMenu'));
    }

    public function simpanKategori(Request $request)
    {
        // Tambah Kategori Baru[cite: 6]
        $request->validate(['nama_kategori' => 'required|string|max:50']);
        
        Kategori::insert([
            'nama_kategori' => $request->input('nama_kategori')
        ]);
        
        return redirect()->back();
    }

    public function hapusKategori($id)
    {
        // Hapus Kategori[cite: 6]
        Kategori::where('id_kategori', $id)->delete();
        return redirect()->back();
    }

    public function simpanMenu(Request $request)
    {
        // Simpan atau Edit Menu[cite: 6]
        $id_menu = $request->input('id_menu');
        
        $data = [
            'id_kategori'  => $request->input('id_kategori'),
            'nama_menu'    => $request->input('nama_menu'),
            'harga'        => $request->input('harga'),
            'ketersediaan' => $request->input('ketersediaan'),
        ];

        if (empty($id_menu)) {
            // Mode Tambah Baru[cite: 6]
            Menu::insert($data);
        } else {
            // Mode Edit[cite: 6]
            Menu::where('id_menu', $id_menu)->update($data);
        }

        return redirect()->route('manajemen.menu'); // Sesuaikan dengan penamaan nama route kamu
    }

    public function hapusMenu($id)
    {
        // Hapus Menu[cite: 6]
        Menu::where('id_menu', $id)->delete();
        return redirect()->back();
    }
}