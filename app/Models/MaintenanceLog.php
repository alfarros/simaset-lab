<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{

    protected $fillable = [
    'asset_id',
    'reported_by',
    'issue_description',
    'status',
    'resolution_notes',
    'resolved_at'
];

public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

}
