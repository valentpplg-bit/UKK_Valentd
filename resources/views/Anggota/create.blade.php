@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h3 class="mb-3">Tambah Anggota</h3>

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <strong>Form Tambah Anggota</strong>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('anggota.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email User</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="password-field">
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                        <button type="button" class="toggle-password" aria-label="Tampilkan password" title="Tampilkan password">
                            <span class="eye-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="password-field">
                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               required>
                        <button type="button" class="toggle-password" aria-label="Tampilkan password" title="Tampilkan password">
                            <span class="eye-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text"
                           name="nama_lengkap"
                           class="form-control"
                           value="{{ old('nama_lengkap') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">NIS</label>
                    <input type="text"
                           name="nis"
                           class="form-control"
                           value="{{ old('nis') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat"
                              class="form-control"
                              rows="3"
                              required>{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>
                    <input type="text"
                           name="kelas"
                           class="form-control"
                           value="{{ old('kelas') }}"
                           required>
                </div>

                <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
            </form>

        </div>

    </div>

</div>

@endsection

<style>
    .password-field {
        position: relative;
    }

    .password-field input {
        padding-right: 48px;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 10px;
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 6px;
        background: transparent;
        color: #6c757d;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .toggle-password:hover {
        background: #eef1f3;
        color: #212529;
    }

    .eye-icon svg {
        width: 20px;
        height: 20px;
        display: block;
        fill: none;
        stroke: currentColor;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-width: 1.8;
    }
</style>

@push('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(function (button) {
        const input = button.parentElement.querySelector('input');
        const icon = button.querySelector('.eye-icon');

        icon.innerHTML = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>';

        button.addEventListener('click', function () {
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.innerHTML = isHidden
                ? '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 3l18 18M10.6 6.2A10.8 10.8 0 0 1 12 6c6.5 0 10 6 10 6a18.4 18.4 0 0 1-3.1 3.7M6.1 6.2C3.4 8.1 2 12 2 12s3.5 6 10 6a10.8 10.8 0 0 0 2.4-.3"></path><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"></path></svg>'
                : '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6Z"></path><circle cx="12" cy="12" r="2.5"></circle></svg>';
            this.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
            this.setAttribute('title', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });
    });
</script>
@endpush
