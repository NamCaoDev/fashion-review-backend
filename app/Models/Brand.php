<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Brand extends Model
{
    //
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'established_at',
        'founder',
        'addresses',
        'logo',
        'social_links'
    ];

    protected function casts(): array
    {
        return [
            'addresses' => 'array',
            'social_links' => 'array',
        ];
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
