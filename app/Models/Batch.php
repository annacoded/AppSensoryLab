<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{
    protected $fillable = [
        'product_name',
        'batch_number',
        'production_date',
        'status',
    ];

    protected $casts = [
        'production_date' => 'date',
        'status' => 'string',
    ];

    public function testData(): HasMany
    {
        return $this->hasMany(TestData::class);
    }
}
