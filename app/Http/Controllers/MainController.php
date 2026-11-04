<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class MainController extends Controller
{
    /**
     * Читает articles.json и возвращает массив
     */
    private function getArticles(): array
    {
        $path = public_path('articles.json');

        if (!File::exists($path)) {
            return [];
        }

        $json = File::get($path);
        return json_decode($json, true) ?? [];
    }

    /**
     * Главная страница — список статей
     */
    public function index()
    {
        $articles = $this->getArticles();
        return view('home', ['articles' => $articles]);
    }

    /**
     * Страница галереи — full_image
     */
    public function galery()
    {
        $articles = $this->getArticles();
        return view('galery', ['articles' => $articles]);
    }
}