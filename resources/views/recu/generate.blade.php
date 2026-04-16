<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de paiement #{{ $numero_recu }} | Collecte+</title>
    
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
                    }
                }
            }
        }
    </script>
    
    <style>
        @media print {
            body {
                background: white !important;
            }
            .no-print {
                display: none !important;
            }
            .receipt-container {
                box-shadow: none !important;
                max-width: 100% !important;
            }
        }
        
        body {
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .receipt-container {
            animation: slideIn 0.6s ease-out;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="receipt-container w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden">
        
        <!-- Header avec logo et badge -->
        <div class="bg-gradient-to-r from-primary to-green-600 p-8 text-white relative overflow-hidden">
            <!-- Decoration circles -->
            <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-16 -mb-16"></div>
            
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center">
                            <i class="ti ti-coins text-4xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-extrabold">Collecte+</h1>
                            <p class="text-sm text-white/90">Plateforme de collecte</p>
                        </div>
                    </div>
                    <div class="bg-white/20 backdrop-blur px-4 py-2 rounded-xl">
                        <i class="ti ti-circle-check-filled text-2xl"></i>
                    </div>
                </div>
                
                <div class="mt-6">
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur px-4 py-2 rounded-full">
                        <i class="ti ti-receipt"></i>
                        <span class="text-sm font-semibold">Reçu de paiement</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="p-8">
            
            <!-- Numéro de reçu -->
            <div class="text-center mb-8 pb-6 border-b-2 border-gray-200">
                <p class="text-sm text-gray-600 mb-2">Numéro de reçu</p>
                <h2 class="text-4xl font-extrabold text-primary">{{ $numero_recu }}</h2>
            </div>

            <!-- Informations du paiement -->
            <div class="space-y-4 mb-8">
                
                <!-- Client -->
                <div class="flex items-start justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                            <i class="ti ti-user text-2xl text-primary"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Client</p>
                            <p class="font-bold text-gray-800 text-lg">
                                @if(isset($client) && $client)
                                    {{ $client->nom_cli }} 
                                    @if(!empty($client->prenom_cli))
                                        {{ ' ' . $client->prenom_cli }}
                                    @endif
                                @elseif(isset($nom_cli))
                                    {{ $nom_cli }}
                                    @if(!empty($prenom_cli))
                                        {{ ' ' . $prenom_cli }}
                                    @endif
                                @elseif(isset($nom))
                                    {{ $nom }}
                                    @if(!empty($prenom))
                                        {{ ' ' . $prenom }}
                                    @endif
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Référence -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                            <i class="ti ti-hash text-2xl text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Référence</p>
                            <p class="font-semibold text-gray-800">{{ $reference ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Date -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                            <i class="ti ti-calendar text-2xl text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Date de paiement</p>
                            <p class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($date_paiement)->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Mode de paiement -->
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                            <i class="ti ti-wallet text-2xl text-orange-600"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Mode de paiement</p>
                            <p class="font-semibold text-gray-800">{{ $mode_paiement }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Montant total -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-2xl p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Montant payé</p>
                        <p class="text-4xl font-extrabold text-primary">{{ number_format($montant, 0, ',', ' ') }} <span class="text-2xl">FCFA</span></p>
                    </div>
                    <div class="w-20 h-20 bg-primary/20 rounded-full flex items-center justify-center">
                        <i class="ti ti-cash text-4xl text-primary"></i>
                    </div>
                </div>
            </div>

            <!-- Informations additionnelles -->
            <div class="p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg mb-8">
                <div class="flex items-start gap-3">
                    <i class="ti ti-info-circle text-2xl text-blue-500 mt-1"></i>
                    <div>
                        <p class="text-sm font-semibold text-blue-800 mb-1">Reçu valide</p>
                        <p class="text-xs text-blue-700">Ce reçu certifie le paiement effectué. Conservez-le comme preuve de transaction. En cas de litige, présentez ce document.</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="no-print flex flex-col sm:flex-row gap-4">
                <button onclick="window.print()" 
                        class="flex-1 flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-primary to-green-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                    <i class="ti ti-printer text-2xl"></i>
                    <span>Imprimer le reçu</span>
                </button>
                
                <form action="{{ route('recu.pdf') }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="numero_recu" value="{{ $numero_recu }}">
                    @if(isset($client) && $client)
                        <input type="hidden" name="nom" value="{{ $client->nom_cli }}">
                        <input type="hidden" name="prenom" value="{{ $client->prenom_cli }}">
                    @elseif(isset($nom_cli))
                        <input type="hidden" name="nom" value="{{ $nom_cli }}">
                        <input type="hidden" name="prenom" value="{{ $prenom_cli }}">
                    @elseif(isset($nom))
                        <input type="hidden" name="nom" value="{{ $nom }}">
                        <input type="hidden" name="prenom" value="{{ $prenom }}">
                    @endif
                    <input type="hidden" name="reference" value="{{ $reference }}">
                    <input type="hidden" name="montant" value="{{ $montant }}">
                    <input type="hidden" name="mode_paiement" value="{{ $mode_paiement }}">
                    <input type="hidden" name="date_paiement" value="{{ $date_paiement }}">
                    
                    
                </form>
            </div>

        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <i class="ti ti-shield-check text-primary"></i>
                    <span>Paiement sécurisé et certifié</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ti ti-calendar text-primary"></i>
                    <span>Généré le {{ now()->format('d/m/Y à H:i') }}</span>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Animation d'apparition
        window.addEventListener('load', function() {
            const receipt = document.querySelector('.receipt-container');
            receipt.style.opacity = '0';
            receipt.style.transform = 'translateY(-30px)';
            
            setTimeout(() => {
                receipt.style.transition = 'all 0.6s ease-out';
                receipt.style.opacity = '1';
                receipt.style.transform = 'translateY(0)';
            }, 100);
        });

        // Impression automatique si paramètre ?print=1 dans l'URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === '1') {
            setTimeout(() => window.print(), 500);
        }
    </script>

</body>
</html>

{{-- 
    =========================
    AIDE POUR LE CONTRÔLEUR :
    =========================
    Pour que l'affichage fonctionne correctement sur ce reçu, assure-toi de passer les bons paramètres à la vue depuis ton contrôleur `PaiementController`.
    
    Exemple minimum à passer dans le return du contrôleur (dans la méthode store()) :
        return view('recu.generate', [
            'numero_recu'   => $numero_recu,
            'nom'           => $paiement->client->nom_cli ?? '',
            'prenom'        => $paiement->client->prenom_cli ?? '',
            'reference'     => $validated['reference'] ?? '',
            'montant'       => $paiement->montant_paie,
            'mode_paiement' => $validated['mode_paiement'],
            'date_paiement' => $validated['date_paiement'],
        ]);
    
    ⚠️ Si tu veux utiliser $client directement dans la vue, passe-le aussi dans le tableau du return :
        'client' => $paiement->client,
    
    Pour impression automatique, ajoute ?print=1 à l'URL de redirection :
        return redirect()->route('recu.generate', ['id' => $paiement->id])->with('print', true);
--}}