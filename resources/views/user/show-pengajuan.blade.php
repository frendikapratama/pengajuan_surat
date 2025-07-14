@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('components.user-menu')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Pengajuan Surat</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if ($pengajuan->jenis_surat)
                                <div class="col-6 mb-3">
                                    <strong>Surat Pengantar Rt/Rw</strong>
                                    <div class="mt-1">
                                        <a href="{{ $pengajuan->jenis_surat_url }}" target="_blank">
                                            <img src="{{ $pengajuan->jenis_surat_url }}" alt="jenis_surat"
                                                class="img-thumbnail" style="max-width: 100px;">
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6">
                                <strong>Status:</strong>
                                <p>{!! $pengajuan->status_badge !!}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Tanggal Pengajuan:</strong>
                                <p>{{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                @if ($pengajuan->tanggal_selesai)
                                    <strong>Tanggal Selesai:</strong>
                                    <p>{{ $pengajuan->tanggal_selesai->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong>Keperluan:</strong>
                            <p>{{ $pengajuan->keperluan }}</p>
                        </div>

                        @if ($pengajuan->keterangan)
                            <div class="mb-3">
                                <strong>Keterangan:</strong>
                                <p>{{ $pengajuan->keterangan }}</p>
                            </div>
                        @endif

                        @if ($pengajuan->catatan_admin)
                            <div class="mb-3">
                                <strong>Catatan Admin:</strong>
                                <div class="alert alert-info">{{ $pengajuan->catatan_admin }}</div>
                            </div>
                        @endif

                        @if ($pengajuan->file_surat)
                            <div class="mb-3">
                                <strong>File Surat:</strong>
                                <br>
                                <a href="{{ $pengajuan->file_surat_url }}" class="btn btn-success" target="_blank">
                                    <i class="fas fa-download"></i> Download Surat
                                </a>
                            </div>
                        @endif

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
