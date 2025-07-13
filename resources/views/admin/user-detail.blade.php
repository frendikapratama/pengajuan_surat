@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('components.admin-menu')
            </div>
            <div class="col-md-9">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header">
                                <h4>Detail User</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Informasi Akun</h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Nama:</strong></td>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    @if ($user->status == 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($user->status == 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @else
                                                        <span class="badge bg-danger">Rejected</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal Daftar:</strong></td>
                                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-6">
                                        <h5>Informasi Profile</h5>
                                        @if ($user->profile)
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Nama Lengkap:</strong></td>
                                                    <td>{{ $user->profile->nama }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>NIK:</strong></td>
                                                    <td>{{ $user->profile->nik }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>No. KK:</strong></td>
                                                    <td>{{ $user->profile->no_kk }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>No. Telepon:</strong></td>
                                                    <td>{{ $user->profile->no_telepon }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Alamat:</strong></td>
                                                    <td>{{ $user->profile->alamat }}</td>
                                                </tr>
                                            </table>
                                        @else
                                            <p>Data profile tidak ditemukan.</p>
                                        @endif
                                    </div>
                                </div>

                                @if ($user->profile)
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h5>Dokumen</h5>
                                            <div class="row">
                                                @if ($user->profile->foto_ktp)
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-header">Foto KTP</div>
                                                            <div class="card-body text-center">
                                                                <img src="{{ $user->profile->foto_ktp_url }}"
                                                                    class="img-fluid" style="max-height: 200px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($user->profile->foto_kk)
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-header">Foto KK</div>
                                                            <div class="card-body text-center">
                                                                <img src="{{ $user->profile->foto_kk_url }}"
                                                                    class="img-fluid" style="max-height: 200px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($user->profile->foto_akte)
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-header">Foto Akte</div>
                                                            <div class="card-body text-center">
                                                                <img src="{{ $user->profile->foto_akte_url }}"
                                                                    class="img-fluid" style="max-height: 200px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($user->profile->pas_photo)
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-header">Pas Photo</div>
                                                            <div class="card-body text-center">
                                                                <img src="{{ $user->profile->pas_photo_url }}"
                                                                    class="img-fluid" style="max-height: 200px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="{{ route('admin.pending-users') }}" class="btn btn-secondary">Kembali</a>
                                    @if ($user->status == 'pending')
                                        <form method="POST" action="{{ route('admin.approve-user', $user->id) }}"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success"
                                                onclick="return confirm('Setujui user ini?')">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.reject-user', $user->id) }}"
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Tolak user ini?')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
