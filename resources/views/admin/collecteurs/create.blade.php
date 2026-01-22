<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Collecteur</title>
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
        }
        
        @media (max-width: 576px) {
            .main-content {
                padding: 10px;
            }
            
            .dashboard-card {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    @include('admin.partials.mobile-menu')
    @include('admin.partials.sidebar')
    
    <div class="main-content">
        <h4 class="mb-4"><i class="bi bi-person-plus me-2"></i>Ajouter un Collecteur</h4>
        
        <div class="dashboard-card">
            <form action="{{ route('admin.collecteurs.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom_collect" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nom_collect" name="nom_collect" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prenom_collect" class="form-label">Prénom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="prenom_collect" name="prenom_collect" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tel_collect" class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tel_collect" name="tel_collect" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="zone_collect" class="form-label">Zone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="zone_collect" name="zone_collect" required>
                    </div>
                    <hr class="mt-4 mb-3">
                    <div class="col-12">
                        <h5>Compte d'accès pour le collecteur (optionnel)</h5>
                        <p class="text-muted mb-3">En renseignant un email et un mot de passe, un compte de connexion sera créé pour ce collecteur.</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="user_email" class="form-label">Email de connexion</label>
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="email@exemple.com">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="user_password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="user_password" name="user_password">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="user_password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="user_password_confirmation" name="user_password_confirmation">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                    <a href="{{ route('admin.collecteurs') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

