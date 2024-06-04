@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h6 class="mb-0 text-uppercase">FORM TAMBAH TOKO</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                            <h5 class="mb-0 text-primary">Tambah Data Toko</h5>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('toko/tambahdata') }}" class="row g-3" enctype="multipart/form-data" method="POST">
                        @csrf
                        <!-- Username -->
                        <div class="col-md-6">
                            <label class="form-label" for="username">Username</label>
                            <input class="form-control" id="username" name="username" placeholder="Username" type="text"
                                value="{{ old('username') }}" />
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" id="password" name="password" placeholder="Password"
                                type="password" />
                        </div>

                        <!-- Nama -->
                        <div class="col-md-6">
                            <label class="form-label" for="nama">Nama</label>
                            <input class="form-control" id="nama" name="nama" placeholder="Nama Toko" type="text"
                                value="{{ old('nama') }}" />
                        </div>

                        <!-- Alamat -->
                        <div class="col-md-6">
                            <label class="form-label" for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat Toko" rows="3">{{ old('alamat') }}</textarea>
                        </div>

                        <!-- Telepon -->
                        <div class="col-md-6">
                            <label class="form-label" for="telepon">Telepon</label>
                            <input class="form-control" id="telepon" name="telepon" placeholder="Telepon" type="text"
                                value="{{ old('telepon') }}" />
                        </div>

                        <!-- Logo -->
                        <div class="col-md-6">
                            <label class="form-label" for="logo">Logo</label>
                            <input class="form-control" id="logo" name="logo" type="file" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi Toko" rows="3">{{ old('deskripsi') }}</textarea>
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
