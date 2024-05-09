@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h6 class="mb-0 text-uppercase">FORM EDIT JENIS SATUAN</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                        </div>
                    </div>
                    <hr>
                    <form class="row g-3" action="{{ url('satuan/editdata/' . $jenissatuan->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Token CSRF -->
                        <div class="col-md-6">
                            <label for="nama_jenis_satuan" class="form-label">NAMA JENIS SATUAN</label>
                            <input type="text" class="form-control border-start-0" id="nama_jenis_satuan"
                                name="nama_jenis_satuan" placeholder="Nama Jenis"
                                value="{{ $jenissatuan->nama_jenis_satuan }}" required />
                        </div>


                        <div class="col-12">
                            <button type="submit" class="btn btn-success px-5 float-right">SIMPAN PERUBAHAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
