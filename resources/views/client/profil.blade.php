<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Espace Client</title>
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
            margin: 30px auto;
            padding: 20px;
        }

        .profile-header {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            text-align: center;
            margin-bottom: 25px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #16a085 0%, #1abc9c 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 5px 20px rgba(22, 160, 133, 0.3);
        }

        .profile-avatar svg {
            width: 60px;
            height: 60px;
            fill: white;
        }

        .profile-name {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .profile-phone {
            color: #666;
            font-size: 18px;
        }

        .info-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .info-section h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #16a085;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #16a085;
        }

        .info-label {
            color: #666;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .info-value {
            color: #333;
            font-size: 18px;
            font-weight: 500;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: linear-gradient(135deg, #34bd79ff 0%, #a1eec7ff 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
        }

        .stat-card h3 {
            font-size: 14px;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
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
        <h1>Mon Profil</h1>
        <div class="nav-links">
            <a href="{{ route('client.dashboard') }}">Dashboard</a>
            <a href="{{ route('client.solde') }}">Solde</a>
            <a href="{{ route('client.historique') }}">Historique</a>
        </div>
    </div>

    <div class="container">
        <!-- En-tête du profil -->
        <div class="profile-header">
            <div class="profile-avatar">
                <svg viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                </svg>
            </div>
            <div class="profile-name">{{ $client->prenom }} {{ $client->nom }}</div>
            <div class="profile-phone">{{ $client->telephone }}</div>
        </div>

        <!-- Informations personnelles -->
        <div class="info-section">
            <h2>Informations Personnelles</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Prénom</div>
                    <div class="info-value">{{ $client->prenom }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Nom</div>
                    <div class="info-value">{{ $client->nom }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Téléphone</div>
                    <div class="info-value">{{ $client->telephone }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $client->email ?? 'Non renseigné' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Numéro de compte</div>
                    <div class="info-value">{{ str_pad($client->id, 8, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Membre depuis</div>
                    <div class="info-value">{{ $client->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Statistiques du compte -->
        <div class="info-section">
            <h2>Statistiques du Compte</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Solde Actuel</h3>
                    <div class="value">{{ number_format($client->solde, 0, ',', ' ') }} FCFA</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #0E8D4D 0%, #035f31ff 100%);">
                    <h3>Transactions</h3>
                    <div class="value">{{ $client->transactions()->count() }}</div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #0E8D4D 0%, #06b45dff 100%);">
                    <h3>Dernière Connexion</h3>
                    <div class="value" style="font-size: 16px;">
                        {{ $client->derniere_connexion ? $client->derniere_connexion->format('d/m/Y') : 'Jamais' }}
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('client.dashboard') }}" class="back-btn">← Retour au Dashboard</a>
    </div>
</body>
</html>