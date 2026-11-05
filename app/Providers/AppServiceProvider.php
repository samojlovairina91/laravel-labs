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
        // Шлюз: модератор может всё с комментариями
        Gate::before(function (User $user) {
            if ($user->isModerator()) {
                return true;
            }
        });

        // Читатель может создавать комментарии
        Gate::define('create-comment', function (User $user) {
            return true;
        });

        // Редактировать/удалять комментарии может только модератор
        Gate::define('update-comment', function (User $user, Comment $comment) {
            return false;
        });

        Gate::define('delete-comment', function (User $user, Comment $comment) {
            return false;
        });
    }
}