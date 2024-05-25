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
                    <form action="{{ url('produk/tambahdata') }}" class="row g-3" enctype="multipart/form-data" method="POST">
                        @csrf
                        <!-- Token CSRF -->
                        <div class="col-md-6">
                            <label class="form-label" for="nama_produk">NAMA BUAH</label>
                            <input class="form-control border-start-0" id="nama_produk" name="nama_produk"
                                placeholder="Nama Buah" required type="text" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="jenis_produk_id">JENIS PRODUK</label>
                            <select class="form-control" name="jenis_produk_id">
                                <option value="">-- Pilih Jenis Produk --</option>
                                @foreach ($jenisProduk as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis_produk }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="supplier_id">SUPPLIER</label>
                            <select class="form-control" name="supplier_id">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="form-label" for="barcode">Barcode Barang (`scan barcode`)</label>
                            <input class="form-control border-start-0" id="barcode" name="barcode"
                                placeholder="barcode Buah xxxx" type="text" />
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="stok">STOK</label>
                            <input class="form-control border-start-0" id="stok" name="stok" placeholder="Stok Buah"
                                required type="number" />
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="deskripsi">DESKRIPSI</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi Buah" required rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="gambar">GAMBAR BUAH</label>
                            <input class="form-control" id="gambar" name="gambar" required type="file">
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
