@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('components.admin-menu')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>Dashboard Admin</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5>Pending Users</h5>
                                        <h2>{{ $pendingUsers }}</h2>
                                        <a href="{{ route('admin.pending-users') }}" class="btn btn-light btn-sm">Lihat
                                            Detail</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5>Total Users</h5>
                                        <h2>{{ $totalUsers }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5>Pending Pengajuan</h5>
                                        <h2>{{ $pendingPengajuan }}</h2>
                                        <a href="{{ route('admin.pengajuan-surat') }}" class="btn btn-light btn-sm">Lihat
                                            Detail</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h5>Total Pengajuan</h5>
                                        <h2>{{ $totalPengajuan }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
