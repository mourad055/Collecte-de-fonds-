<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #dddfdeff, #e7e8e7ff);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 20px;
            width: 420px;
            color: #1f2937;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        h2 {
            text-align: center;
            color: #0E8D4D;
            margin-bottom: 20px;
        }
        label {
            font-size: 0.99em;
            margin-bottom: -2px;
            color: #0B6844;
            font-weight: 450;
        }
        input, select, button {
            width: 100%;
            margin-top: 12px;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            font-family: inherit;
            font-size: 1em;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #0E8D4D;
        }
        button {
            margin-top: 20px;
            background: linear-gradient(135deg, #0E8D4D, #22c55e);
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            font-size: 1em;
        }
        button:hover {
            opacity: 0.95;
        }
        .error {
            color: #e02424;
            background: #ffefef;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 12px;
            font-size: 0.97em;
        }
    </style>
</head>
<body>

<form class="card" action="{{ route('paiement.store') }}" method="POST">
    @csrf

    <h2>💳 Paiement</h2>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <label for="client_id">Client</label>
    <select name="client_id" id="client_id" required>
        <option value="">-- Sélectionnez un client --</option>
        @if(isset($clients) && count($clients) > 0)
            @foreach($clients as $client)
                {{-- 
                    On affiche maintenant le nom et le prénom du client dans la liste déroulante.
                    Le champ prénom doit être bien rempli dans la BDD (prenom_cli)
                --}}
                <option value="{{ $client->id_cli }}">
                    {{ $client->nom_cli }}
                    @if(!empty($client->prenom_cli))
                        {{ ' ' . $client->prenom_cli }}
                    @endif
                </option>
            @endforeach
        @else
            <option disabled>Aucun client disponible</option>
        @endif
    </select>

    <label for="reference">Référence (optionnelle)</label>
    <input type="text" name="reference" id="reference" placeholder="Référence">

    <label for="montant">Montant (FCFA)</label>
    <input type="number" name="montant" id="montant" placeholder="Montant (FCFA)" required min="0" step="any">

    <label for="mode_paiement">Mode de paiement</label>
    <input type="text" name="mode_paiement" id="mode_paiement" value="Espèce" readonly required>

    <label for="date_paiement">Date du paiement</label>
    <input type="date" name="date_paiement" id="date_paiement" required value="{{ date('Y-m-d') }}">

    <button type="submit">Générer le reçu</button>
</form>

</body>
</html>

{{-- 
    //
    // =============================
    // Remarque pour le contrôleur :
    // =============================
    // Tu n'as rien à changer du côté du contrôleur, car la vue reçoit déjà $clients
    // qui contient les champs 'nom_cli' et 'prenom_cli'. 
    // Assure-toi seulement que les deux champs sont bien présents et renseignés
    // dans ta base de données, sinon certains clients risquent d'avoir juste le nom.
    //
--}}
