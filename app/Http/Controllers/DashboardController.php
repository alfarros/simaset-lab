<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::count();
        $borrowedAssets = Asset::where('status', 'Dipinjam')->count();
        
        // UBAH INI: Hitung hanya yang statusnya 'Rusak'
        $brokenAssets = Asset::where('status', 'Rusak')->count(); 

        // TAMBAHKAN INI: Hitung yang statusnya 'Perbaikan'
        $inRepairAssets = Asset::where('status', 'Perbaikan')->count();

        // Kirim semua variabel ke view
        return view('dashboard', compact(
            'totalAssets', 
            'borrowedAssets', 
            'brokenAssets', 
            'inRepairAssets'
        ));
    }
}
