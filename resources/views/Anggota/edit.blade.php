@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Edit Anggota</h3>

        <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('anggota.update', $anggota->id_anggota) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Email User</label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $anggota->user?->email) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Kosongkan jika tidak ingin mengubah password">
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>

                    <input type="password"
                           name="password_confirmation"
                           class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">NIS</label>

                    <input type="text"
                           name="nis"
                           class="form-control"
                           value="{{ old('nis', $anggota->nis) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>

                    <input type="text"
                           name="nama_lengkap"
                           class="form-control"
                           value="{{ old('nama_lengkap', $anggota->nama_lengkap) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>

                    <textarea name="alamat"
                              class="form-control"
                              rows="3">{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>

                    <input type="text"
                           name="kelas"
                           class="form-control"
                           value="{{ old('kelas', $anggota->kelas) }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    Update
                </button>

                <a href="{{ route('anggota.index') }}"
                   class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>
    </div>

</div>

@endsection