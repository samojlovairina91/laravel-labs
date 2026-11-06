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
        Gate::authorize('create-comment');

        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'author'     => 'required|string|max:100',
            'content'    => 'required|string|min:5',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_approved'] = false; // Комментарий ждет проверки

        Comment::create($validated);

        return redirect()
            ->route('articles.show', $validated['article_id'])
            ->with('success', 'Комментарий отправлен на модерацию! Он появится на сайте после проверки.');
    }

    // Список комментариев на модерации
    public function moderation()
    {
        // Доступ только у модератора (проверяем через роль)
        if (!auth()->user()->isModerator()) {
            abort(403, 'Доступ только для модераторов');
        }

        // Берем только те, что НЕ одобрены
        $comments = Comment::where('is_approved', false)->with('article', 'user')->latest()->get();

        return view('comments.moderation', compact('comments'));
    }

    // Одобрить комментарий
    public function approve(Comment $comment)
    {
        if (!auth()->user()->isModerator()) {
            abort(403);
        }
        
        $comment->update(['is_approved' => true]);

        return redirect()->route('comments.moderation')->with('success', 'Комментарий одобрен!');
    }

    // Отклонить (удалить) комментарий
    public function reject(Comment $comment)
    {
        if (!auth()->user()->isModerator()) {
            abort(403);
        }
        
        $comment->delete();

        return redirect()->route('comments.moderation')->with('success', 'Комментарий отклонен и удален!');
    }

    public function edit(Comment $comment)
    {
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