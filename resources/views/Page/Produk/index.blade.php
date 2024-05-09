@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Produk</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="/produk/tambah" class="btn btn-success"><i class='bx bx-plus-circle'></i> TAMBAH
                            DATA</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Data Produk Buah</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NAMA</th>
                                    <th>JENIS</th>
                                    <th>SUPPLIER</th>
                                    <th>STOK</th>
                                    <th>DESKRIPSI</th>
                                    <th>GAMBAR</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produkbuah as $key => $produk)
                                    <tr>
                                        <td>{{ $produk->nama_produk }}</td>
                                        <td>{{ $produk->jenisProduk->nama_jenis_produk }}</td>
                                        <td>{{ $produk->supplier->nama_supplier }}</td>
                                        <td>{{ $produk->stok }}</td>
                                        <td>{{ $produk->deskripsi }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $key }}">
                                                Tampilkan Gambar
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{ $key }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel{{ $key }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="exampleModalLabel{{ $key }}">Gambar Produk:
                                                                {{ $produk->nama }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ asset($produk->gambar) }}" class="img-fluid"
                                                                alt="{{ $produk->nama }}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('produk/edit', ['id' => $produk->id]) }}"
                                                class="btn btn-primary">Edit</a>
                                            <button class="btn btn-danger btn-delete"
                                                data-id="{{ $produk->id }}">Hapus</button>
                                            <form id="delete-form-{{ $produk->id }}"
                                                action="{{ url('produk/hapus', ['id' => $produk->id]) }}" method="GET"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>NAMA</th>
                                    <th>JENIS</th>
                                    <th>SUPPLIER</th>
                                    <th>STOK</th>
                                    <th>DESKRIPSI</th>
                                    <th>GAMBAR</th>
                                    <th>AKSI</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
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
