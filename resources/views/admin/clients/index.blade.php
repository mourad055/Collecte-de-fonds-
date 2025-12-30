<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients</title>
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
        
        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            background: var(--primary-green);
            color: #fff;
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
            
            .dashboard-card {
                padding: 15px;
            }
            
            .table thead th,
            .table tbody td {
                padding: 10px 8px;
                font-size: 0.85rem;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 15px;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            
            .dashboard-card {
                padding: 12px;
            }
            
            .table thead th,
            .table tbody td {
                padding: 8px 5px;
                font-size: 0.75rem;
            }
            
            .btn {
                font-size: 0.85rem;
                padding: 6px 12px;
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
    
    @include('admin.partials.sidebar')
    
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4><i class="bi bi-person-badge me-2"></i>Gestion des Clients</h4>
            <a href="{{ route('admin.clients.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Ajouter un Client
            </a>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="dashboard-card">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>Solde</th>
                            <th>Paiements</th>
                            <th>Montant Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                            <tr>
                                <td>{{ $client->id_cli }}</td>
                                <td>{{ $client->nom_cli }}</td>
                                <td>{{ $client->prenom_cli }}</td>
                                <td>{{ $client->tel_cli }}</td>
                                <td>{{ $client->adresse_cli }}</td>
                                <td><strong>{{ number_format($client->solde_cli, 0, ',', ' ') }} FCFA</strong></td>
                                <td><span class="badge bg-info">{{ $client->paiements_count }}</span></td>
                                <td><strong>{{ number_format($client->paiements_sum_montant_paie ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                                <td>
                                    <a href="{{ route('admin.clients.edit', $client->id_cli) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.clients.destroy', $client->id_cli) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">Aucun client trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        }
        
        menuToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);
        
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

