<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Collecteur | Collecte+</title>
    
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
            border-radius: 0;
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
        
        /* Welcome Header - Nouvelle section */
        .welcome-header {
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            border-radius: 25px;
            padding: 35px 40px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(14, 141, 77, 0.25);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .welcome-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }
        
        .welcome-header-content {
            position: relative;
            z-index: 1;
        }
        
        .welcome-header h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .welcome-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            margin-bottom: 0;
        }
        
        .welcome-header .zone-badge {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            padding: 12px 24px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        /* Stat Cards - Amélioré */
        .stat-card {
            background: var(--white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(53,92,125,0.12);
            border: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green) 0%, #47a55e 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }
        
        .stat-card:hover::before {
            transform: scaleX(1);
        }
        
        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 45px rgba(14, 141, 77, 0.25);
        }
        
        .stat-card .icon-wrapper {
            width: 75px;
            height: 75px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }
        
        .stat-card.primary .icon-wrapper {
            background: linear-gradient(135deg, rgba(14, 141, 77, 0.15) 0%, rgba(71, 165, 94, 0.15) 100%);
            color: var(--primary-green);
        }
        
        .stat-card.success .icon-wrapper {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(32, 201, 151, 0.15) 100%);
            color: #28a745;
        }
        
        .stat-card.info .icon-wrapper {
            background: linear-gradient(135deg, rgba(138, 43, 226, 0.15) 0%, rgba(156, 39, 176, 0.15) 100%);
            color: #8a2be2;
        }
        
        .stat-card.warning .icon-wrapper {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.15) 0%, rgba(255, 184, 0, 0.15) 100%);
            color: #ffc107;
        }
        
        .stat-card .value {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 15px 0 10px 0;
            line-height: 1;
        }
        
        .stat-card .label {
            color: #6c757d;
            font-size: 1rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-card .change {
            font-size: 0.85rem;
            margin-top: 10px;
            padding: 6px 12px;
            border-radius: 8px;
            display: inline-block;
        }
        
        .stat-card .change.positive {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .stat-card .change.neutral {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }
        
        /* Dashboard Cards */
        .dashboard-card {
            background: var(--white);
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 8px 30px rgba(53,92,125,0.12);
            border: none;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }
        
        .dashboard-card:hover {
            box-shadow: 0 12px 40px rgba(53,92,125,0.18);
        }
        
        .dashboard-card .card-header-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .dashboard-card h5 {
            font-weight: 700;
            margin: 0;
            color: var(--dark-gray);
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .dashboard-card h5 i {
            color: var(--primary-green);
            font-size: 1.6rem;
        }
        
        .card-action-btn {
            padding: 8px 20px;
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .card-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 141, 77, 0.3);
            color: white;
        }
        
        /* Tables Améliorées */
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            color: var(--white);
            border: none;
            font-weight: 600;
            padding: 20px 18px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.8px;
            white-space: nowrap;
        }
        
        .table tbody td {
            padding: 20px 18px;
            vertical-align: middle;
            border-bottom: 1px solid #f5f5f5;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background: linear-gradient(90deg, rgba(14, 141, 77, 0.03) 0%, rgba(71, 165, 94, 0.03) 100%);
            transform: translateX(5px);
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        
        .empty-state h6 {
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .empty-state p {
            color: #adb5bd;
            font-size: 0.95rem;
        }
        
        /* Badges modernisés */
        .badge {
            padding: 10px 16px;
            font-weight: 600;
            border-radius: 10px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .badge.bg-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        }
        
        .badge.bg-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
        }
        
        /* Client Card dans le tableau */
        .client-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .client-avatar {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .client-details h6 {
            margin: 0;
            font-weight: 600;
            color: var(--dark-gray);
            font-size: 0.95rem;
        }
        
        .client-details small {
            color: #6c757d;
            font-size: 0.8rem;
        }
        
        /* Date Badge */
        .date-badge {
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 10px;
            border-left: 3px solid var(--primary-green);
        }
        
        .date-badge .date {
            font-weight: 600;
            color: var(--dark-gray);
            display: block;
            margin-bottom: 2px;
        }
        
        .date-badge .time {
            color: #6c757d;
            font-size: 0.8rem;
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
            padding: 20px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(40, 167, 69, 0.5);
            font-weight: 700;
            font-size: 1.1rem;
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 15px;
            animation: slideDown 0.5s ease;
        }
        
        @keyframes slideDown {
            from {
                transform: translateX(-50%) translateY(-100px);
                opacity: 0;
            }
            to {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
            }
        }
        
        .popup-success-icon {
            width: 35px;
            height: 35px;
            background: rgba(255,255,255,0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        
        /* Pagination custom */
        .pagination {
            margin-top: 25px;
        }
        
        .pagination .page-link {
            border: 2px solid #e0e0e0;
            color: var(--primary-green);
            border-radius: 10px;
            margin: 0 5px;
            font-weight: 600;
        }
        
        .pagination .page-link:hover {
            background: var(--primary-green);
            color: white;
            border-color: var(--primary-green);
        }
        
        .pagination .active .page-link {
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            border-color: var(--primary-green);
        }
        
        /* Quick Stats Section */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .quick-stat-item {
            background: white;
            padding: 20px;
            border-radius: 15px;
            border-left: 4px solid var(--primary-green);
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        
        .quick-stat-item .label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .quick-stat-item .value {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-gray);
        }
        
        /* Responsive Styles */
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
            
            .welcome-header {
                padding: 25px 30px;
            }
            
            .welcome-header h2 {
                font-size: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .welcome-header {
                padding: 20px;
            }
            
            .welcome-header h2 {
                font-size: 1.3rem;
            }
            
            .welcome-header p {
                font-size: 0.95rem;
            }
            
            .stat-card {
                padding: 20px;
            }
            
            .stat-card .value {
                font-size: 2rem;
            }
            
            .stat-card .icon-wrapper {
                width: 60px;
                height: 60px;
                font-size: 26px;
            }
            
            .dashboard-card {
                padding: 20px;
            }
            
            .dashboard-card h5 {
                font-size: 1.2rem;
            }
            
            .table thead th,
            .table tbody td {
                padding: 15px 12px;
                font-size: 0.85rem;
            }
            
            .client-avatar {
                width: 38px;
                height: 38px;
                font-size: 0.95rem;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 15px 10px;
            }
            
            .welcome-header {
                padding: 18px;
            }
            
            .welcome-header h2 {
                font-size: 1.2rem;
            }
            
            .stat-card {
                padding: 18px;
            }
            
            .stat-card .value {
                font-size: 1.6rem;
            }
            
            .dashboard-card {
                padding: 18px;
            }
            
            .table thead th,
            .table tbody td {
                padding: 12px 10px;
                font-size: 0.8rem;
            }
            
            .badge {
                padding: 6px 10px;
                font-size: 0.75rem;
            }
            
            .client-info {
                gap: 8px;
            }
            
            .card-header-custom {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start !important;
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
    @include('collecteur.partials.sidebar')

    <!-- Pop-up pour connexion réussie -->
    <div id="popup-success" class="popup-success">
        <div class="popup-success-icon">
            <i class="bi bi-check-lg"></i>
        </div>
        <span>Connexion réussie !</span>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Welcome Header -->
        <div class="welcome-header">
            <div class="welcome-header-content">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div>
                        <h2>Bonjour, {{ $collecteur->nom_collect }} {{ $collecteur->prenom_collect }} 👋</h2>
                        <p>Bienvenue dans votre espace de gestion</p>
                    </div>
                    <div class="zone-badge">
                        <i class="bi bi-geo-alt-fill me-2"></i>
                        Zone {{ $collecteur->zone_collect }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card primary">
                    <div class="icon-wrapper">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="value">{{ number_format($totalClients, 0, ',', ' ') }}</div>
                    <div class="label">Total Clients</div>
                    <div class="change neutral">
                        <i class="bi bi-circle-fill" style="font-size: 6px;"></i>
                        Actifs
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card success">
                    <div class="icon-wrapper">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                    <div class="value">{{ number_format($totalTransactions, 0, ',', ' ') }}</div>
                    <div class="label">Transactions</div>
                    <div class="change positive">
                        <i class="bi bi-arrow-up"></i>
                        Total effectuées
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card info">
                    <div class="icon-wrapper">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="value">{{ number_format($totalEncaissements, 0, ',', ' ') }}</div>
                    <div class="label">Encaissements</div>
                    <div class="change positive">
                        <i class="bi bi-currency-exchange"></i>
                        FCFA
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="stat-card warning">
                    <div class="icon-wrapper">
                        <i class="bi bi-calendar-month"></i>
                    </div>
                    <div class="value">{{ number_format($paiementsCeMois, 0, ',', ' ') }}</div>
                    <div class="label">Ce mois</div>
                    <div class="change positive">
                        <i class="bi bi-calendar-check"></i>
                        {{ \Carbon\Carbon::now()->locale('fr')->isoFormat('MMMM') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Récentes et Historique -->
        <div class="row g-4 mb-4">
            <!-- Paiements Récents -->
            <div class="col-12 col-lg-6">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5>
                            <i class="bi bi-cash-coin"></i>
                            Paiements Récents
                        </h5>
                        <a href="#historique" class="card-action-btn">
                            <span>Voir tout</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paiementsRecent as $paiement)
                                    <tr>
                                        <td>
                                            <div class="client-info">
                                                <div class="client-avatar">
                                                    {{ substr($paiement->client->nom_cli ?? 'N', 0, 1) }}{{ substr($paiement->client->prenom_cli ?? 'A', 0, 1) }}
                                                </div>
                                                <div class="client-details">
                                                    <h6>{{ $paiement->client->nom_cli ?? 'N/A' }} {{ $paiement->client->prenom_cli ?? '' }}</h6>
                                                    <small><i class="bi bi-telephone"></i> {{ $paiement->client->tel_cli ?? 'Non renseigné' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="date-badge">
                                                <span class="date">{{ \Carbon\Carbon::parse($paiement->date_paie)->format('d/m/Y') }}</span>
                                                <span class="time">{{ \Carbon\Carbon::parse($paiement->date_paie)->format('H:i') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                <i class="bi bi-cash"></i>
                                                {{ number_format($paiement->montant_paie, 0, ',', ' ') }} FCFA
                                            </span>
                                        </td>
                                        <td>
                                            @if($paiement->statut_paie === 'validé')
                                                <span class="badge bg-success" style="font-size: 0.7rem;">
                                                    <i class="bi bi-check"></i>
                                                    Validé
                                                </span>
                                            @elseif($paiement->statut_paie === 'en_attente')
                                                <span class="badge bg-warning" style="font-size: 0.7rem;">
                                                    <i class="bi bi-clock"></i>
                                                    Attente
                                                </span>
                                            @else
                                                <span class="badge bg-danger" style="font-size: 0.7rem;">
                                                    <i class="bi bi-x"></i>
                                                    Rejeté
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="empty-state">
                                                <i class="bi bi-inbox"></i>
                                                <h6>Aucun paiement récent</h6>
                                                <p>Les nouveaux paiements apparaîtront ici</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Stats / Aperçu -->
            <div class="col-12 col-lg-6">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5>
                            <i class="bi bi-graph-up-arrow"></i>
                            Aperçu Rapide
                        </h5>
                    </div>
                    
                    <div class="quick-stats">
                        <div class="quick-stat-item">
                            <div class="label">Moyenne / Transaction</div>
                            <div class="value">
                                {{ $totalTransactions > 0 ? number_format($totalEncaissements / $totalTransactions, 0, ',', ' ') : '0' }}
                            </div>
                        </div>
                        
                        <div class="quick-stat-item" style="border-left-color: #28a745;">
                            <div class="label">Paiements Aujourd'hui</div>
                            <div class="value" style="font-size: 1.5rem;">
                                {{ $nombrePaiementsAujourdhui }}
                            </div>
                        </div>
                        
                        <div class="quick-stat-item" style="border-left-color: #8a2be2;">
                            <div class="label">Clients Actifs</div>
                            <div class="value" style="font-size: 1.5rem;">
                                {{ number_format($totalClients, 0, ',', ' ') }}
                            </div>
                        </div>
                        
                        <div class="quick-stat-item" style="border-left-color: #ffc107;">
                            <div class="label">En attente</div>
                            <div class="value" style="font-size: 1.5rem;">
                                0
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-3" style="background: linear-gradient(135deg, rgba(14, 141, 77, 0.05) 0%, rgba(71, 165, 94, 0.05) 100%); border-radius: 12px; border-left: 3px solid var(--primary-green);">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-1" style="color: var(--primary-green); font-weight: 700;">Performance Mensuelle</h6>
                                <p class="mb-0 text-muted small">Objectif: {{ number_format($paiementsCeMois, 0, ',', ' ') }} FCFA collectés</p>
                            </div>
                            <div class="text-end">
                                <i class="bi bi-trophy-fill" style="font-size: 2.5rem; color: var(--primary-green); opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historique Complet des Paiements -->
        <div class="row" id="historique">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5>
                            <i class="bi bi-cash-coin"></i>
                            Historique Complet des Paiements
                        </h5>
                        <div class="d-flex gap-2">
                            <button class="card-action-btn" onclick="window.print()">
                                <i class="bi bi-printer"></i>
                                Imprimer
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Date & Heure</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paiements as $paiement)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">
                                                <i class="bi bi-hash"></i>
                                                {{ $paiement->id_paie }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="client-info">
                                                <div class="client-avatar">
                                                    {{ substr($paiement->client->nom_cli ?? 'N', 0, 1) }}{{ substr($paiement->client->prenom_cli ?? 'A', 0, 1) }}
                                                </div>
                                                <div class="client-details">
                                                    <h6>{{ $paiement->client->nom_cli ?? 'N/A' }} {{ $paiement->client->prenom_cli ?? '' }}</h6>
                                                    <small><i class="bi bi-telephone"></i> {{ $paiement->client->tel_cli ?? 'Non renseigné' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="date-badge">
                                                <span class="date">{{ \Carbon\Carbon::parse($paiement->date_paie)->format('d/m/Y') }}</span>
                                                <span class="time">{{ \Carbon\Carbon::parse($paiement->date_paie)->format('H:i') }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-success" style="font-size: 0.95rem;">
                                                <i class="bi bi-cash"></i>
                                                {{ number_format($paiement->montant_paie, 0, ',', ' ') }} FCFA
                                            </span>
                                        </td>
                                        <td>
                                            @if($paiement->statut_paie === 'validé')
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Validé
                                                </span>
                                            @elseif($paiement->statut_paie === 'en_attente')
                                                <span class="badge bg-warning">
                                                    <i class="bi bi-clock-fill"></i>
                                                    En attente
                                                </span>
                                            @elseif($paiement->statut_paie === 'rejeté')
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                    Rejeté
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-question-circle-fill"></i>
                                                    {{ ucfirst($paiement->statut_paie) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <i class="bi bi-inbox"></i>
                                                <h6>Aucun paiement enregistré</h6>
                                                <p>Commencez par enregistrer votre premier paiement</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($paiements->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $paiements->links() }}
                        </div>
                    @endif
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
        
        if (menuToggle) {
            menuToggle.addEventListener('click', toggleSidebar);
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', toggleSidebar);
        }
        
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

        // Affiche le popup de succès avec animation
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('login_success'))
                const popup = document.getElementById('popup-success');
                popup.style.display = 'flex';
                
                setTimeout(() => {
                    popup.style.transition = 'all 0.4s ease';
                    popup.style.transform = 'translateX(-50%) translateY(-120px)';
                    popup.style.opacity = '0';
                    
                    setTimeout(() => {
                        popup.style.display = 'none';
                        popup.style.transform = 'translateX(-50%) translateY(0)';
                        popup.style.opacity = '1';
                    }, 400);
                }, 3000);
            @endif
        });

        // Animation au scroll des cartes
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observer les cartes au chargement
        document.querySelectorAll('.stat-card, .dashboard-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    </script>

    @include('components.chat-assistant', ['role' => Auth::user()->role ?? 'collecteur'])
</body>
</html>