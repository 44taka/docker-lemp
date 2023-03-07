<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // 保存対象カラム
    protected $fillable = ['title','author_id'];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
