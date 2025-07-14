@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('components.admin-menu')
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Detail Pengajuan Surat</h4>
                        <a href="{{ route('admin.pengajuan-surat') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="row">
                            <!-- Informasi Pengajuan -->
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Informasi Pengajuan</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>ID Pengajuan:</strong></td>
                                                <td>#{{ $pengajuan->id }}</td>
                                            </tr>

                                            <tr>
                                                <td><strong>Tanggal Pengajuan:</strong></td>
                                                <td>{{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>{!! $pengajuan->status_badge !!}</td>
                                            </tr>
                                            @if ($pengajuan->tanggal_selesai)
                                                <tr>
                                                    <td><strong>Tanggal Selesai:</strong></td>
                                                    <td>{{ $pengajuan->tanggal_selesai->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>

                                <!-- Keperluan dan Keterangan -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Detail Keperluan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <strong>Keperluan:</strong>
                                            <p class="mt-1">{{ $pengajuan->keperluan }}</p>
                                        </div>
                                        @if ($pengajuan->keterangan)
                                            <div class="mb-3">
                                                <strong>Keterangan Tambahan:</strong>
                                                <p class="mt-1">{{ $pengajuan->keterangan }}</p>
                                            </div>
                                        @endif
                                        @if ($pengajuan->catatan_admin)
                                            <div class="mb-3">
                                                <strong>Catatan Admin:</strong>
                                                <p class="mt-1 text-info">{{ $pengajuan->catatan_admin }}</p>
                                            </div>
                                        @endif
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
                                    </div>
                                </div>

                                <!-- File Surat (jika sudah ada) -->
                                @if ($pengajuan->file_surat)
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h5 class="mb-0">File Surat</h5>
                                        </div>
                                        <div class="card-body">
                                            <a href="{{ $pengajuan->file_surat_url }}" target="_blank"
                                                class="btn btn-success">
                                                <i class="fas fa-download"></i> Download Surat
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Informasi Pemohon -->
                            <div class="col-md-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Informasi Pemohon</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td width="40%"><strong>Nama:</strong></td>
                                                <td>{{ $pengajuan->user->profile->nama }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $pengajuan->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>No. Telepon:</strong></td>
                                                <td>{{ $pengajuan->user->profile->no_telepon }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NIK:</strong></td>
                                                <td>{{ $pengajuan->user->profile->nik }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>No. KK:</strong></td>
                                                <td>{{ $pengajuan->user->profile->no_kk }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat:</strong></td>
                                                <td>{{ $pengajuan->user->profile->alamat }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Dokumen Pemohon -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Dokumen Pemohon</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @if ($pengajuan->user->profile->foto_ktp)
                                                <div class="col-6 mb-3">
                                                    <strong>Foto KTP:</strong>
                                                    <div class="mt-1">
                                                        <a href="{{ $pengajuan->user->profile->foto_ktp_url }}"
                                                            target="_blank">
                                                            <img src="{{ $pengajuan->user->profile->foto_ktp_url }}"
                                                                alt="KTP" class="img-thumbnail"
                                                                style="max-width: 100px;">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($pengajuan->user->profile->foto_kk)
                                                <div class="col-6 mb-3">
                                                    <strong>Foto KK:</strong>
                                                    <div class="mt-1">
                                                        <a href="{{ $pengajuan->user->profile->foto_kk_url }}"
                                                            target="_blank">
                                                            <img src="{{ $pengajuan->user->profile->foto_kk_url }}"
                                                                alt="KK" class="img-thumbnail"
                                                                style="max-width: 100px;">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($pengajuan->user->profile->foto_akte)
                                                <div class="col-6 mb-3">
                                                    <strong>Foto Akte:</strong>
                                                    <div class="mt-1">
                                                        <a href="{{ $pengajuan->user->profile->foto_akte_url }}"
                                                            target="_blank">
                                                            <img src="{{ $pengajuan->user->profile->foto_akte_url }}"
                                                                alt="Akte" class="img-thumbnail"
                                                                style="max-width: 100px;">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($pengajuan->user->profile->pas_photo)
                                                <div class="col-6 mb-3">
                                                    <strong>Pas Photo:</strong>
                                                    <div class="mt-1">
                                                        <a href="{{ $pengajuan->user->profile->pas_photo_url }}"
                                                            target="_blank">
                                                            <img src="{{ $pengajuan->user->profile->pas_photo_url }}"
                                                                alt="Pas Photo" class="img-thumbnail"
                                                                style="max-width: 100px;">
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div>
                            <div style="border-bottom: 1px solid #ccc; margin-bottom: 20px">
                            </div>
                            @if ($pengajuan->status === 'pending' && auth()->user()->role === 'admin')
                                <div class="row">
                                    <div class="col-md-6">
                                        <form method="POST"
                                            action="{{ route('admin.pengajuan.process', $pengajuan->id) }}"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-info btn-sm me-2"
                                                onclick="return confirm('Mulai memproses pengajuan ini?')">
                                                <i class="fas fa-play"></i> Mulai Proses
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </div>
                                </div>
                            @endif

                            {{-- Diproses - Hanya Super Admin --}}
                            @if ($pengajuan->status === 'diproses' && auth()->user()->role === 'super_admin')
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#completeModal">
                                            <i class="fas fa-check"></i> Selesaikan
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#rejectModal">
                                            <i class="fas fa-times"></i> Tolak
                                        </button>
                                    </div>
                                </div>
                            @endif

                            {{-- Selesai --}}
                            @if ($pengajuan->status === 'selesai')
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> Pengajuan telah selesai diproses.
                                </div>
                            @endif

                            {{-- Ditolak --}}
                            @if ($pengajuan->status === 'ditolak')
                                <div class="alert alert-danger">
                                    <i class="fas fa-times-circle"></i> Pengajuan telah ditolak.
                                </div>
                            @endif

                        </div>
                        {{-- </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Selesaikan -->
    <div class="modal fade" id="completeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Selesaikan Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.pengajuan.complete', $pengajuan->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file_surat" class="form-label">Upload File Surat <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="file_surat" name="file_surat"
                                accept=".pdf,.doc,.docx" required>
                            <div class="form-text">Format yang didukung: PDF, DOC, DOCX (Max: 2MB)</div>
                        </div>
                        <div class="mb-3">
                            <label for="catatan_admin" class="form-label">Catatan Admin</label>
                            <textarea class="form-control" id="catatan_admin" name="catatan_admin" rows="3"
                                placeholder="Catatan tambahan untuk pemohon..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Selesaikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tolak -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.pengajuan.reject', $pengajuan->id) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="catatan_admin_reject" class="form-label">Alasan Penolakan <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="catatan_admin_reject" name="catatan_admin" rows="4"
                                placeholder="Jelaskan alasan penolakan..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
