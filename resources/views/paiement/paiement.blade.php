<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Paiement | Collecte+</title>
    
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
                        },
                        pulse: {
                            '0%, 100%': { opacity: '1' },
                            '50%': { opacity: '.7' }
                        }
                    },
                    animation: {
                        'slide-in': 'slideIn 0.5s ease-out',
                        'fade-in': 'fadeIn 0.6s ease-out',
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
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper input:focus + .input-icon,
        .input-wrapper select:focus + .input-icon {
            color: #0E8D4D;
        }
        
        /* Custom select arrow */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-2xl">
        
        <!-- Header avec retour -->
        <div class="mb-8 animate-slide-in">
            <a href="javascript:history.back()" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 group mb-6">
                <i class="ti ti-arrow-left text-xl text-primary group-hover:-translate-x-1 transition-transform"></i>
                <span class="font-semibold text-gray-800">Retour</span>
            </a>
            
            <!-- Titre principal -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-primary to-green-600 rounded-2xl mb-4 shadow-lg animate-pulse-slow">
                    <i class="ti ti-credit-card text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Nouveau Paiement</h1>
                <p class="text-gray-600 text-lg">Enregistrez un paiement client</p>
            </div>
        </div>

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-xl p-4 shadow-lg animate-slide-in">
                <div class="flex items-start gap-3">
                    <i class="ti ti-alert-circle text-2xl text-red-500 mt-1"></i>
                    <div>
                        <p class="font-semibold text-red-800 mb-2">Erreurs de validation</p>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('paiement.store') }}" method="POST" class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10 animate-fade-in">
            @csrf

            <!-- Section: Informations du paiement -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="ti ti-file-invoice text-primary"></i>
                    Détails du paiement
                </h3>
                
                <div class="space-y-6">
                    
                    <!-- Sélection du client -->
                    <div class="input-wrapper">
                        <label for="client_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Client <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors z-10">
                                <i class="ti ti-user text-xl"></i>
                            </div>
                            <select id="client_id" 
                                    name="client_id" 
                                    required
                                    class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all bg-white">
                                <option value="">-- Sélectionnez un client --</option>
                                @if(isset($clients) && count($clients) > 0)
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id_cli }}">
                                            {{ $client->nom_cli }}
                                            @if(!empty($client->prenom_cli))
                                                {{ ' ' . $client->prenom_cli }}
                                            @endif
                                            - Solde: {{ number_format($client->solde_cli ?? 0, 0, ',', ' ') }} FCFA
                                        </option>
                                    @endforeach
                                @else
                                    <option disabled>Aucun client disponible</option>
                                @endif
                            </select>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 flex items-center gap-1">
                            <i class="ti ti-info-circle"></i>
                            Le solde du client s'affiche dans la liste
                        </p>
                    </div>

                    <!-- Référence (optionnelle) -->
                    <div class="input-wrapper">
                        <label for="reference" class="block text-sm font-semibold text-gray-700 mb-2">
                            Référence (optionnelle)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-hash text-xl"></i>
                            </div>
                            <input id="reference" 
                                   type="text" 
                                   name="reference"
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="Ex: PAY-2026-001">
                        </div>
                    </div>

                    <!-- Montant -->
                    <div class="input-wrapper">
                        <label for="montant" class="block text-sm font-semibold text-gray-700 mb-2">
                            Montant <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-cash text-xl"></i>
                            </div>
                            <input id="montant" 
                                   type="number" 
                                   name="montant" 
                                   required
                                   min="0"
                                   step="any"
                                   class="w-full pl-12 pr-20 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-lg font-semibold"
                                   placeholder="0">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-bold">FCFA</span>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 flex items-center gap-1">
                            <i class="ti ti-info-circle"></i>
                            Montant en Francs CFA
                        </p>
                    </div>

                    <!-- Mode de paiement -->
                    <div class="input-wrapper">
                        <label for="mode_paiement" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mode de paiement <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-wallet text-xl"></i>
                            </div>
                            <input id="mode_paiement" 
                                   type="text" 
                                   name="mode_paiement" 
                                   value="Espèce"
                                   readonly
                                   required
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 cursor-not-allowed outline-none">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="ti ti-lock text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Date du paiement -->
                    <div class="input-wrapper">
                        <label for="date_paiement" class="block text-sm font-semibold text-gray-700 mb-2">
                            Date du paiement <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-calendar text-xl"></i>
                            </div>
                            <input id="date_paiement" 
                                   type="date" 
                                   name="date_paiement" 
                                   required
                                   value="{{ date('Y-m-d') }}"
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                        </div>
                    </div>

                </div>
            </div>

            <!-- Récapitulatif -->
            <div id="recap" class="hidden mb-8 p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl border-2 border-green-200">
                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="ti ti-file-check text-primary"></i>
                    Récapitulatif
                </h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Client :</span>
                        <span id="recap-client" class="font-semibold text-gray-800">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Montant :</span>
                        <span id="recap-montant" class="font-bold text-primary text-lg">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Mode :</span>
                        <span id="recap-mode" class="font-semibold text-gray-800">Espèce</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date :</span>
                        <span id="recap-date" class="font-semibold text-gray-800">-</span>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="reset" 
                        class="flex-1 px-8 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all flex items-center justify-center gap-2">
                    <i class="ti ti-refresh"></i>
                    Réinitialiser
                </button>
                <button type="submit" 
                        class="flex-1 px-8 py-4 bg-gradient-to-r from-primary to-green-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center justify-center gap-2">
                    <i class="ti ti-receipt"></i>
                    Générer le reçu
                </button>
            </div>

            <!-- Note importante -->
            <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                <div class="flex items-start gap-3">
                    <i class="ti ti-info-circle text-2xl text-blue-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-semibold text-blue-800 mb-1">Information importante</p>
                        <p class="text-xs text-blue-700">Un reçu de paiement sera généré automatiquement après validation. Assurez-vous que toutes les informations sont correctes.</p>
                    </div>
                </div>
            </div>

        </form>

    </div>

    <script>
        // Éléments du formulaire
        const clientSelect = document.getElementById('client_id');
        const montantInput = document.getElementById('montant');
        const dateInput = document.getElementById('date_paiement');
        const recapDiv = document.getElementById('recap');
        const recapClient = document.getElementById('recap-client');
        const recapMontant = document.getElementById('recap-montant');
        const recapDate = document.getElementById('recap-date');

        // Fonction pour mettre à jour le récapitulatif
        function updateRecap() {
            const client = clientSelect.options[clientSelect.selectedIndex]?.text;
            const montant = montantInput.value;
            const date = dateInput.value;

            if (client && client !== '-- Sélectionnez un client --' && montant && date) {
                recapDiv.classList.remove('hidden');
                recapClient.textContent = client;
                recapMontant.textContent = new Intl.NumberFormat('fr-FR').format(montant) + ' FCFA';
                
                // Formater la date
                const dateObj = new Date(date);
                recapDate.textContent = dateObj.toLocaleDateString('fr-FR', { 
                    day: '2-digit', 
                    month: 'long', 
                    year: 'numeric' 
                });
            } else {
                recapDiv.classList.add('hidden');
            }
        }

        // Écouter les changements
        clientSelect.addEventListener('change', updateRecap);
        montantInput.addEventListener('input', updateRecap);
        dateInput.addEventListener('change', updateRecap);

        // Animation des icônes au focus
        const inputs = document.querySelectorAll('input, select');
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

        // Formater le montant en temps réel
        montantInput.addEventListener('input', function() {
            if (this.value) {
                const value = parseFloat(this.value);
                if (!isNaN(value) && value > 0) {
                    this.classList.add('text-primary');
                } else {
                    this.classList.remove('text-primary');
                }
            }
        });

        // Validation avant soumission
        document.querySelector('form').addEventListener('submit', function(e) {
            const montant = parseFloat(montantInput.value);
            
            if (montant <= 0 || isNaN(montant)) {
                e.preventDefault();
                alert('⚠️ Le montant doit être supérieur à 0 FCFA');
                montantInput.focus();
                return false;
            }

            if (!clientSelect.value) {
                e.preventDefault();
                alert('⚠️ Veuillez sélectionner un client');
                clientSelect.focus();
                return false;
            }

            // Confirmation
            const clientName = clientSelect.options[clientSelect.selectedIndex].text;
            const confirmMsg = `Confirmer le paiement ?\n\nClient: ${clientName}\nMontant: ${new Intl.NumberFormat('fr-FR').format(montant)} FCFA\nDate: ${dateInput.value}`;
            
            if (!confirm(confirmMsg)) {
                e.preventDefault();
                return false;
            }
        });
    </script>

</body>
</html>