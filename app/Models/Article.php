<?php

namespace App\Models;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    // Colonne autorisé en écriture

    use HasFactory;
    
    protected $fillable =
    [
        'title',
        'content',
        'published',
    ];
    protected $casts =
    [
        'published' => 'boolean',
    ];
}
