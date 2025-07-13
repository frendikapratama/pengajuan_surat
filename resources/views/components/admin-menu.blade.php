{{-- resources/views/components/admin-menu.blade.php --}}
<div class="card">
    <div class="card-header">Menu Admin</div>
    <div class="list-group list-group-flush">
        <a href="{{ route('admin.dashboard') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <a href="{{ route('admin.pending-users') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('admin.pending-users') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Pending Users
            @if (isset($pendingUsers) && $pendingUsers > 0)
                <span class="badge bg-warning">{{ $pendingUsers }}</span>
            @endif
        </a>

        <a href="{{ route('admin.pengajuan-surat') }}"
            class="list-group-item list-group-item-action {{ request()->routeIs('admin.pengajuan-surat') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Pengajuan Surat
            @if (isset($pendingPengajuan) && $pendingPengajuan > 0)
                <span class="badge bg-info">{{ $pendingPengajuan }}</span>
            @endif
        </a>

        {{-- Menu tambahan bisa ditambahkan sesuai kebutuhan --}}
        {{-- Contoh menu lain yang bisa ditambahkan jika route sudah dibuat:
        <a href="{{ route('admin.users') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <i class="fas fa-user-cog"></i> Kelola Users
        </a>
        
        <a href="{{ route('admin.reports') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Laporan
        </a>
        
        <a href="{{ route('admin.settings') }}" 
           class="list-group-item list-group-item-action {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Pengaturan
        </a>
        --}}
    </div>
</div>
