@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Pendaftaran Akun</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Data Akun</h5>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5>Data Diri</h5>
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ old('nama') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_telepon" class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                                            value="{{ old('no_telepon') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control" id="nik" name="nik"
                                            value="{{ old('nik') }}" maxlength="16" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_kk" class="form-label">No. KK</label>
                                        <input type="text" class="form-control" id="no_kk" name="no_kk"
                                            value="{{ old('no_kk') }}" maxlength="16" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <h5>Upload Dokumen</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="foto_ktp" class="form-label">Foto KTP</label>
                                                <input type="file" class="form-control" id="foto_ktp" name="foto_ktp"
                                                    accept="image/*">
                                            </div>

                                            <div class="mb-3">
                                                <label for="foto_kk" class="form-label">Foto KK</label>
                                                <input type="file" class="form-control" id="foto_kk" name="foto_kk"
                                                    accept="image/*">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="foto_akte" class="form-label">Foto Akte Kelahiran</label>
                                                <input type="file" class="form-control" id="foto_akte"
                                                    name="foto_akte" accept="image/*">
                                            </div>

                                            <div class="mb-3">
                                                <label for="pas_photo" class="form-label">Pas Photo</label>
                                                <input type="file" class="form-control" id="pas_photo"
                                                    name="pas_photo" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Daftar</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}">Sudah punya akun? Login di sini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
