<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'enregistrement client | Collecte+</title>
    
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
        
        .step-indicator {
            transition: all 0.3s ease;
        }
        
        .step-indicator.active {
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            color: white;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-4xl">
        
        <!-- Header avec retour -->
        <div class="mb-8 animate-slide-in">
            <a href="{{ route('collecteur.dashboard') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 bg-white rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105 group mb-6">
                <i class="ti ti-arrow-left text-xl text-primary group-hover:-translate-x-1 transition-transform"></i>
                <span class="font-semibold text-gray-800">Retour au dashboard</span>
            </a>
            
            <!-- Titre principal -->
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-primary to-green-600 rounded-2xl mb-4 shadow-lg">
                    <i class="ti ti-user-plus text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Nouveau Client</h1>
                <p class="text-gray-600 text-lg">Enregistrez un nouveau client dans le système</p>
            </div>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('clients.store') }}" class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10 animate-fade-in">
            @csrf

            <!-- Step Indicators -->
            <div class="flex items-center justify-center gap-4 mb-10">
                <div class="step-indicator active flex items-center gap-2 px-4 py-2 rounded-full bg-primary text-white font-semibold">
                    <i class="ti ti-user"></i>
                    <span class="hidden sm:inline">Informations personnelles</span>
                    <span class="sm:hidden">Personnel</span>
                </div>
                <div class="w-12 h-1 bg-gray-200 rounded"></div>
                <div class="step-indicator flex items-center gap-2 px-4 py-2 rounded-full bg-gray-200 text-gray-600 font-semibold">
                    <i class="ti ti-lock"></i>
                    <span class="hidden sm:inline">Accès compte</span>
                    <span class="sm:hidden">Compte</span>
                </div>
            </div>

            <!-- Section 1: Informations personnelles -->
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
                                   required
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="Entrez l'adresse complète">
                        </div>
                    </div>

                    <!-- Solde initial -->
                    <div class="input-wrapper md:col-span-2">
                        <label for="solde_cli" class="block text-sm font-semibold text-gray-700 mb-2">
                            Solde initial <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-cash text-xl"></i>
                            </div>
                            <input id="solde_cli" 
                                   type="number" 
                                   name="solde_cli" 
                                   required
                                   min="0"
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="0">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-semibold">FCFA</span>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 flex items-center gap-1">
                            <i class="ti ti-info-circle"></i>
                            Montant initial du compte client
                        </p>
                    </div>

                </div>
            </div>

            <!-- Séparateur -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t-2 border-gray-200"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-white px-6 py-2 text-sm font-semibold text-gray-600 rounded-full border-2 border-gray-200">
                        <i class="ti ti-lock text-primary"></i> Paramètres de connexion (optionnel)
                    </span>
                </div>
            </div>

            <!-- Section 2: Accès au compte -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                    <i class="ti ti-key text-primary"></i>
                    Accès au compte client
                </h3>
                <p class="text-gray-600 mb-6 text-sm">
                    <i class="ti ti-info-circle text-blue-500"></i> 
                    Si vous souhaitez que le client puisse se connecter à l'application, renseignez ces informations.
                </p>
                
                <div class="grid grid-cols-1 gap-6">
                    
                    <!-- Email -->
                    <div class="input-wrapper">
                        <label for="user_email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email de connexion
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-mail text-xl"></i>
                            </div>
                            <input id="user_email" 
                                   type="email" 
                                   name="user_email"
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="email@exemple.com">
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div class="input-wrapper">
                        <label for="user_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-lock text-xl"></i>
                            </div>
                            <input id="user_password" 
                                   type="password" 
                                   name="user_password"
                                   class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="••••••••">
                            <button type="button" 
                                    onclick="togglePassword('user_password', 'eye1')"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary transition-colors">
                                <i id="eye1" class="ti ti-eye text-xl"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div class="input-wrapper">
                        <label for="user_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirmation du mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none input-icon text-gray-400 transition-colors">
                                <i class="ti ti-lock-check text-xl"></i>
                            </div>
                            <input id="user_password_confirmation" 
                                   type="password" 
                                   name="user_password_confirmation"
                                   class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
                                   placeholder="••••••••">
                            <button type="button" 
                                    onclick="togglePassword('user_password_confirmation', 'eye2')"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-primary transition-colors">
                                <i id="eye2" class="ti ti-eye text-xl"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4 mt-10">
                <button type="reset" 
                        class="flex-1 px-8 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all flex items-center justify-center gap-2">
                    <i class="ti ti-refresh"></i>
                    Réinitialiser
                </button>
                <button type="submit" 
                        class="flex-1 px-8 py-4 bg-gradient-to-r from-primary to-green-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center justify-center gap-2">
                    <i class="ti ti-check"></i>
                    Enregistrer le client
                </button>
            </div>

            <!-- Note de sécurité -->
            <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                <div class="flex items-start gap-3">
                    <i class="ti ti-shield-check text-2xl text-blue-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-semibold text-blue-800 mb-1">Sécurité des données</p>
                        <p class="text-xs text-blue-700">Toutes les informations sont cryptées et stockées en toute sécurité. Le client recevra un email de bienvenue si une adresse email est renseignée.</p>
                    </div>
                </div>
            </div>

        </form>

    </div>

    <script>
        // Toggle password visibility
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ti-eye');
                icon.classList.add('ti-eye-off');
            } else {
                input.type = 'password';
                icon.classList.remove('ti-eye-off');
                icon.classList.add('ti-eye');
            }
        }

        // Animation des step indicators au scroll
        window.addEventListener('scroll', function() {
            const form = document.querySelector('form');
            const formRect = form.getBoundingClientRect();
            const steps = document.querySelectorAll('.step-indicator');
            
            // Si on a scrollé au-delà de la moitié du formulaire
            if (formRect.top < window.innerHeight / 2) {
                steps.forEach(step => step.classList.add('active'));
            }
        });

        // Validation en temps réel des mots de passe
        const password = document.getElementById('user_password');
        const confirmPassword = document.getElementById('user_password_confirmation');

        confirmPassword.addEventListener('input', function() {
            if (password.value && confirmPassword.value) {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Les mots de passe ne correspondent pas');
                    confirmPassword.classList.add('border-red-500');
                } else {
                    confirmPassword.setCustomValidity('');
                    confirmPassword.classList.remove('border-red-500');
                    confirmPassword.classList.add('border-green-500');
                }
            }
        });
    </script>

</body>
</html>