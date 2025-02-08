<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    use HasUuids, HasFactory;
    protected $fillable = [
        'name',
        'description',
        'images',
        'origin_price',
        'current_price',
        'materials',
        'price_symbol',
        'product_type',
        'in_stock',
        'buy_links',
        'brand_id'
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'buy_links' => 'array',
            'materials' => 'array'
        ];
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function scopeFindProductByName($query, $name) {
        return $query->whereLike('name', "$name%");
    }

    public function scopeFindProductByType($query, $type) {
        return $query->whereIn('type', $type);
    }

    public function scopeFindProductByBrandId($query, $brand_id) {
        return $query->where('brand_id', $brand_id);
    }

}
