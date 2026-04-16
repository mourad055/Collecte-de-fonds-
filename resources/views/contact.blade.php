<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact - Collecte+</title>
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
                        slideIn: {
                            '0%': { opacity: '0', transform: 'translateX(-30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' }
                        }
                    },
                    animation: {
                        'slide-in': 'slideIn 0.6s ease-out',
                        'float': 'float 3s ease-in-out infinite'
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
        <li><a href="{{ route('fonctionnement') }}" class="flex items-center gap-1 hover:text-primary transition"><i class="ti ti-hand-coins"></i> Fonctionnement</a></li>
        <li><a href="{{ route('contact') }}" class="flex items-center gap-1 text-primary"><i class="ti ti-mail"></i> Contact</a></li>
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
    <a href="{{ route('fonctionnement') }}" class="flex items-center gap-2 hover:text-primary-dark transition"><i class="ti ti-hand-coins"></i> Fonctionnement</a>
    <a href="{{ route('contact') }}" class="flex items-center gap-2 text-primary-dark"><i class="ti ti-mail"></i> Contact</a>
</div>

<!-- HERO SECTION -->
<section class="px-4 sm:px-8 py-16 text-center">
    <div class="max-w-4xl mx-auto animate-slide-in">
        <span class="inline-flex items-center gap-2 bg-primary/10 text-primary px-5 py-2 rounded-full text-sm font-semibold mb-6">
            <i class="ti ti-message-circle text-lg"></i>
            Nous sommes à votre écoute
        </span>
        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 mb-6">
            Contactez-<span class="text-primary">nous</span>
        </h1>
        <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
            Une question ? Une suggestion ? Notre équipe est là pour vous accompagner
        </p>
    </div>
</section>

<!-- SECTION PRINCIPALE -->
<section class="px-4 sm:px-8 py-16">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- FORMULAIRE DE CONTACT -->
        <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-xl border border-gray-100">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
                <i class="ti ti-send text-primary"></i>
                Envoyez-nous un message
            </h2>
            
            <form id="contact-form" class="space-y-6">
                <!-- Nom complet -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Nom complet <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ti ti-user text-gray-400"></i>
                        </div>
                        <input type="text" required 
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                               placeholder="Votre nom complet">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Adresse email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ti ti-mail text-gray-400"></i>
                        </div>
                        <input type="email" required 
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                               placeholder="votre@email.com">
                    </div>
                </div>

                <!-- Téléphone -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Téléphone
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ti ti-phone text-gray-400"></i>
                        </div>
                        <input type="tel" 
                               class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                               placeholder="+237 6XX XXX XXX">
                    </div>
                </div>

                <!-- Sujet -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Sujet <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="ti ti-bookmark text-gray-400"></i>
                        </div>
                        <select required 
                                class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none appearance-none bg-white">
                            <option value="">Sélectionnez un sujet</option>
                            <option value="info">Demande d'information</option>
                            <option value="support">Support technique</option>
                            <option value="commercial">Question commerciale</option>
                            <option value="autre">Autre</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i class="ti ti-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Votre message <span class="text-red-500">*</span>
                    </label>
                    <textarea required rows="5"
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none resize-none"
                              placeholder="Décrivez votre demande en détail..."></textarea>
                </div>

                <!-- Bouton d'envoi -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-primary to-green-600 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center justify-center gap-2 group">
                    <i class="ti ti-send text-xl group-hover:translate-x-1 transition-transform"></i>
                    Envoyer le message
                </button>
            </form>
        </div>

        <!-- INFORMATIONS DE CONTACT -->
        <div class="space-y-8">
            <!-- Carte d'information 1 -->
            <div class="bg-gradient-to-br from-primary to-green-600 text-white p-8 rounded-3xl shadow-xl animate-float">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="ti ti-map-pin text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Notre adresse</h3>
                        <p class="opacity-90 leading-relaxed">
                           
                            Ambam, region du sud<br>
                            Cameroun
                        </p>
                    </div>
                </div>
            </div>

            <!-- Carte d'information 2 -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 animate-float" style="animation-delay: 0.5s">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary to-green-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="ti ti-phone text-3xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Téléphone</h3>
                        <p class="text-gray-600 leading-relaxed">
                            <a href="tel:+237XXXXXXXXX" class="hover:text-primary transition">+237 697 07 44 55</a><br>
                            <span class="text-sm text-gray-500">Lun - Ven : 8h - 18h</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Carte d'information 3 -->
            <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 animate-float" style="animation-delay: 1s">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-primary rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="ti ti-mail text-3xl text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Email</h3>
                        <p class="text-gray-600 leading-relaxed">
                            <a href="mailto:contact@collecte.com" class="hover:text-primary transition">contact@collecteplus.com</a><br>
                            <a href="mailto:support@collecte.com" class="hover:text-primary transition">support@collecteplus.com</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Réseaux sociaux -->
            <div class="bg-gradient-to-br from-gray-50 to-green-50 p-8 rounded-3xl border border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i class="ti ti-share text-primary"></i>
                    Suivez-nous
                </h3>
                <div class="flex gap-4">
                    <a href="#" class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all shadow-md hover:shadow-lg hover:scale-110">
                        <i class="ti ti-brand-facebook text-2xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all shadow-md hover:shadow-lg hover:scale-110">
                        <i class="ti ti-brand-twitter text-2xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all shadow-md hover:shadow-lg hover:scale-110">
                        <i class="ti ti-brand-linkedin text-2xl"></i>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all shadow-md hover:shadow-lg hover:scale-110">
                        <i class="ti ti-brand-instagram text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HORAIRES D'OUVERTURE -->
<section class="px-4 sm:px-8 py-16 bg-white">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-12">
            Nos <span class="text-primary">horaires</span>
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-2xl border border-gray-200">
                <p class="font-semibold text-gray-900 mb-2">Lundi - Vendredi</p>
                <p class="text-primary font-bold text-lg">8h00 - 18h00</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-2xl border border-gray-200">
                <p class="font-semibold text-gray-900 mb-2">Samedi</p>
                <p class="text-primary font-bold text-lg">9h00 - 14h00</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-2xl border border-gray-200">
                <p class="font-semibold text-gray-900 mb-2">Dimanche</p>
                <p class="text-gray-500 font-bold text-lg">Fermé</p>
            </div>
        </div>
    </div>
</section>

<!-- SECTION CARTE (OPTIONNELLE) -->
<section class="px-4 sm:px-8 py-16 bg-gradient-to-br from-gray-50 to-green-50">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl sm:text-4xl font-bold text-center text-gray-900 mb-12">
            Où nous <span class="text-primary">trouver</span> ?
        </h2>
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Vous pouvez intégrer ici Google Maps ou une carte interactive -->
            <img src="{{ asset('images/localisation.png') }}" alt="Localisation" class="w-full h-80 object-cover">
        </div>
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
            <a href="#" class="hover:text-primary transition">CGU</a>
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

// Gestion du formulaire
document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Ici vous ajouterez la logique d'envoi du formulaire
    // Par exemple via AJAX vers votre backend Laravel
    
    // Animation de succès temporaire
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="ti ti-check text-xl"></i> Message envoyé !';
    btn.classList.add('bg-green-600');
    
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.classList.remove('bg-green-600');
        this.reset();
    }, 3000);
});
</script>
</body>
</html>