<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion | Collecte+</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
                    boxShadow: {
                        'soft-green': '0 6px 32px rgba(14, 141, 77, 0.13), 0 1.5px 10px rgba(0,0,0,0.10)'
                    },
                    keyframes: {
                        slideDown: {
                            '0%': { opacity: '0', transform: 'translateY(-20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        scaleIn: {
                            '0%': { opacity: '0', transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' }
                        }
                    },
                    animation: {
                        'slide-down': 'slideDown 0.5s ease-out',
                        'scale-in': 'scaleIn 0.6s ease-out'
                    }
                }
            }
        }
    </script>
    <style>
        /* Animation for icons in the background */
        .floating {
            position: absolute;
            z-index: 2;
            opacity: 0.08;
            pointer-events: none;
        }
        .float-1 { left: 11%; top: 12%; animation: floatY1 8s ease-in-out infinite; }
        .float-2 { right: 8%; top: 25%; animation: floatY2 7.5s ease-in-out infinite; }
        .float-3 { left: 7%; bottom: 15%; animation: floatY3 11s ease-in-out infinite;}
        .float-4 { right: 13%; bottom: 21%; animation: floatY4 9s ease-in-out infinite;}
        .float-5 { left: 49%; top: 3%; animation: floatY5 10.4s ease-in-out infinite;}
        .float-6 { right: 30%; top: 8%; animation: floatY1 9.2s ease-in-out infinite;}
        .float-7 { left: 25%; bottom: 8%; animation: floatY3 8.8s ease-in-out infinite;}
        @keyframes floatY1 {0%,100%{transform:translateY(0)} 50%{transform:translateY(-30px)}}
        @keyframes floatY2 {0%,100%{transform:translateY(0)} 50%{transform:translateY(18px)}}
        @keyframes floatY3 {0%,100%{transform:translateY(0)} 50%{transform:translateY(-22px)}}
        @keyframes floatY4 {0%,100%{transform:translateY(0)} 50%{transform:translateY(33px)}}
        @keyframes floatY5 {0%,100%{transform:translateY(0)} 50%{transform:translateY(-19px)}}
        
        /* Popup animation */
        @keyframes slideInTop {
            from { opacity: 0; transform: translateX(-50%) translateY(-30px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }
        .popup-success {
            animation: slideInTop 0.5s ease-out;
        }
    </style>
</head>

<body class="min-h-screen bg-cover bg-center relative overflow-x-hidden" style="background-image: url('/images/background.png');">

<!-- Overlay -->
<div class="absolute inset-0 bg-gradient-to-br from-white/92 via-white/75 to-primary/25"></div>

<!-- Animated floating icons (background) -->
<span class="floating float-1" style="width:52px; height:52px;">
    <i class="ti ti-user-circle text-primary-dark" style="font-size: 52px;"></i>
</span>
<span class="floating float-2" style="width:44px; height:44px;">
    <i class="ti ti-mail text-green-600" style="font-size: 44px;"></i>
</span>
<span class="floating float-3" style="width:48px; height:48px;">
    <i class="ti ti-lock text-primary" style="font-size: 48px;"></i>
</span>
<span class="floating float-4" style="width:38px; height:38px;">
    <i class="ti ti-key text-green-500" style="font-size: 38px;"></i>
</span>
<span class="floating float-5" style="width:40px; height:40px;">
    <i class="ti ti-shield-check text-primary-dark" style="font-size: 40px;"></i>
</span>
<span class="floating float-6" style="width:36px; height:36px;">
    <i class="ti ti-fingerprint text-green-600" style="font-size: 36px;"></i>
</span>
<span class="floating float-7" style="width:42px; height:42px;">
    <i class="ti ti-device-mobile text-primary" style="font-size: 42px;"></i>
</span>

<!-- Pop-up pour connexion réussie -->
<div id="popup-success" class="fixed top-6 left-1/2 -translate-x-1/2 bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-4 rounded-2xl shadow-2xl font-bold text-base z-[9999] hidden items-center gap-3 popup-success">
    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
        <i class="ti ti-check text-2xl"></i>
    </div>
    <span>Connexion réussie !</span>
</div>

<!-- Bouton retour vers l'accueil (TOP LEFT) -->
<a href="{{ route('home') }}" 
   class="fixed top-6 left-6 z-50 flex items-center gap-2 bg-white/90 backdrop-blur-md px-5 py-3 rounded-full shadow-lg hover:shadow-xl transition-all group hover:scale-105 animate-slide-down">
    <i class="ti ti-arrow-left text-xl text-primary group-hover:-translate-x-1 transition-transform"></i>
    <span class="font-semibold text-gray-800">Retour à l'accueil</span>
</a>

<!-- Content -->
<div class="relative z-10 flex items-center justify-center min-h-screen px-4 py-20">

    <div class="w-full max-w-md animate-scale-in">
        
        <!-- Card -->
        <div class="bg-white/70 backdrop-blur-2xl rounded-3xl shadow-2xl p-8 sm:p-10 border border-white/50 relative overflow-hidden">
            
            <!-- Decorative gradient top -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary via-green-500 to-primary"></div>
            
            <!-- Logo et titre -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-primary to-green-600 rounded-2xl mb-4 shadow-soft-green">
                    <i class="ti ti-coins text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl font-extrabold text-primary mb-2">Collecte+</h1>
                <p class="text-gray-600 font-medium">Connectez-vous à votre espace</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div class="relative">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-primary pointer-events-none z-10">
                        <i class="ti ti-mail text-xl"></i>
                    </div>
                    <input
                        type="email"
                        name="email"
                        required
                        placeholder=" "
                        class="peer w-full pl-12 pr-4 py-4 rounded-xl bg-white/80 border-2 border-gray-200 focus:border-primary focus:ring-0 outline-none transition-all placeholder-transparent"
                    >
                    <label class="absolute left-12 top-1/2 -translate-y-1/2 text-gray-500 transition-all pointer-events-none
                        peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500
                        peer-focus:top-0 peer-focus:left-4 peer-focus:text-xs peer-focus:text-primary peer-focus:bg-white peer-focus:px-2
                        peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:left-4 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-primary peer-[:not(:placeholder-shown)]:bg-white peer-[:not(:placeholder-shown)]:px-2
                    ">
                        Adresse email
                    </label>
                </div>

                <!-- Password -->
                <div class="relative">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-primary pointer-events-none z-10">
                        <i class="ti ti-lock text-xl"></i>
                    </div>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        placeholder=" "
                        class="peer w-full pl-12 pr-12 py-4 rounded-xl bg-white/80 border-2 border-gray-200 focus:border-primary focus:ring-0 outline-none transition-all placeholder-transparent"
                    >
                    <label class="absolute left-12 top-1/2 -translate-y-1/2 text-gray-500 transition-all pointer-events-none
                        peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500
                        peer-focus:top-0 peer-focus:left-4 peer-focus:text-xs peer-focus:text-primary peer-focus:bg-white peer-focus:px-2
                        peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:left-4 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:text-primary peer-[:not(:placeholder-shown)]:bg-white peer-[:not(:placeholder-shown)]:px-2
                    ">
                        Mot de passe
                    </label>
                    <!-- Toggle password visibility -->
                    <button type="button" id="toggle-password" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                        <i class="ti ti-eye text-xl" id="eye-icon"></i>
                    </button>
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer">
                        <span class="text-gray-700 group-hover:text-primary transition-colors">Se souvenir de moi</span>
                    </label>
                    <a href="#" class="text-primary font-semibold hover:underline hover:text-primary-dark transition-colors">
                        Mot de passe oublié ?
                    </a>
                </div>

                <!-- Button -->
                <button type="submit"
                        class="w-full py-4 rounded-xl font-bold text-white relative overflow-hidden group shadow-soft-green hover:shadow-xl transition-all">
                    <span class="absolute inset-0 bg-gradient-to-r from-primary to-green-600 transition-transform duration-300"></span>
                    <span class="absolute inset-0 bg-gradient-to-r from-green-600 to-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <i class="ti ti-login-2 text-xl"></i>
                        Se connecter
                    </span>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white/70 text-gray-600 font-medium">Ou continuer avec</span>
                </div>
            </div>

            <!-- Social Login (Optional) -->
            <div class="grid grid-cols-2 gap-4">
                <button type="button" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 border-gray-200 bg-white/60 hover:bg-white hover:border-primary transition-all group">
                    <i class="ti ti-brand-google text-xl text-red-500"></i>
                    <span class="font-semibold text-gray-700 group-hover:text-primary">Google</span>
                </button>
                <button type="button" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl border-2 border-gray-200 bg-white/60 hover:bg-white hover:border-primary transition-all group">
                    <i class="ti ti-brand-facebook text-xl text-blue-600"></i>
                    <span class="font-semibold text-gray-700 group-hover:text-primary">Facebook</span>
                </button>
            </div>

           

            <!-- Security badge -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-center gap-2 text-xs text-gray-500">
                <i class="ti ti-shield-lock text-primary"></i>
                <span>Connexion sécurisée SSL 256-bit</span>
            </div>
        </div>

        <!-- Additional info -->
        <div class="mt-6 text-center text-sm text-gray-600 bg-white/40 backdrop-blur-md rounded-2xl px-6 py-4 shadow-md">
            <div class="flex items-center justify-center gap-2 mb-2">
                <i class="ti ti-info-circle text-primary"></i>
                <span class="font-semibold">Besoin d'aide ?</span>
            </div>
            <p>Contactez notre support au <a href="tel:+237697074455" class="text-primary font-semibold hover:underline">+237 697 074 455</a></p>
        </div>

    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('toggle-password').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('ti-eye');
            eyeIcon.classList.add('ti-eye-off');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('ti-eye-off');
            eyeIcon.classList.add('ti-eye');
        }
    });

    // Affiche le popup de succès si besoin
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('login_success'))
            const popup = document.getElementById('popup-success');
            popup.style.display = 'flex';
            setTimeout(() => {
                popup.style.opacity = '0';
                setTimeout(() => {
                    popup.style.display = 'none';
                    popup.style.opacity = '1';
                }, 300);
            }, 2500);
        @endif
    });
</script>

{{-- 
    IMPORTANT : 
    Pour afficher le popup "connexion réussie" après une connexion, 
    ajoute dans ton LoginController ou AuthController :

    return redirect()->intended(route('dashboard'))->with('login_success', true);

    N'oublie pas aussi de créer la route 'home' dans web.php :
    Route::get('/', function () {
        return view('welcome');
    })->name('home');
--}}

</body>
</html>