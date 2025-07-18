<div class="card">
    <div class="card-header">Menu</div>
    <div class="list-group list-group-flush">
        <a href="{{ route('user.dashboard') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <a href="{{ route('user.pengajuan.create') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('user.pengajuan.create') ? 'active' : '' }}">
            <i class="fas fa-plus"></i> Ajukan Surat
        </a>
    </div>
</div>
