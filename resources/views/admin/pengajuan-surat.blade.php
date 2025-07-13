@extends('layouts.app')

@section('title', 'Pengajuan Surat')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('components.admin-menu')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>Kelola Pengajuan Surat</h4>
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
                                        <th>Nama Pemohon</th>
                                        <th>Jenis Surat</th>
                                        <th>Keperluan</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengajuanSurat as $pengajuan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pengajuan->user->profile->nama ?? $pengajuan->user->name }}</td>
                                            <td>{{ $pengajuan->jenis_surat }}</td>
                                            <td>{{ Str::limit($pengajuan->keperluan, 50) }}</td>
                                            <td>{{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</td>
                                            <td>{!! $pengajuan->status_badge !!}</td>
                                            <td>
                                                <a href="{{ route('admin.pengajuan.detail', $pengajuan->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Belum ada pengajuan surat</td>
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
