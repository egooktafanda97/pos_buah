@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h6 class="mb-0 text-uppercase">Edit Data Toko</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                            <!-- Optional Card Title -->
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('toko/editdata/' . $toko->id) }}" class="row g-3" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <!-- This line spoofs the PUT method -->

                        <div class="col-md-6">
                            <label class="form-label" for="username">Username</label>
                            <input class="form-control" id="username" name="username"
                                value="{{ old('username', $toko->username) }}" type="text">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="password">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="nama">Nama</label>
                            <input class="form-control" id="nama" name="nama" value="{{ old('nama', $toko->nama) }}"
                                type="text">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat">{{ old('alamat', $toko->alamat) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="telepon">Telepon</label>
                            <input class="form-control" id="telepon" name="telepon"
                                value="{{ old('telepon', $toko->telepon) }}" type="text">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="logo">Logo</label>
                            <input class="form-control" id="logo" name="logo" type="file">
                            @if ($toko->logo)
                                <img src="{{ asset('image/logo/' . $toko->logo) }}" alt="Logo" width="50">
                            @endif
                        </div>

                        <div class="col-md-12">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $toko->deskripsi) }}</textarea>
                        </div>

                        <div class="w-100 border-top"></div>
                        <div class="col">
                            <button type="submit" class="btn btn-outline-success"><i class='bx bx-save me-0'></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
