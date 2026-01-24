<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Espace Client</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }

        .navbar {
            background: linear-gradient(135deg, #16a085 0%, #1abc9c 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            font-size: 24px;
        }

        .navbar .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.3s;
        }

        .navbar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }

        .page-header {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .page-header h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #666;
        }

        .notifications-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .notification-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-left: 4px solid #16a085;
            transition: all 0.2s;
        }

        .notification-card:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
        }

        .notification-card.non-lu {
            background: #e3f2fd;
            border-left-color: #3498db;
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 12px;
        }

        .notification-titre {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            flex: 1;
        }

        .notification-date {
            color: #999;
            font-size: 13px;
            white-space: nowrap;
            margin-left: 20px;
        }

        .notification-message {
            color: #555;
            line-height: 1.6;
            font-size: 15px;
        }

        .notification-badge {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            margin-left: 10px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 25px;
        }

        .pagination a,
        .pagination span {
            padding: 10px 16px;
            background: white;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            transition: all 0.2s;
        }

        .pagination a:hover {
            background: #16a085;
            color: white;
            transform: translateY(-2px);
        }

        .pagination .active {
            background: #16a085;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            fill: #ccc;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #666;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: #16a085;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #1abc9c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(22, 160, 133, 0.3);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Notifications</h1>
        <div class="nav-links">
            <a href="{{ route('client.dashboard') }}">Dashboard</a>
            <a href="{{ route('client.solde') }}">Solde</a>
            <a href="{{ route('client.historique') }}">Historique</a>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h2>Centre de notifications</h2>
            <p>Restez informé de toutes vos activités</p>
        </div>

        <div class="notifications-list">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="notification-card {{ !$notification->lu ? 'non-lu' : '' }}">
                        <div class="notification-header">
                            <div class="notification-titre">
                                {{ $notification->titre }}
                                @if(!$notification->lu)
                                    <span class="notification-badge">Nouveau</span>
                                @endif
                            </div>
                            <div class="notification-date">
                                {{ $notification->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="notification-message">
                            {{ $notification->message }}
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.89 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                    </svg>
                    <h3>Aucune notification</h3>
                    <p>Vous n'avez aucune notification pour le moment</p>
                </div>
            @endif
        </div>

        @if($notifications->hasPages())
            <div class="pagination">
                @if ($notifications->onFirstPage())
                    <span>← Précédent</span>
                @else
                    <a href="{{ $notifications->previousPageUrl() }}">← Précédent</a>
                @endif

                <span class="active">Page {{ $notifications->currentPage() }}</span>

                @if ($notifications->hasMorePages())
                    <a href="{{ $notifications->nextPageUrl() }}">Suivant →</a>
                @else
                    <span>Suivant →</span>
                @endif
            </div>
        @endif

        <a href="{{ route('client.dashboard') }}" class="back-btn">← Retour au Dashboard</a>
    </div>
</body>
</html>