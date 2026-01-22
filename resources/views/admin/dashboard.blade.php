<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Administrateur | Collecte+</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
    
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
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            color: var(--dark-gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0E8D4D 0%, #0b6f3d 100%);
            color: var(--white);
            padding: 20px 0;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(14, 141, 77, 0.15);
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
            background: rgba(255,255,255,0.15);
            border-left: 4px solid var(--white);
            padding-left: 16px;
        }
        
        .sidebar-menu i {
            margin-right: 12px;
            width: 20px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
        }
        
        /* Top Navbar */
        .navbar-top {
            background: var(--white);
            padding: 20px 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            border-radius: 15px;
            margin-bottom: 30px;
        }
        
        /* Stat Cards */
        .stat-card {
            background: var(--white);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(53,92,125,0.12);
            border: none;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(14, 141, 77, 0.2);
        }
        
        .stat-card .icon {
            width: 65px;
            height: 65px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 15px;
        }
        
        .stat-card.primary .icon {
            background: linear-gradient(135deg, rgba(14, 141, 77, 0.1) 0%, rgba(14, 141, 77, 0.2) 100%);
            color: var(--primary-green);
        }
        
        .stat-card.success {
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            color: white;
        }
        
        .stat-card.success .icon {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        
        .stat-card.warning .icon {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.2) 100%);
            color: #ffc107;
        }
        
        .stat-card.info .icon {
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.1) 0%, rgba(138, 43, 226, 0.2) 100%);
            color: #8a2be2;
        }
        
        .stat-card .value {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 10px 0;
        }
        
        .stat-card.success .value,
        .stat-card.success .label {
            color: white;
        }
        
        .stat-card .label {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        /* Dashboard Cards */
        .dashboard-card {
            background: var(--white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(53,92,125,0.12);
            border: none;
            margin-bottom: 30px;
        }
        
        .dashboard-card h5 {
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--dark-gray);
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .dashboard-card h5 i {
            color: var(--primary-green);
        }
        
        /* Tables */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            color: var(--white);
            border: none;
            font-weight: 600;
            padding: 18px 15px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: #f8fffe;
            transform: scale(1.01);
        }
        
        .table-striped > tbody > tr:nth-of-type(odd) {
            --bs-table-bg-type: #fafbfc;
        }
        
        /* Badges */
        .badge {
            padding: 8px 14px;
            font-weight: 600;
            border-radius: 10px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .badge.bg-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        }
        
        .badge.bg-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ffb800 100%) !important;
            color: #000 !important;
        }
        
        .badge.bg-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        }
        
        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            background: var(--primary-green);
            color: var(--white);
            border: none;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 1001;
            box-shadow: 0 4px 15px rgba(14, 141, 77, 0.3);
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
        
        /* Popup Success */
        .popup-success {
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 18px 35px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(40, 167, 69, 0.4);
            font-weight: 700;
            font-size: 1.1rem;
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 12px;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
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
                padding: 20px 15px;
            }
            
            .navbar-top {
                padding: 20px;
            }
        }
        
        @media (max-width: 768px) {
            .navbar-top h4 {
                font-size: 1.2rem;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .stat-card .value {
                font-size: 1.8rem;
            }
            
            .stat-card .icon {
                width: 55px;
                height: 55px;
                font-size: 24px;
            }
            
            .dashboard-card {
                padding: 20px;
            }
            
            .table thead th,
            .table tbody td {
                padding: 12px 10px;
                font-size: 0.85rem;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 15px 10px;
            }
            
            .navbar-top {
                padding: 15px;
            }
            
            .stat-card {
                padding: 18px;
            }
            
            .stat-card .value {
                font-size: 1.5rem;
            }
            
            .dashboard-card {
                padding: 15px;
            }
            
            .table thead th,
            .table tbody td {
                padding: 10px 8px;
                font-size: 0.75rem;
            }
            
            .badge {
                padding: 6px 10px;
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

    <!-- Pop-up pour connexion réussie -->
    <div id="popup-success" class="popup-success">
        <div style="width: 30px; height: 30px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-check-lg" style="font-size: 20px;"></i>
        </div>
        Connexion réussie !
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="navbar-top">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h4 class="mb-1 fw-bold">Tableau de Bord Administrateur</h4>
                    <p class="text-muted mb-0 small">Vue d'ensemble de la plateforme</p>
                </div>
                <div>
                    <a href="{{ route('admin.rapport.financier') }}" class="btn btn-primary" style="background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%); border: none;">
                        <i class="bi bi-download me-2"></i>
                        <span class="d-none d-md-inline">Exporter Rapport</span>
                        <span class="d-md-none">Export</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card primary">
                    <div class="icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="value">{{ number_format($totalClients, 0, ',', ' ') }}</div>
                    <div class="label">Total Clients</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card primary">
                    <div class="icon">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <div class="value">{{ number_format($totalCollecteurs, 0, ',', ' ') }}</div>
                    <div class="label">Total Collecteurs</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="stat-card success">
                    <div class="icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="value">{{ number_format($totalEncaissements, 0, ',', ' ') }}</div>
                    <div class="label">Encaissements Totaux (FCFA)</div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
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
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-4">
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
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="icon bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-calendar-month"></i>
                        </div>
                        <div>
                            <div class="value text-success">{{ number_format($paiementsCeMois, 0, ',', ' ') }}</div>
                            <div class="label">Encaissements ce Mois (FCFA)</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center">
                        <div class="icon bg-warning bg-opacity-10 text-warning me-3">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div>
                            <div class="value text-warning">{{ number_format($montantEnAttente, 0, ',', ' ') }}</div>
                            <div class="label">Montant en Attente (FCFA)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions and Payments -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <div class="dashboard-card">
                    <h5><i class="bi bi-arrow-left-right"></i>Transactions Récentes</h5>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
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
                                        <td><strong>{{ $transaction->client->nom_cli ?? 'N/A' }} {{ $transaction->client->prenom_cli ?? '' }}</strong></td>
                                        <td><span class="badge bg-success">{{ number_format($transaction->montant_transact, 0, ',', ' ') }} FCFA</span></td>
                                        <td>{{ $transaction->collecteur->nom_collect ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Aucune transaction récente</td>
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

            <div class="col-12 col-lg-6">
                <div class="dashboard-card">
                    <h5><i class="bi bi-cash-coin"></i>Paiements Récents</h5>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
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
                                        <td><strong>{{ $paiement->client->nom_cli ?? 'N/A' }} {{ $paiement->client->prenom_cli ?? '' }}</strong></td>
                                        <td><strong>{{ number_format($paiement->montant_paie, 0, ',', ' ') }} FCFA</strong></td>
                                        <td>
                                            @if($paiement->statut_paie == 'validé')
                                                <span class="badge bg-success"><i class="bi bi-check-circle-fill"></i> Validé</span>
                                            @elseif($paiement->statut_paie == 'en_attente')
                                                <span class="badge bg-warning"><i class="bi bi-clock-fill"></i> En attente</span>
                                            @else
                                                <span class="badge bg-danger"><i class="bi bi-x-circle-fill"></i> Rejeté</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">Aucun paiement récent</td>
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
                    <h5><i class="bi bi-trophy"></i>Top Collecteurs</h5>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
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
                                                <span class="badge" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); color: #000; font-size: 1.1rem;">🥇 #1</span>
                                            @elseif($index == 1)
                                                <span class="badge" style="background: linear-gradient(135deg, #C0C0C0 0%, #A8A8A8 100%); color: #000; font-size: 1.1rem;">🥈 #2</span>
                                            @elseif($index == 2)
                                                <span class="badge" style="background: linear-gradient(135deg, #CD7F32 0%, #B8860B 100%); color: #fff; font-size: 1.1rem;">🥉 #3</span>
                                            @else
                                                <strong style="font-size: 1.1rem;">#{{ $index + 1 }}</strong>
                                            @endif
                                        </td>
                                        <td><strong>{{ $collecteur->nom_collect }}</strong></td>
                                        <td>{{ $collecteur->prenom_collect }}</td>
                                        <td><span class="badge bg-info">{{ $collecteur->zone_collect }}</span></td>
                                        <td><span class="badge bg-success" style="font-size: 0.9rem;">{{ number_format($collecteur->paiements_sum_montant_paie ?? 0, 0, ',', ' ') }} FCFA</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <p class="mt-2">Aucun collecteur trouvé</p>
                                        </td>
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
        if (window.innerWidth <= 991) {
            const sidebarLinks = document.querySelectorAll('.sidebar-menu a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                });
            });
        }

        // Affiche le popup de succès
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('login_success'))
                const popup = document.getElementById('popup-success');
                popup.style.display = 'flex';
                setTimeout(() => {
                    popup.style.opacity = '0';
                    popup.style.transition = 'opacity 0.3s';
                    setTimeout(() => {
                        popup.style.display = 'none';
                        popup.style.opacity = '1';
                    }, 300);
                }, 2500);
            @endif
        });
    </script>

    @include('components.chat-assistant', ['role' => Auth::user()->role ?? 'admin'])
</body>
</html>