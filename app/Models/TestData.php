<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestData extends Model
{
    protected $fillable = [
        'batch_id',
        'parameter_name',
        'value',
    ];

    protected $casts = [
        'value' => 'float',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
}
