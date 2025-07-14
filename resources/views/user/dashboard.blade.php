@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('components.user-menu')
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>Dashboard User</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5>Total Pengajuan</h5>
                                        <h3>{{ $pengajuanSurat->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5>Surat Selesai</h5>
                                        <h3>{{ $pengajuanSurat->where('status', 'selesai')->count() }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5>Riwayat Pengajuan Surat</h5>
                            </div>
                            <div class="card-body">
                                @if ($pengajuanSurat->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal Pengajuan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pengajuanSurat as $index => $pengajuan)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</td>
                                                        <td>{!! $pengajuan->status_badge !!}</td>
                                                        <td>
                                                            <a href="{{ route('user.pengajuan.show', $pengajuan->id) }}"
                                                                class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i> Detail
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>Belum ada pengajuan surat.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
