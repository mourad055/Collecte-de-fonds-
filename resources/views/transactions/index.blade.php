<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Suivi des Transactions - Gestion Financière</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        header {
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        h1 {
            color: #333;
            font-size: 32px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 12px;
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Statistiques */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card.green {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-card.red {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #30cfd0 0%, #330867 100%);
        }

        .stat-card h3 {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 10px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
            margin-top: 5px;
        }

        /* Filtres */
        .filters {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
            border: 1px solid #e0e0e0;
        }

        .filters h2 {
            color: #333;
            font-size: 18px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filters form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-size: 13px;
            color: #555;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .filters input,
        .filters select {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        .filters input:focus,
        .filters select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            grid-column: 1 / -1;
            flex-wrap: wrap;
        }

        /* Tableau */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead {
            background: #667eea;
            color: white;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
        }

        tbody tr {
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.encaissement {
            background: #d4edda;
            color: #155724;
        }

        .badge.decaissement {
            background: #f8d7da;
            color: #721c24;
        }

        .badge.valide {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge.en-attente {
            background: #fff3cd;
            color: #856404;
        }

        .badge.annule {
            background: #e2e3e5;
            color: #383d41;
        }

        /* Actions */
        .actions {
            display: flex;
            gap: 8px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .pagination .disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Message vide */
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .no-data .icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .no-data h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #666;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filters form {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 10px;
            }

            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div>
                <h1>📊 Suivi des Transactions</h1>
                <p style="color: #666; font-size: 14px; margin-top: 5px;">Gestion et analyse des transactions financières</p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                    ➕ Nouvelle Transaction
                </a>
                <a href="{{ route('transactions.export', request()->query()) }}" class="btn btn-success">
                    📥 Exporter CSV
                </a>
            </div>
        </header>

        <!-- Messages de succès/erreur -->
        @if(session('success'))
        <div class="alert alert-success">
            <span style="font-size: 20px;">✅</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            <span style="font-size: 20px;">❌</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card blue">
                <h3>Total Transactions</h3>
                <div class="value">{{ number_format($stats['total_transactions']) }}</div>
            </div>
            <div class="stat-card green">
                <h3>Total Encaissements</h3>
                <div class="value">{{ number_format($stats['total_encaissements'], 0, ',', ' ') }} FCFA</div>
            </div>
            <div class="stat-card red">
                <h3>Total Décaissements</h3>
                <div class="value">{{ number_format($stats['total_decaissements'], 0, ',', ' ') }} FCFA</div>
            </div>
            <div class="stat-card">
                <h3>Solde</h3>
                <div class="value">{{ number_format($stats['solde'], 0, ',', ' ') }} FCFA</div>
            </div>
        </div>

        <!-- Filtres de recherche -->
        <div class="filters">
            <h2>🔍 Filtrer les transactions</h2>
            <form method="GET" action="{{ route('transactions.index') }}">
                <div class="filter-group">
                    <label>Rechercher</label>
                    <input type="text" name="search" placeholder="Nom client ou N° reçu" value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label>Date début</label>
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}">
                </div>

                <div class="filter-group">
                    <label>Date fin</label>
                    <input type="date" name="date_fin" value="{{ request('date_fin') }}">
                </div>

                <div class="filter-group">
                    <label>Type</label>
                    <select name="type">
                        <option value="">Tous les types</option>
                        <option value="encaissement" {{ request('type') == 'encaissement' ? 'selected' : '' }}>Encaissement</option>
                        <option value="decaissement" {{ request('type') == 'decaissement' ? 'selected' : '' }}>Décaissement</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Statut</label>
                    <select name="statut">
                        <option value="">Tous les statuts</option>
                        <option value="valide" {{ request('statut') == 'valide' ? 'selected' : '' }}>Validé</option>
                        <option value="en-attente" {{ request('statut') == 'en-attente' ? 'selected' : '' }}>En attente</option>
                        <option value="annule" {{ request('statut') == 'annule' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Montant minimum</label>
                    <input type="number" name="montant_min" placeholder="0" value="{{ request('montant_min') }}">
                </div>

                <div class="filter-group">
                    <label>Montant maximum</label>
                    <input type="number" name="montant_max" placeholder="1000000" value="{{ request('montant_max') }}">
                </div>

                <div class="filter-buttons">
                    <button type="submit" class="btn btn-primary">🔍 Rechercher</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">🔄 Réinitialiser</a>
                </div>
            </form>
        </div>

        <!-- Tableau des transactions -->
        <div class="table-container">
            @if($transactions->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>N° Reçu</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Mode Paiement</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td><strong>{{ $transaction->numero_recu }}</strong></td>
                        <td>{{ $transaction->nom_client }}</td>
                        <td>{{ $transaction->date_paiement->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $transaction->type }}">
                                {{ $transaction->type == 'encaissement' ? '💰' : '💸' }}
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                        <td style="font-weight: bold; font-size: 15px; color: {{ $transaction->type == 'encaissement' ? '#28a745' : '#dc3545' }}">
                            {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                        </td>
                        <td>{{ ucfirst($transaction->mode_paiement) }}</td>
                        <td>
                            <span class="badge {{ $transaction->statut }}">
                                {{ ucfirst(str_replace('-', ' ', $transaction->statut)) }}
                            </span>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-primary btn-sm">👁️ Voir</a>
                                <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-secondary btn-sm">✏️ Modifier</a>
                                <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette transaction ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️ Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                {!! $transactions->links() !!}
            </div>
            @else
            <div class="no-data">
                <div class="icon">📭</div>
                <h3>Aucune transaction trouvée</h3>
                <p>Essayez de modifier vos critères de recherche ou ajoutez de nouvelles transactions.</p>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
