<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'cover_image',
        'revision_number',
        'published_date',
        'publisher',
        'author',
        'genre',
        'synopsis',
        'added_date'
    ];
}
