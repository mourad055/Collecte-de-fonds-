{{-- 
    =========================
    AIDE POUR LE CONTRÔLEUR :
    =========================
    Pour que l'affichage fonctionne correctement sur ce reçu, assure-toi de passer les bons paramètres à la vue depuis ton contrôleur `PaiementController`.
    
    Il faut impérativement que tu passes soit un objet $client (avec nom_cli et prenom_cli), 
    soit (au moins) $nom ou $nom_cli, voire $prenom_cli si tu veux qu'ils s'affichent.
    
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
    
    Sinon, tu peux ajuster l'affichage ici pour utiliser uniquement les variables $nom, $prenom, etc.

    Relis le code de ton contrôleur pour vérifier que tu récupères bien le client lié au paiement !
--}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0E8D4D, #22c55e);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .recu {
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 20px;
            width: 600px;
            color: #1f2937;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        h2 {
            text-align: center;
            color: #0E8D4D;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }
        hr {
            border: none;
            border-top: 1px solid #d1d5db;
            margin: 20px 0;
        }
        .actions {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }
        button {
            flex: 1;
            padding: 12px;
            border-radius: 12px;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }
        .print {
            background: linear-gradient(135deg, #0E8D4D, #22c55e);
            color: white;
        }
        .pdf {
            background: white;
            color: #0E8D4D;
            border: 2px solid #0E8D4D;
        }
        .pdf:hover {
            background: #0E8D4D;
            color: white;
        }
    </style>
</head>
<body>
    <div class="recu">
        <h2>🧾 Reçu de paiement</h2>
        <p><strong>N° Reçu :</strong> {{ $numero_recu }}</p>

        {{-- Récupération et affichage du nom complet du client sélectionné --}}
        <div class="row">
            <span>Client</span>
            <span>
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
            </span>
        </div>
        <div class="row"><span>Référence</span><span>{{ $reference ?? '-' }}</span></div>
        <div class="row"><span>Date</span><span>{{ \Carbon\Carbon::parse($date_paiement)->format('d/m/Y') }}</span></div>
        <div class="row"><span>Mode</span><span>{{ $mode_paiement }}</span></div>

        <hr>

        <div class="row">
            <strong>Montant</strong>
            <strong>{{ number_format($montant, 0, ',', ' ') }} FCFA</strong>
        </div>

        <div class="actions">
            <button class="print" onclick="window.print()">🖨️ Imprimer</button>
            <form action="{{ route('recu.pdf') }}" method="POST" style="margin:0;">
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
                <button class="pdf">📄 PDF</button>
            </form>
        </div>
    </div>
</body>
</html>
