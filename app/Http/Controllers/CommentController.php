<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Проверка шлюза на создание
        Gate::authorize('create-comment');

        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'author'     => 'required|string|max:100',
            'content'    => 'required|string|min:5',
        ]);

        // Привязываем комментарий к текущему авторизованному пользователю
        $validated['user_id'] = auth()->id();

        Comment::create($validated);

        return redirect()
            ->route('articles.show', $validated['article_id'])
            ->with('success', 'Комментарий добавлен!');
    }

    public function edit(Comment $comment)
    {
        // Проверка шлюза на редактирование
        Gate::authorize('update-comment', $comment);

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update-comment', $comment);

        $validated = $request->validate([
            'author'  => 'required|string|max:100',
            'content' => 'required|string|min:5',
        ]);

        $comment->update($validated);

        return redirect()
            ->route('articles.show', $comment->article_id)
            ->with('success', 'Комментарий обновлён!');
    }

    public function destroy(Comment $comment)
    {
        Gate::authorize('delete-comment', $comment);

        $article_id = $comment->article_id;
        $comment->delete();

        return redirect()
            ->route('articles.show', $article_id)
            ->with('success', 'Комментарий удалён!');
    }
}