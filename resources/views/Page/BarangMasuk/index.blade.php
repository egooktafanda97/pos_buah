@extends('Template.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Barang Masuk</div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ url('barangmasuk/tambah') }}" class="btn btn-success">
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
                                    <th>Produk</th>
                                    <th>Supplier</th>
                                    <th>Harga Beli</th>
                                    <th>Satuan Beli</th>
                                    <th>Jumlah Barang Masuk</th>
                                    <th>Jumlah Barang Keluar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangMasuks as $barangMasuk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $barangMasuk->produk->nama_produk }}</td>
                                        <td>{{ $barangMasuk->supplier->nama_supplier }}</td>
                                        <td>{{ $barangMasuk->harga_beli }}</td>
                                        <td>{{ $barangMasuk->satuanBeli->nama_satuan }}</td>
                                        <td>{{ $barangMasuk->jumlah_barang_masuk }}</td>
                                        <td>{{ $barangMasuk->jumlah_barang_keluar }}</td>
                                        <td>
                                            <a href="{{ url('barangmasuk/edit', ['id' => $barangMasuk->id]) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class='bx bx-pencil'></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger btn-delete"
                                                data-id="{{ $barangMasuk->id }}">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                            <form action="{{ url('barangmasuk/destroy', ['id' => $barangMasuk->id]) }}"
                                                id="delete-form-{{ $barangMasuk->id }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th>Supplier</th>
                                    <th>Harga Beli</th>
                                    <th>Satuan Beli</th>
                                    <th>Jumlah Barang Masuk</th>
                                    <th>Jumlah Barang Keluar</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
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
