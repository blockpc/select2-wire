<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_id',
    ];

    public function brand() : BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function colors() : BelongsToMany
    {
        return $this->belongsToMany(Color::class);
    }
}
