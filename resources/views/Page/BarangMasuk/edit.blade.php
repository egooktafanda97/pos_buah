@extends('Template.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Edit Barang Masuk</div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ route('barangmasuk.index') }}" class="btn btn-secondary">
                            <i class='bx bx-arrow-back'></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
            <hr />
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('barangmasuk/editdata', ['id' => $barangMasuk->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="produks_id" class="form-label">Produk</label>
                                <select name="produks_id" class="form-control">
                                    @foreach ($produk as $p)
                                        <option value="{{ $p->id }}"
                                            {{ $p->id == $barangMasuk->produks_id ? 'selected' : '' }}>{{ $p->nama_produk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <select name="supplier_id" class="form-control">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"
                                            {{ $supplier->id == $barangMasuk->supplier_id ? 'selected' : '' }}>
                                            {{ $supplier->nama_supplier }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="harga_beli" class="form-label">Harga Beli</label>
                                <input type="number" class="form-control" name="harga_beli" id="harga_beli"
                                    value="{{ $barangMasuk->harga_beli }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="satuan_beli_id" class="form-label">Satuan Beli</label>
                                <select name="satuan_beli_id" class="form-control">
                                    @foreach ($JenisSatuan as $satuan)
                                        <option value="{{ $satuan->id }}"
                                            {{ $satuan->id == $barangMasuk->satuan_beli_id ? 'selected' : '' }}>
                                            {{ $satuan->nama_satuan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="jumlah_barang_masuk" class="form-label">Jumlah Barang Masuk</label>
                                <input type="number" class="form-control" name="jumlah_barang_masuk"
                                    id="jumlah_barang_masuk" value="{{ $barangMasuk->jumlah_barang_masuk }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="jumlah_barang_keluar" class="form-label">Jumlah Barang Keluar</label>
                                <input type="number" class="form-control" name="jumlah_barang_keluar"
                                    id="jumlah_barang_keluar" value="{{ $barangMasuk->jumlah_barang_keluar }}" required>
                            </div>

                            <div class="col">
                                <button type="submit" class="btn btn-outline-success"><i class='bx bx-save me-0'></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
