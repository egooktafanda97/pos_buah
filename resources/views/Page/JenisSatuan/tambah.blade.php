@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h6 class="mb-0 text-uppercase">FORM TAMBAH JENIS SATUAN</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('satuan/tambahdata') }}" class="row g-3" enctype="multipart/form-data" method="POST">
                        @csrf
                        <!-- Token CSRF -->
                        <div class="col-md-6">
                            <label class="form-label" for="nama_jenis_satuan">NAMA JENIS SATUAN</label>
                            <input class="form-control border-start-0" id="nama_jenis_satuan" name="nama"
                                placeholder="Nama Satuan" required type="text" />
                        </div>


                        <div class="w-100 border-top"></div>
                        <div class="col">
                            <button class="btn btn-outline-success" type="submit"><i class='bx bx-save me-0'></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
