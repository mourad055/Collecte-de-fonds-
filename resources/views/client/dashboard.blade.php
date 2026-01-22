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
                            <p class="text-white text-sm font-semibold">{{ Auth::user()->name }}</p>
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
                Bienvenue, <span class="text-primary">{{ Auth::user()->name }}</span> 👋
            </h2>
            <p class="text-gray-600">Voici un aperçu de votre activité aujourd'hui</p>
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

            <!-- Transactions du mois -->
            <div class="bg-white rounded-2xl p-6 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.1s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <i class="ti ti-calendar-month text-2xl text-blue-600"></i>
                    </div>
                    <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">Ce mois</span>
                </div>
                <p class="text-gray-600 text-sm mb-2">Transactions</p>
                <p class="text-3xl font-bold text-gray-800">{{ $transactions->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                <p class="text-gray-500 text-sm mt-1">opérations</p>
            </div>

            <!-- Dernière transaction -->
            <div class="bg-white rounded-2xl p-6 shadow-lg card-hover animate-fade-in" style="animation-delay: 0.2s">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="ti ti-clock text-2xl text-purple-600"></i>
                    </div>
                    <span class="bg-purple-100 text-purple-600 px-3 py-1 rounded-full text-xs font-semibold">Récent</span>
                </div>
                <p class="text-gray-600 text-sm mb-2">Dernière activité</p>
                @if($transactions->first())
                    <p class="text-2xl font-bold text-gray-800">{{ $transactions->first()->created_at->diffForHumans() }}</p>
                @else
                    <p class="text-xl text-gray-400">Aucune activité</p>
                @endif
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

        <!-- GRAPHIQUE & ACTIONS RAPIDES -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Actions Rapides -->
            <div class="bg-white rounded-2xl p-6 shadow-lg animate-scale-in">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="ti ti-bolt text-primary"></i>
                    Actions rapides
                </h3>
                <div class="space-y-3">
                    <button class="w-full flex items-center gap-3 p-4 rounded-xl bg-gradient-to-r from-primary to-green-600 text-white hover:shadow-lg transition-all group">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="ti ti-send text-xl"></i>
                        </div>
                        <div class="text-left flex-1">
                            <p class="font-semibold">Nouvelle demande</p>
                            <p class="text-xs text-white/80">Effectuer un retrait</p>
                        </div>
                        <i class="ti ti-chevron-right group-hover:translate-x-1 transition-transform"></i>
                    </button>

                    <button class="w-full flex items-center gap-3 p-4 rounded-xl border-2 border-gray-200 hover:border-primary hover:bg-primary/5 transition-all group">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="ti ti-file-text text-xl text-blue-600"></i>
                        </div>
                        <div class="text-left flex-1">
                            <p class="font-semibold text-gray-800">Télécharger relevé</p>
                            <p class="text-xs text-gray-500">Format PDF</p>
                        </div>
                        <i class="ti ti-chevron-right text-gray-400 group-hover:translate-x-1 transition-transform"></i>
                    </button>

                    <button class="w-full flex items-center gap-3 p-4 rounded-xl border-2 border-gray-200 hover:border-primary hover:bg-primary/5 transition-all group">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="ti ti-help text-xl text-purple-600"></i>
                        </div>
                        <div class="text-left flex-1">
                            <p class="font-semibold text-gray-800">Support client</p>
                            <p class="text-xs text-gray-500">Contactez-nous</p>
                        </div>
                        <i class="ti ti-chevron-right text-gray-400 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>

            <!-- Activité récente -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-lg animate-scale-in" style="animation-delay: 0.1s">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="ti ti-activity text-primary"></i>
                    Activité récente
                </h3>
                <div class="space-y-4">
                    @forelse($transactions->take(4) as $transaction)
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $transaction->type == 'dépôt' ? 'bg-green-100' : 'bg-red-100' }}">
                                <i class="ti {{ $transaction->type == 'dépôt' ? 'ti-arrow-down-circle text-green-600' : 'ti-arrow-up-circle text-red-600' }} text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ ucfirst($transaction->type) }}</p>
                                <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-lg {{ $transaction->type == 'dépôt' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $transaction->type == 'dépôt' ? '+' : '-' }}{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                                </p>
                                @if($transaction->statut == 'validé')
                                    <span class="inline-block px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Validé</span>
                                @elseif($transaction->statut == 'en attente')
                                    <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">En attente</span>
                                @else
                                    <span class="inline-block px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">Refusé</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i class="ti ti-inbox text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Aucune transaction récente</p>
                        </div>
                    @endforelse
                </div>
                @if($transactions->count() > 4)
                    <button class="w-full mt-4 py-3 text-primary font-semibold hover:bg-primary/5 rounded-xl transition-colors">
                        Voir toutes les transactions
                    </button>
                @endif
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
                        <p class="text-gray-500 text-sm mt-1">Toutes vos transactions</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="flex items-center gap-2 px-4 py-2 border-2 border-gray-200 rounded-xl hover:border-primary hover:bg-primary/5 transition-all">
                            <i class="ti ti-filter"></i>
                            <span>Filtrer</span>
                        </button>
                        <button class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl hover:bg-primary-dark transition-all">
                            <i class="ti ti-download"></i>
                            <span>Exporter</span>
                        </button>
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
                            <th class="px-6 py-4 text-left font-semibold">Statut</th>
                            <th class="px-6 py-4 text-left font-semibold">Actions</th>
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
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $transaction->type == 'dépôt' ? 'bg-green-100' : 'bg-red-100' }}">
                                            <i class="ti {{ $transaction->type == 'dépôt' ? 'ti-arrow-down text-green-600' : 'ti-arrow-up text-red-600' }}"></i>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ ucfirst($transaction->type) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-lg {{ $transaction->type == 'dépôt' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type == 'dépôt' ? '+' : '-' }}{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($transaction->statut == 'validé')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full font-semibold text-sm">
                                            <i class="ti ti-circle-check-filled"></i>
                                            Validé
                                        </span>
                                    @elseif($transaction->statut == 'en attente')
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full font-semibold text-sm">
                                            <i class="ti ti-clock"></i>
                                            En attente
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full font-semibold text-sm">
                                            <i class="ti ti-x"></i>
                                            Refusé
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <button class="text-primary hover:text-primary-dark transition-colors">
                                        <i class="ti ti-eye text-xl"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <i class="ti ti-inbox text-6xl text-gray-300 mb-4"></i>
                                    <p class="text-gray-500 text-lg">Aucune transaction trouvée</p>
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
                    <a href="{{ route('contact') }}" class="hover:text-primary transition-colors">Support</a>
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