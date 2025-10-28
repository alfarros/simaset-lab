<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Enums\AssetCategory;
use Illuminate\Validation\Rule;
use App\Models\Asset;
use App\Models\User;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Mulai query
    $query = Asset::query();

    // 2. === PENCARIAN ===
    if ($request->filled('search')) {
        $search = $request->search;
        // Jika search mengandung spasi (misal: "ruang komputer"), baru cari di lokasi
    if (str_contains(strtolower($search), 'ruang')) {
        $query->where(function ($q) use ($search) {
            $q->where('nama_barang', 'LIKE', "%{$search}%")
              ->orWhere('lokasi', 'LIKE', "%{$search}%");
        });
    } else {
        // Kalau cuma "komputer", cari di nama_barang & kode saja
        $query->where(function ($q) use ($search) {
            $q->where('nama_barang', 'LIKE', "%{$search}%")
              ->orWhere('kode_aset', 'LIKE', "%{$search}%");
        });
    }
    }

    // 3. === SORTING ===
    $validSortColumns = ['nama_barang', 'kode_aset', 'kategori', 'lokasi', 'status', 'created_at'];
    $sortBy = $request->query('sort_by', 'nama_barang');
    $order = $request->query('order', 'asc');

    if (!in_array($sortBy, $validSortColumns)) {
        $sortBy = 'created_at';
    }
    if (!in_array(strtolower($order), ['asc', 'desc'])) {
        $order = 'desc';
    }

    // 4. Terapkan sort dan pagination
    $assets = $query->orderBy($sortBy, $order)
                    ->paginate(10)
                    ->appends($request->query()); // Pertahankan semua parameter (search, sort, dll)

    // 5. Data tambahan
    $categoriesEnum = AssetCategory::cases();

    // 6. Kirim ke view
    return view('assets.index', compact('assets', 'sortBy', 'order', 'categoriesEnum'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil data kategori & lokasi yang unik dari tabel assets
        $categories = Asset::select('kategori')->distinct()->pluck('kategori');
        $locations = Asset::select('lokasi')->distinct()->pluck('lokasi');

    // Kirim data tersebut ke view menggunakan compact()
        return view('assets.modals.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
    $validator = Validator::make($request->all(), [
        'nama_barang' => 'required|string|max:255',
        'kode_aset'   => 'required|string|unique:assets|max:50',
        'kategori'    => ['required', Rule::in(AssetCategory::values())],
        'lokasi'      => 'required|string|max:100',
        'status'      => 'required|in:Tersedia,Dipinjam,Perbaikan,Rusak',
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Jika validasi berhasil, buat aset
    Asset::create($validator->validated());

    // Kembalikan respons JSON sukses
    return response()->json(['message' => 'Aset berhasil ditambahkan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        $asset->load('maintenanceLogs');
        $users = User::all();
        return view('assets.show', compact('asset', 'users'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $categoriesEnum = AssetCategory::cases();
        return view('assets.modals.edit', compact('asset', 'categoriesEnum'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Asset $asset)
    {
       // Validasi data
    $validator = Validator::make($request->all(), [
        'nama_barang' => 'required|string|max:255',
        'kode_aset'   => 'required|string|max:50|unique:assets,kode_aset,'.$asset->id,
        'kategori'    => ['required', Rule::in(AssetCategory::values())],
        'lokasi'      => 'required|string|max:100',
        'status'      => 'required|in:Tersedia,Dipinjam,Perbaikan,Rusak',
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Update data aset
    $asset->update($validator->validated());

    // Kembalikan respons JSON sukses
    return response()->json(['message' => 'Aset berhasil diperbarui.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
    $asset->delete();

    // Kembalikan respons JSON sukses
    return response()->json(['message' => 'Aset berhasil dihapus.']);
    }

    public function updateStatus(Request $request, Asset $asset)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Tersedia,Dipinjam,Perbaikan,Rusak',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Pastikan 'status' ada di $fillable model Asset Anda
        $asset->update($validator->validated());

        return response()->json([
            'message' => 'Status berhasil diperbarui.'
        ]);
    }

    public function updateDescription(Request $request, Asset $asset)
    {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'nullable|string|max:1000', // Validasi hanya deskripsi
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Pastikan 'deskripsi' ada di $fillable model Asset Anda
        $asset->update($validator->validated());

        return response()->json([
            'message' => 'Deskripsi berhasil diperbarui.'
        ]);
    }
    
    
}
