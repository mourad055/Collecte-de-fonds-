<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Espace Client</title>
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

        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .navbar .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .menu-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .menu-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            border-color: #16a085;
        }

        .menu-card .icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #16a085 0%, #1abc9c 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .menu-card .icon svg {
            width: 25px;
            height: 25px;
            fill: white;
        }

        .menu-card h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #333;
        }

        .menu-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }

        .solde-card {
            background: linear-gradient(135deg, #0E8D4D 0%, #1abc9c 100%);
            color: white;
        }

        .solde-card h3,
        .solde-card p {
            color: white;
        }

        .solde-card .amount {
            font-size: 32px;
            font-weight: bold;
            margin-top: 10px;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .section h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
            border-bottom: 2px solid #16a085;
            padding-bottom: 10px;
        }

        .transaction-item,
        .notification-item {
            padding: 15px;
            border-left: 4px solid #16a085;
            background: #f8f9fa;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .transaction-item .header,
        .notification-item .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .transaction-item .type {
            font-weight: 600;
            color: #333;
        }

        .transaction-item .amount {
            font-weight: bold;
            font-size: 16px;
        }

        .transaction-item.depot .amount {
            color: #27ae60;
        }

        .transaction-item.retrait .amount {
            color: #e74c3c;
        }

        .notification-item .titre {
            font-weight: 600;
            color: #333;
        }

        .notification-item .message {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        .notification-item.non-lu {
            border-left-color: #3498db;
            background: #e3f2fd;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Dashboard</h1>
        <div class="user-info">
            <span>{{ $client->prenom }} {{ $client->nom }}</span>
            <form method="POST" action="{{ route('client.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>
    </div>

    <div class="container">
        <!-- Menu Cards -->
        <div class="menu-cards">
            <div class="menu-card solde-card">
                <div class="icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/></svg>
                </div>
                <h3>Solde Actuel</h3>
                <div class="amount">{{ number_format($client->solde, 0, ',', ' ') }} FCFA</div>
            </div>

            <a href="{{ route('client.historique') }}" class="menu-card">
                <div class="icon">
                    <svg viewBox="0 0 24 24"><path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg>
                </div>
                <h3>Historique</h3>
                <p>Consultez toutes vos transactions</p>
            </a>

            <a href="{{ route('client.notifications') }}" class="menu-card">
                <div class="icon">
                    <svg viewBox="0 0 24 24"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                </div>
                <h3>Notifications</h3>
                <p>{{ $notifications->count() }} nouvelles notifications</p>
            </a>

            <a href="{{ route('client.profil') }}" class="menu-card">
                <div class="icon">
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <h3>Mon Profil</h3>
                <p>Gérez vos informations personnelles</p>
            </a>
        </div>

        <!-- Dernières Transactions -->
        <div class="section">
            <h2>Dernières Transactions</h2>
            @if($transactions->count() > 0)
                @foreach($transactions as $transaction)
                    <div class="transaction-item {{ $transaction->type }}">
                        <div class="header">
                            <span class="type">{{ ucfirst($transaction->type) }}</span>
                            <span class="amount">
                                {{ $transaction->type == 'depot' ? '+' : '-' }}
                                {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                            </span>
                        </div>
                        <div class="description">{{ $transaction->description }}</div>
                        <div style="font-size: 12px; color: #999; margin-top: 5px;">
                            {{ $transaction->created_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                @endforeach
                <a href="{{ route('client.historique') }}" style="color: #16a085; text-decoration: none; display: inline-block; margin-top: 10px;">
                    Voir tout l'historique →
                </a>
            @else
                <div class="empty-state">
                    Aucune transaction pour le moment
                </div>
            @endif
        </div>

        <!-- Notifications récentes -->
        <div class="section">
            <h2>Notifications Récentes</h2>
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="notification-item {{ !$notification->lu ? 'non-lu' : '' }}">
                        <div class="header">
                            <span class="titre">{{ $notification->titre }}</span>
                            <span style="font-size: 12px; color: #999;">
                                {{ $notification->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        <div class="message">{{ $notification->message }}</div>
                    </div>
                @endforeach
                <a href="{{ route('client.notifications') }}" style="color: #16a085; text-decoration: none; display: inline-block; margin-top: 10px;">
                    Voir toutes les notifications →
                </a>
            @else
                <div class="empty-state">
                    Aucune notification
                </div>
            @endif
        </div>
    </div>
</body>
</html>