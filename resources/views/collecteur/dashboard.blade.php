<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Collecteur</title>
    <style>
        :root {
            --main-bg: #F3FFF6;                       /* Blanc/vert très pâle */
            --navbar-bg: #098142;                     /* Vert principal FONCÉ */
            --navbar-btn: #fff;                       /* Boutons navbar : blanc */
            --navbar-icon: #94d9ad;                   /* Vert clair pour icônes */
            --primary: #086230;                       /* Vert primaire FONCÉ */
            --primary-light: #daf4e6;                 /* Vert très clair */
            --action-bg: #fff;                        /* Fond des actions : blanc */
            --action-shadow: 0 4px 28px 0 rgba(9,129,66,0.10);
            --action-shadow-hover: 0 8px 40px 0 rgba(9,129,66,0.17);
            --action-accent: #e4f8ea;                 /* Accent de carte: vert très pâle */
            --action-icon: #086230;                   /* Icônes d'action : vert */
            --footer-bg: #075128;                     /* Footer vert foncé */
            --footer-txt: #fff;                       /* Texte footer blanc */
            --footer-link: #b3ffd3;                   /* Lien footer : vert menthe pâle */
            --footer-link-hover: #fff;                /* Hover: blanc */
            --action-btn-gradient-light: #daf4e6;     
            --action-btn-gradient-dark: #41b76f;      
            --action-btn-hover-gradient-light: #16a058; 
            --action-btn-hover-gradient-dark: #075128;
            --action-btn-glow: 0 4px 24px 0 rgba(9,129,66,0.08), 0 1.5px 7px 0 #35e68733;
            --action-btn-glow-hover: 0 8px 36px 0 rgba(9,129,66,0.24), 0 2px 8px 0 #27c37633;
            --action-btn-border: 2px solid #24dc7d;
            --text-main: #15452f;                     /* Texte principal : vert sombre */
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: var(--main-bg);
            margin: 0;
            min-height: 100vh;
            color: var(--text-main);
            display: flex;
            flex-direction: column;
        }
        /* Navbar green & modern */
        .navbar {
            width: 100%;
            background: var(--navbar-bg);
            color: var(--navbar-btn);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 46px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 14px 0 rgba(9,129,66,0.12);
        }
        .navbar .logo {
            font-size: 1.38em;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 9px;
        }
        .navbar .logo .ti {
            color: #d7ffe5;
            font-size: 1.5em;
        }
        .navbar .navbar-actions {
            display: flex;
            gap: 18px;
        }
        .navbar .nav-btn {
            background: linear-gradient(90deg, #0e5834 10%, #178a4b 80%);
            border: none;
            color: var(--navbar-btn);
            font-size: 1.05em;
            padding: 8px 22px 8px 16px;
            border-radius: 32px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background 0.17s, color 0.13s, box-shadow 0.16s, transform 0.09s;
            gap: 9px;
            outline: none;
            text-decoration: none;
            box-shadow: 0 2px 10px 0 rgba(15,72,41,0.07);
            border-bottom: 2.5px solid #13c16b55;
            position: relative;
            overflow: hidden;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .navbar .nav-btn .ti {
            font-size: 1.35em;
            color: var(--navbar-icon);
        }
        .navbar .nav-btn:hover, .navbar .nav-btn:focus-visible {
            background: linear-gradient(90deg, #18b273 18%, #086230 90%);
            color: #b9fddd;
            transform: translateY(-1.5px) scale(1.04);
            box-shadow: 0 2px 22px 0 rgba(9,129,66,0.17);
        }
        /* Container and Welcome */
        .container {
            max-width: 780px;
            margin: 40px auto 32px auto;
            background: var(--action-bg);
            border-radius: 22px;
            box-shadow: var(--action-shadow);
            padding: 44px 46px 38px 46px;
            text-align: center;
        }
        .welcome-modern {
            font-size: 1.62em;
            margin-bottom: 31px;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 1px;
            background: var(--primary-light);
            border-radius: 14px;
            display: inline-block;
            padding: 18px 42px 17px 42px;
            border-left: 7px solid var(--primary);
            border-bottom: 2.5px solid #41b76f;
            box-shadow: 0 4px 22px 0 #09451b0e;
        }
        /* Actions - Modern neon-green button style */
        .actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 34px 24px;
            margin-top: 23px;
        }
        .action-btn {
            background: linear-gradient(120deg, var(--action-btn-gradient-light) 50%, var(--action-btn-gradient-dark) 98%);
            color: var(--primary);
            border: var(--action-btn-border);
            outline: none;
            border-radius: 19px;
            font-size: 1.14em;
            font-weight: 700;
            padding: 29px 39px 25px 39px;
            box-shadow: var(--action-btn-glow);
            transition: 
                background 0.13s, 
                box-shadow 0.16s, 
                transform 0.11s, 
                color 0.13s, 
                border 0.17s;
            cursor: pointer;
            min-width: 210px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            margin-bottom: 3px;
            letter-spacing: 0.5px;
        }
        .action-btn .action-icon {
            font-size: 2.14em;
            margin-bottom: 12px;
            color: #1ae977;
            background: linear-gradient(130deg, #a8f2c9 62%, #e1fbe3 100%);
            border-radius: 99px;
            padding: 11px 15px 10px 15px;
            box-shadow: 0 3px 14px 0 rgba(22,192,100,0.13);
            margin-top: -7px;
            border: 2px solid #24dc7d2c;
            transition: color 0.14s, box-shadow 0.12s;
        }
        .action-btn:hover,
        .action-btn:focus-visible {
            background: linear-gradient(120deg, var(--action-btn-hover-gradient-light) 10%, var(--action-btn-hover-gradient-dark) 100%);
            transform: translateY(-5px) scale(1.045);
            box-shadow: var(--action-btn-glow-hover);
            color: #16a058;
            border: 2.5px solid #1ae977;
        }
        .action-btn:hover .action-icon,
        .action-btn:focus-visible .action-icon {
            color: #fff;
            background: linear-gradient(120deg, #13c16b 50%, #24dc7d 100%);
            border: 2px solid #1ae977;
            box-shadow: 0 5px 18px 0 #22d78b22;
        }
        .action-btn:active {
            background: #c5ffd8;
            color: #0c9957;
            border: 2.5px solid #13c16bcc;
            box-shadow: 0 1px 4px #21c77135;
        }
        @media (max-width: 820px) {
            .container {
                max-width: 99vw;
                padding: 8vw 4vw 8vw 4vw;
            }
            .actions { gap: 19px 0;}
        }
        @media (max-width: 600px) {
            .container {
                padding: 4vw 2vw 5vw 2vw;
                margin: 26px 2vw 16px 2vw;
            }
            .welcome-modern {
                font-size: 1.07em;
                padding: 12px 10vw 10px 5vw;
            }
            .actions { gap: 14px 0; }
            .action-btn { min-width: 90vw; font-size: 1em; padding: 17px 9px;}
            .action-icon { font-size: 1.6em;}
            .navbar { flex-direction: column; gap: 9px; padding: 14px 5vw;}
            .navbar .logo { font-size: 1.08em;}
        }
        /* Footer green */
        .footer {
            background: var(--footer-bg);
            color: var(--footer-txt);
            text-align: center;
            padding: 26px 14px 23px 14px;
            font-size: 1em;
            margin-top: auto;
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
            box-shadow: 0 -1px 17px 0 rgba(9,129,66,0.08);
        }
        .footer .footer-links {
            margin-bottom: 11px;
            display: flex;
            justify-content: center;
            gap: 21px;
            flex-wrap: wrap;
        }
        .footer a {
            color: var(--footer-link);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.17s;
        }
        .footer a:hover {
            color: var(--footer-link-hover);
            text-decoration: underline;
        }
    </style>
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.47.0/tabler-icons.min.css">
</head>
<body>
    <!-- Navbar moderne -->
    <nav class="navbar">
        <div class="logo">
            <i class="ti ti-grid-dots"></i>
            Collecteur
        </div>
        <div class="navbar-actions">
            <a href="#" class="nav-btn" title="Aide">
                <i class="ti ti-help-circle"></i>
                Aide
            </a>
            <a href="#" class="nav-btn" title="Paramètres">
                <i class="ti ti-settings"></i>
                Paramètres
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="nav-btn" title="Déconnexion">
                    <i class="ti ti-logout"></i>
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>
    <div class="container">
        <div class="welcome-modern">
            Bienvenue, <span style="color:var(--primary);">{{ Auth::user()->name }}</span>
        </div>
        <div class="actions">
            <a href="{{ route('clients.create') }}" class="action-btn">
                <span class="action-icon"><i class="ti ti-user-plus"></i></span>
                Enregistrer un client
            </a>
            <a href="{{ route('clients.index') }}" class="action-btn">
                <span class="action-icon"><i class="ti ti-users"></i></span>
                Liste des clients enregistrés
            </a>
            <a href="{{ route('clients.create') }}" class="action-btn">
                <span class="action-icon"><i class="ti ti-user-circle"></i></span>
                Créer un compte client
            </a>
            <a href="{{ route('paiement') }}" class="action-btn">
                <span class="action-icon"><i class="ti ti-currency-dollar"></i></span>
                Enregistrer un paiement
            </a>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-links">
            <a href="#">Aide</a>
            <a href="#">Contact support</a>
            <a href="#">Mentions légales</a>
        </div>
        &copy; {{ date('Y') }} MonApplication • Interface Collecteur moderne
    </footer>
</body>
</html>