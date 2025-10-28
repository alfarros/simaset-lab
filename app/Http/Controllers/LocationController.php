<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        // Ambil semua kategori unik dari tabel assets
        $locations = Asset::select('lokasi')->distinct()->get();
        return view('locations.index', compact('lokasi'));
    }

    public function show($category)
    {
        // Ambil semua aset yang memiliki kategori yang sama
        $assets = Asset::where('lokasi', $locations)->latest()->paginate(10);
        return view('locations.show', compact('assets', 'category'));
    }
}
