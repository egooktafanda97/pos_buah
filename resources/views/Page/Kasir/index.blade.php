@extends('Template.layout')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Data Kasir</div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ url('kasir/tambah') }}" class="btn btn-success"><i class='bx bx-plus-circle'></i> Tambah
                            Data</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Data Kasir</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Logo</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kasir as $kasir)
                                    <tr>
                                        <td>{{ $kasir->nama }}</td>
                                        <td>{{ $kasir->alamat }}</td>
                                        <td>{{ $kasir->telepon }}</td>
                                        <td>
                                            @if ($kasir->logo)
                                                <img src="{{ asset($kasir->logo) }}" alt="Logo" width="50">
                                            @else
                                                Tidak ada logo
                                            @endif
                                        </td>
                                        <td>{{ $kasir->deskripsi }}</td>
                                        <td>
                                            <a href="{{ url('kasir/edit', ['id' => $kasir->id]) }}"
                                                class="btn btn-primary btn-sm"><i class='bx bx-pencil'></i> Edit</a>
                                            <button class="btn btn-danger btn-sm btn-delete"
                                                data-id="{{ $kasir->id }}"><i class='bx bx-trash'></i> Hapus</button>
                                            <form action="{{ url('kasir/destroy', ['id' => $kasir->id]) }}"
                                                id="delete-form-{{ $kasir->id }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Logo</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
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
