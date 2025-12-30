<div class="sidebar">
    <div class="sidebar-brand">
        <i class="bi bi-shield-check"></i> Admin Panel
    </div>
    <ul class="sidebar-menu">
        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.collecteurs') }}" class="{{ request()->routeIs('admin.collecteurs*') ? 'active' : '' }}"><i class="bi bi-people"></i> Collecteurs</a></li>
        <li><a href="{{ route('admin.clients') }}" class="{{ request()->routeIs('admin.clients*') ? 'active' : '' }}"><i class="bi bi-person-badge"></i> Clients</a></li>
        <li><a href="{{ route('admin.transactions') }}" class="{{ request()->routeIs('admin.transactions') ? 'active' : '' }}"><i class="bi bi-arrow-left-right"></i> Transactions</a></li>
        <li><a href="{{ route('admin.encaissements') }}" class="{{ request()->routeIs('admin.encaissements*') ? 'active' : '' }}"><i class="bi bi-cash-coin"></i> Encaissements</a></li>
        <li><a href="{{ route('admin.rapport.financier') }}" class="{{ request()->routeIs('admin.rapport*') ? 'active' : '' }}"><i class="bi bi-file-earmark-pdf"></i> Rapports Financiers</a></li>
        <li><a href="{{ route('admin.statistiques') }}" class="{{ request()->routeIs('admin.statistiques') ? 'active' : '' }}"><i class="bi bi-graph-up"></i> Statistiques</a></li>
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

