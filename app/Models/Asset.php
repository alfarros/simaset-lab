<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kode_aset',
        'kategori',
        'lokasi',
        'status',
        'deskripsi',
    ];

     public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }

}
