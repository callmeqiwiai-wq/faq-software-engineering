<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'order'
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class)->orderBy('order');
    }

    public function test()
    {
        return $this->hasOne(Test::class);
    }
}