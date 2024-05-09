@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h6 class="mb-0 text-uppercase">FORM TAMBAH SUPPLIER</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                        </div>
                    </div>
                    <hr>
                    <form class="row g-3" action="{{ url('supplier/tambahdata') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Token CSRF -->
                        <div class="col-md-6">
                            <label for="nama_supplier" class="form-label">NAMA SUPPLIER</label>
                            <input type="text" class="form-control border-start-0" id="nama_supplier"
                                name="nama_supplier" placeholder="Nama Supplier" required />
                        </div>
                        <div class="col-md-6">
                            <label for="alamat_supplier" class="form-label">ALAMAT SUPPLIER</label>
                            <input type="text" class="form-control border-start-0" id="alamat_supplier"
                                name="alamat_supplier" placeholder="Alamat Supplier" required />
                        </div>
                        <div class="col-md-6">
                            <label for="nomor_telepon_supplier" class="form-label">NO HP SUPPLIER</label>
                            <input type="text" class="form-control border-start-0" id="nomor_telepon_supplier"
                                name="nomor_telepon_supplier" placeholder="No Hp Supplier" required />
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-success px-5 float-right">TAMBAH DATA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
