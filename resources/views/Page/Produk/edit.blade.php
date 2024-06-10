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
                    <form action="{{ url('produk/editdata/' . $produk->id) }}" class="row g-3" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        <!-- Token CSRF -->
                        <div class="col-md-6">
                            <label class="form-label" for="nama_produk">NAMA BUAH</label>
                            <input class="form-control border-start-0" id="nama_produk" name="nama_produk"
                                placeholder="Nama Buah" required type="text" value="{{ $produk->nama_produk }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="jenis_produk_id">JENIS PRODUK</label>
                            <select class="form-control" name="jenis_produk_id">
                                <option value="">-- Pilih Jenis Produk --</option>
                                @foreach ($jenisProduk as $jenis)
                                    <option {{ $produk->jenis_produk_id == $jenis->id ? 'selected' : '' }}
                                        value="{{ $jenis->id }}">
                                        {{ $jenis->nama_jenis_produk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="supplier_id">SUPPLIER</label>
                            <select class="form-control" name="supplier_id">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($suppliers as $supplier)
                                    <option {{ $produk->supplier_id == $supplier->id ? 'selected' : '' }}
                                        value="{{ $supplier->id }}">
                                        {{ $supplier->nama_supplier }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="form-label" for="barcode">Barcode Barang (`scan barcode`)</label>
                            <input class="form-control border-start-0" id="barcode" name="barcode"
                                placeholder="barcode Buah xxxx" type="text" value="{{ $produk->barcode ?? '' }}" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="rak_id">RAK</label>
                            <select class="form-control" name="rak_id">
                                <option value="">-- Pilih Rak Penyimpanan --</option>
                                @foreach ($rak as $jenis)
                                    <option {{ $jenis->id == $produk->rak_id ? 'selected' : '' }}
                                        value="{{ $jenis->id }}">
                                        {{ $jenis->nomor }} - {{ $jenis->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="satuan_jual_terkecil_id">SATUAN JUAL</label>
                            <select class="form-control" name="satuan_jual_terkecil_id">
                                <option value="">-- Pilih Satuan Jual --</option>
                                @foreach ($satuan_jual as $jenis)
                                    {{-- <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option> --}}
                                    <option {{ $jenis->id == $produk->satuan_jual_terkecil_id ? 'selected' : '' }}
                                        value="{{ $jenis->id }}">
                                        {{ $jenis->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="deskripsi">DESKRIPSI</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi Buah" required rows="3">{{ $produk->deskripsi }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="gambar">GAMBAR BUAH</label>
                            <input class="form-control" id="gambar" name="gambar" type="file">
                            <p class="mt-2">Gambar saat ini:</p>
                            <img alt="Gambar Produk" src="{{ asset($produk->gambar) }}" style="max-width: 200px;">
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
