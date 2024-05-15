@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h6 class="mb-0 text-uppercase">FORM EDIT PRODUK</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                        </div>
                    </div>
                    <hr>
                    <form class="row g-3" action="{{ url('produk/editdata/' . $produk->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Token CSRF -->
                        <div class="col-md-6">
                            <label for="nama_produk" class="form-label">NAMA BUAH</label>
                            <input type="text" class="form-control border-start-0" id="nama_produk" name="nama_produk"
                                placeholder="Nama Buah" value="{{ $produk->nama_produk }}" required />
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_produk_id" class="form-label">JENIS PRODUK</label>
                            <select name="jenis_produk_id" class="form-control">
                                <option value="">-- Pilih Jenis Produk --</option>
                                @foreach ($jenisProduk as $jenis)
                                    <option value="{{ $jenis->id }}"
                                        {{ $produk->jenis_produk_id == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama_jenis_produk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="supplier_id" class="form-label">SUPPLIER</label>
                            <select name="supplier_id" class="form-control">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ $produk->supplier_id == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                        </div>



                        <div class="col-12">
                            <label for="stok" class="form-label">STOK</label>
                            <input type="number" class="form-control border-start-0" id="stok" name="stok"
                                placeholder="Stok Buah" value="{{ $produk->stok }}" required />
                        </div>
                        <div class="col-12">
                            <label for="deskripsi" class="form-label">DESKRIPSI</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi Buah" rows="3" required>{{ $produk->deskripsi }}</textarea>
                        </div>
                        <div class="col-12">
                            <label for="gambar" class="form-label">GAMBAR BUAH</label>
                            <input class="form-control" type="file" id="gambar" name="gambar">
                            <p class="mt-2">Gambar saat ini:</p>
                            <img src="{{ asset($produk->gambar) }}" alt="Gambar Produk" style="max-width: 200px;">
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