<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Comment;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Модератор может делать с комментариями ВСЁ
        Gate::before(function (User $user) {
            if ($user->isModerator()) {
                return true;
            }
        });

        // Читатель может оставлять комментарии
        Gate::define('create-comment', function (User $user) {
            return true;
        });

        // Редактировать комментарий может только его автор (модератора пропустит before)
        Gate::define('update-comment', function (User $user, Comment $comment) {
            return $user->id === $comment->user_id;
        });

        // Удалять комментарий может только его автор (модератора пропустит before)
        Gate::define('delete-comment', function (User $user, Comment $comment) {
            return $user->id === $comment->user_id;
        });
    }
}