@extends('Templateweb.layout')
@section('content')
    <div class="container-fluid fruite py-5 mt-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <br><br><br><br>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    @foreach ($dataproduk as $data)
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded border border-secondary position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <img src="{{ $data->produk->gambar }}"
                                                        class="img-fluid w-100 rounded-top" alt="">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">{{ $data->produk->stok }}
                                                    {{ $data->jenisSatuan->nama_jenis_satuan }}</div>
                                                <div class="p-4  rounded-bottom">
                                                    <h4>{{ $data->produk->nama_produk }}</h4>
                                                    <p>{{ $data->produk->deskripsi }}</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">Rp
                                                            {{ number_format($data->harga_satuan) }} /
                                                            {{ $data->jenisSatuan->nama_jenis_satuan }}</p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
