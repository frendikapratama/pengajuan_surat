@extends('layouts.app')

@section('title', 'Ajukan Surat Pengantar')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('components.user-menu')
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>Ajukan Surat Pengantar</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('user.pengajuan.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan</label>
                                <textarea class="form-control" id="keperluan" name="keperluan" rows="4" required
                                    placeholder="Jelaskan untuk keperluan apa surat pengantar ini dibutuhkan...">{{ old('keperluan') }}</textarea>
                                @error('keperluan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan Tambahan (Opsional)</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                    placeholder="Informasi tambahan yang diperlukan...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis_surat" class="form-label">Upload Foto Surat Pengantar Rt/Rw(jpg, jpeg,
                                    png)</label>
                                <input type="file" class="form-control" id="jenis_surat" name="jenis_surat"
                                    accept="image/*" required>
                                @error('jenis_surat')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Ajukan Surat</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
