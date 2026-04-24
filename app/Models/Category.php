<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'title',
        'content',
        'is_public',
        'category_id',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    // Relación: una nota pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación: muchos a muchos con usuarios (con pivote)
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role')
            ->withTimestamps();
    }
}
