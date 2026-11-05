<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Показываем форму создания и список всех комментариев к статье
    // (Или просто редиректим на статью, если список там же)
    public function index()
    {
        $comments = Comment::with('article')->latest()->paginate(10);
        return view('comments.index', compact('comments'));
    }

    // Форма создания комментария (мы будем использовать её на странице статьи)
    public function create(Request $request)
    {
        $article_id = $request->query('article_id');
        $article = Article::findOrFail($article_id);
        return view('comments.create', compact('article'));
    }

    // Сохранение комментария
    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'author'     => 'required|string|max:100',
            'content'    => 'required|string|min:5',
        ]);

        Comment::create($validated);

        // Возвращаемся на страницу статьи, к которой оставили комментарий
        return redirect()
            ->route('articles.show', $validated['article_id'])
            ->with('success', 'Комментарий добавлен!');
    }

    public function show(Comment $comment)
    {
        return view('comments.show', compact('comment'));
    }

    public function edit(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
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
        $article_id = $comment->article_id;
        $comment->delete();

        return redirect()
            ->route('articles.show', $article_id)
            ->with('success', 'Комментарий удалён!');
    }
}