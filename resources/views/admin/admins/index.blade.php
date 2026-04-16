<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateurs | Collecte+</title>
    
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
            --sidebar-width: 260px;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
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
            color: white;
            padding: 20px 0;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(14, 141, 77, 0.15);
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
        }
        
        /* Admin Card */
        .admin-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 8px 30px rgba(53,92,125,0.12);
            transition: all 0.3s ease;
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(14, 141, 77, 0.2);
        }
        
        /* Mobile */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            background: var(--primary-green);
            color: white;
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
        
        .fab-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 30px rgba(14, 141, 77, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 50;
            text-decoration: none;
            color: white;
        }
        
        .fab-button:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 12px 40px rgba(14, 141, 77, 0.5);
            color: white;
        }
        
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
        }
        
        @media (max-width: 640px) {
            .fab-button {
                width: 60px;
                height: 60px;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="menu-toggle" id="menuToggle">
        <i class="bi bi-list"></i>
    </button>
    
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
   

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary to-green-600 shadow-2xl" style="background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%); border-radius: 20px; margin-bottom: 30px;">
            <div class="px-4 px-md-5 py-4">
                <!-- Bouton retour -->
                <div class="mb-3" style="animation: slideDown 0.5s ease-out;">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="d-inline-flex align-items-center gap-2 px-4 py-2 text-white text-decoration-none"
                       style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 12px; transition: all 0.3s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                       onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                        <i class="ti ti-arrow-left" style="font-size: 1.2rem;"></i>
                        <span class="fw-semibold">Retour au dashboard</span>
                    </a>
                </div>
                
                <!-- Titre et bouton -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 text-white">
                    <div>
                        <h1 class="h2 fw-bold mb-2 d-flex align-items-center gap-2">
                            <i class="ti ti-shield-lock" style="font-size: 2.5rem;"></i>
                            Administrateurs
                        </h1>
                        <p class="mb-0 opacity-75">Gérez les comptes administrateurs de la plateforme</p>
                    </div>
                    <div class="d-flex gap-3">
                        <div class="text-center px-4 py-3" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 15px;">
                            <p class="h3 fw-bold mb-0">{{ count($admins) }}</p>
                            <p class="small mb-0 opacity-90">Administrateurs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 mb-4" 
                 style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-left: 4px solid #28a745 !important; border-radius: 15px; box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);">
                <div class="d-flex align-items-center">
                    <div class="me-3" style="width: 40px; height: 40px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="ti ti-check text-white" style="font-size: 1.5rem;"></i>
                    </div>
                    <p class="mb-0 fw-semibold text-success">{{ session('success') }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Barre de recherche -->
        <div class="bg-white rounded-4 shadow-lg p-4 mb-4">
            <div class="d-flex flex-column flex-md-row gap-3">
                <div class="flex-fill position-relative">
                    <div class="position-absolute top-50 start-0 translate-middle-y ms-3">
                        <i class="ti ti-search text-muted" style="font-size: 1.2rem;"></i>
                    </div>
                    <input type="text" 
                           id="searchInput"
                           placeholder="Rechercher un administrateur (nom, email...)" 
                           class="form-control border-2 ps-5 py-3"
                           style="border-radius: 12px; border-color: #e0e0e0;">
                </div>
            </div>
        </div>

        <!-- Liste des administrateurs -->
        @forelse($admins as $index => $admin)
            <div class="admin-card" style="animation: fadeIn {{ $index * 0.05 }}s ease-out;">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4">
                    
                    <!-- Info admin -->
                    <div class="d-flex align-items-start gap-3 flex-fill">
                        <!-- Avatar -->
                        <div class="d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                             style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; font-size: 1.5rem;">
                            {{ strtoupper(substr($admin->nom_admin, 0, 1)) }}{{ strtoupper(substr($admin->prenom_admin, 0, 1)) }}
                        </div>
                        
                        <!-- Details -->
                        <div class="flex-fill">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <h5 class="mb-0 fw-bold">{{ $admin->nom_admin }} {{ $admin->prenom_admin }}</h5>
                                <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="ti ti-shield-check me-1"></i>Admin
                                </span>
                            </div>
                            <div class="d-flex flex-wrap gap-3 small text-muted">
                                <span class="d-flex align-items-center gap-1">
                                    <i class="ti ti-mail" style="color: #0E8D4D;"></i>
                                    {{ $admin->email_admin }}
                                </span>
                                <span class="d-flex align-items-center gap-1">
                                    <i class="ti ti-calendar" style="color: #0E8D4D;"></i>
                                    Créé le {{ $admin->created_at?->format('d/m/Y à H:i') ?? 'N/A' }}
                                </span>
                                <span class="d-flex align-items-center gap-1">
                                    <i class="ti ti-hash" style="color: #0E8D4D;"></i>
                                    ID: {{ $admin->id_admin }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Badge admin actif -->
                    <div class="text-center px-4 py-3" 
                         style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-radius: 12px; border: 2px solid #28a745;">
                        <i class="ti ti-circle-check-filled text-success" style="font-size: 2rem;"></i>
                        <p class="mb-0 small fw-bold text-success mt-1">Actif</p>
                    </div>

                </div>
            </div>
        @empty
            <div class="bg-white rounded-4 shadow-lg p-5 text-center">
                <div class="d-flex align-items-center justify-content-center mx-auto mb-4"
                     style="width: 120px; height: 120px; background: #f8f9fa; border-radius: 50%;">
                    <i class="ti ti-user-x text-muted" style="font-size: 4rem;"></i>
                </div>
                <h3 class="fw-bold mb-3">Aucun administrateur trouvé</h3>
                <p class="text-muted mb-4">Commencez par ajouter le premier administrateur</p>
                <a href="{{ route('admin.admins.create') }}" 
                   class="btn btn-lg text-white fw-bold"
                   style="background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%); border-radius: 12px; box-shadow: 0 4px 15px rgba(14, 141, 77, 0.3);">
                    <i class="ti ti-plus me-2"></i>
                    Ajouter un administrateur
                </a>
            </div>
        @endforelse

    </div>

    <!-- Bouton flottant d'ajout (FAB) -->
    @if(count($admins) > 0)
        <a href="{{ route('admin.admins.create') }}" class="fab-button" title="Ajouter un administrateur">
            <i class="ti ti-plus" style="font-size: 2.5rem;"></i>
        </a>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            });
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        }

        // Recherche en temps réel
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                const adminCards = document.querySelectorAll('.admin-card');
                
                adminCards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeIn 0.3s ease-out';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</body>
</html>