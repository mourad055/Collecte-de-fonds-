<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un client | Collecte+</title>
    
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
                        slideIn: {
                            '0%': { opacity: '0', transform: 'translateY(-20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        }
                    },
                    animation: {
                        'slide-in': 'slideIn 0.5s ease-out',
                        'fade-in': 'fadeIn 0.6s ease-out'
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper input:focus + .input-icon {
            color: #0E8D4D;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl">
        
        <!-- Header avec retour -->
        <div class="mb-8 animate-slide-in">
            <a href="{{ route('clients.index') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 group mb-6">
                <i class="ti ti-arrow-left text-xl text-primary group-hover:-translate-x-1 transition-transform"></i>
                <span class="font-semibold text-gray-800">Retour à la liste</span>
            </a>
            
            <!-- Titre principal -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl mb-4 shadow-lg">
                    <i class="ti ti-user-edit text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Modifier le client</h1>
                <p class="text-gray-600 text-lg">Mettez à jour les informations de {{ $client->nom_cli }} {{ $client->prenom_cli }}</p>
            </div>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('clients.update', $client->id_cli) }}" class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10 animate-fade-in">
            @csrf
            @method('PUT')

            <!-- Info card -->
            <div class="mb-8 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="ti ti-info-circle text-2xl text-blue-500"></i>
                    <div>
                        <p class="text-sm font-semibold text-blue-800 mb-1">Modification en cours</p>
                        <p class="text-xs text-blue-700">Les modifications seront enregistrées immédiatement après validation</p>
                    </div>
                </div>
            </div>

            <!-- Section: Informations personnelles -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="ti ti-id text-primary"></i>
                    Informations personnelles
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Nom -->
                    <div class="input-wrapper">
                        <label for="nom_cli" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nom <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-user text-xl"></i>
                            </div>
                            <input id="nom_cli" 
                                   type="text" 
                                   name="nom_cli" 
                                   value="{{ old('nom_cli', $client->nom_cli) }}"
                                   required
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="Entrez le nom">
                        </div>
                    </div>

                    <!-- Prénom -->
                    <div class="input-wrapper">
                        <label for="prenom_cli" class="block text-sm font-semibold text-gray-700 mb-2">
                            Prénom <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-user text-xl"></i>
                            </div>
                            <input id="prenom_cli" 
                                   type="text" 
                                   name="prenom_cli" 
                                   value="{{ old('prenom_cli', $client->prenom_cli) }}"
                                   required
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="Entrez le prénom">
                        </div>
                    </div>

                    <!-- Téléphone -->
                    <div class="input-wrapper">
                        <label for="tel_cli" class="block text-sm font-semibold text-gray-700 mb-2">
                            Téléphone <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-phone text-xl"></i>
                            </div>
                            <input id="tel_cli" 
                                   type="tel" 
                                   name="tel_cli" 
                                   value="{{ old('tel_cli', $client->tel_cli) }}"
                                   required
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="+237 6XX XXX XXX">
                        </div>
                    </div>

                    <!-- Adresse -->
                    <div class="input-wrapper">
                        <label for="adresse_cli" class="block text-sm font-semibold text-gray-700 mb-2">
                            Adresse <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-map-pin text-xl"></i>
                            </div>
                            <input id="adresse_cli" 
                                   type="text" 
                                   name="adresse_cli" 
                                   value="{{ old('adresse_cli', $client->adresse_cli) }}"
                                   required
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="Entrez l'adresse complète">
                        </div>
                    </div>

                    <!-- Solde -->
                    <div class="input-wrapper md:col-span-2">
                        <label for="solde_cli" class="block text-sm font-semibold text-gray-700 mb-2">
                            Solde actuel <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-cash text-xl"></i>
                            </div>
                            <input id="solde_cli" 
                                   type="number" 
                                   name="solde_cli" 
                                   value="{{ old('solde_cli', $client->solde_cli) }}"
                                   required
                                   min="0"
                                   class="w-full pl-12 pr-20 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="0">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-semibold">FCFA</span>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 flex items-center gap-1">
                            <i class="ti ti-info-circle"></i>
                            Solde actuel du compte client
                        </p>
                    </div>

                </div>
            </div>

            <!-- Historique des modifications (optionnel) -->
            <div class="mb-8 p-6 bg-gray-50 rounded-2xl">
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="ti ti-history text-gray-600"></i>
                    Historique
                </h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <p class="flex items-center gap-2">
                        <i class="ti ti-calendar text-primary"></i>
                        <span class="font-semibold">Créé le :</span> {{ $client->created_at ? $client->created_at->format('d/m/Y à H:i') : 'N/A' }}
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="ti ti-edit text-primary"></i>
                        <span class="font-semibold">Dernière modification :</span> {{ $client->updated_at ? $client->updated_at->format('d/m/Y à H:i') : 'N/A' }}
                    </p>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('clients.index') }}" 
                   class="flex-1 px-8 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all flex items-center justify-center gap-2">
                    <i class="ti ti-x"></i>
                    Annuler
                </a>
                <button type="submit" 
                        class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center justify-center gap-2">
                    <i class="ti ti-device-floppy"></i>
                    Enregistrer les modifications
                </button>
            </div>

            <!-- Note de sécurité -->
            <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-500 rounded-lg">
                <div class="flex items-start gap-3">
                    <i class="ti ti-alert-triangle text-2xl text-yellow-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-semibold text-yellow-800 mb-1">Attention</p>
                        <p class="text-xs text-yellow-700">Assurez-vous que toutes les informations sont correctes avant de sauvegarder. Cette action modifiera définitivement les données du client.</p>
                    </div>
                </div>
            </div>

        </form>

        <!-- Bouton de suppression (séparé du formulaire) -->
        <div class="mt-6 bg-white rounded-2xl shadow-lg p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h4 class="text-lg font-bold text-red-600 flex items-center gap-2 mb-1">
                        <i class="ti ti-alert-triangle"></i>
                        Zone de danger
                    </h4>
                    <p class="text-sm text-gray-600">La suppression de ce client est irréversible</p>
                </div>
                <form action="{{ route('clients.destroy', $client->id_cli) }}" method="POST" onsubmit="return confirm('⚠️ ATTENTION !\n\nÊtes-vous absolument sûr de vouloir supprimer {{ $client->nom_cli }} {{ $client->prenom_cli }} ?\n\nToutes les données associées (transactions, paiements...) seront également supprimées.\n\nCette action est IRRÉVERSIBLE !');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-6 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition-all flex items-center gap-2 shadow-md hover:shadow-lg">
                        <i class="ti ti-trash"></i>
                        Supprimer ce client
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        // Détection des modifications non sauvegardées
        let formModified = false;
        const form = document.querySelector('form[method="POST"]');
        const inputs = form.querySelectorAll('input');

        inputs.forEach(input => {
            input.addEventListener('input', () => {
                formModified = true;
            });
        });

        // Avertir l'utilisateur s'il quitte sans sauvegarder
        window.addEventListener('beforeunload', (e) => {
            if (formModified) {
                e.preventDefault();
                e.returnValue = '';
                return 'Vous avez des modifications non sauvegardées. Voulez-vous vraiment quitter ?';
            }
        });

        // Ne pas alerter si on soumet le formulaire
        form.addEventListener('submit', () => {
            formModified = false;
        });

        // Animation des icônes au focus
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                const icon = this.previousElementSibling?.querySelector('i');
                if (icon) {
                    icon.style.transform = 'scale(1.2)';
                    icon.style.transition = 'transform 0.2s ease';
                }
            });

            input.addEventListener('blur', function() {
                const icon = this.previousElementSibling?.querySelector('i');
                if (icon) {
                    icon.style.transform = 'scale(1)';
                }
            });
        });
    </script>

</body>
</html>