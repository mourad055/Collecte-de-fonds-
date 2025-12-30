<div class="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-person-workspace"></i> Collecteur
    </div>
    <ul class="sidebar-menu">
        <li><a href="{{ route('collecteur.dashboard') }}" class="{{ request()->routeIs('collecteur.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="{{ route('clients.create') }}" class="{{ request()->routeIs('clients.create') ? 'active' : '' }}"><i class="bi bi-person-plus"></i> Enregistrer un client</a></li>
        <li><a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.index') ? 'active' : '' }}"><i class="bi bi-people"></i> Liste des clients</a></li>
        <li><a href="{{ route('paiement') }}" class="{{ request()->routeIs('paiement*') ? 'active' : '' }}"><i class="bi bi-cash-coin"></i> Enregistrer un paiement</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-link text-white text-start w-100" style="padding: 12px 20px; border: none; background: transparent;">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </button>
            </form>
        </li>
    </ul>
</div>

