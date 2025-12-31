<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods'; // ✅ Make sure it matches your migration

    protected $fillable = [
        'name', 'category', 'slug', 'image', 'short_description', 'full_description', 'amount'
    ];

    public function cat()
    {
        return $this->hasOne(Category::class, 'id', 'category');
    }
}
