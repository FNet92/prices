<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $guid
 * @property string $name
 */

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'product_guid', 'guid');
    }
}
