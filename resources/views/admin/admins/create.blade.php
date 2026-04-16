<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un administrateur | Collecte+</title>
    
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
        
        /* Sidebar Styles - Compatible avec votre sidebar */
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
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.15);
            border-left: 4px solid white;
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
        
        /* Card Modern */
        .modern-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(53,92,125,0.12);
            border: none;
            padding: 40px;
            margin-top: 20px;
        }
        
        /* Form Inputs */
        .form-label {
            font-weight: 600;
            color: #23272F;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(14, 141, 77, 0.1);
        }
        
        /* Buttons */
        .btn-success {
            background: linear-gradient(135deg, #0E8D4D 0%, #47a55e 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(14, 141, 77, 0.3);
            transition: all 0.3s;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 141, 77, 0.4);
            background: linear-gradient(135deg, #0b6f3d 0%, #0E8D4D 100%);
        }
        
        .btn-secondary {
            border: 2px solid #6c757d;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            background: white;
            color: #6c757d;
            transition: all 0.3s;
        }
        
        .btn-secondary:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-2px);
        }
        
        /* Header */
        .page-header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        
        .page-header h4 {
            margin: 0;
            font-weight: 700;
            color: #23272F;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .page-header h4 i {
            color: var(--primary-green);
        }
        
        /* Input Icons */
        .input-group-icon {
            position: relative;
        }
        
        .input-group-icon .form-control {
            padding-left: 45px;
        }
        
        .input-group-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }
        
        .input-group-icon .form-control:focus ~ i {
            color: var(--primary-green);
        }
        
        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 10;
        }
        
        .password-toggle:hover {
            color: var(--primary-green);
        }
        
        /* Mobile Menu Toggle */
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
        }
        
        @media (max-width: 768px) {
            .modern-card {
                padding: 25px 20px;
            }
            
            .page-header {
                padding: 20px;
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
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Page Header -->
        <div class="page-header">
            <h4>
                <i class="ti ti-user-plus"></i>
                Ajouter un administrateur
            </h4>
            <p class="text-muted mb-0 mt-2">Créez un nouveau compte administrateur pour la plateforme</p>
        </div>

        <!-- Form Card -->
        <div class="modern-card">
            
            <!-- Info Alert -->
            <div class="alert alert-info border-0 mb-4" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-left: 4px solid #2196F3 !important;">
                <div class="d-flex align-items-start">
                    <i class="ti ti-info-circle" style="font-size: 1.5rem; color: #1976D2; margin-right: 12px; margin-top: 2px;"></i>
                    <div>
                        <strong style="color: #1565C0;">Important</strong>
                        <p class="mb-0" style="color: #1976D2; font-size: 0.95rem;">L'administrateur aura un accès complet à la plateforme. Assurez-vous de choisir un mot de passe fort et sécurisé.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.admins.store') }}">
                @csrf

                <!-- Section: Informations personnelles -->
                <h5 class="mb-4 pb-3 border-bottom" style="color: var(--primary-green); font-weight: 700;">
                    <i class="ti ti-id me-2"></i>
                    Informations personnelles
                </h5>

                <div class="row">
                    <!-- Nom -->
                    <div class="col-md-6 mb-4">
                        <label for="nom_admin" class="form-label">
                            Nom <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-icon">
                            <input type="text" 
                                   id="nom_admin" 
                                   name="nom_admin" 
                                   class="form-control" 
                                   placeholder="Entrez le nom"
                                   required>
                            <i class="ti ti-user"></i>
                        </div>
                    </div>

                    <!-- Prénom -->
                    <div class="col-md-6 mb-4">
                        <label for="prenom_admin" class="form-label">
                            Prénom <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-icon">
                            <input type="text" 
                                   id="prenom_admin" 
                                   name="prenom_admin" 
                                   class="form-control" 
                                   placeholder="Entrez le prénom"
                                   required>
                            <i class="ti ti-user"></i>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-12 mb-4">
                        <label for="email_admin" class="form-label">
                            Email de connexion <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-icon">
                            <input type="email" 
                                   id="email_admin" 
                                   name="email_admin" 
                                   class="form-control" 
                                   placeholder="admin@exemple.com"
                                   required>
                            <i class="ti ti-mail"></i>
                        </div>
                        <small class="text-muted">
                            <i class="ti ti-info-circle"></i>
                            Cette adresse sera utilisée pour se connecter à la plateforme
                        </small>
                    </div>
                </div>

                <!-- Section: Sécurité -->
                <h5 class="mb-4 pb-3 border-bottom mt-4" style="color: var(--primary-green); font-weight: 700;">
                    <i class="ti ti-lock me-2"></i>
                    Paramètres de sécurité
                </h5>

                <div class="row">
                    <!-- Mot de passe -->
                    <div class="col-md-6 mb-4">
                        <label for="password" class="form-label">
                            Mot de passe <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-icon">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="••••••••"
                                   required>
                            <i class="ti ti-key"></i>
                            <span class="password-toggle" onclick="togglePassword('password', 'eye1')">
                                <i id="eye1" class="ti ti-eye"></i>
                            </span>
                        </div>
                        <small class="text-muted">
                            <i class="ti ti-shield-lock"></i>
                            Minimum 8 caractères
                        </small>
                    </div>

                    <!-- Confirmation -->
                    <div class="col-md-6 mb-4">
                        <label for="password_confirmation" class="form-label">
                            Confirmer le mot de passe <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-icon">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   class="form-control" 
                                   placeholder="••••••••"
                                   required>
                            <i class="ti ti-lock-check"></i>
                            <span class="password-toggle" onclick="togglePassword('password_confirmation', 'eye2')">
                                <i id="eye2" class="ti ti-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-5 d-flex gap-3 flex-wrap">
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-check-circle me-2"></i>
                        Enregistrer l'administrateur
                    </button>
                    <a href="{{ route('admin.admins') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-2"></i>
                        Retour à la liste
                    </a>
                </div>

            </form>
        </div>

    </div>

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

        // Toggle password visibility
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('ti-eye');
                icon.classList.add('ti-eye-off');
            } else {
                input.type = 'password';
                icon.classList.remove('ti-eye-off');
                icon.classList.add('ti-eye');
            }
        }

        // Validation des mots de passe
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');

        confirmPassword.addEventListener('input', function() {
            if (password.value && confirmPassword.value) {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Les mots de passe ne correspondent pas');
                    confirmPassword.classList.add('is-invalid');
                } else {
                    confirmPassword.setCustomValidity('');
                    confirmPassword.classList.remove('is-invalid');
                    confirmPassword.classList.add('is-valid');
                }
            }
        });

        // Animation des icônes au focus
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                const icon = this.parentElement.querySelector('.ti');
                if (icon && !icon.classList.contains('password-toggle')) {
                    icon.style.transform = 'translateY(-50%) scale(1.2)';
                    icon.style.transition = 'transform 0.2s ease';
                }
            });

            input.addEventListener('blur', function() {
                const icon = this.parentElement.querySelector('.ti');
                if (icon && !icon.classList.contains('password-toggle')) {
                    icon.style.transform = 'translateY(-50%) scale(1)';
                }
            });
        });
    </script>
</body>
</html>