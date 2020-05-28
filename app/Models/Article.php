<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = ['title', 'short_description', 'description', 'image', 'meta_title', 'meta_description'];
}
