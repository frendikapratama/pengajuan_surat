@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-user-edit"></i> Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle"></i> Terdapat kesalahan dalam form:
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Data Akun -->
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="fas fa-user"></i> Data Akun</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Lengkap (Akun)</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                                    name="name" value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control bg-light" id="email"
                                                    value="{{ $user->email }}" readonly>
                                                <small class="form-text text-muted">
                                                    <i class="fas fa-info-circle"></i> Email tidak dapat diubah
                                                </small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="role" class="form-label">Role</label>
                                                <input type="text" class="form-control bg-light" id="role"
                                                    value="{{ ucfirst($user->role) }}" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status Akun</label>
                                                <div class="form-control bg-light">
                                                    @if ($user->is_approved)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle"></i> Disetujui
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock"></i> Menunggu Persetujuan
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Data Profile -->
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0"><i class="fas fa-id-card"></i> Data Profile</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama Lengkap (Profile)</label>
                                                <input type="text"
                                                    class="form-control @error('nama') is-invalid @enderror" id="nama"
                                                    name="nama" value="{{ old('nama', $profile->nama ?? '') }}" required>
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                                    required>{{ old('alamat', $profile->alamat ?? '') }}</textarea>
                                                @error('alamat')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="no_telepon" class="form-label">No. Telepon</label>
                                                <input type="text"
                                                    class="form-control @error('no_telepon') is-invalid @enderror"
                                                    id="no_telepon" name="no_telepon"
                                                    value="{{ old('no_telepon', $profile->no_telepon ?? '') }}" required>
                                                @error('no_telepon')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="nik" class="form-label">NIK</label>
                                                <input type="text"
                                                    class="form-control @error('nik') is-invalid @enderror" id="nik"
                                                    name="nik" value="{{ old('nik', $profile->nik ?? '') }}"
                                                    maxlength="16" required>
                                                @error('nik')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="no_kk" class="form-label">No. KK</label>
                                                <input type="text"
                                                    class="form-control @error('no_kk') is-invalid @enderror"
                                                    id="no_kk" name="no_kk"
                                                    value="{{ old('no_kk', $profile->no_kk ?? '') }}" maxlength="16"
                                                    required>
                                                @error('no_kk')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Dokumen -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h5 class="mb-0"><i class="fas fa-upload"></i> Upload Dokumen</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="foto_ktp" class="form-label">
                                                            <i class="fas fa-id-card"></i> Foto KTP
                                                        </label>
                                                        <input type="file"
                                                            class="form-control @error('foto_ktp') is-invalid @enderror"
                                                            id="foto_ktp" name="foto_ktp" accept="image/*">
                                                        @if (isset($profile->foto_ktp) && $profile->foto_ktp)
                                                            <small class="form-text text-success">
                                                                <i class="fas fa-check"></i> File sudah diupload
                                                            </small>
                                                        @endif
                                                        @error('foto_ktp')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="foto_kk" class="form-label">
                                                            <i class="fas fa-users"></i> Foto KK
                                                        </label>
                                                        <input type="file"
                                                            class="form-control @error('foto_kk') is-invalid @enderror"
                                                            id="foto_kk" name="foto_kk" accept="image/*">
                                                        @if (isset($profile->foto_kk) && $profile->foto_kk)
                                                            <small class="form-text text-success">
                                                                <i class="fas fa-check"></i> File sudah diupload
                                                            </small>
                                                        @endif
                                                        @error('foto_kk')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="foto_akte" class="form-label">
                                                            <i class="fas fa-certificate"></i> Foto Akte Kelahiran
                                                        </label>
                                                        <input type="file"
                                                            class="form-control @error('foto_akte') is-invalid @enderror"
                                                            id="foto_akte" name="foto_akte" accept="image/*">
                                                        @if (isset($profile->foto_akte) && $profile->foto_akte)
                                                            <small class="form-text text-success">
                                                                <i class="fas fa-check"></i> File sudah diupload
                                                            </small>
                                                        @endif
                                                        @error('foto_akte')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="pas_photo" class="form-label">
                                                            <i class="fas fa-camera"></i> Pas Photo
                                                        </label>
                                                        <input type="file"
                                                            class="form-control @error('pas_photo') is-invalid @enderror"
                                                            id="pas_photo" name="pas_photo" accept="image/*">
                                                        @if (isset($profile->pas_photo) && $profile->pas_photo)
                                                            <small class="form-text text-success">
                                                                <i class="fas fa-check"></i> File sudah diupload
                                                            </small>
                                                        @endif
                                                        @error('pas_photo')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="alert alert-info">
                                                <i class="fas fa-info-circle"></i>
                                                <strong>Catatan:</strong> File yang diupload harus berformat JPG, JPEG, atau
                                                PNG dengan ukuran maksimal 2MB.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route(auth()->user()->role . '.dashboard') }}"
                                            class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Preview gambar sebelum upload
            function previewImage(input, targetId) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(targetId).src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Validasi ukuran file
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function() {
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    if (this.files[0] && this.files[0].size > maxSize) {
                        alert('Ukuran file terlalu besar. Maksimal 2MB.');
                        this.value = '';
                    }
                });
            });

            // Validasi NIK dan No. KK (harus 16 digit)
            document.getElementById('nik').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 16) {
                    this.value = this.value.slice(0, 16);
                }
            });

            document.getElementById('no_kk').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 16) {
                    this.value = this.value.slice(0, 16);
                }
            });

            // Validasi nomor telepon
            document.getElementById('no_telepon').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9+\-\s]/g, '');
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .card {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                border: 1px solid rgba(0, 0, 0, 0.125);
            }

            .card-header {
                font-weight: 600;
            }

            .form-label {
                font-weight: 500;
                color: #495057;
            }

            .alert {
                border-left: 4px solid;
            }

            .alert-success {
                border-left-color: #28a745;
            }

            .alert-danger {
                border-left-color: #dc3545;
            }

            .alert-info {
                border-left-color: #17a2b8;
            }

            .badge {
                font-size: 0.875em;
            }

            .btn {
                font-weight: 500;
            }

            .text-success {
                color: #28a745 !important;
            }

            .bg-light {
                background-color: #f8f9fa !important;
            }
        </style>
    @endpush
@endsection
