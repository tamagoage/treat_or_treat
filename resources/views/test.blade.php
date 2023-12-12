<!DOCTYPE html>
<html lang="ja" data-theme="cupcake">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handmade Sweets Matching App</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-base-100">
    <header class="bg-primary text-primary-content p-4">
        <h1 class="text-lg">Handmade Sweets Matching App</h1>
    </header>

    <main class="p-4">
        <h2 class="text-2xl mb-4">Sweets Posts</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @for ($i = 0; $i < 5; $i++) <div class="card bordered">
                <figure>
                    <img src="https://placekitten.com/200/300">
                </figure>
                <div class="card-body">
                    <h2 class="card-title">Sweet Post {{ $i + 1 }}
                    </h2>
                    <p>This is a description of Sweet Post {{ $i + 1 }}.</p>
                </div>
        </div>
        @endfor
        </div>
    </main>

    <footer class="bg-neutral text-neutral-content p-4 mt-auto">
        <p>© 2022 Handmade Sweets Matching App</p>
    </footer>
</body>

</html>