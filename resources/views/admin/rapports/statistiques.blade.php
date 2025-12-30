<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #0E8D4D;
            --sidebar-width: 260px;
        }
        body { background: #f6f6fa; }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--primary-green);
            color: #fff;
            padding: 20px 0;
        }
        .main-content { margin-left: var(--sidebar-width); padding: 30px; }
        .dashboard-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 24px rgba(53,92,125,0.07);
        }
        .stat-box {
            background: linear-gradient(135deg, #0E8D4D 0%, #0b6f3d 100%);
            color: #fff;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }
        .table thead th {
            background: var(--primary-green);
            color: #fff;
            border: none;
        }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="bi bi-graph-up me-2"></i>Statistiques Générales</h4>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
        
        <div class="row">
            <div class="col-md-3">
                <div class="stat-box">
                    <h6>Total Clients</h6>
                    <h2>{{ $stats['total_clients'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <h6>Total Collecteurs</h6>
                    <h2>{{ $stats['total_collecteurs'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <h6>Total Paiements</h6>
                    <h2>{{ $stats['total_paiements'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-box">
                    <h6>Encaissements Totaux</h6>
                    <h2>{{ number_format($stats['total_encaissements'], 0, ',', ' ') }} FCFA</h2>
                </div>
            </div>
        </div>
        
        <div class="dashboard-card">
            <h5 class="mb-4">Performance par Collecteur</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Zone</th>
                            <th>Montant Collecté</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['paiements_par_collecteur'] as $index => $collecteur)
                            <tr>
                                <td>
                                    @if($index == 0)
                                        <span class="badge bg-warning">🥇</span>
                                    @elseif($index == 1)
                                        <span class="badge bg-secondary">🥈</span>
                                    @elseif($index == 2)
                                        <span class="badge bg-warning">🥉</span>
                                    @else
                                        <strong>#{{ $index + 1 }}</strong>
                                    @endif
                                </td>
                                <td>{{ $collecteur->nom_collect }}</td>
                                <td>{{ $collecteur->prenom_collect }}</td>
                                <td>{{ $collecteur->zone_collect }}</td>
                                <td><strong>{{ number_format($collecteur->paiements_sum_montant_paie ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Aucune donnée disponible</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

