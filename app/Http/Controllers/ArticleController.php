<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticleCreated;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderByDesc('published_at')->paginate(5);
        return view('articles.index', ['articles' => $articles]);
    }

    public function create()
    {
        Gate::authorize('create', Article::class);
        return view('articles.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Article::class);
        
        $validated = $request->validate([
            'title'             => 'required|string|min:3|max:255',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'required|string|min:10',
            'preview_image'     => 'nullable|string|max:255',
            'full_image'        => 'nullable|string|max:255',
            'published_at'      => 'required|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        
        // 1. Сохраняем статью в базу
        $article = Article::create($validated);

        // 2. Ищем модератора (первого попавшегося)
        $moderator = User::whereHas('role', function ($query) {
            $query->where('name', 'moderator');
        })->first();

        // 3. Если модератор найден — отправляем ему письмо
        if ($moderator) {
            Mail::to($moderator->email)->send(new ArticleCreated($article));
        }

        return redirect()->route('articles.index')->with('success', 'Новость успешно создана, модератору отправлено письмо!');
    }

    public function show(string $id)
    {
        $article = Article::findOrFail($id);
        return view('articles.show', ['article' => $article]);
    }

    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        Gate::authorize('update', $article);
        return view('articles.edit', ['article' => $article]);
    }

    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);
        Gate::authorize('update', $article);

        $validated = $request->validate([
            'title'             => 'required|string|min:3|max:255',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'required|string|min:10',
            'preview_image'     => 'nullable|string|max:255',
            'full_image'        => 'nullable|string|max:255',
            'published_at'      => 'required|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . $article->id;
        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Новость успешно обновлена');
    }

    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        Gate::authorize('delete', $article);
        
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Новость удалена');
    }
}