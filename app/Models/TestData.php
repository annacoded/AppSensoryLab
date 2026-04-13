<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestData extends Model
{
    protected $table = 'test_data';

    protected $fillable = [
        'batch_id',
        'parameter_name',
        'value',
        'measurement_unit',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
}