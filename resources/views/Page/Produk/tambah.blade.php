@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h6 class="mb-0 text-uppercase">FORM TAMBAH PRODUK</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                        </div>
                    </div>
                    <hr>
                    <form class="row g-3" action="{{ url('produk/tambahdata') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Token CSRF -->
                        <div class="col-md-6">
                            <label for="nama" class="form-label">NAMA BUAH</label>
                            <input type="text" class="form-control border-start-0" id="nama" name="nama"
                                placeholder="Nama Buah" required />
                        </div>
                        <div class="col-md-6">
                            <label for="harga" class="form-label">HARGA</label>
                                <input type="number" class="form-control border-start-0" id="harga" name="harga"
                                    placeholder="Harga Buah" required />
                        </div>
                        <div class="col-12">
                            <label for="stok" class="form-label">STOK</label>
                                <input type="number" class="form-control border-start-0" id="stok" name="stok"
                                    placeholder="Stok Buah" required />                        </div>
                        <div class="col-12">
                            <label for="deskripsi" class="form-label">DESKRIPSI</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi Buah" rows="3" required></textarea>
                        </div>
                        <div class="col-12">
                            <label for="gambar" class="form-label">GAMBAR BUAH</label>
                            <input class="form-control" type="file" id="gambar" name="gambar" required>
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
