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
        input, button {
            width: 100%;
            margin-top: 12px;
            padding: 12px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            font-family: inherit;
        }
        input:focus {
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
        }
        button:hover {
            opacity: 0.95;
        }
    </style>
</head>
<body>

<form class="card" action="{{ route('paiement.generate') }}" method="POST">
    @csrf

    <h2>💳 Paiement en espèces</h2>

    <input type="text" name="nom" placeholder="Nom du client" required>
    <input type="text" name="reference" placeholder="Référence" required>
    <input type="number" name="montant" placeholder="Montant (FCFA)" required>
    <input type="text" name="mode_paiement" value="Espèce" readonly>
    <input type="date" name="date_paiement" required>

    <button type="submit">Générer le reçu</button>
</form>

</body>
</html>
