<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-green: #0E8D4D;
            --accent-green: #0b6f3d;
            --gray-bg: #f6f6fa;
            --white: #fff;
            --dark-gray: #23272F;
            --sidebar-width: 260px;
        }
        
        body {
            background: var(--gray-bg);
            color: var(--dark-gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--primary-green);
            color: var(--white);
            padding: 20px 0;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .sidebar-brand {
            padding: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin: 5px 0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.1);
            border-left: 4px solid var(--white);
        }
        
        .sidebar-menu i {
            margin-right: 12px;
            width: 20px;
        }
        
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
        }
        
        .stat-card {
            background: var(--white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 24px rgba(53,92,125,0.07);
            border: none;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .stat-card.primary .icon {
            background: rgba(14, 141, 77, 0.1);
            color: var(--primary-green);
        }
        
        .stat-card.success .icon {
            background: rgba(71, 165, 94, 0.1);
            color: #47a55e;
        }
        
        .stat-card.warning .icon {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .stat-card.info .icon {
            background: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
        }
        
        .stat-card .value {
            font-size: 2rem;
            font-weight: 700;
            margin: 10px 0;
        }
        
        .stat-card .label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .dashboard-card {
            background: var(--white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 24px rgba(53,92,125,0.07);
            border: none;
            margin-bottom: 25px;
        }
        
        .dashboard-card h5 {
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--dark-gray);
        }
        
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table thead th {
            background: var(--primary-green);
            color: var(--white);
            border: none;
            font-weight: 500;
            padding: 15px;
        }
        
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }
        
        .table-striped > tbody > tr:nth-of-type(odd) {
            --bs-table-bg-type: #f8f9fa;
        }
        
        .badge {
            padding: 6px 12px;
            font-weight: 500;
        }
        
        .btn-action {
            padding: 5px 10px;
            margin: 0 2px;
        }
        
        .navbar-top {
            background: var(--white);
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-left: var(--sidebar-width);
        }
        
        .btn-export {
            background: var(--primary-green);
            color: var(--white);
            border: none;
        }
        
        .btn-export:hover {
            background: var(--accent-green);
            color: var(--white);
        }
        
        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            background: var(--primary-green);
            color: var(--white);
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 1001;
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
        
        /* Responsive Styles */
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            .navbar-top {
                margin-left: 0;
                padding: 15px;
            }
            
            .navbar-top h4 {
                font-size: 1.2rem;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .stat-card .value {
                font-size: 1.5rem;
            }
            
            .stat-card .icon {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
            
            .dashboard-card {
                padding: 15px;
            }
            
            .table thead th,
            .table tbody td {
                padding: 10px 8px;
                font-size: 0.85rem;
            }
            
            .btn-export {
                font-size: 0.85rem;
                padding: 8px 12px;
            }
            
            .btn-export i {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            
            .navbar-top {
                padding: 10px;
                flex-direction: column;
                gap: 10px;
            }
            
            .navbar-top h4 {
                font-size: 1rem;
            }
            
            .stat-card {
                padding: 15px;
            }
            
            .stat-card .value {
                font-size: 1.3rem;
            }
            
            .stat-card .label {
                font-size: 0.8rem;
            }
            
            .dashboard-card {
                padding: 12px;
            }
            
            .dashboard-card h5 {
                font-size: 1rem;
                margin-bottom: 15px;
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
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="menu-toggle position-fixed" id="menuToggle" style="top: 15px; left: 15px;">
        <i class="bi bi-list"></i>
    </button>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="navbar-top">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="mb-0">Tableau de Bord</h4>
                <div>
                    <a href="{{ route('admin.rapport.financier') }}" class="btn btn-export">
                        <i class="bi bi-download"></i> <span class="d-none d-md-inline">Exporter Rapport</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mt-4">
            <div class="col-md-3 mb-4">
                <div class="stat-card primary">
                    <div class="icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="value">{{ number_format($totalClients, 0, ',', ' ') }}</div>
                    <div class="label">Total Clients</div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card success">
                    <div class="icon">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <div class="value">{{ number_format($totalCollecteurs, 0, ',', ' ') }}</div>
                    <div class="label">Total Collecteurs</div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card info">
                    <div class="icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="value">{{ number_format($totalEncaissements, 0, ',', ' ') }} FCFA</div>
                    <div class="label">Encaissements Totaux</div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card warning">
                    <div class="icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="value">{{ $paiementsEnAttente }}</div>
                    <div class="label">Paiements en Attente</div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="icon bg-primary bg-opacity-10 text-primary me-3">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>
                        <div>
                            <div class="value text-primary">{{ number_format($totalTransactions, 0, ',', ' ') }}</div>
                            <div class="label">Transactions</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="icon bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-calendar-month"></i>
                        </div>
                        <div>
                            <div class="value text-success">{{ number_format($paiementsCeMois, 0, ',', ' ') }} FCFA</div>
                            <div class="label">Encaissements ce Mois</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="icon bg-warning bg-opacity-10 text-warning me-3">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="value text-warning">{{ number_format($montantEnAttente, 0, ',', ' ') }} FCFA</div>
                            <div class="label">Montant en Attente</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions and Payments -->
        <div class="row">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <h5><i class="bi bi-arrow-left-right me-2"></i>Transactions Récentes</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Collecteur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactionsRecent as $transaction)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($transaction->date_transact)->format('d/m/Y') }}</td>
                                        <td>{{ $transaction->client->nom_cli ?? 'N/A' }} {{ $transaction->client->prenom_cli ?? '' }}</td>
                                        <td><strong>{{ number_format($transaction->montant_transact, 0, ',', ' ') }} FCFA</strong></td>
                                        <td>{{ $transaction->collecteur->nom_collect ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Aucune transaction récente</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.transactions') }}" class="btn btn-sm btn-outline-primary">Voir toutes les transactions</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="dashboard-card">
                    <h5><i class="bi bi-cash-coin me-2"></i>Paiements Récents</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paiementsRecent as $paiement)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($paiement->date_paie)->format('d/m/Y') }}</td>
                                        <td>{{ $paiement->client->nom_cli ?? 'N/A' }} {{ $paiement->client->prenom_cli ?? '' }}</td>
                                        <td><strong>{{ number_format($paiement->montant_paie, 0, ',', ' ') }} FCFA</strong></td>
                                        <td>
                                            @if($paiement->statut_paie == 'validé')
                                                <span class="badge bg-success">Validé</span>
                                            @elseif($paiement->statut_paie == 'en_attente')
                                                <span class="badge bg-warning">En attente</span>
                                            @else
                                                <span class="badge bg-danger">Rejeté</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Aucun paiement récent</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.encaissements') }}" class="btn btn-sm btn-outline-primary">Voir tous les encaissements</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Collecteurs -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <h5><i class="bi bi-trophy me-2"></i>Top Collecteurs</h5>
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
                                @forelse($topCollecteurs as $index => $collecteur)
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
                                        <td colspan="5" class="text-center text-muted">Aucun collecteur trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        }
        
        menuToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);
        
        // Close sidebar when clicking on a link (mobile)
        if (window.innerWidth <= 768) {
            const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                });
            });
        }
    </script>
</body>
</html>
