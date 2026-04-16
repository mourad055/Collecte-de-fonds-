<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport Financier</title>
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
        .table thead th {
            background: var(--primary-green);
            color: #fff;
            border: none;
        }
        @media print {
            .sidebar, .no-print { display: none; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    @include('admin.partials.sidebar')
    
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h4><i class="bi bi-file-earmark-pdf me-2"></i>Rapport Financier</h4>
            <div>
                <button onclick="window.print()" class="btn btn-success">
                    <i class="bi bi-printer"></i> Imprimer
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Retour
                </a>
            </div>
        </div>
        
        <div class="dashboard-card mb-4 no-print">
            <form method="GET" action="{{ route('admin.rapport.financier') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Date début</label>
                    <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut', \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Date fin</label>
                    <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin', \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filtrer
                    </button>
                </div>
            </form>
        </div>
        
        <div class="dashboard-card">
            <div class="mb-4">
                <h5>Période: {{ \Carbon\Carbon::parse($dateDebut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateFin)->format('d/m/Y') }}</h5>
                <p class="text-muted">Généré le {{ now()->format('d/m/Y à H:i') }}</p>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Total Encaissements</h6>
                            <h3 class="text-success">{{ number_format($total, 0, ',', ' ') }} FCFA</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">Nombre de Paiements</h6>
                            <h3 class="text-primary">{{ $nombrePaiements }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Collecteur</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $paiement)
                            <tr>
                                <td>{{ $paiement->id_paie }}</td>
                                <td>{{ \Carbon\Carbon::parse($paiement->date_paie)->format('d/m/Y H:i') }}</td>
                                <td>{{ $paiement->client->nom_cli ?? 'N/A' }} {{ $paiement->client->prenom_cli ?? '' }}</td>
                                <td>{{ $paiement->collecteur->nom_collect ?? 'N/A' }} {{ $paiement->collecteur->prenom_collect ?? '' }}</td>
                                <td><strong>{{ number_format($paiement->montant_paie, 0, ',', ' ') }} FCFA</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Aucun paiement trouvé pour cette période</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="table-success">
                            <th colspan="4" class="text-end">TOTAL</th>
                            <th>{{ number_format($total, 0, ',', ' ') }} FCFA</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

