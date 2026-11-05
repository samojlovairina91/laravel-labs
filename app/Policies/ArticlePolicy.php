<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    // Если модератор — разрешаем ВСЁ (хук before)
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isModerator()) {
            return true;
        }
        return null;
    }

    // Читатель может смотреть
    public function viewAny(User $user): bool { return true; }
    public function view(User $user, Article $article): bool { return true; }

    // Только модератор (до сюда дойдет только если before вернул null)
    public function create(User $user): bool { return false; }
    public function update(User $user, Article $article): bool { return false; }
    public function delete(User $user, Article $article): bool { return false; }
}