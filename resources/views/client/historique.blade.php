<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique - Espace Client</title>
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
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
        }

        .page-header {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .page-header h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #666;
        }

        .transactions-list {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .transaction-item {
            padding: 20px 25px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-item:hover {
            background: #f8f9fa;
        }

        .transaction-left {
            flex: 1;
        }

        .transaction-type {
            font-weight: 600;
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }

        .transaction-description {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .transaction-date {
            color: #999;
            font-size: 13px;
        }

        .transaction-reference {
            color: #999;
            font-size: 12px;
            font-family: monospace;
        }

        .transaction-right {
            text-align: right;
        }

        .transaction-amount {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .transaction-amount.depot {
            color: #27ae60;
        }

        .transaction-amount.retrait {
            color: #e74c3c;
        }

        .transaction-amount.transfert {
            color: #3498db;
        }

        .transaction-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-depot {
            background: #d4edda;
            color: #27ae60;
        }

        .badge-retrait {
            background: #f8d7da;
            color: #e74c3c;
        }

        .badge-transfert {
            background: #d1ecf1;
            color: #3498db;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
        }

        .pagination a,
        .pagination span {
            padding: 10px 16px;
            background: white;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            transition: all 0.2s;
        }

        .pagination a:hover {
            background: #16a085;
            color: white;
            transform: translateY(-2px);
        }

        .pagination .active {
            background: #16a085;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            fill: #ccc;
            margin-bottom: 20px;
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
        <h1>Historique des Transactions</h1>
        <div class="nav-links">
            <a href="{{ route('client.dashboard') }}">Dashboard</a>
            <a href="{{ route('client.solde') }}">Solde</a>
            <a href="{{ route('client.profil') }}">Profil</a>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>Toutes vos transactions</h2>
            <p>Consultez l'historique complet de vos opérations</p>
        </div>

        <div class="transactions-list">
            @if($transactions->count() > 0)
                @foreach($transactions as $transaction)
                    <div class="transaction-item">
                        <div class="transaction-left">
                            <div class="transaction-type">
                                <span class="transaction-badge badge-{{ $transaction->type }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </div>
                            <div class="transaction-description">{{ $transaction->description }}</div>
                            <div class="transaction-date">
                                {{ $transaction->created_at->format('d/m/Y à H:i') }}
                            </div>
                            <div class="transaction-reference">Réf: {{ $transaction->reference }}</div>
                        </div>
                        <div class="transaction-right">
                            <div class="transaction-amount {{ $transaction->type }}">
                                {{ $transaction->type == 'depot' ? '+' : '-' }}
                                {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <svg viewBox="0 0 24 24">
                        <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
                    </svg>
                    <h3>Aucune transaction</h3>
                    <p>Vous n'avez encore effectué aucune transaction</p>
                </div>
            @endif
        </div>

        @if($transactions->hasPages())
            <div class="pagination">
                @if ($transactions->onFirstPage())
                    <span>← Précédent</span>
                @else
                    <a href="{{ $transactions->previousPageUrl() }}">← Précédent</a>
                @endif

                <span class="active">Page {{ $transactions->currentPage() }}</span>

                @if ($transactions->hasMorePages())
                    <a href="{{ $transactions->nextPageUrl() }}">Suivant →</a>
                @else
                    <span>Suivant →</span>
                @endif
            </div>
        @endif

        <a href="{{ route('client.dashboard') }}" class="back-btn">← Retour au Dashboard</a>
    </div>
</body>
</html>