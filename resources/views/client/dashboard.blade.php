<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tableau de bord Client | Collecte+</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0E8D4D',
                        'primary-dark': '#0b6f3d'
                    },
                    keyframes: {
                        slideDown: {
                            '0%': { opacity: '0', transform: 'translateY(-20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.95)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        },
                        pulse: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '.7' }
                        }
                    },
                    animation: {
                        'slide-down': 'slideDown 0.5s ease-out',
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(14, 141, 77, 0.15);
        }
        
        .gradient-green {
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
        }
        
        .stat-card {
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse-slow 3s infinite;
        }
    </style>
</head>
<body class="min-h-screen">

    <!-- Pop-up pour connexion réussie -->
    <div id="popup-success" class="fixed top-6 left-1/2 -translate-x-1/2 bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-4 rounded-2xl shadow-2xl font-bold text-base z-[9999] hidden items-center gap-3">
        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
            <i class="ti ti-check text-2xl"></i>
        </div>
        <span>Connexion réussie !</span>
    </div>

    <!-- NAVBAR -->
    <nav class="gradient-green shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                        <i class="ti ti-coins text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg">Collecte+</h1>
                        <p class="text-white/80 text-xs">Espace Client</p>
                    </div>
                </div>

                <!-- User Info & Logout -->
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center gap-3 bg-white/10 backdrop-blur px-4 py-2 rounded-xl">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="ti ti-user text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-white text-sm font-semibold">{{ $client->nom_cli }} {{ $client->prenom_cli }}</p>
                            <p class="text-white/70 text-xs">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl font-semibold transition-all border border-white/20">
                            <i class="ti ti-logout"></i>
                            <span class="hidden sm:inline">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Welcome Message -->
        <div class="mb-8 animate-slide-down">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">
                Bienvenue, <span class="text-primary">{{ $client->prenom_cli }}</span> 👋
            </h2>
            <p class="text-gray-600">Voici un aperçu de votre activité</p>
        </div>

        <!-- STATISTIQUES -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Solde Principal -->
            <div class="stat-card bg-gradient-to-br from-primary to-green-600 rounded-2xl p-6 text-white shadow-xl card-hover animate-fade-in">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                        <i class="ti ti-wallet text-2xl"></i>
                    </div>
                    <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-semibold">Principal</span>
                </div>
                <p class="text-white/80 text-sm mb-2">Mon Solde</p>
                <p class="text-4xl font-bold">{{ number_format($solde, 0, ',', ' ') }}</p>
                <p class="text-white/90 text-sm mt-1">FCFA</p>
            </div>

            <!-- Total Paiements -->
            <div class="bg-white rounded-2xl p-6 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.1s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="ti ti-receipt text-2xl text-blue-600"></i>
                    </div>
                    <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">Total</span>
                </div>
                <p class="text-gray-600 text-sm mb-2">Paiements</p>
                <p class="text-3xl font-bold text-gray-800">{{ $transactions->count() }}</p>
                <p class="text-gray-500 text-sm mt-1">opérations</p>
            </div>

            <!-- Paiements ce mois -->
            <div class="bg-white rounded-2xl p-6 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.2s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="ti ti-calendar-month text-2xl text-purple-600"></i>
                    </div>
                    <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-xs font-semibold">Ce mois</span>
                </div>
                <p class="text-gray-600 text-sm mb-2">Paiements</p>
                <p class="text-3xl font-bold text-gray-800">
                    {{ $transactions->where('created_at', '>=', now()->startOfMonth())->count() }}
                </p>
                <p class="text-gray-500 text-sm mt-1">ce mois</p>
            </div>

            <!-- Statut général -->
            <div class="bg-white rounded-2xl p-6 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.3s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="ti ti-shield-check text-2xl text-green-600"></i>
                    </div>
                    <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-semibold">Statut</span>
                </div>
                <p class="text-gray-600 text-sm mb-2">Compte</p>
                <p class="text-2xl font-bold text-green-600 flex items-center gap-2">
                    <i class="ti ti-circle-check-filled"></i> Actif
                </p>
            </div>

        </div>

        <!-- HISTORIQUE COMPLET -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden animate-fade-in">
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                            <i class="ti ti-history text-primary"></i>
                            Historique complet
                        </h3>
                        <p class="text-gray-500 text-sm mt-1">Tous vos paiements effectués</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-primary to-green-600 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Date & Heure</th>
                            <th class="px-6 py-4 text-left font-semibold">Type</th>
                            <th class="px-6 py-4 text-left font-semibold">Montant</th>
                            <th class="px-6 py-4 text-left font-semibold">Collecteur</th>
                            <th class="px-6 py-4 text-left font-semibold">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $transaction->created_at->format('d/m/Y') }}</p>
                                        <p class="text-sm text-gray-500">{{ $transaction->created_at->format('H:i') }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-green-100">
                                            <i class="ti ti-cash text-green-600"></i>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ ucfirst($transaction->type) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-lg text-green-600">
                                        {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                            {{ substr($transaction->collecteur, 0, 2) }}
                                        </div>
                                        <span class="text-sm text-gray-600">{{ $transaction->collecteur }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($transaction->statut == 'validé')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full font-semibold text-sm">
                                            <i class="ti ti-circle-check-filled"></i>
                                            Validé
                                        </span>
                                    @elseif($transaction->statut == 'en_attente')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full font-semibold text-sm">
                                            <i class="ti ti-clock"></i>
                                            En attente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full font-semibold text-sm">
                                            <i class="ti ti-x"></i>
                                            Rejeté
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <i class="ti ti-inbox text-6xl text-gray-300 mb-4 block"></i>
                                    <p class="text-gray-500 text-lg">Aucun paiement trouvé</p>
                                    <p class="text-gray-400 text-sm mt-2">Vos paiements apparaîtront ici une fois effectués</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-600">
                <p>© 2026 <span class="font-semibold text-primary">Collecte+</span> - Tous droits réservés</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-primary transition-colors">Conditions d'utilisation</a>
                    <a href="#" class="hover:text-primary transition-colors">Confidentialité</a>
                    <a href="#" class="hover:text-primary transition-colors">Support</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Popup de succès
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('login_success'))
                const popup = document.getElementById('popup-success');
                popup.style.display = 'flex';
                setTimeout(() => {
                    popup.style.opacity = '0';
                    popup.style.transition = 'opacity 0.3s';
                    setTimeout(() => {
                        popup.style.display = 'none';
                        popup.style.opacity = '1';
                    }, 300);
                }, 2500);
            @endif
        });
    </script>

    @include('components.chat-assistant', ['role' => Auth::user()->role ?? 'client'])
</body>
</html>