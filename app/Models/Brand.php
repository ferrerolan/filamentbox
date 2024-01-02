<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'url',
        'primary_hex',
        'is_visible',
        'description',
    ];

    public function bands(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
