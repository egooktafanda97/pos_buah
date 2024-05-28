@extends('Template.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tambah Rak</div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('rak.index') }}">Kembali</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ url('rak/tambahdata') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nomor" class="form-label">Nomor Rak</label>
                                    <input type="text" class="form-control" id="nomor" name="nomor" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Rak</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kapasitas" class="form-label">Kapasitas</label>
                                    <input type="number" class="form-control" id="kapasitas" name="kapasitas" required>
                                </div>
                                <button type="submit" class="btn btn-success">Tambah Rak</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
