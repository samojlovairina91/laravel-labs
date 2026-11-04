<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Список новостей с пагинацией
     */
    public function index()
    {
        $articles = Article::orderByDesc('published_at')->paginate(5);

        return view('articles.index', ['articles' => $articles]);
    }

    /**
     * Форма создания
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Сохранить новую новость
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'             => 'required|string|min:3|max:255',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'required|string|min:10',
            'preview_image'     => 'nullable|string|max:255',
            'full_image'        => 'nullable|string|max:255',
            'published_at'      => 'required|date',
        ]);

        // Автогенерация slug из заголовка
        $validated['slug'] = Str::slug($validated['title']) . '-' . time();

        Article::create($validated);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Новость успешно создана');
    }

    /**
     * Показать одну новость
     */
    public function show(string $id)
    {
        $article = Article::findOrFail($id);

        return view('articles.show', ['article' => $article]);
    }

    /**
     * Форма редактирования
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);

        return view('articles.edit', ['article' => $article]);
    }

    /**
     * Сохранить изменения
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

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

        return redirect()
            ->route('articles.index')
            ->with('success', 'Новость успешно обновлена');
    }

    /**
     * Удалить новость
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Новость удалена');
    }
}