<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'latitude',
        'longitude',
        'min_level',
    ];

    public function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'min_level' => 'integer',
        ];
    }
}
