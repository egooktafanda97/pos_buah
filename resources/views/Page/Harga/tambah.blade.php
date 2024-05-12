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
                    <form class="row g-3" action="{{ url('harga/tambahdata') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Token CSRF -->
                        <div class="col-md-6">
                            <label for="harga_satuan" class="form-label">HARGA SATUAN</label>
                            <input type="text" class="form-control border-start-0" id="harga_satuan" name="harga_satuan"
                                placeholder="Harga Satuan" required />
                        </div>

                        <div class="col-md-6">
                            <label for="produk_id" class="form-label">PRODUK</label>
                            <select name="produk_id" class="form-control">
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_satuan_id" class="form-label">JENIS SATUAN</label>
                            <select name="jenis_satuan_id" class="form-control">
                                <option value="">-- Pilih Jenis Satuan --</option>
                                @foreach ($satuan as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->nama_jenis_satuan }}</option>
                                @endforeach
                            </select>
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
