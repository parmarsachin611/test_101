<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'thumbnail'];

    // Accessor for thumbnail column
    public function getThumbnailAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}

