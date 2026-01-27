<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un client | Collecte+</title>
    
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
    @include('collecteur.partials.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        
        <!-- Page Header -->
        <div class="page-header">
            <h4>
                <i class="ti ti-user-plus"></i>
                Ajouter un client
            </h4>
            <p class="text-muted mb-0 mt-2">Créez un nouveau compte client dans le système</p>
        </div>

        <!-- Form Card -->
        <div class="modern-card">
            
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success border-0 mb-4" style="background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); border-left: 4px solid #4CAF50 !important;">
                    <div class="d-flex align-items-start">
                        <i class="ti ti-check-circle" style="font-size: 1.5rem; color: #2E7D32; margin-right: 12px; margin-top: 2px;"></i>
                        <div>
                            <strong style="color: #1B5E20;">Succès</strong>
                            <p class="mb-0" style="color: #2E7D32; font-size: 0.95rem;">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger border-0 mb-4" style="background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); border-left: 4px solid #f44336 !important;">
                    <div class="d-flex align-items-start">
                        <i class="ti ti-alert-circle" style="font-size: 1.5rem; color: #c62828; margin-right: 12px; margin-top: 2px;"></i>
                        <div>
                            <strong style="color: #b71c1c;">Erreurs de validation</strong>
                            <ul class="mb-0 mt-2" style="color: #c62828; font-size: 0.95rem;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Info Alert -->
            <div class="alert alert-info border-0 mb-4" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-left: 4px solid #2196F3 !important;">
                <div class="d-flex align-items-start">
                    <i class="ti ti-info-circle" style="font-size: 1.5rem; color: #1976D2; margin-right: 12px; margin-top: 2px;"></i>
                    <div>
                        <strong style="color: #1565C0;">Information</strong>
                        <p class="mb-0" style="color: #1976D2; font-size: 0.95rem;">Les informations de connexion sont optionnelles. Si vous les renseignez, le client pourra se connecter à l'application.</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('clients.store') }}">
                @csrf

                <!-- Section: Informations personnelles -->
                <h5 class="mb-4 pb-3 border-bottom" style="color: var(--primary-green); font-weight: 700;">
                    <i class="ti ti-id me-2"></i>
                    Informations personnelles
                </h5>

                <div class="row">
                    <!-- Nom -->
                    <div class="col-md-6 mb-4">
                        <label for="nom_cli" class="form-label">
                            Nom <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-icon">
                            <input type="text" 
                                   id="nom_cli" 
                                   name="nom_cli" 
                                   class="form-control @error('nom_cli') is-invalid @enderror" 
                                   placeholder="Entrez le nom"
                                   value="{{ old('nom_cli') }}"
                                   required>
                            <i class="ti ti-user"></i>
                        </div>
                        @error('nom_cli')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Prénom -->
                    <div class="col-md-6 mb-4">
                        <label for="prenom_cli" class="form-label">
                            Prénom <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-icon">
                            <input type="text" 
                                   id="prenom_cli" 
                                   name="prenom_cli" 
                                   class="form-control @error('prenom_cli') is-invalid @enderror" 
                                   placeholder="Entrez le prénom"
                                   value="{{ old('prenom_cli') }}"
                                   required>
                            <i class="ti ti-user"></i>
                        </div>
                        @error('prenom_cli')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="col-md-6 mb-4">
                        <label for="tel_cli" class="form-label">
                            Téléphone <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-icon">
                            <input type="tel" 
                                   id="tel_cli" 
                                   name="tel_cli" 
                                   class="form-control @error('tel_cli') is-invalid @enderror" 
                                   placeholder="+237 6XX XXX XXX"
                                   value="{{ old('tel_cli') }}"
                                   required>
                            <i class="ti ti-phone"></i>
                        </div>
                        @error('tel_cli')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Adresse -->
                    <div class="col-md-6 mb-4">
                        <label for="adresse_cli" class="form-label">
                            Adresse <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-icon">
                            <input type="text" 
                                   id="adresse_cli" 
                                   name="adresse_cli" 
                                   class="form-control @error('adresse_cli') is-invalid @enderror" 
                                   placeholder="Entrez l'adresse complète"
                                   value="{{ old('adresse_cli') }}"
                                   required>
                            <i class="ti ti-map-pin"></i>
                        </div>
                        @error('adresse_cli')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Solde initial -->
                    <div class="col-md-12 mb-4">
                        <label for="solde_cli" class="form-label">
                            Solde initial <span class="text-danger">*</span>
                        </label>
                        <div class="input-group-icon">
                            <input type="number" 
                                   id="solde_cli" 
                                   name="solde_cli" 
                                   class="form-control @error('solde_cli') is-invalid @enderror" 
                                   placeholder="0"
                                   value="{{ old('solde_cli', 0) }}"
                                   min="0"
                                   step="0.01"
                                   required>
                            <i class="ti ti-cash"></i>
                        </div>
                        @error('solde_cli')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="ti ti-info-circle"></i>
                            Montant initial du compte client (en FCFA)
                        </small>
                    </div>
                </div>

                <!-- Section: Accès au compte (Optionnel) -->
                <h5 class="mb-4 pb-3 border-bottom mt-4" style="color: var(--primary-green); font-weight: 700;">
                    <i class="ti ti-lock me-2"></i>
                    Paramètres de connexion <span class="badge bg-secondary ms-2">Optionnel</span>
                </h5>

                <div class="row">
                    <!-- Email -->
                    <div class="col-md-12 mb-4">
                        <label for="user_email" class="form-label">
                            Email de connexion
                        </label>
                        <div class="input-group-icon">
                            <input type="email" 
                                   id="user_email" 
                                   name="user_email" 
                                   class="form-control @error('user_email') is-invalid @enderror" 
                                   placeholder="email@exemple.com"
                                   value="{{ old('user_email') }}">
                            <i class="ti ti-mail"></i>
                        </div>
                        @error('user_email')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="ti ti-info-circle"></i>
                            Si renseigné, le client pourra se connecter avec cet email
                        </small>
                    </div>

                    <!-- Mot de passe -->
                    <div class="col-md-6 mb-4">
                        <label for="user_password" class="form-label">
                            Mot de passe
                        </label>
                        <div class="input-group-icon">
                            <input type="password" 
                                   id="user_password" 
                                   name="user_password" 
                                   class="form-control @error('user_password') is-invalid @enderror" 
                                   placeholder="••••••••">
                            <i class="ti ti-key"></i>
                            <span class="password-toggle" onclick="togglePassword('user_password', 'eye1')">
                                <i id="eye1" class="ti ti-eye"></i>
                            </span>
                        </div>
                        @error('user_password')
                            <div class="text-danger mt-1" style="font-size: 0.875rem;">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="ti ti-shield-lock"></i>
                            Minimum 6 caractères
                        </small>
                    </div>

                    <!-- Confirmation -->
                    <div class="col-md-6 mb-4">
                        <label for="user_password_confirmation" class="form-label">
                            Confirmer le mot de passe
                        </label>
                        <div class="input-group-icon">
                            <input type="password" 
                                   id="user_password_confirmation" 
                                   name="user_password_confirmation" 
                                   class="form-control" 
                                   placeholder="••••••••">
                            <i class="ti ti-lock-check"></i>
                            <span class="password-toggle" onclick="togglePassword('user_password_confirmation', 'eye2')">
                                <i id="eye2" class="ti ti-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-5 d-flex gap-3 flex-wrap">
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-check-circle me-2"></i>
                        Enregistrer le client
                    </button>
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-2"></i>
                        Retour à la liste
                    </a>
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="ti ti-refresh me-2"></i>
                        Réinitialiser
                    </button>
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
        const password = document.getElementById('user_password');
        const confirmPassword = document.getElementById('user_password_confirmation');

        if (confirmPassword) {
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
        }

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