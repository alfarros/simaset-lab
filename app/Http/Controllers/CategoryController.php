<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Enums\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
    // Ambil daftar kategori statis dari Enum
    $allCategories = AssetCategory::cases();

    // Ambil hitungan aset (seperti sebelumnya)
    $categoriesWithCount = Asset::select('kategori', DB::raw('count(*) as total_aset'))
                                ->groupBy('kategori')
                                ->pluck('total_aset', 'kategori'); // 'kategori' sebagai key

    return view('categories.index', compact('allCategories', 'categoriesWithCount'));
    }

    public function show($category)
    {
       // Ambil daftar aset utama dengan paginasi
        //    Kita ubah ke 12 agar pas di grid 3 atau 4 kolom
        $assets = Asset::where('kategori', $category)
                        ->orderByRaw("FIELD(status, 'Rusak', 'Perbaikan', 'Dipinjam', 'Tersedia')")
                        ->orderBy('nama_barang', 'asc')
                        ->paginate(12); // <-- Ganti ke 12

        // Ambil statistik HANYA untuk kategori ini
        $stats = [
            'total'     => Asset::where('kategori', $category)->count(),
            'tersedia'  => Asset::where('kategori', $category)->where('status', 'Tersedia')->count(),
            'dipinjam'  => Asset::where('kategori', $category)->where('status', 'Dipinjam')->count(),
            'rusak'     => Asset::where('kategori', $category)->where('status', 'Rusak')->count(),
            'perbaikan' => Asset::where('kategori', $category)->where('status', 'Perbaikan')->count(),
        ];

        $categoriesEnum = AssetCategory::cases();

        // Kirim semua data ke view
        return view('categories.show', compact('assets', 'category', 'stats', 'categoriesEnum'));
    }
}
