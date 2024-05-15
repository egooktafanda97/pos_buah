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
                            <li class="breadcrumb-item active" aria-current="page">Data Harga</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="/harga/tambah" class="btn btn-success"><i class='bx bx-plus-circle'></i> TAMBAH
                            DATA</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Data Harga</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>HARGA SATUAN</th>
                                    <th>PRODUK</th>
                                    <th>JENIS SATUAN</th>
                                    <th>AKSI</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($harga as $key => $harga)
                                    <tr>
                                        <td>{{ $harga->harga_satuan }}</td>
                                        <td>{{ $harga->produk->nama_produk }}</td>
                                        <td>{{ $harga->jenisSatuan->nama_jenis_satuan }}</td>


                                        <td>
                                            <a href="{{ url('harga/edit', ['id' => $harga->id]) }}"
                                                class="btn btn-sm btn-primary"><i class='bx bx-pencil'></i></a>
                                            <button class="btn btn-sm btn-danger btn-delete"
                                                data-id="{{ $harga->id }}"><i class='bx bx-trash'></i></button>
                                            <form id="delete-form-{{ $harga->id }}"
                                                action="{{ url('harga/hapus', ['id' => $harga->id]) }}" method="GET"
                                                style="display: none;">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>HARGA SATUAN</th>
                                    <th>PRODUK</th>
                                    <th>JENIS SATUAN</th>
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
