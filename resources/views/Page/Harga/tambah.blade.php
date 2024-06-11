@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h6 class="mb-0 text-uppercase">FORM TAMBAH HARGA</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ url('harga/tambahdata') }}" class="row g-3" enctype="multipart/form-data" method="POST">
                        @csrf
                        <!-- Token CSRF -->
                        <div class="col-md-6">
                            <label class="form-label" for="harga_satuan">HARGA SATUAN</label>
                            <input class="form-control border-start-0" id="harga_satuan" name="harga_satuan"
                                placeholder="Harga Satuan" required type="text" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="produk_id">PRODUK</label>
                            <select class="form-control" name="produk_id">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="jenis_satuan_id">JENIS SATUAN</label>
                            <select class="form-control" name="jenis_satuan_id">
                                <option value="">-- Pilih Jenis Satuan --</option>
                                @foreach ($satuan as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->nama }}</option>
                                @endforeach
                            </select>
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
