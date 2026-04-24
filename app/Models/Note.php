<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    // Relación: una categoría tiene muchas notas
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
