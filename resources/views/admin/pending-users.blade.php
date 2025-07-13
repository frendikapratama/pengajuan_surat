@extends('layouts.app')

@section('title', 'Pending Users')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('components.admin-menu')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>Users Menunggu Persetujuan</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <span class="badge bg-warning">{{ ucfirst($user->status) }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.user.detail', $user->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                <form method="POST" action="{{ route('admin.approve-user', $user->id) }}"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success"
                                                        onclick="return confirm('Setujui user ini?')">
                                                        <i class="fas fa-check"></i> Setujui
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.reject-user', $user->id) }}"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Tolak user ini?')">
                                                        <i class="fas fa-times"></i> Tolak
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada user yang menunggu persetujuan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
