<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{
    protected $fillable = [
        'product_name',
        'product_code',
        'batch_number',
        'date_created',
    ];

    protected $casts = [
        'date_created' => 'date',
    ];

    public function testData(): HasMany
    {
        return $this->hasMany(TestData::class);
    }
}
