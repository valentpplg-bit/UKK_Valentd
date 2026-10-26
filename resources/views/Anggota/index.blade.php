@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Daftar User / Anggota</h3>
            <p class="text-muted mb-0">Kelola akun user beserta NIS dan kelas anggota.</p>
        </div>

        <a href="{{ route('anggota.create') }}" class="btn btn-primary">
            + Tambah Anggota
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Email User</th>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($anggota as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user?->email ?? '-' }}</td>
                            <td>{{ $item->nis }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->kelas }}</td>

                            <td>

                                <a href="{{ route('anggota.edit', $item->id_anggota) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('anggota.destroy', $item->id_anggota) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus anggota ini?')">
                                        Hapus
                                    </button>

                                </form>

                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada data anggota.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection