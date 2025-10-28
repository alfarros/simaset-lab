<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\MaintenanceLog;

class MaintenanceController extends Controller
{
    public function create(Asset $asset)
{
    return view('maintenance.create', compact('asset'));
}

public function store(Request $request, Asset $asset)
{
    $request->validate([
        'issue_description' => 'required|string|max:500',
    ]);

    $log = $asset->maintenanceLogs()->create([
        'reported_by' => auth()->user()->name,
        'issue_description' => $request->issue_description,
        'status' => 'Menunggu'
    ]);

    // Update status aset jadi "Rusak"
    $asset->update(['status' => 'Rusak']);

    // ✅ Cek apakah ini request AJAX
   if ($request->expectsJson()) {
    return response()->json(['message' => 'Laporan kerusakan berhasil dibuat!']);
    }
    return redirect()->route('assets.show', $asset)->with('success', 'Laporan kerusakan berhasil dibuat!');
}

public function complete(MaintenanceLog $log)
{

    // Pastikan log dalam status yang benar
    if ($log->status !== 'Sedang Dikerjakan') {
        return back()->with('error', 'Laporan ini tidak bisa ditandai selesai.');
    }

    $log->update([
        'status' => 'Selesai',
        'resolved_at' => now(),
        'resolution_notes' => request('resolution_notes', '-')
    ]);

    // Kembalikan status aset ke Tersedia
    $log->asset->update(['status' => 'Tersedia']);

    if (request()->expectsJson()) {
        return response()->json(['message' => 'Perbaikan ditandai sebagai selesai.']);
    }

    return back()->with('success', 'Perbaikan ditandai sebagai selesai.');
}

public function start(MaintenanceLog $log)
{
    // Pastikan status log adalah "Menunggu"
    if ($log->status !== 'Menunggu') {
        return back()->with('error', 'Laporan ini sudah diproses.');
    }

    $log->update(['status' => 'Sedang Dikerjakan']);
    $log->asset->update(['status' => 'Perbaikan']);

    if (request()->expectsJson()) {
        return response()->json(['message' => 'Perbaikan dimulai.']);
    }

    return back()->with('success', 'Perbaikan dimulai.');
}

}
