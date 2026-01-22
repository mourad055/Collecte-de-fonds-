<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des clients | Collecte+</title>
    
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
                            '0%': { opacity: '0', transform: 'translateY(-30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.9)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        }
                    },
                    animation: {
                        'slide-down': 'slideDown 0.5s ease-out',
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'scale-in': 'scaleIn 0.4s ease-out'
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
        }
        
        .client-card {
            transition: all 0.3s ease;
        }
        
        .client-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(14, 141, 77, 0.15);
        }
        
        .fab-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 30px rgba(14, 141, 77, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 50;
        }
        
        .fab-button:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 12px 40px rgba(14, 141, 77, 0.5);
        }
        
        @media (max-width: 640px) {
            .fab-button {
                width: 60px;
                height: 60px;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
</head>
<body class="min-h-screen pb-24">

    <!-- Header -->
    <div class="bg-gradient-to-r from-primary to-green-600 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Bouton retour -->
            <div class="mb-6 animate-slide-down">
                <a href="{{ route('collecteur.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-md rounded-xl text-white hover:bg-white/30 transition-all group">
                    <i class="ti ti-arrow-left text-xl group-hover:-translate-x-1 transition-transform"></i>
                    <span class="font-semibold">Retour au dashboard</span>
                </a>
            </div>
            
            <!-- Titre et stats -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 text-white animate-fade-in">
                <div>
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-2 flex items-center gap-3">
                        <i class="ti ti-users text-5xl"></i>
                        Mes Clients
                    </h1>
                    <p class="text-white/90 text-lg">Gérez tous vos clients en un seul endroit</p>
                </div>
                <div class="flex gap-4">
                    <div class="bg-white/20 backdrop-blur-md px-6 py-4 rounded-2xl text-center">
                        <p class="text-3xl font-bold">{{ count($clients) }}</p>
                        <p class="text-sm text-white/90">Clients</p>
                    </div>
                    <div class="bg-white/20 backdrop-blur-md px-6 py-4 rounded-2xl text-center">
                        <p class="text-3xl font-bold">{{ number_format($clients->sum('solde_cli'), 0, ',', ' ') }}</p>
                        <p class="text-sm text-white/90">Solde total (FCFA)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message de succès -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 animate-scale-in">
            <div class="bg-green-50 border-l-4 border-green-500 rounded-xl p-4 shadow-lg flex items-center gap-3">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                    <i class="ti ti-check text-white text-xl"></i>
                </div>
                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Barre de recherche et filtres -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 animate-scale-in">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="ti ti-search text-gray-400 text-xl"></i>
                    </div>
                    <input type="text" 
                           id="searchInput"
                           placeholder="Rechercher un client (nom, prénom, téléphone...)" 
                           class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                </div>
                <button class="px-6 py-3 bg-gradient-to-r from-primary to-green-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all flex items-center gap-2">
                    <i class="ti ti-filter"></i>
                    <span>Filtrer</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Liste des clients -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @forelse($clients as $index => $client)
            <div class="client-card bg-white rounded-2xl shadow-lg p-6 mb-6 animate-fade-in" style="animation-delay: {{ $index * 0.05 }}s">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    
                    <!-- Info client -->
                    <div class="flex items-start gap-4 flex-1">
                        <!-- Avatar -->
                        <div class="w-16 h-16 bg-gradient-to-br from-primary to-green-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold flex-shrink-0">
                            {{ strtoupper(substr($client->nom_cli, 0, 1)) }}{{ strtoupper(substr($client->prenom_cli, 0, 1)) }}
                        </div>
                        
                        <!-- Details -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $client->nom_cli }} {{ $client->prenom_cli }}</h3>
                            <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                <span class="flex items-center gap-1">
                                    <i class="ti ti-phone text-primary"></i>
                                    {{ $client->tel_cli }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="ti ti-map-pin text-primary"></i>
                                    {{ $client->adresse_cli }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Solde et actions -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <!-- Solde -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 px-6 py-3 rounded-xl border-2 border-green-200">
                            <p class="text-xs text-gray-600 mb-1">Solde</p>
                            <p class="text-2xl font-bold text-primary">{{ number_format($client->solde_cli, 0, ',', ' ') }}</p>
                            <p class="text-xs text-gray-500">FCFA</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a href="{{ route('clients.edit', $client->id_cli) }}" 
                               class="w-12 h-12 bg-blue-100 hover:bg-blue-500 text-blue-600 hover:text-white rounded-xl flex items-center justify-center transition-all hover:scale-110"
                               title="Modifier">
                                <i class="ti ti-edit text-xl"></i>
                            </a>
                            <form action="{{ route('clients.destroy', $client->id_cli) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer {{ $client->nom_cli }} {{ $client->prenom_cli }} ?')"
                                        class="w-12 h-12 bg-red-100 hover:bg-red-500 text-red-600 hover:text-white rounded-xl flex items-center justify-center transition-all hover:scale-110"
                                        title="Supprimer">
                                    <i class="ti ti-trash text-xl"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-lg p-16 text-center animate-scale-in">
                <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="ti ti-user-x text-6xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Aucun client trouvé</h3>
                <p class="text-gray-600 mb-8">Commencez par ajouter votre premier client</p>
                <a href="{{ route('clients.create') }}" 
                   class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary to-green-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                    <i class="ti ti-plus text-xl"></i>
                    Ajouter un client
                </a>
            </div>
        @endforelse

    </div>

    <!-- Bouton flottant d'ajout (FAB) -->
    @if(count($clients) > 0)
        <a href="{{ route('clients.create') }}" class="fab-button group" title="Ajouter un client">
            <i class="ti ti-plus text-4xl text-white"></i>
        </a>
    @endif

    <!-- Pagination (si nécessaire) -->
    @if(method_exists($clients, 'links'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
            {{ $clients->links() }}
        </div>
    @endif

    <script>
        // Recherche en temps réel
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const clientCards = document.querySelectorAll('.client-card');
            
            clientCards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    card.style.display = 'block';
                    card.classList.add('animate-fade-in');
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.client-card').forEach(card => {
            observer.observe(card);
        });

        // Confirmation de suppression améliorée
        document.querySelectorAll('form[action*="destroy"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const clientName = this.closest('.client-card').querySelector('h3').textContent;
                if (!confirm(`⚠️ Voulez-vous vraiment supprimer ${clientName} ?\n\nCette action est irréversible.`)) {
                    e.preventDefault();
                }
            });
        });
    </script>

</body>
</html>