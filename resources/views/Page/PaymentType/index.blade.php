@extends('Template.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Payment Types</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Payment Types</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ url('paymenttype/tambah') }}" class="btn btn-success"><i class='bx bx-plus-circle'></i>
                            Add Payment Type</a>
                    </div>
                </div>
            </div>
            <!-- End breadcrumb -->

            <h6 class="mb-0 text-uppercase">Payment Types</h6>
            <hr />

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Icon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paymentTypes as $paymentType)
                                    <tr>
                                        <td>{{ $paymentType->name }}</td>
                                        <td>{{ $paymentType->description }}</td>
                                        <td>
                                            @if ($paymentType->icon)
                                                <img src="{{ asset('image/icons/' . $paymentType->icon) }}" alt="Icon"
                                                    width="50">
                                            @else
                                                No icon
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('paymenttype/edit', $paymentType->id) }}"
                                                class="btn btn-sm btn-primary"><i class='bx bx-pencil'></i> Edit</a>
                                            <button class="btn btn-sm btn-danger btn-delete"
                                                data-id="{{ $paymentType->id }}">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                            <form action="{{ url('paymenttype/destroy', ['id' => $paymentType->id]) }}"
                                                id="delete-form-{{ $paymentType->id }}" method="POST"
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
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Icon</th>
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
