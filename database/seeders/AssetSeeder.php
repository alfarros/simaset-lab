<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asset; // <-- 1. Import model Asset
use App\Enums\AssetCategory; // <-- 2. Import Enum Kategori

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data aset yang akan dimasukkan
        $assets = [
            // Komputer
            [
                'nama_barang' => 'Komputer 1',
                'kode_aset' => 'K-01',
                'kategori' => AssetCategory::HARDWARE->value, // Ambil nilai dari Enum
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => 'AIO PC Spek Standar Lab',
            ],
            [
                'nama_barang' => 'Komputer 2',
                'kode_aset' => 'K-02',
                'kategori' => AssetCategory::HARDWARE->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => 'AIO PC Spek Standar Lab',
            ],
            [
                'nama_barang' => 'Komputer 3',
                'kode_aset' => 'K-03',
                'kategori' => AssetCategory::HARDWARE->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => 'AIO PC Spek Standar Lab',
            ],
            // Meja
            [
                'nama_barang' => 'Meja Komputer 1',
                'kode_aset' => 'M-01',
                'kategori' => AssetCategory::FURNITUR->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
            [
                'nama_barang' => 'Meja Komputer 2',
                'kode_aset' => 'M-02',
                'kategori' => AssetCategory::FURNITUR->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
            [
                'nama_barang' => 'Meja Komputer 3',
                'kode_aset' => 'M-03',
                'kategori' => AssetCategory::FURNITUR->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
             // Kursi
             [
                'nama_barang' => 'Kursi Lab 1',
                'kode_aset' => 'KS-01',
                'kategori' => AssetCategory::FURNITUR->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
            [
                'nama_barang' => 'Kursi Lab 2',
                'kode_aset' => 'KS-02',
                'kategori' => AssetCategory::FURNITUR->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
            [
                'nama_barang' => 'Kursi Lab 3',
                'kode_aset' => 'KS-03',
                'kategori' => AssetCategory::FURNITUR->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
             // Mouse
             [
                'nama_barang' => 'Mouse USB 1',
                'kode_aset' => 'MS-01',
                'kategori' => AssetCategory::PENDUKUNG->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
            [
                'nama_barang' => 'Mouse USB 2',
                'kode_aset' => 'MS-02',
                'kategori' => AssetCategory::PENDUKUNG->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
            [
                'nama_barang' => 'Mouse USB 3',
                'kode_aset' => 'MS-03',
                'kategori' => AssetCategory::PENDUKUNG->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
             // Keyboard
             [
                'nama_barang' => 'Keyboard USB 1',
                'kode_aset' => 'KB-01',
                'kategori' => AssetCategory::PENDUKUNG->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
            [
                'nama_barang' => 'Keyboard USB 2',
                'kode_aset' => 'KB-02',
                'kategori' => AssetCategory::PENDUKUNG->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
            [
                'nama_barang' => 'Keyboard USB 3',
                'kode_aset' => 'KB-03',
                'kategori' => AssetCategory::PENDUKUNG->value,
                'lokasi' => 'Ruangan Komputer A1',
                'status' => 'Tersedia',
                'deskripsi' => null,
            ],
        ];

        // Masukkan data ke database menggunakan model Asset
        foreach ($assets as $assetData) {
            Asset::create($assetData);
        }

        // Atau cara alternatif (jika tidak pakai model):
        // DB::table('assets')->insert($assets); 
        // Jangan lupa use Illuminate\Support\Facades\DB;
    }
}