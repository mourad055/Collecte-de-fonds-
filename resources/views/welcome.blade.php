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
                        bounceUp: {
                            '0%,100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-8px)' }
                        },
                        breathe: {
                            '0%,100%': {boxShadow: '0 0 16px 0 rgba(14,141,77,0.10)'},
                            '50%': {boxShadow: '0 0 30px 4px rgba(14,141,77,0.16)'}
                        },
                        slideInRight: {
                            '0%': { opacity: '0', transform: 'translateX(100px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        }
                    },
                    animation: {
                        'bounce-up': 'bounceUp 1.5s infinite',
                        'breathe': 'breathe 2.5s infinite',
                        'slide-in-right': 'slideInRight 0.6s ease-out',
                        'fade-in': 'fadeIn 0.8s ease-out'
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
    <nav class="w-full px-4 sm:px-8 py-5 flex justify-between items-center bg-white/90 backdrop-blur-md shadow-md sticky top-0 z-50">
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
                <a href="#" class="flex items-center gap-1 text-primary transition">
                    <i class="ti ti-home-2"></i> Accueil
                </a>
            </li>
            <li>
                <a href="{{ route('fonctionnement') }}" class="flex items-center gap-1 hover:text-primary transition">
                    <i class="ti ti-hand-coins"></i> Fonctionnement
                </a>
            </li>
            <li>
                <a href="{{ route('contact') }}" class="flex items-center gap-1 hover:text-primary transition">
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
        <a href="#" class="flex items-center gap-2 text-primary-dark transition">
            <i class="ti ti-home-2"></i> Accueil
        </a>
        <a href="{{ route('fonctionnement') }}" class="flex items-center gap-2 hover:text-primary-dark transition">
            <i class="ti ti-hand-coins"></i> Fonctionnement
        </a>
        <a href="{{ route('contact') }}" class="flex items-center gap-2 hover:text-primary-dark transition">
            <i class="ti ti-mail"></i> Contact
        </a>
    </div>

    <!-- HERO SECTION -->
    <main class="flex-grow flex items-center justify-center px-3 pt-10 pb-8 relative">
        <!-- Animated coins left -->
        <span class="hidden sm:block absolute left-[-60px] top-24 text-primary/30">
            <i class="ti ti-coin text-5xl"></i>
        </span>
        <span class="hidden sm:block absolute left-[18%] top-[86%] text-yellow-400/60">
            <i class="ti ti-coin-euro text-4xl"></i>
        </span>
        <!-- Animated coins right -->
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
                       class="relative inline-flex items-center justify-center gap-2 px-8 sm:px-10 py-3 sm:py-4 font-bold text-white rounded-full overflow-hidden group shadow-soft-green transition-all duration-200 bg-gradient-to-l from-primary via-green-600 to-primary-dark hover:shadow-xl hover:scale-105">
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

    <!-- SECTION STATISTIQUES -->
    <section class="relative px-4 sm:px-8 py-16 bg-gradient-to-r from-primary to-green-600">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Stat 1 -->
                <div class="text-center text-white animate-fade-in">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-users text-3xl"></i>
                    </div>
                    <div class="text-4xl font-extrabold mb-2">12,000+</div>
                    <div class="text-white/90 font-medium">Utilisateurs actifs</div>
                </div>
                <!-- Stat 2 -->
                <div class="text-center text-white animate-fade-in" style="animation-delay: 0.1s">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-cash text-3xl"></i>
                    </div>
                    <div class="text-4xl font-extrabold mb-2">500K+</div>
                    <div class="text-white/90 font-medium">Collectes réalisées</div>
                </div>
                <!-- Stat 3 -->
                <div class="text-center text-white animate-fade-in" style="animation-delay: 0.2s">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-shield-check text-3xl"></i>
                    </div>
                    <div class="text-4xl font-extrabold mb-2">100%</div>
                    <div class="text-white/90 font-medium">Transactions sécurisées</div>
                </div>
                <!-- Stat 4 -->
                <div class="text-center text-white animate-fade-in" style="animation-delay: 0.3s">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-clock-24 text-3xl"></i>
                    </div>
                    <div class="text-4xl font-extrabold mb-2">24/7</div>
                    <div class="text-white/90 font-medium">Support disponible</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CARROUSEL DE TÉMOIGNAGES -->
    <section class="relative px-4 sm:px-8 py-20 bg-white/60 backdrop-blur-sm">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 bg-primary/10 text-primary px-5 py-2 rounded-full text-sm font-semibold mb-4">
                    <i class="ti ti-message-star"></i>
                    Ce qu'ils disent de nous
                </span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                    Nos clients sont <span class="text-primary">ravis</span>
                </h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Découvrez les témoignages de ceux qui utilisent quotidiennement notre plateforme
                </p>
            </div>

            <!-- CAROUSEL CONTAINER -->
            <div class="relative">
                <div class="overflow-hidden">
                    <div id="carousel-track" class="flex transition-transform duration-500 ease-out">
                        
                        <!-- Témoignage 1 -->
                        <div class="carousel-slide min-w-full px-4">
                            <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl p-8 sm:p-12 border border-gray-100">
                                <div class="flex items-center gap-1 mb-6 justify-center">
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-700 text-lg sm:text-xl leading-relaxed text-center mb-8 italic">
                                    "Collecte+ a révolutionné notre façon de gérer les collectes quotidiennes. Interface intuitive, rapide et sécurisée. Je recommande vivement !"
                                </p>
                                <div class="flex items-center gap-4 justify-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-green-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                        MK
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-lg">Marie Kamga</div>
                                        <div class="text-gray-600">Gérante, Douala</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Témoignage 2 -->
                        <div class="carousel-slide min-w-full px-4">
                            <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl p-8 sm:p-12 border border-gray-100">
                                <div class="flex items-center gap-1 mb-6 justify-center">
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-700 text-lg sm:text-xl leading-relaxed text-center mb-8 italic">
                                    "Un outil indispensable pour notre entreprise. La traçabilité des transactions nous a fait gagner un temps précieux. Service client au top !"
                                </p>
                                <div class="flex items-center gap-4 justify-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-primary rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                        JN
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-lg">Jean Nkoa</div>
                                        <div class="text-gray-600">Directeur Commercial, Yaoundé</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Témoignage 3 -->
                        <div class="carousel-slide min-w-full px-4">
                            <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl p-8 sm:p-12 border border-gray-100">
                                <div class="flex items-center gap-1 mb-6 justify-center">
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                    <i class="ti ti-star-filled text-yellow-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-700 text-lg sm:text-xl leading-relaxed text-center mb-8 italic">
                                    "Simplicité et efficacité sont au rendez-vous ! Mes équipes adorent la plateforme et les rapports automatiques nous facilitent vraiment la vie."
                                </p>
                                <div class="flex items-center gap-4 justify-center">
                                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-green-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                                        AT
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-lg">Aissatou Toure</div>
                                        <div class="text-gray-600">Comptable, Limbe</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Boutons de navigation -->
                <button id="prev-btn" class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 sm:-translate-x-6 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all hover:scale-110 z-10">
                    <i class="ti ti-chevron-left text-2xl"></i>
                </button>
                <button id="next-btn" class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 sm:translate-x-6 w-12 h-12 bg-white rounded-full shadow-lg flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all hover:scale-110 z-10">
                    <i class="ti ti-chevron-right text-2xl"></i>
                </button>

                <!-- Indicateurs -->
                <div class="flex justify-center gap-3 mt-8">
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-primary transition-all" data-index="0"></button>
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 transition-all" data-index="1"></button>
                    <button class="carousel-indicator w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400 transition-all" data-index="2"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="px-5 sm:px-6 py-5 text-center text-xs sm:text-sm text-gray-600 bg-white/80 backdrop-blur border-t border-gray-100 w-full relative">
        <span class="inline-flex items-center gap-2 justify-center">
            <i class="ti ti-cash-banknote text-primary-dark"></i>
            © {{ date('Y') }} <span class="font-semibold text-primary">Collecte+</span> · Plateforme professionnelle de collecte d'argent
        </span>
    </footer>

</div>

<!-- Styles et Scripts -->
<style>
@keyframes spin-slow {
  to { transform: rotate(360deg);}
}
.animate-spin-slow {
  animation: spin-slow 4.8s linear infinite;
}
</style>

<script>
// Menu mobile
document.getElementById('menu-toggle').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
});
document.getElementById('close-menu').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
});

// Carrousel
let currentSlide = 0;
const slides = document.querySelectorAll('.carousel-slide');
const totalSlides = slides.length;
const track = document.getElementById('carousel-track');
const indicators = document.querySelectorAll('.carousel-indicator');

function updateCarousel() {
    track.style.transform = `translateX(-${currentSlide * 100}%)`;
    
    indicators.forEach((indicator, index) => {
        if (index === currentSlide) {
            indicator.classList.add('bg-primary', 'w-8');
            indicator.classList.remove('bg-gray-300');
        } else {
            indicator.classList.remove('bg-primary', 'w-8');
            indicator.classList.add('bg-gray-300');
        }
    });
}

document.getElementById('next-btn').addEventListener('click', () => {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
});

document.getElementById('prev-btn').addEventListener('click', () => {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateCarousel();
});

indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
        currentSlide = index;
        updateCarousel();
    });
});

// Auto-play du carrousel (optionnel)
setInterval(() => {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
}, 6000); // Change toutes les 6 secondes
</script>
</body>
</html>