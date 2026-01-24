<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Solde - Espace Client</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        .navbar {
            background: linear-gradient(135deg, #16a085 0%, #1abc9c 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 24px;
        }

        .navbar .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.3s;
        }

        .navbar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }

        .solde-card {
            background: linear-gradient(135deg, #0E8D4D 0%, #1abc9c 100%);
            color: white;
            padding: 50px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .solde-card h2 {
            font-size: 20px;
            margin-bottom: 20px;
            opacity: 0.9;
        }

        .solde-card .amount {
            font-size: 56px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .solde-card .subtitle {
            font-size: 14px;
            opacity: 0.8;
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .info-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .info-card h3 {
            color: #16a085;
            font-size: 14px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .back-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            background: #16a085;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #1abc9c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(22, 160, 133, 0.3);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Mon Solde</h1>
        <div class="nav-links">
            <a href="{{ route('client.dashboard') }}">Dashboard</a>
            <a href="{{ route('client.historique') }}">Historique</a>
            <a href="{{ route('client.profil') }}">Profil</a>
        </div>
    </div>

    <div class="container">
        <div class="solde-card">
            <h2>Solde Disponible</h2>
            <div class="amount">{{ number_format($client->solde, 0, ',', ' ') }} FCFA</div>
            <div class="subtitle">Dernière mise à jour : {{ now()->format('d/m/Y à H:i') }}</div>
        </div>

        <div class="info-cards">
            <div class="info-card">
                <h3>Compte N°</h3>
                <div class="value">{{ str_pad($client->id, 8, '0', STR_PAD_LEFT) }}</div>
            </div>

            <div class="info-card">
                <h3>Titulaire</h3>
                <div class="value" style="font-size: 18px;">{{ $client->prenom }} {{ $client->nom }}</div>
            </div>

            <div class="info-card">
                <h3>Téléphone</h3>
                <div class="value" style="font-size: 20px;">{{ $client->telephone }}</div>
            </div>
        </div>

        <a href="{{ route('client.dashboard') }}" class="back-btn">← Retour au Dashboard</a>
    </div>
</body>
</html>