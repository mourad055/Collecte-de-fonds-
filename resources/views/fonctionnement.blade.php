<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fonctionnement - Collecte+</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
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
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.9)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' }
                        }
                    },
                    animation: {
                        'fade-in-up': 'fadeInUp 0.6s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-out'
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-green-50">

<!-- NAVBAR -->
<nav class="w-full px-4 sm:px-8 py-5 flex justify-between items-center bg-white/95 backdrop-blur-md shadow-md sticky top-0 z-50">
    <div class="flex items-center gap-2">
        <span class="text-primary">
            <i class="ti ti-coins text-3xl sm:text-4xl"></i>
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-primary tracking-wide">
            Collecte+
        </h1>
    </div>
    <button id="menu-toggle" class="md:hidden focus:outline-none text-primary-dark hover:bg-primary/10 p-2 rounded-lg">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <ul id="nav-links" class="hidden md:flex space-x-8 text-base font-semibold">
        <li><a href="/" class="flex items-center gap-1 hover:text-primary transition"><i class="ti ti-home-2"></i> Accueil</a></li>
        <li><a href="{{ route('fonctionnement') }}" class="flex items-center gap-1 text-primary"><i class="ti ti-hand-coins"></i> Fonctionnement</a></li>
        <li><a href="{{ route('contact') }}" class="flex items-center gap-1 hover:text-primary transition"><i class="ti ti-mail"></i> Contact</a></li>
    </ul>
</nav>

<!-- MOBILE MENU -->
<div id="mobile-menu" class="md:hidden fixed inset-0 bg-white/98 z-50 flex flex-col items-center justify-center space-y-8 text-primary text-xl font-semibold hidden">
    <button id="close-menu" class="absolute top-6 right-6 text-primary hover:text-primary-dark">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
    <a href="/" class="flex items-center gap-2 hover:text-primary-dark transition"><i class="ti ti-home-2"></i> Accueil</a>
    <a href="{{ route('fonctionnement') }}" class="flex items-center gap-2 text-primary-dark"><i class="ti ti-hand-coins"></i> Fonctionnement</a>
    <a href="{{ route('contact') }}" class="flex items-center gap-2 hover:text-primary-dark transition"><i class="ti ti-mail"></i> Contact</a>
</div>

<!-- HERO SECTION -->
<section class="px-4 sm:px-8 py-16 text-center">
    <div class="max-w-4xl mx-auto animate-fade-in-up">
        <span class="inline-flex items-center gap-2 bg-primary/10 text-primary px-5 py-2 rounded-full text-sm font-semibold mb-6">
            <i class="ti ti-bulb-filled text-lg"></i>
            Découvrez notre solution
        </span>
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 mb-6">
            Comment ça <span class="text-primary">fonctionne</span> ?
        </h1>
        
    </div>
</section>

<!-- ÉTAPES DE FONCTIONNEMENT -->
<section class="px-4 sm:px-8 py-16 bg-white">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-bold text-center text-gray-900 mb-16">
            En <span class="text-primary">4 étapes simples</span>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Étape 1 -->
            <div class="text-center group animate-scale-in">
                <div class="relative mx-auto w-24 h-24 mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary to-green-400 rounded-full opacity-20 group-hover:scale-110 transition-transform"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-primary to-green-500 rounded-full flex items-center justify-center text-white shadow-lg group-hover:shadow-xl transition-shadow">
                        <i class="ti ti-user-plus text-4xl"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 bg-white text-primary font-bold w-8 h-8 rounded-full flex items-center justify-center shadow-md border-2 border-primary">1</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Inscription</h3>
                <p class="text-gray-600">Pour commencer, vous devez vous inscrire sur la plateforme. Cette étape est essentielle pour créer votre compte et accéder à vos données.</p>
            </div>

            <!-- Étape 2 -->
            <div class="text-center group animate-scale-in" style="animation-delay: 0.1s">
                <div class="relative mx-auto w-24 h-24 mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-primary rounded-full opacity-20 group-hover:scale-110 transition-transform"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-green-500 to-primary rounded-full flex items-center justify-center text-white shadow-lg group-hover:shadow-xl transition-shadow">
                        <i class="ti ti-settings text-4xl"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 bg-white text-primary font-bold w-8 h-8 rounded-full flex items-center justify-center shadow-md border-2 border-primary">2</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Configuration</h3>
                <p class="text-gray-600">Une fois votre compte créé, vous pouvez configurer votre plateforme en fonction de vos besoins. Vous pouvez ajouter des collecteurs, des clients, des produits, etc.</p>
            </div>

            <!-- Étape 3 -->
            <div class="text-center group animate-scale-in" style="animation-delay: 0.2s">
                <div class="relative mx-auto w-24 h-24 mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary to-green-600 rounded-full opacity-20 group-hover:scale-110 transition-transform"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white shadow-lg group-hover:shadow-xl transition-shadow">
                        <i class="ti ti-cash text-4xl"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 bg-white text-primary font-bold w-8 h-8 rounded-full flex items-center justify-center shadow-md border-2 border-primary">3</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Collecte</h3>
                <p class="text-gray-600">Vous pouvez collecter les données de vos clients en utilisant notre plateforme. Vous pouvez ajouter des collecteurs, des clients, des produits, etc.</p>
            </div>

            <!-- Étape 4 -->
            <div class="text-center group animate-scale-in" style="animation-delay: 0.3s">
                <div class="relative mx-auto w-24 h-24 mb-6">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-600 to-primary-dark rounded-full opacity-20 group-hover:scale-110 transition-transform"></div>
                    <div class="relative w-full h-full bg-gradient-to-br from-green-600 to-primary-dark rounded-full flex items-center justify-center text-white shadow-lg group-hover:shadow-xl transition-shadow">
                        <i class="ti ti-chart-line text-4xl"></i>
                    </div>
                    <span class="absolute -top-2 -right-2 bg-white text-primary font-bold w-8 h-8 rounded-full flex items-center justify-center shadow-md border-2 border-primary">4</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Suivi</h3>
                <p class="text-gray-600">Vous pouvez suivre les données de vos clients en utilisant notre plateforme. Vous pouvez ajouter des collecteurs, des clients, des produits, etc.</p>
            </div>
        </div>
    </div>
</section>

<!-- FONCTIONNALITÉS CLÉS -->
<section class="px-4 sm:px-8 py-16 bg-gradient-to-br from-green-50 to-white">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-bold text-center text-gray-900 mb-4">
            Fonctionnalités <span class="text-primary">principales</span>
        </h2>
        <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">
            Notre plateforme de collecte journalière est conçue pour simplifier la gestion de vos collecte d'argent. Elle vous permet de collecter, de suivre et d'analyser vos données de manière efficace.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Fonctionnalité 1 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all group border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-green-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="ti ti-shield-check text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Sécurité maximale</h3>
                <p class="text-gray-600 leading-relaxed">Notre plateforme est conçue pour être sécurisée et conforme aux normes de sécurité les plus strictes. Nous utilisons des technologies de pointe pour protéger vos données et vous assurer que vos transactions sont protégées.</p>
            </div>

            <!-- Fonctionnalité 2 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all group border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-primary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="ti ti-report-analytics text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Rapports détaillés</h3>
                <p class="text-gray-600 leading-relaxed">Notre plateforme vous permet de générer des rapports détaillés de vos collectes. Vous pouvez exporter vos données en format PDF, CSV, etc.</p>
            </div>

            <!-- Fonctionnalité 3 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all group border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-green-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="ti ti-bell-ringing text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Notifications temps réel</h3>
                <p class="text-gray-600 leading-relaxed">Notre plateforme vous permet de recevoir des notifications en temps réel de vos collectes. Vous pouvez configurer vos notifications pour recevoir des alertes par email, par SMS, etc.</p>
            </div>

            <!-- Fonctionnalité 4 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all group border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-green-600 to-primary-dark rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="ti ti-users-group text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Gestion multi-utilisateurs</h3>
                <p class="text-gray-600 leading-relaxed">Notre plateforme vous permet de gérer plusieurs utilisateurs. Vous pouvez ajouter des utilisateurs, modifier leurs permissions, etc.</p>
            </div>

            <!-- Fonctionnalité 5 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all group border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-green-400 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="ti ti-cloud-download text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Export de données</h3>
                <p class="text-gray-600 leading-relaxed">Notre plateforme vous permet d'exporter vos données en format PDF, CSV, etc. Vous pouvez exporter vos données de manière sécurisée et conforme aux normes de sécurité les plus strictes.</p>
            </div>

            <!-- Fonctionnalité 6 -->
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all group border border-gray-100">
                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-primary rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="ti ti-device-mobile text-3xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Application mobile</h3>
                <p class="text-gray-600 leading-relaxed">Notre plateforme est accessible sur mobile. Vous pouvez collecter des données de manière sécurisée et conforme aux normes de sécurité les plus strictes.</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ SECTION -->
<section class="px-4 sm:px-8 py-16 bg-white">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-bold text-center text-gray-900 mb-4">
            Questions <span class="text-primary">fréquentes</span>
        </h2>
        <p class="text-center text-gray-600 mb-12">
            Trouvez rapidement les réponses à vos questions
        </p>

        <div class="space-y-4">
            <!-- Question 1 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900 pr-4">Comment puis-je commencer à utiliser la plateforme ?</span>
                    <i class="ti ti-chevron-down text-primary text-xl faq-icon transition-transform"></i>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-gray-600">
                    Pour commencer, vous devez vous inscrire sur la plateforme. Cette étape est essentielle pour créer votre compte et accéder à vos données.
                </div>
            </div>

            <!-- Question 2 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900 pr-4">Quelle est la sécurité de mes données ?</span>
                    <i class="ti ti-chevron-down text-primary text-xl faq-icon transition-transform"></i>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-gray-600">
                    Notre plateforme est conçue pour être sécurisée et conforme aux normes de sécurité les plus strictes. Nous utilisons des technologies de pointe pour protéger vos données et vous assurer que vos transactions sont protégées.
                </div>
            </div>

            <!-- Question 3 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900 pr-4">Puis-je accéder à l'application depuis mon mobile ?</span>
                    <i class="ti ti-chevron-down text-primary text-xl faq-icon transition-transform"></i>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-gray-600">
                    Notre plateforme est accessible sur mobile. Vous pouvez collecter des données de manière sécurisée et conforme aux normes de sécurité les plus strictes.
                </div>
            </div>

            <!-- Question 4 -->
            <div class="border border-gray-200 rounded-xl overflow-hidden">
                <button class="faq-btn w-full px-6 py-5 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <span class="font-semibold text-gray-900 pr-4">Y a-t-il des frais d'utilisation ?</span>
                    <i class="ti ti-chevron-down text-primary text-xl faq-icon transition-transform"></i>
                </button>
                <div class="faq-content hidden px-6 pb-5 text-gray-600">
                    Notre plateforme est gratuite. Vous pouvez utiliser notre plateforme sans aucun frais.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="px-4 sm:px-8 py-20 bg-gradient-to-br from-primary to-green-600 text-white text-center">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-6">
            Prêt à simplifier votre collecte ?
        </h2>
        <p class="text-lg sm:text-xl mb-10 opacity-90">
            Rejoignez-nous dès aujourd'hui et découvrez la différence
        </p>
        <a href="/login" class="inline-flex items-center gap-3 bg-white text-primary px-10 py-4 rounded-full font-bold text-lg shadow-xl hover:shadow-2xl hover:scale-105 transition-all">
            <i class="ti ti-rocket text-2xl"></i>
            Commencer maintenant
        </a>
    </div>
</section>

<!-- FOOTER -->
<footer class="px-5 sm:px-6 py-8 text-center text-sm text-gray-600 bg-white border-t border-gray-100">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <span class="flex items-center gap-2">
            <i class="ti ti-cash-banknote text-primary"></i>
            © 2026 <span class="font-semibold text-primary">Collecte+</span>
        </span>
        <div class="flex gap-6 text-sm">
            <a href="#" class="hover:text-primary transition">Mentions légales</a>
            <a href="#" class="hover:text-primary transition">Confidentialité</a>
            <a href="/contact" class="hover:text-primary transition">Contact</a>
        </div>
    </div>
</footer>

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

// FAQ accordion
document.querySelectorAll('.faq-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const content = this.nextElementSibling;
        const icon = this.querySelector('.faq-icon');
        
        document.querySelectorAll('.faq-content').forEach(c => {
            if(c !== content) {
                c.classList.add('hidden');
                c.previousElementSibling.querySelector('.faq-icon').classList.remove('rotate-180');
            }
        });
        
        content.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    });
});
</script>
</body>
</html>