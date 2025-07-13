// resources/views/user/create-pengajuan.blade.php
@extends('layouts.app')

@section('title', 'Ajukan Surat Pengantar')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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

                        <form method="POST" action="{{ route('user.pengajuan.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan</label>
                                <textarea class="form-control" id="keperluan" name="keperluan" rows="4" required
                                    placeholder="Jelaskan untuk keperluan apa surat pengantar ini dibutuhkan...">{{ old('keperluan') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan Tambahan (Opsional)</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                    placeholder="Informasi tambahan yang diperlukan...">{{ old('keterangan') }}</textarea>
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
