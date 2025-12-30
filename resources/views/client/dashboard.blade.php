<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #0E8D4D;
            --accent-green: #0b6f3d;
            --gray-bg: #f6f6fa;
            --white: #fff;
            --dark-gray: #23272F;
            --badge-green: #47a55e;
        }
        body {
            background: var(--gray-bg);
            color: var(--dark-gray);
        }
        .dashboard-card {
            border-radius: 15px;
            box-shadow: 0 4px 24px rgba(53,92,125,0.07);
            background: var(--white);
            border: none;
        }
        .balance {
            font-size: 2.3rem;
            font-weight: 700;
            color: var(--primary-green);
        }
        .navbar {
            background: var(--primary-green) !important;
        }
        .navbar .navbar-brand,
        .navbar .nav-link,
        .navbar span,
        .navbar .btn {
            color: var(--white) !important;
        }
        .navbar .btn-logout {
            border: 1.5px solid var(--white);
            background: transparent;
            color: var(--white) !important;
            transition: background 0.18s;
        }
        .navbar .btn-logout:hover,
        .navbar .btn-logout:active {
            background: var(--white);
            color: var(--primary-green) !important;
        }
        .dashboard-card .text-muted {
            color: var(--accent-green) !important;
            opacity: 1;
            font-size: 1.12rem;
        }
        .history-table th {
            background-color: var(--primary-green) !important;
            color: var(--white) !important;
            border: none;
        }
        .history-table td {
            vertical-align: middle;
        }
        .table-striped > tbody > tr:nth-of-type(odd) {
            --bs-table-bg-type: #f1f2f6;
        }
        .badge.bg-success {
            background: var(--badge-green) !important;
            color: var(--white) !important;
        }
        .badge.bg-warning {
            background: #fef8ea !important;
            color: var(--primary-green) !important;
            border: 1.4px solid var(--primary-green);
        }
        .badge.bg-danger {
            background: #e53e3e !important;
            color: var(--white) !important;
        }
        .table-responsive::-webkit-scrollbar {
            height: 7px;
            background: #eceff2;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: var(--accent-green);
            border-radius: 10px;
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .navbar .container {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .navbar .d-flex {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }
            
            .navbar span {
                text-align: center;
            }
            
            .balance {
                font-size: 1.8rem;
            }
            
            .dashboard-card {
                padding: 20px 15px !important;
            }
            
            .table thead th,
            .table tbody td {
                padding: 10px 8px;
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 576px) {
            .navbar .container {
                padding: 10px;
            }
            
            .navbar-brand {
                font-size: 0.95rem;
            }
            
            .balance {
                font-size: 1.5rem;
            }
            
            .dashboard-card {
                padding: 15px 10px !important;
            }
            
            .table thead th,
            .table tbody td {
                padding: 8px 5px;
                font-size: 0.75rem;
            }
            
            .badge {
                padding: 4px 8px;
                font-size: 0.7rem;
            }
            
            .btn-logout {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Tableau de Bord Client</a>
            <div class="d-flex align-items-center">
                <span class="me-3 d-none d-md-inline">Bonjour, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-logout btn-sm">Déconnexion</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <div class="card dashboard-card p-4">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <svg width="48" height="48" fill="none" viewBox="0 0 48 48" stroke="var(--primary-green)">
                                <rect x="7" y="12" width="34" height="24" rx="6" stroke-width="2.5" fill="#fff"/>
                                <rect x="14.5" y="20.5" width="19" height="7" rx="2.5" stroke-width="2.2" fill="#dbeafe" stroke="var(--accent-green)"/>
                                <circle cx="36" cy="24" r="2.5" fill="var(--accent-green)" />
                            </svg>
                        </div>
                        <div>
                            <div class="text-muted">Mon Solde</div>
                            <div class="balance">{{ number_format($solde, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card dashboard-card p-4">
                    <h5 class="mb-3">Historique de mes transactions</h5>
                    <div class="table-responsive">
                        <table class="table table-striped history-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ ucfirst($transaction->type) }}</td>
                                        <td>{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</td>
                                        <td>
                                            @if($transaction->statut == 'validé')
                                                <span class="badge bg-success">Validé</span>
                                            @elseif($transaction->statut == 'en attente')
                                                <span class="badge bg-warning">En attente</span>
                                            @else
                                                <span class="badge bg-danger">Refusé</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Aucune transaction trouvée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>