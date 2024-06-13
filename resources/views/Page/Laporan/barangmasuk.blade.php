@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <h6 class="mb-0 text-uppercase">LAPORAN BARANG MASUK</h6>
            <hr />
            <div class="card border-top border-0 border-4 border-primary">
                <div class="card-body p-5">
                    <div class="card-title d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">FILTER BY DATE RANGE</h5>
                        </div>
                    </div>
                    <hr>
                    {{-- filter --}}
                    <form method="GET" action="{{ route('Laporan.laporanbarangmasuk') }}">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                            <div class="col">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class='bx bx-filter'></i> FILTER
                        </button>
                    </form>
                </div>
            </div>
            <a href="{{ route('Laporan.printlaporanbarangmasuk', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                target="_blank" class="btn btn-sm btn-warning mt-3"><i class='bx bxs-printer'></i></i> PRINT</a>
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Log Barang Masuk</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Toko</th>
                                    <th>Produk</th>
                                    <th>Supplier</th>
                                    <th>Harga Beli</th>
                                    <th>Jumlah Barang Masuk</th>
                                    <th>Stok Sisa</th>
                                    <th>Satuan Beli</th>
                                    <th>Satuan Stok</th>
                                    <th>Status</th>
                                    <th>Tanggal Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logBarangMasuks as $logBarangMasuk)
                                    <tr>
                                        <td>{{ $logBarangMasuk->kode }}</td>
                                        <td>{{ $logBarangMasuk->toko->nama }}</td>
                                        <td>{{ $logBarangMasuk->produk->nama_produk }}</td>
                                        <td>{{ $logBarangMasuk->supplier->nama_supplier }}</td>
                                        <td>{{ $logBarangMasuk->harga_beli }}</td>
                                        <td>{{ $logBarangMasuk->jumlah_barang_masuk }}</td>
                                        <td>{{ $logBarangMasuk->stok_sisa }}</td>
                                        <td>{{ $logBarangMasuk->satuanBeli->nama }}</td>
                                        <td>{{ $logBarangMasuk->satuanStok->nama }}</td>
                                        <td>{{ $logBarangMasuk->status->nama }}</td>
                                        <td>{{ $logBarangMasuk->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
