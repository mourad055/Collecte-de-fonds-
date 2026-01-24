<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - Collecte de Fonds</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-emerald-50 to-teal-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">C</span>
                    </div>
                    <span class="font-bold text-xl text-gray-800">Collecte</span>
                </div>

                @auth('client')
                <!-- Menu -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('client.dashboard') }}" class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                        Accueil
                    </a>
                    <a href="{{ route('client.solde') }}" class="nav-link {{ request()->routeIs('client.solde') ? 'active' : '' }}">
                        Mon solde
                    </a>
                    <a href="{{ route('client.historique') }}" class="nav-link {{ request()->routeIs('client.historique') ? 'active' : '' }}">
                        Historique
                    </a>
                    <a href="{{ route('client.notifications') }}" class="nav-link {{ request()->routeIs('client.notifications') ? 'active' : '' }}">
                        Notifications
                    </a>
                </div>

                <!-- Profil -->
                <div class="flex items-center gap-4">
                    <div class="hidden md:block text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ Auth::guard('client')->user()->prenom }} {{ Auth::guard('client')->user()->nom }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::guard('client')->user()->telephone }}</p>
                    </div>
                    <div class="relative group">
                        <button class="w-10 h-10 bg-gradient-to-br from-emerald-600 to-teal-600 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ substr(Auth::guard('client')->user()->prenom, 0, 1) }}{{ substr(Auth::guard('client')->user()->nom, 0, 1) }}
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 hidden group-hover:block">
                            <a href="{{ route('client.profil') }}" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Mon profil</a>
                            <form method="POST" action="{{ route('client.logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Contenu -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                <p class="text-red-700">{{ session('error') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    <style>
        .nav-link {
            @apply flex items-center gap-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition font-medium;
        }
        .nav-link.active {
            @apply bg-emerald-100 text-emerald-600;
        }
    </style>
</body>
</html>