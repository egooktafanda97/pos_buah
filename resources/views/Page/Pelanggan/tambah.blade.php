@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h6 class="mb-0 text-uppercase">FORM TAMBAH PELANGGAN</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                        </div>
                    </div>
                    <hr>
                    <form class="row g-3" action="{{ url('pelanggan/tambahdata') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Token CSRF -->
                        <div class="col-md-6">
                            <label for="nama_pelanggan" class="form-label">NAMA PELANGGAN</label>
                            <input type="text" class="form-control border-start-0" id="nama_pelanggan"
                                name="nama_pelanggan" placeholder="Nama Pelanggan" required />
                        </div>
                        <div class="col-md-6">
                            <label for="alamat_pelanggan" class="form-label">ALAMAT PELANGGAN</label>
                            <input type="text" class="form-control border-start-0" id="alamat_pelanggan"
                                name="alamat_pelanggan" placeholder="Alamat Pelanggan" required />
                        </div>
                        <div class="col-md-6">
                            <label for="nomor_telepon_pelanggan" class="form-label">NO HP PELANGGAN</label>
                            <input type="text" class="form-control border-start-0" id="nomor_telepon_pelanggan"
                                name="nomor_telepon_pelanggan" placeholder="No Hp Pelanggan" required />
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
