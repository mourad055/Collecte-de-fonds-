<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Plateforme de Collecte</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Heroicons CDN -->
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
                        // bounceUp kept for "pourquoi nous choisir" block, not used elsewhere
                        bounceUp: {
                            '0%,100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-8px)' }
                        },
                        breathe: {
                            '0%,100%': {boxShadow: '0 0 16px 0 rgba(14,141,77,0.10)'},
                            '50%': {boxShadow: '0 0 30px 4px rgba(14,141,77,0.16)'}
                        }
                    },
                    animation: {
                        'bounce-up': 'bounceUp 1.5s infinite',
                        'breathe': 'breathe 2.5s infinite'
                    }
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-cover bg-center relative overflow-x-hidden" style="background-image: url('/images/background.png');">

<!-- OVERLAY GRADIENT -->
<div class="absolute inset-0 bg-gradient-to-br from-white/90 via-white/85 to-primary/20 pointer-events-none"></div>

<!-- PAGE CONTENT -->
<div class="relative z-10 flex flex-col min-h-screen">

    <!-- NAVBAR -->
    <nav class="w-full px-4 sm:px-8 py-5 flex justify-between items-center bg-white/90 backdrop-blur-md shadow-md">
        <div class="flex items-center gap-2">
            <span class="text-primary animate-spin-slow">
                <i class="ti ti-coins text-3xl sm:text-4xl"></i>
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-primary tracking-wide drop-shadow-sm select-none">
                Collecte+
            </h1>
        </div>
        <button id="menu-toggle" class="md:hidden focus:outline-none text-primary-dark hover:bg-primary/10 p-2 rounded-lg">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <ul id="nav-links" class="hidden md:flex space-x-8 text-base font-semibold">
            <li>
                <a href="#" class="flex items-center gap-1 hover:text-primary transition">
                    <i class="ti ti-home-2"></i> Accueil
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center gap-1 hover:text-primary transition">
                    <i class="ti ti-hand-coins"></i> Fonctionnement
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center gap-1 hover:text-primary transition">
                    <i class="ti ti-mail"></i> Contact
                </a>
            </li>
        </ul>
    </nav>
    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="md:hidden fixed inset-0 bg-white/98 z-20 flex flex-col items-center justify-center space-y-8 text-primary text-xl font-semibold hidden transition-all">
        <button id="close-menu" class="absolute top-6 right-6 text-primary hover:text-primary-dark focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <a href="#" class="flex items-center gap-2 hover:text-primary-dark transition">
            <i class="ti ti-home-2"></i> Accueil
        </a>
        <a href="#" class="flex items-center gap-2 hover:text-primary-dark transition">
            <i class="ti ti-hand-coins"></i> Fonctionnement
        </a>
        <a href="#" class="flex items-center gap-2 hover:text-primary-dark transition">
            <i class="ti ti-mail"></i> Contact
        </a>
    </div>

    <!-- HERO SECTION -->
    <main class="flex-grow flex items-center justify-center px-3 pt-10 pb-8 relative">
        <!-- Animated coins left (animations removed) -->
        <span class="hidden sm:block absolute left-[-60px] top-24 text-primary/30">
            <i class="ti ti-coin text-5xl"></i>
        </span>
        <span class="hidden sm:block absolute left-[18%] top-[86%] text-yellow-400/60">
            <i class="ti ti-coin-euro text-4xl"></i>
        </span>
        <!-- Animated coins right (animations removed) -->
        <span class="hidden md:block absolute right-[8%] top-24 text-green-400/50">
            <i class="ti ti-coin-bitcoin text-5xl"></i>
        </span>
        <span class="hidden md:block absolute right-[4vw] top-[80%] text-primary/20">
            <i class="ti ti-pig-money text-5xl"></i>
        </span>
        <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">

            <!-- TEXTE -->
            <div class="space-y-8 max-w-xl mx-auto md:mx-0">
                <span class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-1 rounded-full text-xs sm:text-sm font-semibold shadow">
                    <i class="ti ti-shield-lock-filled text-lg"></i>
                    Plateforme sécurisée & moderne
                </span>

                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight text-gray-900 drop-shadow-sm flex flex-wrap gap-x-2">
                    Simplifiez votre 
                    <span class="flex items-center gap-1 text-primary bg-primary/5 px-1 rounded-md font-black">
                        <i class="ti ti-currency-dollar text-2xl"></i> collecte journalière
                    </span>
                    <br class="hidden sm:block">d'argent
                </h2>

                <p class="text-gray-700 text-base md:text-lg flex items-center gap-2">
                    <i class="ti ti-report-money text-xl text-primary/80"></i>
                    Bienvenue sur notre plateforme dédiée à la collecte journalière d'argent.
                    Gérez, suivez et sécurisez vos transactions en toute sérénité<br class="hidden sm:block"> avec une interface claire et ergonomique.
                </p>
                
                <!-- CTA -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6 mt-6">
                    <a href="{{ route('login') }}"
                       class="relative inline-flex items-center justify-center gap-2 px-8 sm:px-10 py-3 sm:py-4 font-bold text-white rounded-full overflow-hidden group shadow-soft-green transition-all duration-200 bg-gradient-to-l from-primary via-green-600 to-primary-dark">
                        <span class="absolute inset-0 bg-primary opacity-90 transition-transform duration-300 group-hover:scale-110 rounded-full z-0"></span>
                        <span class="absolute inset-0 bg-gradient-to-r from-primary via-green-600 to-primary-dark opacity-0 group-hover:opacity-95 transition rounded-full z-0"></span>
                        <span class="relative z-10 flex items-center gap-2">
                            <i class="ti ti-login-2 text-lg"></i> Se connecter
                        </span>
                    </a>

                    <span class="text-xs sm:text-sm text-gray-600 self-center flex items-center gap-1">
                        <i class="ti ti-shield-lock text-base text-primary"></i>
                        Accès rapide et sécurisé
                    </span>
                </div>
            </div>

            <!-- CARD VISUELLE -->
            <div class="mt-10 md:mt-0 flex md:justify-end">
                <div class="w-full max-w-md bg-white/80 backdrop-blur-lg rounded-3xl shadow-xl p-5 sm:p-8 border border-white/50 flex flex-col space-y-5 scale-100 hover:scale-105 transition-transform duration-200 animate-breathe">
                    <h3 class="text-lg sm:text-xl font-bold text-primary mb-3 sm:mb-6 text-center flex items-center gap-2 justify-center">
                        <i class="ti ti-stars text-yellow-400"></i> Pourquoi nous choisir ?
                    </h3>
                    <ul class="space-y-3 text-gray-800">
                        <li class="flex items-center space-x-3 group">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full shadow bg-gradient-to-br from-primary to-green-500 text-white group-hover:scale-110 transition-transform animate-bounce-up">
                                <i class="ti ti-currency-dollar"></i>
                            </span>
                            <span class="flex-1">Collecte journalière ultra-rapide</span>
                        </li>
                        <li class="flex items-center space-x-3 group">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gradient-to-br from-yellow-300 to-green-400 text-primary-dark shadow group-hover:scale-110 transition-transform animate-bounce-up delay-100">
                                <i class="ti ti-history"></i>
                            </span>
                            <span class="flex-1">Historique détaillé & traçabilité</span>
                        </li>
                        <li class="flex items-center space-x-3 group">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gradient-to-br from-green-600 to-primary text-white shadow group-hover:scale-110 transition-transform animate-bounce-up delay-200">
                                <i class="ti ti-lock"></i>
                            </span>
                            <span class="flex-1">Sécurité et confidentialité des données</span>
                        </li>
                        <li class="flex items-center space-x-3 group">
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gradient-to-br from-primary to-green-300 text-white shadow group-hover:scale-110 transition-transform animate-bounce-up delay-300">
                                <i class="ti ti-device-desktop-analytics"></i>
                            </span>
                            <span class="flex-1">Interface moderne & intuitive</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="px-5 sm:px-6 py-5 text-center text-xs sm:text-sm text-gray-600 bg-white/80 backdrop-blur border-t border-gray-100 w-full relative">
        <span class="inline-flex items-center gap-2 justify-center">
            <i class="ti ti-cash-banknote text-primary-dark"></i>
            © {{ date('Y') }} <span class="font-semibold text-primary">Collecte+</span> · Plateforme professionnelle de collecte d'argent
        </span>
    </footer>

</div>
<!-- Fast Icons Animations -->
<style>
@keyframes spin-slow {
  to { transform: rotate(360deg);}
}
.animate-spin-slow {
  animation: spin-slow 4.8s linear infinite;
}
</style>
<script>
document.getElementById('menu-toggle').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
});
document.getElementById('close-menu').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
});
</script>
</body>
</html>