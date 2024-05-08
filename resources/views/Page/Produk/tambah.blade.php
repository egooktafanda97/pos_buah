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
                            <label for="nama_produk" class="form-label">NAMA BUAH</label>
                            <input type="text" class="form-control border-start-0" id="nama_produk" name="nama_produk"
                                placeholder="Nama Buah" required />
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_produk_id" class="form-label">JENIS PRODUK</label>
                            <select name="jenis_produk_id" class="form-control">
                                <option value="">-- Pilih Jenis Produk --</option>
                                @foreach ($jenisProduk as $jenis)
                                    <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis_produk }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="supplier_id" class="form-label">SUPPLIER</label>
                            <select name="supplier_id" class="form-control">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="harga_id" class="form-label">HARGA</label>
                            <select name="harga_id" class="form-control">
                                <option value="">-- Pilih Harga --</option>
                                @foreach ($hargas as $harga)
                                    <option value="{{ $harga->id }}">{{ $harga->harga_satuan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="stok" class="form-label">STOK</label>
                            <input type="number" class="form-control border-start-0" id="stok" name="stok"
                                placeholder="Stok Buah" required />
                        </div>
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
