@extends('Template.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Barang Masuk</div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a class="btn btn-success" href="{{ url('barangmasuk/tambah') }}">
                            <i class='bx bx-plus-circle'></i> Tambah Data
                        </a>
                    </div>
                </div>
            </div>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Supplier</th>
                                    <th>Harga Beli / Satuan</th>
                                    <th>Jumlah Sebelumnya</th>
                                    <th>Jumlah Barang Masuk</th>
                                    <th>Satuan Beli</th>
                                    <th>Nulai Konversi Satuan</th>
                                    <th>Stok Tersedia</th>
                                    <th>Stok Aktual</th>
                                    {{-- <th>Jumlah Barang Keluar</th> --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangMasuks as $barangMasuk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($barangMasuk->created_at)->format('Y-m-d H:s:i') }}
                                        </td>
                                        <td>{{ $barangMasuk->produk->nama_produk }}</td>
                                        <td>{{ $barangMasuk->supplier->nama_supplier }}</td>
                                        <td>{{ 'Rp. ' . number_format($barangMasuk->harga_beli) }} /
                                            {{ $barangMasuk->satuanBeli->nama }}</td>
                                        <td>{{ $barangMasuk->jumlah_selebelumnya }}
                                            {{ $barangMasuk->produk->satuanJualTerkecil->nama ?? '' }}
                                        </td>
                                        <td>{{ $barangMasuk->jumlah_barang_masuk }}
                                            {{ $barangMasuk->satuanBeli->nama }}
                                        </td>
                                        <td>{{ $barangMasuk->satuanBeli->nama }}</td>
                                        <td>{{ \App\Services\KonversiSatuanService::konversi($barangMasuk->produk->id, $barangMasuk->satuanBeli->id, $barangMasuk->jumlah_barang_masuk) }}
                                            {{ $barangMasuk->produk->satuanJualTerkecil->nama ?? '' }}
                                        </td>
                                        <td>{{ $barangMasuk->jumlah_selebelumnya + \App\Services\KonversiSatuanService::konversi($barangMasuk->produk->id, $barangMasuk->satuanBeli->id, $barangMasuk->jumlah_barang_masuk) }}
                                            {{ $barangMasuk->produk->satuanJualTerkecil->nama ?? '' }}
                                        </td>
                                        <td>
                                            {{ \App\Models\Stok::where('produks_id', $barangMasuk->produk->id)->first()->jumlah }}
                                            {{ $barangMasuk->produk->satuanJualTerkecil->nama ?? '' }}
                                        </td>

                                        {{-- <td>{{ $barangMasuk->jumlah_barang_keluar }}</td> --}}
                                        <td>
                                            <a class="btn btn-sm btn-primary"
                                                href="{{ url('barangmasuk/edit', ['id' => $barangMasuk->id]) }}">
                                                <i class='bx bx-pencil'></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger btn-delete"
                                                data-id="{{ $barangMasuk->id }}">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                            <form
                                                action="{{ url('barangmasuk/delete-proccess', ['id' => $barangMasuk->id]) }}"
                                                id="delete-form-{{ $barangMasuk->id }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteButtons = document.querySelectorAll('.btn-delete');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda akan menghapus data ini!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var form = document.getElementById('delete-form-' + id);
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
@endsection
