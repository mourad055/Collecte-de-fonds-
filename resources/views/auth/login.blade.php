<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion | Collecte+</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                }
            }
        }
    </script>
    <style>
        /* Animation for icons in the background */
        .floating {
            position: absolute;
            z-index: 2;
            opacity: 0.13;
            pointer-events: none;
        }
        .float-1 { left: 11%; top: 12%; animation: floatY1 8s ease-in-out infinite; }
        .float-2 { right: 8%; top: 25%; animation: floatY2 7.5s ease-in-out infinite; }
        .float-3 { left: 7%; bottom: 15%; animation: floatY3 11s ease-in-out infinite;}
        .float-4 { right: 13%; bottom: 21%; animation: floatY4 9s ease-in-out infinite;}
        .float-5 { left: 49%; top: 3%; animation: floatY5 10.4s ease-in-out infinite;}
        @keyframes floatY1 {0%,100%{transform:translateY(0)} 50%{transform:translateY(-30px)}}
        @keyframes floatY2 {0%,100%{transform:translateY(0)} 50%{transform:translateY(18px)}}
        @keyframes floatY3 {0%,100%{transform:translateY(0)} 50%{transform:translateY(-22px)}}
        @keyframes floatY4 {0%,100%{transform:translateY(0)} 50%{transform:translateY(33px)}}
        @keyframes floatY5 {0%,100%{transform:translateY(0)} 50%{transform:translateY(-19px)}}
    </style>
</head>

<body class="min-h-screen bg-cover bg-center relative" style="background-image: url('/images/background.png');">

<!-- Overlay -->
<div class="absolute inset-0 bg-gradient-to-br from-white/90 via-white/70 to-primary/30"></div>

<!-- Animated floating icons (background) -->
<!-- You can swap icons as you wish here -->
<span class="floating float-1" style="width:48px; height:48px;">
  <!-- User Circle -->
  <svg fill="none" viewBox="0 0 48 48" stroke="currentColor" class="w-full h-full text-primary-dark">
    <circle cx="24" cy="24" r="22" stroke-width="3"/>
    <circle cx="24" cy="20" r="6" stroke-width="2"/>
    <path stroke-width="2" d="M12 36c0-4 8-6 12-6s12 2 12 6"/>
  </svg>
</span>
<span class="floating float-2" style="width:40px; height:40px;">
  <!-- Envelope -->
  <svg fill="none" viewBox="0 0 40 40" stroke="currentColor" class="w-full h-full text-green-600">
    <rect x="5" y="10" width="30" height="20" rx="4" stroke-width="2"/>
    <path stroke-width="2" d="M5 12l15 10 15-10"/>
  </svg>
</span>
<span class="floating float-3" style="width:44px; height:44px;">
  <!-- Lock -->
  <svg fill="none" viewBox="0 0 44 44" stroke="currentColor" class="w-full h-full text-primary">
    <rect x="9" y="19" width="26" height="18" rx="4" stroke-width="2"/>
    <path stroke-width="2" d="M15 19v-4a7 7 0 0114 0v4"/>
    <circle cx="22" cy="28" r="2" stroke-width="2"/>
  </svg>
</span>
<span class="floating float-4" style="width:34px; height:34px;">
  <!-- Key -->
  <svg fill="none" viewBox="0 0 34 34" stroke="currentColor" class="w-full h-full text-green-500">
    <circle cx="12" cy="22" r="5" stroke-width="2"/>
    <path stroke-width="2" d="M16.5 17.5l10-10m0 0v5m0-5h-5"/>
  </svg>
</span>
<span class="floating float-5" style="width:36px; height:36px;">
  <!-- Gear Settings -->
  <svg fill="none" viewBox="0 0 36 36" stroke="currentColor" class="w-full h-full text-primary-dark">
    <circle cx="18" cy="18" r="6" stroke-width="2"/>
    <path stroke-width="2" d="M18 7v-4M29 18h4M18 29v4M7 18H3M26.5 26.5l2.5 2.5M9.5 9.5L7 7M26.5 9.5L29 7M9.5 26.5L7 29"/>
  </svg>
</span>

<!-- Content -->
<div class="relative z-10 flex items-center justify-center min-h-screen px-6">

    <div class="w-full max-w-md">
        
        <!-- Card -->
        <div class="bg-white/60 backdrop-blur-xl rounded-3xl shadow-2xl p-10 border border-white/40">
            
            <!-- Logo -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-primary">Collecte+</h1>
                <p class="text-gray-600 mt-2">Connexion à votre espace</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div class="relative flex items-center">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-primary pointer-events-none">
                        <!-- Envelope (email) icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12l-4-4-4 4m8 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4"/>
                        </svg>
                    </span>
                    <input
                        type="email"
                        name="email"
                        required
                        class="peer w-full pl-12 pr-4 pt-6 pb-2 rounded-xl bg-white/70 border border-gray-300 focus:border-primary focus:ring-0 outline-none"
                    >
                    <label class="absolute left-12 top-2 text-gray-500 text-sm transition-all
                        peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                        peer-focus:top-2 peer-focus:text-sm
                    ">
                        Adresse email
                    </label>
                </div>

                <!-- Password -->
                <div class="relative flex items-center">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-primary pointer-events-none">
                        <!-- Lock (password) icon SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17a2 2 0 100-4 2 2 0 000 4zm6-6V9a6 6 0 00-12 0v2a2 2 0 00-2 2v5a2 2 0 002 2h12a2 2 0 002-2v-5a2 2 0 00-2-2z"/>
                        </svg>
                    </span>
                    <input
                        type="password"
                        name="password"
                        required
                        class="peer w-full pl-12 pr-4 pt-6 pb-2 rounded-xl bg-white/70 border border-gray-300 focus:border-primary focus:ring-0 outline-none"
                    >
                    <label class="absolute left-12 top-2 text-gray-500 text-sm transition-all
                        peer-placeholder-shown:top-4 peer-placeholder-shown:text-base
                        peer-focus:top-2 peer-focus:text-sm
                    ">
                        Mot de passe
                    </label>
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
                        <span>Se souvenir de moi</span>
                    </label>
                    <a href="#" class="text-primary hover:underline">Mot de passe oublié ?</a>
                </div>

                <!-- Button -->
                <button type="submit"
                        class="w-full py-4 rounded-xl font-bold text-white relative overflow-hidden group">
                    <span class="absolute inset-0 bg-primary transition-transform duration-300 group-hover:scale-110"></span>
                    <span class="absolute inset-0 bg-gradient-to-r from-primary to-green-600 opacity-0 group-hover:opacity-100 transition"></span>
                    <span class="relative z-10">Se connecter</span>
                </button>
            </form>

            <!-- Register -->
            <p class="text-center text-sm text-gray-600 mt-8">
                Pas encore de compte ?
                <a href="#" class="text-primary font-semibold hover:underline">Créer un compte</a>
            </p>
        </div>

    </div>
</div>

</body>
</html>
