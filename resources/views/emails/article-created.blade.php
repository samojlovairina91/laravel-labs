<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Новая статья</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px;">
        <h1 style="color: #2c3e50;">Новая статья!</h1>
        
        <p>На сайте была опубликована новая статья:</p>
        
        <div style="background: #f9f9f9; padding: 15px; border-left: 4px solid #2c3e50; margin: 20px 0;">
            <h2 style="margin-top: 0;">{{ $article->title }}</h2>
            <p style="color: #555;">{{ $article->short_description }}</p>
        </div>

        <p>Дата публикации: <strong>{{ $article->published_at->format('d.m.Y') }}</strong></p>
        
        <a href="{{ route('articles.show', $article->id) }}" style="display: inline-block; background: #2980b9; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px;">
            Читать на сайте
        </a>
    </div>
</body>
</html>