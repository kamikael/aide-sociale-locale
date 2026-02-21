<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Aide Sociale</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS via CDN pour dev rapide -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- JS classique -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>

    <header class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-blue-600">Aide Sociale</a>
        <div class="flex items-center space-x-4">
            <a href="/cagnottes" class="text-gray-700 hover:text-blue-600">Cagnottes</a>

            @guest
                <a href="/login" class="text-gray-700 hover:text-blue-600">Connexion</a>
                <a href="/register" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">S'inscrire</a>
            @endguest

            @auth
                @if(auth()->user()->role === 'donateur')
                    <a href="/dashboard" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                @endif
                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700">Déconnexion</button>
                </form>
            @endauth
        </div>
    </div>
</header>

    <main class="flex-grow container mx-auto px-6 py-8 min-h-[70vh]">
    @yield('content')
</main>
<footer class="bg-white shadow-inner mt-10 py-6 text-center text-gray-500">
    © {{ date('Y') }} Aide Sociale — Tous droits réservés
</footer>
</body>
</html>
