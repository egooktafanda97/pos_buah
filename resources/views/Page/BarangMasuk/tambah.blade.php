@extends('Template.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tambah Barang Masuk</div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a class="btn btn-secondary" href="{{ route('barangmasuk.index') }}">
                            <i class='bx bx-arrow-back'></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <hr />
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('barangmasuk/tambahdata') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="produks_id">Produk</label>
                                <select class="form-control" name="produks_id">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($produk as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="supplier_id">Supplier</label>
                                <select class="form-control" name="supplier_id">
                                    <option value="">-- Pilih Supplier --</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="harga_beli">Harga Beli / Satuan Beli</label>
                                <input class="form-control" id="harga_beli" name="harga_beli" placeholder="Harga Beli"
                                    required type="number">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="satuan_beli_id">Satuan Beli</label>
                                <select class="form-control" name="satuan_beli_id">
                                    <option value="">-- Pilih Satuan Beli --</option>
                                    @foreach ($JenisSatuan as $satuan)
                                        <option value="{{ $satuan->id }}">{{ $satuan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="jumlah_barang_masuk">Jumlah Barang Masuk</label>
                                <input class="form-control" id="jumlah_barang_masuk" name="jumlah_barang_masuk"
                                    placeholder="Jumlah Barang Masuk" required type="number">
                            </div>

                            {{-- <div class="col-md-6">
                                <label class="form-label" for="jumlah_barang_keluar">Jumlah Barang Keluar</label>
                                <input class="form-control" id="jumlah_barang_keluar" name="jumlah_barang_keluar"
                                    placeholder="Jumlah Barang Keluar" required type="number">
                            </div> --}}

                            <div class="col-12">
                                <button class="btn btn-outline-success" type="submit">
                                    <i class='bx bx-save me-0'></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
