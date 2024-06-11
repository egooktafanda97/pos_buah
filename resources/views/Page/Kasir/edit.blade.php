@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Edit Kasir</div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a class="btn btn-secondary" href="{{ url('kasir') }}"><i class='bx bx-arrow-back'></i>
                            Kembali</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Form Edit Kasir</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <form action="{{ url('kasir/editdata', ['id' => $kasir->id]) }}" class="row g-3" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <label class="form-label" for="username">Username</label>
                            <input class="form-control" id="username" name="username" required type="text"
                                value="{{ old('username', $kasir->username) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="password">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="nama">Nama</label>
                            <input class="form-control" id="nama" name="nama" required type="text"
                                value="{{ old('nama', $kasir->nama) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="telepon">Telepon</label>
                            <input class="form-control" id="telepon" name="telepon" required type="text"
                                value="{{ old('telepon', $kasir->telepon) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" required>{{ old('deskripsi', $kasir->deskripsi) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat', $kasir->alamat) }}</textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-success" type="submit">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
