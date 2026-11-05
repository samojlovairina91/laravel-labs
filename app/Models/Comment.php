<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Какие поля можно заполнять
    protected $fillable = [
        'article_id',
        'author',
        'content',
    ];

    // У одного комментария есть только одна статья
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}