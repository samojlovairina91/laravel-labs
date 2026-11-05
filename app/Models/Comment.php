<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id', // Теперь мы можем сохранять ID автора
        'author',  // Оставим на случай, если пишет гость, или для старых записей
        'content',
    ];

    // Связь со статьей
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // Связь с автором (пользователем)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}