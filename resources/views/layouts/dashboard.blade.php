<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <div class="font-bold text-lg">
            Plateforme Cagnotte
        </div>

        <div class="flex items-center gap-4">
            <span>{{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-600 hover:underline">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <!-- Contenu -->
    <main class="p-8">
        @yield('content')
    </main>

</body>
</html>