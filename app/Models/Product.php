<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category',
        'title',
        'description',
        'price',
        'photo',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the category options.
     */
    public static function getCategoryOptions(): array
    {
        return [
            'makanan' => 'Makanan',
            'minuman' => 'Minuman',
        ];
    }
}
